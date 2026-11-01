<?php

namespace Database\Seeders;

use App\Models\WhyUsFeature;
use Illuminate\Database\Seeder;

class WhyUsFeatureSeeder extends Seeder
{
    public function run(): void
    {
        $features = [
            ['eyebrow' => 'ONE JOURNEY, MANY SIDES OF DUBAI', 'title' => 'Desert Nights to City Lights', 'description' => 'Spend the afternoon crossing golden dunes, then make the most of Dubai’s celebrated landmarks, waterfronts and family attractions. We connect the desert, the city and every little detail in between through one friendly local team.', 'image' => 'images/desert-camp-experience.png', 'link_label' => 'Explore desert adventures', 'link_url' => '/desert-adventures', 'display_order' => 1, 'is_reversed' => false],
            ['eyebrow' => 'MADE FOR YOUR WISHLIST', 'title' => 'Bucket List Moments', 'description' => 'Whether your must-do moment is a desert sunset, a marine escape or an iconic attraction, we help you experience it your way. Our curated choices make it easy to choose more of what you love and less of what you need to organise.', 'image' => 'images/dubai-adventure.png', 'link_label' => 'Browse attractions', 'link_url' => '/attractions', 'display_order' => 2, 'is_reversed' => true],
            ['eyebrow' => 'TRAVEL WITH CARE', 'title' => 'Nature First', 'description' => 'Dubai’s desert is remarkable, and it deserves to stay that way. We select responsible experiences and work with guides who respect the land, wildlife and communities that make every journey feel authentic.', 'image' => 'images/desert-oasis-morning.png', 'link_label' => 'Discover city tours', 'link_url' => '/city-tours', 'display_order' => 3, 'is_reversed' => false],
        ];

        foreach ($features as $feature) {
            WhyUsFeature::query()->updateOrCreate(['title' => $feature['title']], [...$feature, 'is_active' => true]);
        }
    }
}
