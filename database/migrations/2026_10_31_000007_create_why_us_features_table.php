<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('why_us_features', function (Blueprint $table) {
            $table->id();
            $table->string('eyebrow');
            $table->string('title');
            $table->text('description');
            $table->string('image')->nullable();
            $table->string('link_label')->nullable();
            $table->string('link_url')->nullable();
            $table->unsignedSmallInteger('display_order')->default(1);
            $table->boolean('is_reversed')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('why_us_features');
    }
};
