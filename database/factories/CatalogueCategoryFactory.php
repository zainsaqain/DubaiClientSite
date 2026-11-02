<?php

namespace Database\Factories;

use App\Models\CatalogueCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CatalogueCategory>
 */
class CatalogueCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'parent_id' => null,
            'level' => 1,
            'name' => fake()->unique()->words(2, true),
            'slug' => fake()->unique()->slug(2),
            'description' => fake()->optional()->sentence(),
            'image_path' => null,
            'display_order' => 0,
            'status' => 'draft',
            'meta_title' => null,
            'meta_description' => null,
        ];
    }
}
