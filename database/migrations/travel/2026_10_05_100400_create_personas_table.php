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
            $table->string('name')->comment('Название персоны');
            $table->string('description')->nullable()->comment('Описание персоны');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
