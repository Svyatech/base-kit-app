<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id()->comment('ID');
            $table->jsonb('name')->comment('Название города (переводы: ru, en)');
            $table->string('name_local')->nullable()->comment('Название на языке страны (не перевод)');
            $table->jsonb('slug')->unique()->comment('ЧПУ-идентификатор для URL (переводы: ru, en)');
            $table->jsonb('excerpt')->nullable()->comment('Короткое "кому подходит" для карточек (переводы)');
            $table->jsonb('content')->nullable()->comment('Обзор города в markdown (переводы)');
            $table->jsonb('seo_title')->nullable()->comment('SEO title (переводы)');
            $table->jsonb('seo_description')->nullable()->comment('SEO description (переводы)');
            $table->boolean('is_published')->default(false)->comment('Опубликован ли город');
            $table->timestamp('published_at')->nullable()->comment('Дата публикации');
            $table->unsignedInteger('sort_order')->default(0)->comment('Порядок в навигации');
            $table->decimal('map_lat', 10, 7)->nullable()->comment('Широта центра карты города');
            $table->decimal('map_lng', 10, 7)->nullable()->comment('Долгота центра карты города');
            $table->unsignedTinyInteger('map_zoom')->nullable()->comment('Зум карты города по умолчанию (12–13)');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
