# base-kit site

Базовый движок сайта: Laravel 13 + PHP 8.5 + FrankenPHP в Docker.
Это шаблон — для нового сайта копируешь папку, меняешь `.env`, и это уже самостоятельный проект.

Инфраструктура (Caddy, Postgres, Redis) — отдельно, в репозитории `base-kit-infra`.
Все сайты делят один Postgres (у каждого своя база), один Redis и один Caddy.

## Требования

- Docker
- make

## Первый запуск

```bash
cp .env.example .env

make infra-init   # создать общую сеть web (один раз на машине)
make infra-up     # поднять caddy, postgres, redis
make build-base   # собрать базовый образ PHP (один раз, потом редко)
make build        # собрать образ сайта
make db-create DB=basekit
make up
make key          # сгенерировать APP_KEY
make migrate
```

Сайт доступен на http://localhost:8080 (порт задаётся в `infra/.env`).

## Разработка

```bash
make dev      # код смонтирован в контейнер, правки видны по F5 без пересборки
make shell    # shell в контейнере
make tinker   # artisan tinker
make logs     # логи
```

`make` без аргументов показывает все команды с описаниями.

## Прод

Мерж в `main` → GitHub Actions собирает образ → пушит в GHCR → по SSH
обновляет контейнер на VPS (`docker compose pull && up -d`).

Нужные секреты репозитория: `VPS_HOST`, `VPS_USER`, `VPS_SSH_KEY`, `APP_NAME`.
На VPS сайт живёт в `/srv/sites/<APP_NAME>/` — там `.env` и `docker-compose.yml` из этого репозитория.

## Новый сайт из шаблона

1. Скопировать папку `site/` в новый репозиторий.
2. Поменять в `.env`: `APP_NAME`, `APP_IMAGE`, `DB_DATABASE`.
3. `make db-create DB=<новая-база>`, `make build`, `make up`, `make key`, `make migrate`.
4. Добавить домен в Caddyfile инфры.
