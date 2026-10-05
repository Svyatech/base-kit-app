<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id()->comment('ID');
            $table->string('mediable_type')->comment('Класс модели-владельца');
            $table->unsignedBigInteger('mediable_id')->comment('ID записи-владельца');
            $table->string('disk')->default('public')->comment('Диск Laravel Storage');
            $table->string('path')->comment('Путь к файлу на диске');
            $table->string('alt')->nullable()->comment('Alt-текст изображения');
            $table->string('caption')->nullable()->comment('Подпись к изображению');
            $table->unsignedInteger('sort_order')->default(0)->comment('Порядок сортировки');
            $table->timestamps();

            $table->index(['mediable_type', 'mediable_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
