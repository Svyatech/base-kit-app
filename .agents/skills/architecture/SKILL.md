---
name: architecture
description: Архитектура сайта на base-kit — Laravel + FrankenPHP в Docker. Использовать при любых вопросах про Docker, образы, запуск, деплой, создание нового сайта из шаблона.
---

# Архитектура сайта на base-kit (выжимка)

Этот репозиторий — копия шаблона `site/` из base-kit. Сайты: 1 сайт = 1 страна, каждый — самостоятельный проект со своими миграциями, моделями, фичами. Никакого upstream/синхронизации с шаблоном. Полный документ: `~/projects/base-skills/base-kit-architecture.md`.

## Пререквизит: инфраструктура (репозиторий base-kit-infra)

Сайт НЕ самодостаточен. До запуска сайта должна быть установлена и запущена общая инфраструктура (одна на машину/VPS, обслуживает все сайты):

- **Caddy** — единая входная точка: TLS, проксирует на контейнеры сайтов по имени в сети `web`.
- **Postgres 17** — один процесс на все сайты; у каждого сайта СВОЯ база (`CREATE DATABASE`). Отдельных БД-контейнеров на сайт не создавать.
- **Redis 7** — один на все сайты (кэш, сессии, очереди).

Первый раз на машине: `make infra-init && make infra-up` (команды сайта дергают `../infra/docker-compose.yml`). Креды: юзер `basekit` (суперюзер), пароль `basekit` (дев; задаются в `infra/.env`). Смена пароля в живом Postgres — только `ALTER ROLE`, рестарт инфры пароль НЕ меняет (env применяется при первой инициализации тома).

## Стек и ключевые решения

- **Laravel 13 + PHP 8.5 + FrankenPHP** (не nginx + php-fpm): веб-сервер и PHP в одном бинарнике → один контейнер на сайт. Официально поддержан Laravel, задел на worker-режим/Octane.
- SSR на Blade, никаких SPA. Контент сразу со страницы (SEO).
- Контейнер сайта = PHP-контейнер: внутри полноценный PHP CLI + artisan (`make shell`, `make tinker`).

## Образы (двухэтажная сборка)

1. `docker/php.Dockerfile` → `base-kit-php` — FROM `dunglas/frankenphp:php8.5` + расширения (pdo_pgsql, gd, intl, zip, redis) + composer + прод php.ini. Собирается ОДИН раз (`make build-base`), общий для всех сайтов.
2. `Dockerfile` → `<site>-app` — FROM base-kit-php + composer install + код. Лёгкий, per сайт (`make build`).

Слои дедуплицируются: PHP лежит на диске в одном экземпляре, N сайтов = N тонких слоёв с кодом. Порядок инструкций в Dockerfile — от редко меняющегося к часто (кэш слоёв).

## Два режима запуска (НЕ путать с инициализацией)

- `make up` — прод-режим локально: код запечён в образе (COPY). Правки НЕ видны без `make rebuild`.
- `make dev` — дев-режим: `docker-compose.dev.yml` (override) монтирует `./` в `/var/www/html` поверх запечённого кода. Правки видны по F5. Основной режим разработки.
- Инициализация (разовая): `build-base`, `build`, `db-create DB=...`, `key`, `migrate`.

`docker-compose.yml` намеренно НЕ содержит `build:` — на VPS лежит тот же файл без исходников, образ приезжает из registry. Сборка — только через Makefile/CI.

## Команды (make без аргументов = справка)

- Makefile читает `.env` (`-include .env`): `APP_NAME`/`APP_IMAGE` — одно место правды, задавать там, а не в командах. Командная строка перекрывает: `make build APP_IMAGE=other`.
- Работа внутри: `make shell`, `make tinker`, `make migrate`, `make restart`, `make logs`.
- База: `make db-create DB=x` / `db-shell` / `db-dump` (в общем Postgres инфры).
- Если контейнер падает при старте: `docker compose -f docker-compose.yml run --rm app sh`.

## Новый сайт из этого шаблона

1. Скопировать репозиторий, новое имя.
2. `.env`: `APP_NAME`, `APP_IMAGE`, `DB_DATABASE`.
3. `make db-create DB=<name>`, `make build`, `make up`, `make key`, `make migrate`.
4. Добавить домен в Caddyfile инфры, перезапустить caddy.

## Грабли (уже наступили, не повторять)

- Конфиг FrankenPHP копируется в **`/etc/frankenphp/Caddyfile`**, НЕ `/etc/caddy/`.
- OPcache в PHP 8.5 встроен в ядро — не ставить через docker-php-ext-install.
- Правки `.env` требуют `docker compose up -d --force-recreate` (env_file запекается при создании контейнера).
- В `Caddyfile.app` — `auto_https off` (TLS терминирует внешний Caddy инфры).
- Новый composer-пакет: `make rebuild`, затем `docker cp <APP_NAME>-app:/var/www/html/vendor ./vendor` (маунт перекрывает vendor образа).

## Миграции по тематикам

- Ядро (users, cache, jobs) — `database/migrations/`, бежит всегда.
- Тематика — подпапка (`database/migrations/travel/`): дефолтный `migrate` в подпапки НЕ заглядывает, подключается только явно: `php artisan migrate --path=database/migrations/travel`. Откатывать тоже с `--path` (батчи общие).
- `make migrate` = ядро + travel; `migrate-core` / `migrate-travel` — раздельно.
- Модели тематики — `App\Models\Travel\` (City, Article, Place, Persona, Media). Справочник персон: `make seed-travel`.
- Схема travel: cities → articles (city_id nullable = статья уровня страны), places, personas; pivots article_place (sort_order), article_persona; media — полиморфная (attachement к статьям и местам). У статей: markdown-контент, faq/sources jsonb, fact_checked_at.

## Конвенции кода

- Не писать комментарии в коде. Исключение — редкие места, где без пояснения не понять вообще.

## Прод-деплой

Мерж в main → GitHub Actions (`.github/workflows/`): build → GHCR → SSH на VPS → `docker compose pull && up -d`. Секреты: `VPS_HOST`, `VPS_USER`, `VPS_SSH_KEY`, `APP_NAME`. На VPS сайт живёт в `/srv/sites/<APP_NAME>/` (там `.env` + `docker-compose.yml` из этого репо).

## Прод-допил (не сделано, делать перед выкатом)

- Отдельный БД-юзер per сайт (сейчас все ходят суперюзером — утечка одного .env = доступ ко всем базам). Добавить в `make db-create`: CREATE USER + OWNER.
- npm/vite-слой в Dockerfile; entrypoint с migrate + кэшами; воркеры queue/schedule; права storage (сейчас грубо 777); бэкапы pg_dump в cron.
