<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id')->nullable()->constrained()->nullOnDelete();
            $table->string('type')->default('topic');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content')->nullable();
            $table->jsonb('faq')->nullable();
            $table->jsonb('sources')->nullable();
            $table->string('seo_title')->nullable();
            $table->string('seo_description')->nullable();
            $table->string('status')->default('draft');
            $table->date('fact_checked_at')->nullable();
            $table->timestamp('published_at')->nullable();
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
