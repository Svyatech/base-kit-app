# Makefile для сайта на base-kit. Все команды — из папки site/.

# Имена сайта и образа — ТОЛЬКО из .env (APP_NAME, APP_IMAGE).
# BASE_IMAGE — константа: базовый PHP-образ один на все сайты.
-include .env
export

BASE_IMAGE := base-kit-php

COMPOSE      := docker compose -f docker-compose.yml
COMPOSE_DEV  := docker compose -f docker-compose.yml -f docker-compose.dev.yml
COMPOSE_INFRA:= docker compose -f ../infra/docker-compose.yml

.DEFAULT_GOAL := help

## --- Инфраструктура (общая: caddy, postgres, redis) ---

infra-init: ## Первый раз: создать общую сеть web
	docker network create web || true

infra-up: ## Поднять инфраструктуру
	$(COMPOSE_INFRA) up -d

infra-down: ## Остановить инфраструктуру
	$(COMPOSE_INFRA) down

infra-logs: ## Логи инфраструктуры
	$(COMPOSE_INFRA) logs -f

## --- Сборка ---

build-base: ## Собрать базовый образ base-kit-php
	docker build -f docker/php.Dockerfile -t $(BASE_IMAGE) .

build: ## Собрать образ сайта
	docker build --build-arg BASE_IMAGE=$(BASE_IMAGE) -t $(APP_IMAGE) .

rebuild: build up-recreate ## Пересобрать сайт и перезапустить (как прод-деплой)

up: ## Поднять сайт (режим "как на проде", код запечён в образе)
	$(COMPOSE) up -d

up-recreate: ## Перезапустить сайт с новым образом
	$(COMPOSE) up -d --force-recreate

dev: ## Поднять сайт в дев-режиме (код смонтирован, правки видны по F5)
	@if [ ! -f vendor/autoload.php ] || [ composer.lock -nt vendor/autoload.php ]; then $(MAKE) vendor; fi
	$(COMPOSE_DEV) up -d

vendor: ## Установить/обновить vendor с dev-зависимостями (нужен дев-режиму, маунт перекрывает vendor образа)
	docker run --rm -v "$$PWD":/var/www/html -w /var/www/html $(BASE_IMAGE) composer install --prefer-dist --no-interaction

down: ## Остановить сайт
	$(COMPOSE) down

restart: ## Перезапустить контейнер сайта
	docker restart $(APP_NAME)-app

ps: ## Статус контейнеров
	docker ps --filter "name=$(APP_NAME)" --filter "name=infra-"

## --- Работа с приложением ---

migrate: ## Накатить миграции (ядро + travel)
	docker exec $(APP_NAME)-app php artisan migrate --force
	docker exec $(APP_NAME)-app php artisan migrate --force --path=database/migrations/travel

migrate-core: ## Только ядро (database/migrations)
	docker exec $(APP_NAME)-app php artisan migrate --force

migrate-travel: ## Только travel-тематику
	docker exec $(APP_NAME)-app php artisan migrate --force --path=database/migrations/travel

seed-travel: ## Справочник персон туристов
	docker exec $(APP_NAME)-app php artisan db:seed --class=TravelPersonaSeeder --force

test: ## Прогнать тесты
	docker exec $(APP_NAME)-app php artisan test

shell: ## Shell внутри контейнера сайта
	docker exec -it $(APP_NAME)-app sh

tinker: ## Laravel tinker
	docker exec -e HOME=/tmp -it $(APP_NAME)-app php artisan tinker

cache-clear: ## Сбросить кэши Laravel
	docker exec $(APP_NAME)-app php artisan optimize:clear

key: ## Сгенерировать APP_KEY (первый запуск сайта)
	docker exec $(APP_NAME)-app php artisan key:generate --force

logs: ## Логи сайта (live)
	docker logs -f $(APP_NAME)-app

## --- База ---

db-create: ## Создать базу сайта в общем Postgres: make db-create DB=mydb
	docker exec infra-postgres-1 psql -U basekit -c "CREATE DATABASE $(DB);"

db-shell: ## psql в базу сайта: make db-shell DB=basekit
	docker exec -it infra-postgres-1 psql -U basekit -d $(DB)

db-dump: ## Дамп базы в файл: make db-dump DB=basekit
	docker exec infra-postgres-1 pg_dump -U basekit $(DB) | gzip > dump-$(DB)-$(shell date +%Y%m%d-%H%M).sql.gz

## --- Прочее ---

help: ## Показать эту справку
	@grep -E '^[a-zA-Z_-]+:.*?## ' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "  \033[36m%-15s\033[0m %s\n", $$1, $$2}'

.PHONY: infra-init infra-up infra-down infra-logs build-base build rebuild up up-recreate dev vendor down restart ps migrate migrate-core migrate-travel seed-travel test shell tinker cache-clear key logs db-create db-shell db-dump help
