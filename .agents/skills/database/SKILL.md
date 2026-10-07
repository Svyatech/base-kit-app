---
name: database
description: Архитектура БД base-kit — схема travel-тематики, связи, индексы, конвенции миграций. Читать перед любыми изменениями схемы и моделей. Дополнять при каждом изменении схемы.
---

# Архитектура БД (выжимка, дополняется при каждом изменении схемы)

Postgres 17. Ядро Laravel (users, cache, jobs, sessions) — `database/migrations/`.
Тематика — подпапки `database/migrations/<theme>/`, модели — `App\Models\<Theme>\`.

## Конвенции

- Каждому полю — `->comment('кратко по-русски')` (COMMENT ON COLUMN, видно в psql/IDE).
- **Мультиязычность: переводимые поля — jsonb** `{"ru": "...", "en": "..."}`, каст 'array' в модели. Переводимые: у cities — name, slug, excerpt, content, seo_*; у places — name, slug, description, price_note, working_hours; у articles — title, slug, excerpt, content, faq (по локалям), seo_*; у personas — name, description. НЕ переводятся (строки): name_local, address, sources, все служебные поля. Подробности — скилл multilanguage.
- upsert/insert билдером НЕ применяет касты — jsonb-поля кодировать `json_encode(..., JSON_UNESCAPED_UNICODE)` вручную (см. TravelPersonaSeeder).
- Миграции тематики — только в подпапку; запуск `migrate --path=database/migrations/<theme>`; откат тоже с `--path`.
- Порядок файлов = порядок FK (справочники и родители раньше зависимых).
- Модели — чистые: `$fillable`, касты, связи, PHPDoc `@property`/`@return` с дженериками, без логики.
- На начальном этапе схему правим свёрткой в базовые миграции + `migrate:fresh` (данных нет), а не alter-миграциями.

## Схема travel

### cities — города-хабы
name, name_local, slug (unique), excerpt, content (markdown), seo_title/seo_description, is_published, published_at, sort_order.
Карта: map_lat/map_lng (decimal 10,7, nullable) — центр карты города, map_zoom (tinyint) — зум по умолчанию (12–13).
Связи: hasMany articles, places.

### places — места (пляжи, рынки, достопримечательности...)
city_id (FK cascade), **parent_id** (nullable, FK places cascade) — иерархия adjacency list: Винперл → аквапарк. Верхний уровень = parent_id IS NULL. city_id у детей заполнен всегда (наследуется от родителя — контролирует репозиторий, не денормализовать руками).
type (beach/market/attraction/food/coworking), name, slug, description, address, google_maps_url, price_note (текстом), working_hours, sort_order (ручная сортировка по значимости), fact_checked_at.
Карта: lat/lng (decimal 10,7, nullable) — координаты для карты на хабе города (Яндекс JS API, фильтры по type) и для deep links в Google Maps.
Индексы: unique(city_id, slug), (city_id, type), (parent_id, sort_order), (lat, lng).
Связи: city, parent, children (orderBy sort_order), articles (pivot), **guideArticle** (hasOne), media (morphMany).

### articles — статьи
city_id (nullable FK nullOnDelete; NULL = уровень страны: виза, симка), **place_id** (nullable FK nullOnDelete) — статья-гайд по конкретному месту.
type (topic/comparison/persona_guide/country_topic), title, slug (unique), excerpt, content (markdown), faq (jsonb, для schema.org FAQPage), sources (jsonb, ссылки для редакции), seo_title/seo_description, status (draft/published), fact_checked_at, published_at.
Индексы: slug unique, (city_id, status, type), published_at.
Связи: city, place, places (pivot, orderByPivot sort_order), personas (pivot), media (morphMany).

**Три типа привязки статей к местам (все опциональны):**
1. Без мест: виза, деньги — place_id NULL, пивот пуст.
2. Гайд по одному месту: place_id заполнен; дети места подтягиваются автоматически через place.children.
3. Подборка мест: place_id NULL, места через пивот article_place.

### personas — справочник персон туристов
slug (unique), name, description. Сидер `TravelPersonaSeeder` (`make seed-travel`), 6 персон: first-time-asia, with-kids, long-stay, budget, no-english, digital-nomad.

### article_place — места в статье (редакционный список)
article_id, place_id (оба FK cascade), sort_order — порядок места в статье. unique(article_id, place_id).

### article_persona — "кому подходит"
article_id, persona_id (FK cascade). unique(article_id, persona_id).

### media — полиморфные аттачменты
mediable_type + mediable_id (без FK — полиморфизм; целостность и зачистка сирот — на уровне репозиториев). disk (default public), path, alt, caption, sort_order. Индекс (mediable_type, mediable_id).
Владельцы: Article, Place (morphMany media, morphTo mediable).

## Принятые решения (не переобсуждать без причины)

- Иерархия мест — adjacency list в той же таблице, НЕ junction-таблица (у места один родитель; junction = лишние джойны).
- Медиа — одна полиморфная таблица (как spatie/laravel-medialibrary), НЕ таблица на сущность.
- Цены — текстом (price_note), не структура. Часы работы — текстом.
- countries таблицы нет: 1 сайт = 1 страна, главная = article type=country_topic, city_id NULL.
- Нет пока: полнотекст (tsvector), ревизии, отдельная таблица тегов.

## Обновление этого скилла

При КАЖДОМ изменении схемы (миграция, связь, переименование) — сразу править этот файл: таблицы, поля, индексы, решения. Скилл должен всегда совпадать с реальной схемой.
