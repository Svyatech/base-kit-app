<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('article_persona', function (Blueprint $table) {
            $table->id()->comment('ID');
            $table->foreignId('article_id')->comment('Статья')->constrained()->cascadeOnDelete();
            $table->foreignId('persona_id')->comment('Персона')->constrained()->cascadeOnDelete();

            $table->unique(['article_id', 'persona_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('article_persona');
    }
};
