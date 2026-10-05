<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->id()->comment('ID');
            $table->string('slug')->unique()->comment('Код персоны');
            $table->jsonb('name')->comment('Название персоны (переводы: ru, en)');
            $table->jsonb('description')->nullable()->comment('Описание персоны (переводы)');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
