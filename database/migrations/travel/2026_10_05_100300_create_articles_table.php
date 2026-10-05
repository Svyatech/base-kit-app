<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id()->comment('ID');
            $table->foreignId('city_id')->nullable()->comment('Город (NULL — статья уровня страны)')->constrained()->nullOnDelete();
            $table->foreignId('place_id')->nullable()->comment('Место, гайдом по которому является статья')->constrained()->nullOnDelete();
            $table->string('type')->default('topic')->comment('Тип: topic, comparison, persona_guide, country_topic');
            $table->jsonb('title')->comment('Заголовок статьи (переводы: ru, en)');
            $table->jsonb('slug')->unique()->comment('ЧПУ-идентификатор для URL (переводы)');
            $table->jsonb('excerpt')->nullable()->comment('Короткое описание для карточек (переводы)');
            $table->jsonb('content')->nullable()->comment('Текст статьи в markdown (переводы)');
            $table->jsonb('faq')->nullable()->comment('FAQ-блок для schema.org FAQPage (по локалям)');
            $table->jsonb('sources')->nullable()->comment('Источники фактов (для редакции, не переводится)');
            $table->jsonb('seo_title')->nullable()->comment('SEO title (переводы)');
            $table->jsonb('seo_description')->nullable()->comment('SEO description (переводы)');
            $table->string('status')->default('draft')->comment('Статус: draft, published');
            $table->date('fact_checked_at')->nullable()->comment('Дата проверки фактов');
            $table->timestamp('published_at')->nullable()->comment('Дата публикации');
            $table->timestamps();

            $table->index(['city_id', 'status', 'type']);
            $table->index('published_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
