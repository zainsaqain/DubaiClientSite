<?php

namespace Database\Seeders;

use App\Models\Tour;
use App\Models\TourCategory;
use App\Models\TourFeature;
use App\Models\TourSubcategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EveningDesertSafariSeeder extends Seeder
{
    /**
     * Seed the supplied Evening Desert Safari content and gallery.
     *
     * The uploaded files live on the public disk in
     * tours/evening-desert-safari-in-dubai. This seeder is idempotent: it updates
     * this tour only and replaces only its dependent catalogue records.
     */
    public function run(): void
    {
        DB::transaction(function (): void {
            $category = TourCategory::query()
                ->where('slug', 'desert-adventures')
                ->firstOrFail();

            $subcategory = TourSubcategory::query()
                ->where('tour_category_id', $category->id)
                ->where('slug', 'desert-safaris')
                ->firstOrFail();

            $tour = Tour::query()->updateOrCreate(
                ['slug' => 'evening-desert-safari-in-dubai'],
                [
                    'tour_category_id' => $category->id,
                    'tour_subcategory_id' => $subcategory->id,
                    'name' => 'Evening Desert Safari in Dubai',
                    'short_description' => 'Experience Dubai’s desert at sunset with dune driving, wildlife viewing, camel rides, a Bedouin-inspired camp, BBQ dinner and live entertainment.',
                    'about' => 'Our Evening Desert Safari features an unforgettable itinerary of activities, from breathtaking sunset stops and wildlife spotting to a BBQ buffet and stargazing in a Bedouin-inspired camp.',
                    'full_description' => "Set out from Dubai in a 4x4 for an evening in the desert. The journey combines a dune and wildlife drive, a sunset stop, falcon encounter, optional sandboarding and camel rides.\n\nAt the camp, enjoy a BBQ dinner and live entertainment before returning to your accommodation. Exact timings and included services are confirmed when availability is checked.",
                    'location' => 'Dubai',
                    'duration' => 6,
                    'duration_unit' => 'hours',
                    'experience_time' => 'evening',
                    'languages' => ['English'],
                    'starting_price' => 49937,
                    'currency' => 'PKR',
                    'status' => 'active',
                    'thumbnail' => 'tours/evening-desert-safari-in-dubai/sunset-4x4.webp',
                    'main_image' => 'tours/evening-desert-safari-in-dubai/sunset-4x4.webp',
                    'image_alt' => 'Guests beside a 4x4 in the Dubai desert at sunset',
                    'pickup_information' => 'Hotel or residence pick-up included from anywhere in Dubai.',
                    'highlights' => "Dune and wildlife drive\nSunset stop and falcon encounter\nCamel rides and optional sandboarding\nBBQ buffet at a Bedouin-inspired camp\nLive belly dance, Tanoura and fire-show entertainment",
                    'know_before_you_go' => "Wear lightweight, comfortable clothing and closed shoes.\nBring sunscreen, sunglasses and a hat.\nDesert temperatures may change quickly after sunset.\nTell us about dietary or access requirements before departure.\nWildlife sightings cannot be guaranteed.",
                    'age_policy' => "Adults: 12 years and above\nChildren: 5 to 11 years old\nInfants: below 5 years old\nChildren under 5 require a private vehicle and suitable child seating.",
                    'cancellation_policy' => "Cancellation and change terms must be confirmed by the administrator before accepting a booking.\nAvailability, pickup time and final inclusions are confirmed after the date and guest details are selected.",
                    'additional_notes' => 'Availability is managed manually. The published price is a starting price and may vary by selected vehicle and package.',
                    'meta_title' => 'Evening Desert Safari in Dubai | Waheed Murad Tourism',
                    'meta_description' => 'Dubai evening desert safari with dune driving, wildlife viewing, camel rides, a Bedouin-inspired camp, BBQ dinner and live entertainment.',
                    'is_featured' => true,
                    'is_bestseller' => true,
                    'is_travellers_choice' => true,
                    'is_original' => true,
                    'location_badge' => 'Dubai',
                    'display_order' => 1,
                ],
            );

            $tour->images()->delete();
            $tour->images()->createMany([
                ['path' => 'tours/evening-desert-safari-in-dubai/desert-camp-aerial.jpg', 'alt' => 'Aerial view of a desert camp', 'caption' => 'Desert camp view', 'display_order' => 1],
                ['path' => 'tours/evening-desert-safari-in-dubai/desert-refreshments.webp', 'alt' => 'Desert refreshments setup', 'caption' => 'Desert refreshments', 'display_order' => 2],
                ['path' => 'tours/evening-desert-safari-in-dubai/dune-drive.webp', 'alt' => '4x4 dune drive near the desert camp', 'caption' => 'Dune drive', 'display_order' => 3],
                ['path' => 'tours/evening-desert-safari-in-dubai/bbq-buffet.jpg', 'alt' => 'Family enjoying a desert buffet', 'caption' => 'BBQ buffet', 'display_order' => 4],
                ['path' => 'tours/evening-desert-safari-in-dubai/belly-dance.webp', 'alt' => 'Evening dance performance at the camp', 'caption' => 'Live entertainment', 'display_order' => 5],
                ['path' => 'tours/evening-desert-safari-in-dubai/tanoura-performance.jpg', 'alt' => 'Tanoura performance at night', 'caption' => 'Tanoura performance', 'display_order' => 6],
                ['path' => 'tours/evening-desert-safari-in-dubai/fire-show.jpg', 'alt' => 'Fire show during a desert dinner', 'caption' => 'Fire show', 'display_order' => 7],
            ]);

            $featureDefinitions = [
                ['name' => 'Shared or Private Transfer', 'icon' => 'transfer', 'status' => 'included'],
                ['name' => 'Dune Drive', 'icon' => 'dune', 'status' => 'included'],
                ['name' => 'DDCR Visitor Centre', 'icon' => 'tent', 'status' => 'included'],
                ['name' => 'Sunset Stop', 'icon' => 'sun', 'status' => 'included'],
                ['name' => 'Falcon Show', 'icon' => 'falcon', 'status' => 'included'],
                ['name' => 'Wildlife', 'icon' => 'wildlife', 'status' => 'included'],
                ['name' => 'Camel Ride', 'icon' => 'camel', 'status' => 'included'],
                ['name' => 'Sandboarding', 'icon' => 'sandboard', 'status' => 'optional'],
                ['name' => 'Guided Nature Walk', 'icon' => 'walk', 'status' => 'included'],
                ['name' => 'Stargazing', 'icon' => 'stars', 'status' => 'included'],
                ['name' => 'BBQ Buffet', 'icon' => 'bbq', 'status' => 'included'],
                ['name' => 'Soft Drinks or House Beverages', 'icon' => 'drinks', 'status' => 'included'],
            ];

            $featureRows = [];
            foreach ($featureDefinitions as $definition) {
                $feature = TourFeature::query()->firstOrCreate(
                    ['name' => $definition['name']],
                    ['icon' => $definition['icon'], 'is_active' => true],
                );
                $featureRows[$feature->id] = ['inclusion_status' => $definition['status']];
            }
            $tour->features()->sync($featureRows);

            $tour->itineraries()->delete();
            $tour->itineraries()->createMany([
                ['display_order' => 1, 'title' => 'Pickup and journey to the desert', 'description' => 'Pickup timing is confirmed before departure and may vary with operational requirements.', 'duration' => 45, 'duration_unit' => 'minutes', 'icon' => 'transfer'],
                ['display_order' => 2, 'title' => 'Dubai Desert Conservation Reserve Visitor Centre', 'description' => 'An introduction to the protected desert environment and its natural setting.', 'duration' => 15, 'duration_unit' => 'minutes', 'icon' => 'tent'],
                ['display_order' => 3, 'title' => 'Dune and wildlife drive', 'description' => 'A guided drive through dune terrain with opportunities to observe the desert landscape.', 'duration' => 30, 'duration_unit' => 'minutes', 'icon' => 'dune'],
                ['display_order' => 4, 'title' => 'Sunset stop with falcon show and nature walk', 'description' => 'Pause for sunset views, a falcon encounter and a guided outdoor walk.', 'duration' => 60, 'duration_unit' => 'minutes', 'icon' => 'sun'],
                ['display_order' => 5, 'title' => 'Sandboarding and camel rides', 'description' => 'Try optional sandboarding and enjoy a camel ride near the camp area.', 'duration' => null, 'duration_unit' => null, 'icon' => 'camel'],
                ['display_order' => 6, 'title' => 'BBQ dinner and live entertainment', 'description' => 'Enjoy the selected dinner package with live belly dance, Tanoura and fire-show entertainment.', 'duration' => 90, 'duration_unit' => 'minutes', 'icon' => 'bbq'],
                ['display_order' => 7, 'title' => 'Return journey to your accommodation', 'description' => 'Return transport to your accommodation after the experience.', 'duration' => 45, 'duration_unit' => 'minutes', 'icon' => 'transfer'],
            ]);

            $tour->prices()->delete();
            $tour->packages()->delete();

            $softBeverages = $tour->packages()->create([
                'name' => 'Soft Beverages',
                'description' => 'Unlimited soft drinks with the evening safari experience.',
                'is_active' => true,
                'is_recommended' => false,
                'display_order' => 1,
            ]);
            $houseBeverages = $tour->packages()->create([
                'name' => 'House Beverages',
                'description' => 'Unlimited wine and beer with the selected dinner package.',
                'is_active' => true,
                'is_recommended' => true,
                'badge_label' => 'Top Choice',
                'display_order' => 2,
            ]);

            $tour->prices()->createMany([
                ['tour_package_id' => $softBeverages->id, 'vehicle_type' => 'shared', 'vehicle_label' => 'Shared Vehicle', 'description' => 'Hotel pick-up and drop-off in a shared 4-wheel-drive vehicle.', 'adult_price' => 49937, 'child_price' => 37703, 'child_min_age' => 5, 'child_max_age' => 11, 'infant_price' => 0, 'infant_max_age' => 4, 'minimum_guests' => 1, 'maximum_guests' => 6, 'currency' => 'PKR', 'is_active' => true],
                ['tour_package_id' => $softBeverages->id, 'vehicle_type' => 'private', 'vehicle_label' => 'Private Vehicle', 'description' => 'Hotel pick-up and drop-off in a private 4-wheel-drive vehicle.', 'adult_price' => 249685, 'minimum_guests' => 2, 'maximum_guests' => 6, 'currency' => 'PKR', 'is_active' => true],
                ['tour_package_id' => $houseBeverages->id, 'vehicle_type' => 'shared', 'vehicle_label' => 'Shared Vehicle', 'description' => 'Shared vehicle with the house-beverages package.', 'adult_price' => 60710, 'child_price' => 45450, 'child_min_age' => 5, 'child_max_age' => 11, 'infant_price' => 0, 'infant_max_age' => 4, 'minimum_guests' => 1, 'maximum_guests' => 6, 'currency' => 'PKR', 'is_active' => true],
            ]);
        });
    }
}
