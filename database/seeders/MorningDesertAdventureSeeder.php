<?php

namespace Database\Seeders;

use App\Models\Tour;
use App\Models\TourFeature;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MorningDesertAdventureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function (): void {
            $tour = Tour::query()
                ->where('slug', 'morning-desert-adventure')
                ->firstOrFail();
            $tour->update([
                'short_description' => 'Explore Dubai’s desert landscape on a guided safari with dune driving, wildlife viewing, camel rides and a Bedouin-inspired camp experience.',
                'about' => 'A full desert journey combining guided transfer, dune terrain, wildlife moments, camel rides and a camp-style dining experience.',
                'full_description' => 'Begin with a guided journey from Dubai into the desert, followed by a visit to the conservation reserve visitor centre and a drive through dune terrain. The experience continues with a sunset stop, falcon encounter, camel ride and time at a Bedouin-inspired camp. Selectable beverage and vehicle options are displayed separately so the final choice remains clear before availability is checked.',
                'location' => 'Dubai',
                'duration' => 6,
                'duration_unit' => 'hours',
                'experience_time' => 'evening',
                'languages' => ['English'],
                'starting_price' => 49937,
                'currency' => 'PKR',
                'thumbnail' => 'images/safaris/morning-desert-adventure.jpg',
                'main_image' => 'images/safaris/morning-desert-adventure.jpg',
                'image_alt' => 'Desert safari guests beside a 4x4 at sunset',
                'pickup_information' => 'Hotel or residence pick-up included from anywhere in Dubai.',
                'highlights' => "Desert dune drive\nWildlife viewing\nCamel ride\nFalcon encounter\nBBQ buffet and camp entertainment",
                'know_before_you_go' => "Wear light, comfortable clothing and closed shoes.\nBring sunglasses and a hat.\nExact timings may vary with operational requirements.",
                'age_policy' => 'Age and child suitability should be confirmed with the operator before booking.',
                'cancellation_policy' => 'Cancellation terms require operator confirmation before publication.',
                'meta_title' => 'Morning Desert Adventure | Waheed Murad Tourism',
                'meta_description' => 'Guided Dubai desert adventure with dune terrain, wildlife viewing, camel rides and camp-style experiences.',
                'is_featured' => true,
                'is_bestseller' => true,
                'is_travellers_choice' => true,
                'is_original' => true,
                'location_badge' => 'Dubai',
                'promotion_label' => null,
            ]);

            $tour->images()->delete();
            $tour->images()->createMany([
                ['path' => 'images/safaris/wide-view-of-desert-camp.jpg', 'alt' => 'Wide view of a desert camp', 'caption' => 'Desert camp', 'display_order' => 1],
                ['path' => 'images/safaris/family-sandboarding.jpg', 'alt' => 'Desert lounge setup', 'caption' => 'Desert lounge', 'display_order' => 2],
            ]);

            $featureDefinitions = [
                ['name' => 'Shared or Private Transfer', 'icon' => '🚙', 'status' => 'included'],
                ['name' => 'Dune Drive', 'icon' => '🏜️', 'status' => 'included'],
                ['name' => 'DDCR Visitor Centre', 'icon' => '⛺', 'status' => 'included'],
                ['name' => 'Sunset Stop', 'icon' => '🌅', 'status' => 'included'],
                ['name' => 'Falcon Show', 'icon' => '🦅', 'status' => 'included'],
                ['name' => 'Wildlife', 'icon' => '🦌', 'status' => 'included'],
                ['name' => 'Camel Ride', 'icon' => '🐪', 'status' => 'included'],
                ['name' => 'Sandboarding', 'icon' => '🏂', 'status' => 'optional'],
                ['name' => 'Guided Nature Walk', 'icon' => '🥾', 'status' => 'included'],
                ['name' => 'Stargazing', 'icon' => '🌙', 'status' => 'included'],
                ['name' => 'BBQ Buffet', 'icon' => '🍽️', 'status' => 'included'],
                ['name' => 'Soft Drinks or House Beverages', 'icon' => '🥤', 'status' => 'included'],
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
                ['display_order' => 1, 'title' => 'Pickup and journey to the desert', 'description' => 'Pickup timing is coordinated before departure and can vary with operational requirements.', 'duration' => 45, 'duration_unit' => 'minutes', 'icon' => '🚙'],
                ['display_order' => 2, 'title' => 'Dubai Desert Conservation Reserve Visitor Centre', 'description' => 'An introduction to the protected desert environment and its natural setting.', 'duration' => 15, 'duration_unit' => 'minutes', 'icon' => '⛺'],
                ['display_order' => 3, 'title' => 'Dune and wildlife drive', 'description' => 'A guided drive across dune terrain with opportunities to observe the desert landscape.', 'duration' => 30, 'duration_unit' => 'minutes', 'icon' => '🏜️'],
                ['display_order' => 4, 'title' => 'Sunset stop with falcon show and nature walk', 'description' => 'Pause for sunset views, a falcon encounter and a guided outdoor walk.', 'duration' => 60, 'duration_unit' => 'minutes', 'icon' => '🌅'],
                ['display_order' => 5, 'title' => 'Sandboarding and camel rides', 'description' => 'Optional sandboarding and camel ride experiences at the camp area.', 'duration' => null, 'duration_unit' => null, 'icon' => '🐪'],
                ['display_order' => 6, 'title' => 'BBQ dinner and entertainment', 'description' => 'Camp-style dining and live entertainment, subject to the selected package.', 'duration' => 90, 'duration_unit' => 'minutes', 'icon' => '🍽️'],
                ['display_order' => 7, 'title' => 'Return journey to your accommodation', 'description' => 'Return transport to the accommodation after the experience.', 'duration' => 45, 'duration_unit' => 'minutes', 'icon' => '🚙'],
            ]);

            $tour->prices()->delete();
            $tour->packages()->delete();
            $softDrinks = $tour->packages()->create(['name' => 'Soft Beverages', 'description' => 'Unlimited soft drinks.', 'is_active' => true, 'is_recommended' => false, 'display_order' => 1]);
            $houseBeverages = $tour->packages()->create(['name' => 'House Beverages', 'description' => 'Unlimited wine and beer. Top Choice.', 'is_active' => true, 'is_recommended' => true, 'badge_label' => 'Top Choice', 'display_order' => 2]);
            $tour->prices()->createMany([
                ['tour_package_id' => $softDrinks->id, 'vehicle_type' => 'shared', 'vehicle_label' => 'Shared Vehicle', 'description' => 'Hotel pick-up and drop-off in a shared 4-wheel-drive vehicle (Toyota Land Cruiser or similar).', 'adult_price' => 49937, 'minimum_guests' => 1, 'currency' => 'PKR', 'is_active' => true],
                ['tour_package_id' => $softDrinks->id, 'vehicle_type' => 'private', 'vehicle_label' => 'Private Vehicle', 'description' => 'Hotel pick-up and drop-off in a private 4-wheel-drive vehicle (Toyota Land Cruiser or similar).', 'adult_price' => 249685, 'minimum_guests' => 2, 'maximum_guests' => 6, 'currency' => 'PKR', 'is_active' => true],
                ['tour_package_id' => $houseBeverages->id, 'vehicle_type' => 'shared', 'vehicle_label' => 'Shared Vehicle', 'description' => 'Shared vehicle option with house beverages.', 'adult_price' => 60710, 'minimum_guests' => 1, 'currency' => 'PKR', 'is_active' => true],
            ]);
        });
    }
}
