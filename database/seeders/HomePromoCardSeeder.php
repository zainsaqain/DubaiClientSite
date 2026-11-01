<?php

namespace Database\Seeders;

use App\Models\HomePromoCard;
use Illuminate\Database\Seeder;

class HomePromoCardSeeder extends Seeder
{
    public function run(): void
    {
        $cards = [
            ['eyebrow' => 'WMT CURATED', 'title' => 'Curated City Tours', 'description' => 'Book private and shared tours with expert guides across the country’s cultural landmarks.', 'image' => 'images/airport-transfer.png', 'button_label' => 'Learn more', 'button_url' => '#city-tours', 'display_order' => 1],
            ['eyebrow' => 'WMT CURATED', 'title' => "UAE's most popular adventures", 'description' => 'From family fun to bucket-list experiences, there is an adventure for every kind of traveler.', 'image' => 'images/cruise-dubai-marina.png', 'button_label' => 'Learn more', 'button_url' => '#booking', 'display_order' => 2],
        ];

        foreach ($cards as $card) {
            HomePromoCard::query()->updateOrCreate(['title' => $card['title']], [...$card, 'is_active' => true]);
        }
    }
}
