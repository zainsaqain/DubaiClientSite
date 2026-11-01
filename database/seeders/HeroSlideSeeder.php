<?php

namespace Database\Seeders;

use App\Models\HeroSlide;
use Illuminate\Database\Seeder;

class HeroSlideSeeder extends Seeder
{
    public function run(): void
    {
        $slides = [
            ['badge' => 'EXPLORE DUBAI', 'heading' => "Discover Dubai's Best Attractions", 'heading_highlight' => 'Best Attractions', 'description' => 'Browse unforgettable experiences and make the most of your Dubai adventure.', 'image' => 'images/hero-dubai-aquarium.png', 'image_alt' => 'Mother and daughter enjoying a Dubai aquarium experience', 'primary_label' => 'Book Now', 'primary_url' => '#attractions', 'secondary_label' => 'Explore All', 'secondary_url' => '#attractions', 'feature_one' => 'Iconic Places', 'feature_two' => 'Family Fun', 'feature_three' => 'Easy Booking', 'display_order' => 1],
            ['badge' => 'DUBAI AIRPORT TRANSFERS', 'heading' => 'Arrive in Dubai. Travel in Comfort.', 'heading_highlight' => 'Travel in Comfort.', 'description' => 'Enjoy pre-booked pick-up or drop-off between the airport and any hotel or residence in Dubai.', 'image' => 'images/airport-transfer.png', 'image_alt' => 'Luxury Dubai airport transfer with private chauffeur and SUV', 'primary_label' => 'Book Now', 'primary_url' => '#transfers', 'secondary_label' => 'How It Works', 'secondary_url' => '#why-us', 'feature_one' => 'Door-to-door', 'feature_two' => 'Pre-booked', 'feature_three' => 'Dubai-wide', 'display_order' => 2],
            ['badge' => 'EXPLORE DUBAI', 'heading' => 'Discover Dubai From the Water', 'heading_highlight' => 'From the Water', 'description' => 'Enjoy spectacular city views, sunset moments and a relaxed Dubai cruise experience.', 'image' => 'images/cruise-dubai-marina.png', 'image_alt' => 'Luxury yacht cruising in Dubai Marina', 'primary_label' => 'Book a Cruise', 'primary_url' => '#cruise-boat-tours', 'secondary_label' => 'Explore All', 'secondary_url' => '#cruise-boat-tours', 'feature_one' => 'Marina Views', 'feature_two' => 'Sunset Moments', 'feature_three' => 'Easy Booking', 'display_order' => 3],
            ['badge' => 'DUBAI DESERT SAFARI', 'heading' => 'Experience the Magic of the Desert', 'heading_highlight' => 'Magic of the Desert', 'description' => 'Ride golden dunes, spot wildlife, enjoy desert dining and live entertainment.', 'image' => 'images/desert-safari.png', 'image_alt' => 'Dubai desert safari at sunset', 'primary_label' => 'Book Now', 'primary_url' => '#desert-safaris', 'secondary_label' => 'Explore Safari', 'secondary_url' => '#desert-adventures', 'feature_one' => 'Camel Rides', 'feature_two' => 'Golden Dunes', 'feature_three' => 'Desert Dining', 'display_order' => 4],
        ];

        foreach ($slides as $slide) {
            HeroSlide::query()->updateOrCreate(['heading' => $slide['heading']], [...$slide, 'is_active' => true]);
        }
    }
}
