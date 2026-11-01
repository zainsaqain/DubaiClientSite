<?php

namespace Database\Seeders;

use App\Models\Attraction;
use App\Models\CityTour;
use App\Models\CruiseBoatTour;
use App\Models\DesertAdventure;
use App\Models\SportsEvent;
use App\Models\Tour;
use App\Models\TourCategory;
use App\Models\TourFeature;
use App\Models\TourSubcategory;
use App\Models\Transfer;
use App\Models\WaterparkThemePark;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TourManagementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Desert Adventures' => ['Desert Safaris', 'Dune Buggies', 'Desert Experiences', 'School Trips'],
            'Attractions' => ['Entry Tickets', 'UAE Passes'],
            'Sports Events' => ['Golf', 'Motorsport', 'Stadium Events'],
            'City Tours' => ['Dubai', 'Abu Dhabi', 'Al Ain', 'Sharjah'],
            'Cruise and Boat Tours' => ['Luxury Cruises', 'Marina Experiences'],
            'Waterparks & Theme Parks' => ['Waterparks', 'Theme Parks'],
            'Transfers' => ['Airport Transfers', 'Private Transfers'],
        ];

        foreach ($categories as $name => $subcategories) {
            $category = TourCategory::query()->updateOrCreate(['slug' => Str::slug($name)], ['name' => $name, 'is_active' => true]);
            foreach ($subcategories as $index => $subcategory) {
                TourSubcategory::query()->updateOrCreate(['slug' => Str::slug($subcategory)], ['tour_category_id' => $category->id, 'name' => $subcategory, 'display_order' => $index + 1, 'is_active' => true]);
            }
        }

        $featureIcons = [
            'Shared or Private Transfer' => 'transfer',
            'Dune Drive' => 'dune',
            'Visitor Centre' => 'tent',
            'Sunset Stop' => 'sun',
            'Falcon Show' => 'falcon',
            'Wildlife' => 'wildlife',
            'Camel Ride' => 'camel',
            'Sandboarding' => 'sandboard',
            'Guided Nature Walk' => 'walk',
            'Stargazing' => 'stars',
            'BBQ Buffet' => 'bbq',
            'Soft Drinks' => 'drinks',
        ];

        foreach ($featureIcons as $feature => $icon) {
            TourFeature::query()->updateOrCreate(['name' => $feature], ['icon' => $icon, 'is_active' => true]);
        }

        $categoryIds = TourCategory::query()->pluck('id', 'slug');
        $subcategoryIds = TourSubcategory::query()->pluck('id', 'slug');
        $import = function (iterable $records, string $categorySlug, ?string $subcategorySlug) use ($categoryIds, $subcategoryIds): void {
            $records = collect($records);
            $duplicateSlugs = $records
                ->groupBy(fn ($record) => Str::slug($record->title))
                ->filter(fn ($items) => $items->count() > 1)
                ->keys();

            // Earlier imports used the title alone as the slug. Move those two
            // legacy duplicate rows to their existing School Trips identity before
            // preserving every category-specific record below.
            if ($categorySlug === 'desert-adventures') {
                foreach ($duplicateSlugs as $duplicateSlug) {
                    Tour::query()
                        ->where('slug', $duplicateSlug)
                        ->where('tour_category_id', $categoryIds[$categorySlug])
                        ->where('tour_subcategory_id', $subcategoryIds['school-trips'])
                        ->update(['slug' => $duplicateSlug.'-school-trips']);
                }
            }

            foreach ($records as $record) {
                $name = $record->title;
                $subSlug = $subcategorySlug;
                if ($categorySlug === 'desert-adventures') {
                    $subSlug = Str::slug($record->category);
                }

                $baseSlug = Str::slug($name);
                $tourSlug = $duplicateSlugs->contains($baseSlug)
                    ? $baseSlug.'-'.($subSlug ?: $categorySlug)
                    : $baseSlug;

                $tour = Tour::query()->updateOrCreate(
                    ['slug' => $tourSlug],
                    [
                        'tour_category_id' => $categoryIds[$categorySlug],
                        'tour_subcategory_id' => $subSlug && isset($subcategoryIds[$subSlug]) ? $subcategoryIds[$subSlug] : null,
                        'name' => $name,
                        'short_description' => $record->description,
                        'about' => $record->description,
                        'full_description' => $record->description,
                        'location' => $record->location ?: 'Dubai',
                        'duration' => $this->durationValue($record->duration ?? null),
                        'duration_unit' => $this->durationUnit($record->duration ?? null),
                        'languages' => ['English'],
                        'starting_price' => $record->price,
                        'currency' => 'PKR',
                        'status' => $record->is_active ? 'active' : 'inactive',
                        'thumbnail' => $record->image,
                        'main_image' => $record->image,
                        'image_alt' => $name,
                        'is_featured' => (bool) $record->is_featured,
                        'is_bestseller' => (bool) $record->is_featured,
                        'location_badge' => $record->location ?: 'Dubai',
                    ],
                );
                $package = $tour->packages()->firstOrCreate(['name' => 'Standard Package'], ['description' => 'Standard experience package.', 'is_active' => true, 'display_order' => 1]);
                $tour->prices()->firstOrCreate(
                    ['tour_package_id' => $package->id, 'vehicle_type' => 'shared'],
                    ['adult_price' => $tour->starting_price, 'minimum_guests' => 1, 'currency' => $tour->currency, 'is_active' => true],
                );
            }
        };

        $import(DesertAdventure::query()->get(), 'desert-adventures', null);
        $import(Attraction::query()->get(), 'attractions', 'entry-tickets');
        $import(SportsEvent::query()->get(), 'sports-events', null);
        $import(CityTour::query()->get(), 'city-tours', null);
        $import(CruiseBoatTour::query()->get(), 'cruise-and-boat-tours', 'luxury-cruises');
        $import(WaterparkThemePark::query()->get(), 'waterparks-theme-parks', 'theme-parks');
        $import(Transfer::query()->get(), 'transfers', 'private-transfers');

        $this->seedEveningDesertSafari($featureIcons);
    }

    /**
     * Populate the full public detail page for the flagship Evening Desert Safari.
     * All content remains editable through the unified tour management area.
     *
     * @param  array<string, string>  $featureIcons
     */
    private function seedEveningDesertSafari(array $featureIcons): void
    {
        $tour = Tour::query()->where('slug', 'evening-desert-safari-in-dubai')->first();

        if (! $tour) {
            return;
        }

        $tour->update([
            'short_description' => 'An unforgettable evening of dune adventures, wildlife moments, a Bedouin-inspired camp and a generous BBQ dinner beneath the stars.',
            'about' => 'Our Evening Desert Safari features an unforgettable itinerary of activities, from breathtaking sunset stops and wildlife spotting to a sumptuous BBQ buffet and stargazing in a Bedouin-inspired camp.',
            'full_description' => 'Set out from Dubai in a comfortable 4x4 for an evening in the Dubai Desert Conservation Reserve. Enjoy a dune and wildlife drive, a sunset stop with falcon encounter, optional sandboarding and camel rides, then settle into a Bedouin-inspired camp for a BBQ dinner and live entertainment.',
            'pickup_information' => 'Hotel or residence pick-up included from anywhere in Dubai.',
            'duration' => 6,
            'duration_unit' => 'hours',
            'languages' => ['English'],
            'starting_price' => 49937,
            'currency' => 'PKR',
            'thumbnail' => 'images/desert-dune-drive.png',
            'main_image' => 'images/desert-dune-drive.png',
            'image_alt' => 'Evening Desert Safari in Dubai at sunset',
            'is_featured' => true,
            'is_bestseller' => true,
            'is_travellers_choice' => true,
            'is_original' => true,
            'location_badge' => 'Dubai',
            'highlights' => "Local entertainment showcase during BBQ dinner\nHenna hand painting with local artists\nWildlife spotting opportunities throughout your safari\nWatching sunset from the Dubai desert\nA full BBQ dinner of traditional Arabic dishes and international options",
            'know_before_you_go' => "Wear lightweight, breathable clothing and comfortable robust shoes.\nBring sunscreen, sunglasses and a hat.\nDesert temperatures can change quickly, especially in winter evenings.\nWildlife sightings cannot be guaranteed because animals move freely.\nTell us about dietary or access requirements before your experience.\nRestrooms are available during this activity.",
            'age_policy' => "Adults: 12 years and above\nChildren: 5–11 years old\nInfants: below 5 years old\nChildren under 5 must travel in a private vehicle and require special seating. Children aged 5 and above who are under 135 cm must use a child seat.",
            'cancellation_policy' => "Please let us know at least 24 hours before the activity for cancellation or changes.\nFull payment is required at least two days before the activity.\nIn exceptional circumstances, the schedule may need to change; we will communicate any changes as early as possible.",
            'additional_notes' => 'Ramadan daytime consumption guidelines may apply. Please speak to your guide if you have any questions.',
            'meta_title' => 'Evening Desert Safari in Dubai | Waheed Murad Tourism',
            'meta_description' => 'Book an evening desert safari with dune drives, wildlife viewing, camel rides, a Bedouin camp and BBQ dinner.',
            'display_order' => 1,
        ]);

        $gallery = [
            ['path' => 'images/desert-oasis-morning.png', 'caption' => 'Dubai desert reserve views'],
            ['path' => 'images/desert-camp-experience.png', 'caption' => 'Bedouin-inspired desert camp'],
            ['path' => 'images/camel-desert-journey.png', 'caption' => 'Camel ride in the desert'],
        ];
        foreach ($gallery as $index => $image) {
            $tour->images()->updateOrCreate(
                ['path' => $image['path']],
                ['alt' => 'Evening Desert Safari - '.$image['caption'], 'caption' => $image['caption'], 'display_order' => $index + 1],
            );
        }

        $featureRows = [];
        foreach (array_keys($featureIcons) as $featureName) {
            $featureId = TourFeature::query()->where('name', $featureName)->value('id');
            if ($featureId) {
                $featureRows[$featureId] = ['inclusion_status' => $featureName === 'Sandboarding' ? 'optional' : 'included'];
            }
        }
        $tour->features()->sync($featureRows);

        $itinerary = [
            ['title' => 'Pickup and journey to the desert', 'description' => 'Pickup is estimated to be from 4pm. Times may vary depending on operational requirements.', 'duration' => 45, 'duration_unit' => 'minutes', 'icon' => 'transfer'],
            ['title' => 'Dubai Desert Conservation Reserve Visitor Centre', 'description' => 'Start your adventure with an interactive, immersive overview of our protected reserve.', 'duration' => 15, 'duration_unit' => 'minutes', 'icon' => 'tent'],
            ['title' => 'Dune and wildlife drive', 'description' => 'Experience a drive across the dunes while spotting native wildlife roaming freely across the reserve.', 'duration' => 30, 'duration_unit' => 'minutes', 'icon' => 'dune'],
            ['title' => 'Sunset stop with falcon show and nature walk', 'description' => 'Watch the sunset with a beverage in hand, followed by a Saker falcon encounter and wildlife walk.', 'duration' => 60, 'duration_unit' => 'minutes', 'icon' => 'sun'],
            ['title' => 'Sandboarding and camel rides', 'description' => 'Before arriving at camp, take to the rugged slopes of the dunes on a sandboard and sample desert life with a camel ride.', 'duration' => null, 'duration_unit' => null, 'icon' => 'camel'],
            ['title' => 'BBQ dinner and entertainment', 'description' => 'Step into our Bedouin-inspired dining space and enjoy fresh dining options from our BBQ buffet, complemented by live entertainment.', 'duration' => 90, 'duration_unit' => 'minutes', 'icon' => 'bbq'],
            ['title' => 'Return journey to your accommodation', 'description' => 'Dropoff is estimated to be by 9:30pm. Times may vary depending on operational requirements.', 'duration' => 45, 'duration_unit' => 'minutes', 'icon' => 'transfer'],
        ];
        $tour->itineraries()->delete();
        foreach ($itinerary as $index => $step) {
            $tour->itineraries()->create([...$step, 'display_order' => $index + 1]);
        }

        $tour->prices()->delete();
        $tour->packages()->delete();
        $standard = $tour->packages()->create(['name' => 'Evening Desert Safari', 'description' => 'The complete shared desert safari experience.', 'is_active' => true, 'display_order' => 1]);
        $private = $tour->packages()->create(['name' => 'Private Desert Safari', 'description' => 'A private vehicle experience for your group.', 'is_active' => true, 'display_order' => 2]);
        $tour->prices()->create(['tour_package_id' => $standard->id, 'vehicle_type' => 'shared', 'adult_price' => 49937, 'child_price' => 39950, 'minimum_guests' => 1, 'maximum_guests' => 6, 'currency' => 'PKR', 'is_active' => true]);
        $tour->prices()->create(['tour_package_id' => $private->id, 'vehicle_type' => 'private', 'adult_price' => 79900, 'minimum_guests' => 2, 'maximum_guests' => 6, 'currency' => 'PKR', 'is_active' => true]);
    }

    private function durationValue(?string $duration): ?int
    {
        return $duration && preg_match('/\d+/', $duration, $matches) ? (int) $matches[0] : null;
    }

    private function durationUnit(?string $duration): ?string
    {
        if (! $duration) {
            return null;
        }

        return str_contains(strtolower($duration), 'day') ? 'days' : (str_contains(strtolower($duration), 'hour') ? 'hours' : 'minutes');
    }
}
