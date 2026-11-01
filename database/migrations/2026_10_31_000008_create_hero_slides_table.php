<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hero_slides', function (Blueprint $table) {
            $table->id();
            $table->string('badge');
            $table->string('heading');
            $table->string('heading_highlight');
            $table->text('description');
            $table->string('image')->nullable();
            $table->string('image_alt')->nullable();
            $table->string('primary_label');
            $table->string('primary_url');
            $table->string('secondary_label');
            $table->string('secondary_url');
            $table->string('feature_one');
            $table->string('feature_two');
            $table->string('feature_three');
            $table->unsignedSmallInteger('display_order')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hero_slides');
    }
};
