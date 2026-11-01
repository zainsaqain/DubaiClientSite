<?php

namespace Database\Seeders;

use App\Models\HomeTestimonial;
use Illuminate\Database\Seeder;

class HomeTestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            ['name' => 'Sarah Johnson', 'country' => 'United Kingdom', 'quote' => 'An absolutely incredible experience! From the desert safari to the Burj Khalifa, everything was perfectly organized. Dubai is even more amazing than I imagined and this team made it so special.', 'rating' => 5, 'avatar' => 'images/desert-camp-experience.png', 'display_order' => 1, 'is_featured' => false],
            ['name' => 'Ahmed Khan', 'country' => 'Pakistan', 'quote' => 'An unforgettable journey! The desert safari was the highlight of our trip — breathtaking views, amazing guides and authentic Arabian hospitality. Everything was seamless from start to finish.', 'rating' => 5, 'avatar' => 'images/camel-desert-journey.png', 'display_order' => 2, 'is_featured' => true],
            ['name' => 'Emma Wilson', 'country' => 'Australia', 'quote' => 'Dubai is a dream destination and this experience made it truly unforgettable. The activities, the views, the people — all incredible. I can’t wait to come back and explore more with you!', 'rating' => 5, 'avatar' => 'images/dubai-adventure.png', 'display_order' => 3, 'is_featured' => false],
        ];
        foreach ($testimonials as $testimonial) {
            HomeTestimonial::query()->updateOrCreate(['name' => $testimonial['name']], [...$testimonial, 'is_active' => true]);
        }
    }
}
