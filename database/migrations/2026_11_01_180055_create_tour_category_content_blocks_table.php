<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tour_category_content_blocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_category_id')->constrained()->cascadeOnDelete();
            $table->string('heading', 180);
            $table->text('body');
            $table->string('image')->nullable();
            $table->string('image_alt', 255)->nullable();
            $table->string('layout', 30)->default('image_left');
            $table->unsignedSmallInteger('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['tour_category_id', 'is_active', 'display_order'], 'tc_blocks_public_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_category_content_blocks');
    }
};
