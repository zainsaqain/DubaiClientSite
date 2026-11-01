<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('waterpark_theme_parks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('park_type')->default('Waterpark');
            $table->text('description');
            $table->string('location')->default('Dubai');
            $table->decimal('price', 10, 2);
            $table->string('image')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('waterpark_theme_parks');
    }
};
