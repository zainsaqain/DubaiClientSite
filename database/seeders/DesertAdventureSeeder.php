<?php

namespace Database\Seeders;

use App\Models\DesertAdventure;
use Illuminate\Database\Seeder;

class DesertAdventureSeeder extends Seeder
{
    public function run(): void
    {
        foreach (config('desert-adventures.adventures', []) as $adventure) {
            DesertAdventure::query()->updateOrCreate(
                ['title' => $adventure['title']],
                [
                    'category' => $adventure['category_name'] ?? 'Desert Safaris',
                    'description' => $adventure['description'],
                    'location' => $adventure['location_tag'] ?? 'Dubai',
                    'price' => $adventure['price'],
                    'duration' => null,
                    'image' => $adventure['image'] ?? null,
                    'is_featured' => (bool) ($adventure['is_bestseller'] ?? false),
                    'is_active' => true,
                ],
            );
        }

        $schoolTrips = [
            [
                'title' => 'Three-Day Camping Adventure',
                'description' => 'A multi-day desert learning journey with supervised activities, cultural discovery and time outdoors.',
                'location' => 'Dubai',
                'price' => 4457,
                'duration' => '3 days',
                'image' => 'images/desert-camp-experience.png',
            ],
            [
                'title' => 'A Morning at The Fort – Lisaili',
                'description' => 'A daytime desert experience with cultural moments, learning activities and a relaxed camp setting.',
                'location' => 'Lisaili',
                'price' => 425,
                'duration' => '4 hours',
                'image' => 'images/camel-desert-journey.png',
            ],
            [
                'title' => 'Overnight Wildlife Adventure',
                'description' => 'An overnight itinerary built around a slower-paced desert and wildlife experience for school groups.',
                'location' => 'Dubai',
                'price' => 4125,
                'duration' => 'Overnight',
                'image' => 'images/desert-oasis-morning.png',
            ],
            [
                'title' => 'Morning Wildlife Safari',
                'description' => 'A morning desert visit with wildlife-focused learning moments, guided exploration and outdoor discovery.',
                'location' => 'Dubai',
                'price' => 675,
                'duration' => '5 hours',
                'image' => 'images/desert-safari.png',
            ],
        ];

        foreach ($schoolTrips as $schoolTrip) {
            DesertAdventure::query()->updateOrCreate(
                ['title' => $schoolTrip['title'], 'category' => 'School Trips'],
                [...$schoolTrip, 'is_featured' => false, 'is_active' => true],
            );
        }
    }
}
