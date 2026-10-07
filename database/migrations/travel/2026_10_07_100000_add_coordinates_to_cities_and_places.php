<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cities', function (Blueprint $table) {
            $table->decimal('map_lat', 10, 7)->nullable()->comment('Широта центра карты города');
            $table->decimal('map_lng', 10, 7)->nullable()->comment('Долгота центра карты города');
            $table->unsignedTinyInteger('map_zoom')->nullable()->comment('Зум карты города по умолчанию (12–13)');
        });

        Schema::table('places', function (Blueprint $table) {
            $table->decimal('lat', 10, 7)->nullable()->comment('Широта для карты');
            $table->decimal('lng', 10, 7)->nullable()->comment('Долгота для карты');
            $table->index(['lat', 'lng']);
        });
    }

    public function down(): void
    {
        Schema::table('cities', function (Blueprint $table) {
            $table->dropColumn(['map_lat', 'map_lng', 'map_zoom']);
        });

        Schema::table('places', function (Blueprint $table) {
            $table->dropIndex(['lat', 'lng']);
            $table->dropColumn(['lat', 'lng']);
        });
    }
};
