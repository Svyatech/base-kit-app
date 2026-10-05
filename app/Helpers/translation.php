<?php

if (! function_exists('tkey')) {

    /**
     * Путь к jsonb-ключу перевода для SQL: tkey('slug') → "slug->en" (текущая локаль).
     *
     * @param string      $column
     * @param string|null $locale
     *
     * @return string
     */
    function tkey(string $column, ?string $locale = null): string
    {
        return $column.'->'.($locale ?? app()->getLocale());
    }
}
