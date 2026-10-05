<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id')->constrained()->cascadeOnDelete();
            $table->string('type');
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->string('address')->nullable();
            $table->string('google_maps_url')->nullable();
            $table->string('price_note')->nullable();
            $table->string('working_hours')->nullable();
            $table->date('fact_checked_at')->nullable();
            $table->timestamps();

            $table->unique(['city_id', 'slug']);
            $table->index(['city_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('places');
    }
};
