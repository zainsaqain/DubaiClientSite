<?php

namespace Database\Seeders;

use App\Models\CityTour;
use Illuminate\Database\Seeder;

class CityTourSeeder extends Seeder
{
    public function run(): void
    {
        $tours = [
            ['title' => 'Dubai Full Day Tour', 'tour_type' => 'Full day', 'description' => 'Explore Dubai’s essential landmarks, colourful souks and modern skyline with an expert local guide.', 'location' => 'Dubai', 'price' => 18900, 'image' => 'images/dubai-adventure.png', 'is_featured' => true],
            ['title' => 'Abu Dhabi Heritage Tour', 'tour_type' => 'Culture & heritage', 'description' => 'Discover grand architecture, remarkable stories and the cultural heart of the UAE capital.', 'location' => 'Abu Dhabi', 'price' => 28941, 'image' => 'images/dubai-attractions.png', 'is_featured' => true],
            ['title' => 'Abu Dhabi Attractions Tour', 'tour_type' => 'City highlights', 'description' => 'A carefully planned full-day journey through Abu Dhabi’s best-known attractions and photo stops.', 'location' => 'Abu Dhabi', 'price' => 24822, 'image' => 'images/global-village-dubai.png', 'is_featured' => true],
            ['title' => 'Modern Dubai City Tour', 'tour_type' => 'Modern Dubai', 'description' => 'See the city’s impressive new districts, Palm Jumeirah, Marina and world-famous architecture.', 'location' => 'Dubai', 'price' => 11817, 'image' => 'images/helicopter-tour-dubai.png', 'is_featured' => true],
            ['title' => 'Traditional Dubai Tour', 'tour_type' => 'Old Dubai', 'description' => 'Travel through the city’s historic side with local stories, traditional markets and creek views.', 'location' => 'Dubai', 'price' => 13880, 'image' => 'images/desert-camp-experience.png', 'is_featured' => false],
            ['title' => 'Private Dubai City Tour', 'tour_type' => 'Private experience', 'description' => 'Enjoy the freedom of a flexible private city tour designed around your interests and pace.', 'location' => 'Dubai', 'price' => 41660, 'image' => 'images/cruise-dubai-marina.png', 'is_featured' => false],
        ];
        foreach ($tours as $tour) {
            CityTour::query()->updateOrCreate(['title' => $tour['title']], [...$tour, 'is_active' => true]);
        }
    }
}
