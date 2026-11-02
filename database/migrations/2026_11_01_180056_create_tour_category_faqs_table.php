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
        Schema::create('tour_category_faqs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_category_id')->constrained()->cascadeOnDelete();
            $table->string('question', 255);
            $table->text('answer');
            $table->unsignedSmallInteger('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['tour_category_id', 'is_active', 'display_order'], 'tc_faqs_public_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_category_faqs');
    }
};
