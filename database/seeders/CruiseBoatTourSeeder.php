<?php

namespace Database\Seeders;

use App\Models\CruiseBoatTour;
use Illuminate\Database\Seeder;

class CruiseBoatTourSeeder extends Seeder
{
    public function run(): void
    {
        $tours = [
            ['title' => 'Luxury Dubai Marina Cruise', 'tour_type' => 'Luxury yacht', 'description' => 'Sail past Dubai Marina’s iconic skyline with space to relax, celebrate and enjoy the view.', 'location' => 'Dubai Marina', 'price' => 16158, 'image' => 'images/cruise-dubai-marina.png', 'is_featured' => true],
            ['title' => 'Sunset Dhow Dinner Cruise', 'tour_type' => 'Dinner cruise', 'description' => 'A relaxed evening on the water with a glowing skyline, dinner and gentle marina views.', 'location' => 'Dubai Marina', 'price' => 10157, 'image' => 'images/dubai-adventure.png', 'is_featured' => true],
            ['title' => 'Palm & Atlantis Speedboat Tour', 'tour_type' => 'Speedboat', 'description' => 'See the city from a fresh perspective as you cruise from Dubai Marina towards Palm Jumeirah.', 'location' => 'Dubai Marina', 'price' => 11157, 'image' => 'images/cruise-dubai-marina.png', 'is_featured' => true],
            ['title' => 'Old Dubai Abra Journey', 'tour_type' => 'Heritage waterway', 'description' => 'Slow down and discover a classic side of Dubai with a scenic crossing on the historic creek.', 'location' => 'Dubai Creek', 'price' => 6771, 'image' => 'images/airport-transfer.png', 'is_featured' => false],
        ];

        foreach ($tours as $tour) {
            CruiseBoatTour::query()->updateOrCreate(
                ['title' => $tour['title']],
                [...$tour, 'is_active' => true],
            );
        }
    }
}
