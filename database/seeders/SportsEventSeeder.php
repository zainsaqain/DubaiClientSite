<?php

namespace Database\Seeders;

use App\Models\SportsEvent;
use Illuminate\Database\Seeder;

class SportsEventSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            [
                'title' => 'Dubai Championship Golf Day',
                'event_type' => 'Golf',
                'description' => 'A polished day on the fairway with championship atmosphere, skyline views and premium hospitality.',
                'location' => 'Dubai',
                'price' => 100028,
                'image' => 'images/sports-golf-dubai.png',
                'is_featured' => true,
            ],
            [
                'title' => 'Abu Dhabi Grand Prix Weekend',
                'event_type' => 'Motorsport',
                'description' => 'Feel the energy of race weekend with a seamless UAE experience built around speed, spectacle and excitement.',
                'location' => 'Abu Dhabi',
                'price' => 299622,
                'image' => 'images/sports-events-dubai.png',
                'is_featured' => true,
            ],
            [
                'title' => 'Dubai Sevens Rugby Experience',
                'event_type' => 'Rugby',
                'description' => 'A high-energy stadium day with world-class rugby, big-match atmosphere and unforgettable Dubai evenings.',
                'location' => 'Dubai',
                'price' => 115417,
                'image' => 'images/sports-rugby-dubai.png',
                'is_featured' => true,
            ],
            [
                'title' => 'Topgolf Dubai Evening',
                'event_type' => 'Leisure sport',
                'description' => 'Bring your group together for golf, great food and city views in one of Dubai’s favourite social spots.',
                'location' => 'Dubai',
                'price' => 13850,
                'image' => 'images/sports-golf-dubai.png',
                'is_featured' => false,
            ],
        ];

        foreach ($events as $event) {
            SportsEvent::query()->updateOrCreate(
                ['title' => $event['title']],
                [...$event, 'is_active' => true],
            );
        }
    }
}
