<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The V2 catalogue is intentionally isolated from the legacy database.
     */
    protected $connection = 'tourism_v2';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('catalogue_categories', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('catalogue_categories')->restrictOnDelete();
            $table->unsignedTinyInteger('level');
            $table->string('name', 150);
            $table->string('slug', 180);
            $table->text('description')->nullable();
            $table->string('image_path')->nullable();
            $table->unsignedInteger('display_order')->default(0);
            $table->string('status', 20)->default('draft');
            $table->string('meta_title', 255)->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();

            $table->unique(['parent_id', 'slug']);
            $table->index(['parent_id', 'level', 'status', 'display_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalogue_categories');
    }
};
