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
        Schema::create('tour_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->unsignedInteger('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });

        Schema::create('tour_subcategories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_category_id')->constrained()->restrictOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->unsignedInteger('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });

        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_category_id')->constrained()->restrictOnDelete();
            $table->foreignId('tour_subcategory_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('short_description', 1200)->nullable();
            $table->longText('about')->nullable();
            $table->longText('full_description')->nullable();
            $table->string('location')->default('Dubai');
            $table->unsignedInteger('duration')->nullable();
            $table->string('duration_unit', 20)->nullable();
            $table->json('languages')->nullable();
            $table->decimal('starting_price', 12, 2)->default(0);
            $table->string('currency', 8)->default('AED');
            $table->string('status', 16)->default('draft');
            $table->string('thumbnail')->nullable();
            $table->string('main_image')->nullable();
            $table->string('image_alt')->nullable();
            $table->text('pickup_information')->nullable();
            $table->longText('highlights')->nullable();
            $table->longText('know_before_you_go')->nullable();
            $table->longText('age_policy')->nullable();
            $table->longText('cancellation_policy')->nullable();
            $table->longText('additional_notes')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_bestseller')->default(false);
            $table->boolean('is_travellers_choice')->default(false);
            $table->boolean('is_original')->default(false);
            $table->string('location_badge')->nullable();
            $table->unsignedInteger('display_order')->default(0);
            $table->string('youtube_url')->nullable();
            $table->timestamps();
        });

        Schema::create('tour_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained()->cascadeOnDelete();
            $table->string('path');
            $table->string('alt')->nullable();
            $table->string('caption')->nullable();
            $table->unsignedInteger('display_order')->default(0);
            $table->timestamps();
        });

        Schema::create('tour_features', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('icon')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('tour_feature', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tour_feature_id')->constrained()->restrictOnDelete();
            $table->string('inclusion_status', 16)->default('included');
            $table->unique(['tour_id', 'tour_feature_id']);
        });

        Schema::create('tour_itineraries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('display_order')->default(0);
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedInteger('duration')->nullable();
            $table->string('duration_unit', 20)->nullable();
            $table->string('icon')->nullable();
            $table->timestamps();
        });

        Schema::create('tour_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('display_order')->default(0);
            $table->timestamps();
        });

        Schema::create('tour_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tour_package_id')->nullable()->constrained()->nullOnDelete();
            $table->string('vehicle_type', 50)->default('shared');
            $table->decimal('adult_price', 12, 2)->default(0);
            $table->decimal('child_price', 12, 2)->nullable();
            $table->unsignedInteger('minimum_guests')->default(1);
            $table->unsignedInteger('maximum_guests')->nullable();
            $table->string('currency', 8)->default('AED');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->unique(['tour_id', 'tour_package_id', 'vehicle_type'], 'tour_prices_unique_combination');
        });

        Schema::create('tour_availabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained()->cascadeOnDelete();
            $table->date('available_date')->nullable();
            $table->time('start_time')->nullable();
            $table->unsignedInteger('capacity')->nullable();
            $table->unsignedInteger('booking_cutoff_hours')->default(0);
            $table->boolean('is_blocked')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_availabilities');
        Schema::dropIfExists('tour_prices');
        Schema::dropIfExists('tour_packages');
        Schema::dropIfExists('tour_itineraries');
        Schema::dropIfExists('tour_feature');
        Schema::dropIfExists('tour_features');
        Schema::dropIfExists('tour_images');
        Schema::dropIfExists('tours');
        Schema::dropIfExists('tour_subcategories');
        Schema::dropIfExists('tour_categories');
    }
};
