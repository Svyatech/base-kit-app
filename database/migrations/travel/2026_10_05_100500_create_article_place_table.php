<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('article_place', function (Blueprint $table) {
            $table->id()->comment('ID');
            $table->foreignId('article_id')->comment('Статья')->constrained()->cascadeOnDelete();
            $table->foreignId('place_id')->comment('Место')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('sort_order')->default(0)->comment('Порядок места в статье');

            $table->unique(['article_id', 'place_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('article_place');
    }
};
