<?php

namespace Database\Seeders;

use App\Models\WaterparkThemePark;
use Illuminate\Database\Seeder;

class WaterparkThemeParkSeeder extends Seeder
{
    public function run(): void
    {
        $parks = [
            ['title' => 'Dubai Parks and Resorts', 'park_type' => 'Theme park', 'description' => 'A full day of rides, stories and family fun across Dubai’s favourite entertainment parks.', 'location' => 'Dubai', 'price' => 22699, 'image' => 'images/dubai-attractions.png', 'is_featured' => true],
            ['title' => 'Atlantis Aquaventure', 'park_type' => 'Waterpark', 'description' => 'Dive into slides, splash zones and ocean-inspired thrills at one of Dubai’s most iconic waterparks.', 'location' => 'Dubai', 'price' => 31932, 'image' => 'images/water-theme-parks-dubai.png', 'is_featured' => true],
            ['title' => 'IMG Worlds of Adventure', 'park_type' => 'Indoor adventure', 'description' => 'Step into an air-conditioned world of big rides, favourite characters and all-day entertainment.', 'location' => 'Dubai', 'price' => 28085, 'image' => 'images/global-village-dubai.png', 'is_featured' => true],
            ['title' => 'Ski Dubai Snow Park', 'park_type' => 'Indoor snow', 'description' => 'Swap the sunshine for snowy slopes, winter activities and memorable family moments.', 'location' => 'Dubai', 'price' => 19236, 'image' => 'images/hero-dubai-aquarium.png', 'is_featured' => false],
            ['title' => 'Wild Wadi Waterpark', 'park_type' => 'Waterpark', 'description' => 'Cool off with exciting slides, wave pools and spectacular views close to Burj Al Arab.', 'location' => 'Dubai', 'price' => 19929, 'image' => 'images/water-theme-parks-dubai.png', 'is_featured' => false],
        ];

        foreach ($parks as $park) {
            WaterparkThemePark::query()->updateOrCreate(['title' => $park['title']], [...$park, 'is_active' => true]);
        }
    }
}
