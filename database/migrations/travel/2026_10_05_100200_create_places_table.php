<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('places', function (Blueprint $table) {
            $table->id()->comment('ID');
            $table->foreignId('city_id')->comment('Город')->constrained()->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable()->comment('Родительское место (комплекс, внутри которого находится)')->constrained('places')->cascadeOnDelete();
            $table->string('type')->comment('Тип: beach, market, attraction, food, coworking');
            $table->jsonb('name')->comment('Название места (переводы: ru, en)');
            $table->jsonb('slug')->comment('ЧПУ, уникален в пределах города (переводы)');
            $table->jsonb('description')->nullable()->comment('Описание (переводы)');
            $table->string('address')->nullable()->comment('Адрес (не переводится)');
            $table->string('google_maps_url')->nullable()->comment('Ссылка на Google Maps');
            $table->jsonb('price_note')->nullable()->comment('Цены текстом: "вход 30к донг, лежак 50к" (переводы)');
            $table->jsonb('working_hours')->nullable()->comment('Часы работы (переводы)');
            $table->unsignedInteger('sort_order')->default(0)->comment('Порядок вывода (по значимости)');
            $table->date('fact_checked_at')->nullable()->comment('Дата проверки фактов');
            $table->timestamps();

            $table->unique(['city_id', 'slug']);
            $table->index(['city_id', 'type']);
            $table->index(['parent_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('places');
    }
};
