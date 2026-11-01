<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_signature_journeys', function (Blueprint $table) {
            $table->id();
            $table->string('badge');
            $table->string('caption');
            $table->string('eyebrow');
            $table->string('title');
            $table->string('highlight');
            $table->text('description');
            $table->string('point_one');
            $table->string('point_two');
            $table->string('point_three');
            $table->string('button_label');
            $table->string('button_url');
            $table->string('image')->nullable();
            $table->unsignedSmallInteger('display_order')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_signature_journeys');
    }
};
