<?php

namespace Database\Seeders;

use App\Models\Attraction;
use Illuminate\Database\Seeder;

class AttractionSeeder extends Seeder
{
    public function run(): void
    {
        $attractions = [
            ['title' => 'Dubai Aquarium & Underwater Zoo', 'attraction_type' => 'Top attraction', 'description' => 'Step into a spectacular underwater world filled with sharks, rays and more than 33,000 aquatic animals.', 'location' => 'Dubai', 'price' => 8950, 'image' => 'images/hero-dubai-aquarium.png', 'is_featured' => true],
            ['title' => 'Global Village Entry Ticket', 'attraction_type' => 'Family favourite', 'description' => 'Discover pavilions, entertainment, street food and colourful moments from around the world.', 'location' => 'Dubai', 'price' => 2308, 'image' => 'images/global-village-dubai.png', 'is_featured' => true],
            ['title' => 'Helicopter Tour in Dubai', 'attraction_type' => 'Skyline views', 'description' => 'See Palm Jumeirah, Burj Khalifa and Dubai’s iconic coastline from an unforgettable new perspective.', 'location' => 'Dubai', 'price' => 54631, 'image' => 'images/helicopter-tour-dubai.png', 'is_featured' => true],
            ['title' => 'At The Top, Burj Khalifa', 'attraction_type' => 'Entry ticket', 'description' => 'Travel high above the city for extraordinary views from the world’s most celebrated tower.', 'location' => 'Dubai', 'price' => 14563, 'image' => 'images/dubai-adventure.png', 'is_featured' => true],
            ['title' => 'The View at The Palm', 'attraction_type' => 'Observation deck', 'description' => 'Take in the breathtaking panorama of Palm Jumeirah, Dubai Marina and the Arabian Gulf.', 'location' => 'Palm Jumeirah', 'price' => 14236, 'image' => 'images/cruise-dubai-marina.png', 'is_featured' => false],
            ['title' => 'Dubai Frame Entrance Ticket', 'attraction_type' => 'City landmark', 'description' => 'Walk between old and new Dubai at one of the city’s most distinctive architectural landmarks.', 'location' => 'Dubai', 'price' => 8440, 'image' => 'images/dubai-attractions.png', 'is_featured' => false],
        ];
        foreach ($attractions as $attraction) {
            Attraction::query()->updateOrCreate(['title' => $attraction['title']], [...$attraction, 'is_active' => true]);
        }
    }
}
