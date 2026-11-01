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
        Schema::table('tour_packages', function (Blueprint $table) {
            $table->boolean('is_recommended')->default(false)->after('is_active');
            $table->string('badge_label', 80)->nullable()->after('is_recommended');
        });

        Schema::table('tour_prices', function (Blueprint $table) {
            $table->string('vehicle_label', 120)->nullable()->after('vehicle_type');
            $table->text('description')->nullable()->after('vehicle_label');
            $table->unsignedTinyInteger('child_min_age')->nullable()->after('child_price');
            $table->unsignedTinyInteger('child_max_age')->nullable()->after('child_min_age');
            $table->decimal('infant_price', 12, 2)->nullable()->after('child_max_age');
            $table->unsignedTinyInteger('infant_max_age')->nullable()->after('infant_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tour_prices', function (Blueprint $table) {
            $table->dropColumn(['vehicle_label', 'description', 'child_min_age', 'child_max_age', 'infant_price', 'infant_max_age']);
        });

        Schema::table('tour_packages', function (Blueprint $table) {
            $table->dropColumn(['is_recommended', 'badge_label']);
        });
    }
};
