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
            $table->string('name')->comment('Название города');
            $table->string('name_local')->nullable()->comment('Название на языке страны');
            $table->string('slug')->unique()->comment('ЧПУ-идентификатор для URL');
            $table->text('excerpt')->nullable()->comment('Короткое "кому подходит" для карточек');
            $table->longText('content')->nullable()->comment('Обзор города (markdown)');
            $table->string('seo_title')->nullable()->comment('SEO title');
            $table->string('seo_description')->nullable()->comment('SEO description');
            $table->boolean('is_published')->default(false)->comment('Опубликован ли город');
            $table->timestamp('published_at')->nullable()->comment('Дата публикации');
            $table->unsignedInteger('sort_order')->default(0)->comment('Порядок в навигации');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
