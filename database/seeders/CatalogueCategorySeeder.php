<?php

namespace Database\Seeders;

use App\Models\TourCategory;
use Illuminate\Database\Seeder;

class CatalogueCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Attractions', 'slug' => 'attractions', 'description' => 'Discover landmark tickets, family attractions and memorable Dubai experiences.'],
            ['name' => 'Sports Events', 'slug' => 'sports-events', 'description' => 'Explore live sports events and activity experiences across the UAE.'],
            ['name' => 'City Tours', 'slug' => 'city-tours', 'description' => 'See the highlights, culture and neighbourhoods of Dubai and the UAE.'],
            ['name' => 'Cruise and Boat Tours', 'slug' => 'cruise-and-boat-tours', 'description' => 'Enjoy Dubai Marina cruises, yacht experiences and scenic boat tours.'],
            ['name' => 'Waterparks & Theme Parks', 'slug' => 'waterparks-and-theme-parks', 'description' => 'Plan family days out at waterparks and theme parks.'],
            ['name' => 'Transfers', 'slug' => 'transfers', 'description' => 'Book reliable airport, hotel and private transport services.'],
        ];

        foreach ($categories as $displayOrder => $category) {
            TourCategory::query()->updateOrCreate(
                ['slug' => $category['slug']],
                [
                    'name' => $category['name'],
                    'description' => $category['description'],
                    'display_order' => $displayOrder + 1,
                    'is_active' => true,
                ],
            );
        }
    }
}
