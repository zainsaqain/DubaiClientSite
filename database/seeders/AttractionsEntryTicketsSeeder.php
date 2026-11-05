<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use RuntimeException;

/**
 * Imports the 36 screenshot attractions with bundled gallery and icon assets.
 * Source observations and review notes are stored in the companion JSON.
 */
class AttractionsEntryTicketsSeeder extends Seeder
{
    // These must match the actual inclusion_status enum/check constraint.
    private const INCLUDED = 'included';
    private const OPTIONAL = 'optional';
    private const EXCLUDED = 'excluded';

    public function run(): void
    {
        $file = __DIR__.'/data/attractions_entry_tickets.json';
        if (!is_file($file)) {
            throw new RuntimeException('Missing seeder data: '.$file);
        }

        $data = json_decode((string) file_get_contents($file), true, 512, JSON_THROW_ON_ERROR);
        $this->validatePayload($data);
        $this->validateSchema();
        $this->validateAssets($data);

        DB::transaction(function () use ($data): void {
            $categoryIds = [];
            foreach ($data['categories'] as $category) {
                // Preserve metadata of existing categories and retain their IDs.
                $categoryIds[$category['slug']] = $this->put('tour_categories', [
                    'slug' => $category['slug'],
                ], [], [
                    'name' => $category['name'],
                    'description' => $category['description'],
                    'image' => $category['image'],
                    'display_order' => $category['display_order'],
                    'is_active' => true,
                    'meta_title' => $category['name'].' | Waheed Murad Tourism',
                    'meta_description' => $category['description'],
                ]);
            }

            $subcategoryIds = [];
            foreach ($data['subcategories'] as $subcategory) {
                $subcategoryIds[$subcategory['slug']] = $this->put('tour_subcategories', [
                    'tour_category_id' => $categoryIds[$subcategory['category_slug']],
                    'slug' => $subcategory['slug'],
                ], [], [
                    'name' => $subcategory['name'],
                    'description' => $subcategory['description'],
                    'image' => $subcategory['image'],
                    'display_order' => $subcategory['display_order'],
                    'is_active' => true,
                    'meta_title' => $subcategory['name'].' | Waheed Murad Tourism',
                    'meta_description' => $subcategory['description'],
                ]);
            }

            foreach ($data['tours'] as $product) {
                $attributes = array_intersect_key($product, array_flip([
                    'name', 'short_description', 'about', 'full_description', 'location',
                    'duration', 'duration_unit', 'experience_time', 'starting_price',
                    'currency', 'thumbnail', 'main_image', 'image_alt', 'pickup_information',
                    'highlights', 'know_before_you_go', 'age_policy', 'cancellation_policy',
                    'additional_notes', 'is_bestseller', 'is_travellers_choice', 'is_original',
                    'location_badge', 'youtube_url',
                ]));
                $attributes['tour_category_id'] = $categoryIds[$product['category_slug']];
                $attributes['tour_subcategory_id'] = $subcategoryIds[$product['subcategory_slug']];
                $attributes['languages'] = json_encode($product['languages'], JSON_THROW_ON_ERROR);

                $tourId = $this->put('tours', ['slug' => $product['slug']], $attributes, [
                    'status' => 'active',
                    'is_featured' => false, // Screenshot does not establish a featured flag.
                    'promotion_label' => $product['promotion_label'] ?? null,
                    'display_order' => $product['display_order'],
                    'meta_title' => $product['name'].' | Waheed Murad Tourism',
                    'meta_description' => $this->metaDescription($product['about']),
                ]);

                foreach ($product['images'] as $image) {
                    $lookupPath = $image['path'];
                    if (!empty($image['legacy_path'])
                        && !DB::table('tour_images')->where(['tour_id' => $tourId, 'path' => $lookupPath])->exists()
                        && DB::table('tour_images')->where(['tour_id' => $tourId, 'path' => $image['legacy_path']])->exists()) {
                        $lookupPath = $image['legacy_path'];
                    }
                    $this->put('tour_images', ['tour_id' => $tourId, 'path' => $lookupPath], [
                        'path' => $image['path'],
                        'alt' => $image['alt'],
                        'caption' => $image['caption'],
                        'display_order' => $image['display_order'],
                    ]);
                }

                foreach ($product['features'] as $feature) {
                    // Point matching feature labels to verified bundled icons; preserve activation.
                    $featureId = $this->put('tour_features', ['name' => $feature['name']], [
                        'icon' => $feature['icon'],
                    ], [
                        'is_active' => true,
                    ]);
                    $this->put('tour_feature', [
                        'tour_id' => $tourId,
                        'tour_feature_id' => $featureId,
                    ], [
                        'inclusion_status' => match ($feature['inclusion_status']) {
                            'included' => self::INCLUDED,
                            'optional' => self::OPTIONAL,
                            'excluded' => self::EXCLUDED,
                        },
                    ], [], false); // Supplied pivot has no timestamp columns.
                }

                foreach ($product['itineraries'] as $step) {
                    $this->put('tour_itineraries', [
                        'tour_id' => $tourId,
                        'display_order' => $step['display_order'],
                    ], array_intersect_key($step, array_flip([
                        'title', 'description', 'duration', 'duration_unit', 'icon',
                    ])));
                }

                $packageIds = [];
                foreach ($product['packages'] as $package) {
                    $packageIds[$package['name']] = $this->put('tour_packages', [
                        'tour_id' => $tourId,
                        'name' => $package['name'],
                    ], [
                        'description' => $package['description'],
                    ], [
                        // New snapshot packages await activation after rate/availability review.
                        // Re-running this seeder preserves an existing package's activation.
                        'is_active' => false,
                        'is_recommended' => false,
                        'badge_label' => null,
                        'display_order' => $package['display_order'],
                    ]);
                }

                // Import source-displayed PKR service quotes with their documented price basis.
                // The unique index is (tour_id, tour_package_id, vehicle_type):
                // currency is an updated attribute, never part of the lookup key.
                foreach ($this->pricesForDatabase($product) as $price) {
                    $packageName = $price['package_name'];
                    if (!isset($packageIds[$packageName])) {
                        throw new RuntimeException('Unknown price package: '.$packageName);
                    }
                    $this->put('tour_prices', [
                        'tour_id' => $tourId,
                        'tour_package_id' => $packageIds[$packageName],
                        'vehicle_type' => $price['vehicle_type'],
                    ], array_intersect_key($price, array_flip([
                        'currency', 'vehicle_label', 'description', 'adult_price', 'child_price',
                        'child_min_age', 'child_max_age', 'infant_price', 'infant_max_age',
                        'minimum_guests', 'maximum_guests',
                    ])), ['is_active' => false]);
                }
            }
        });

        $this->command?->info('Imported 36 attractions under Attractions / Entry Tickets.');
    }

    /** Keep one tariff per package/vehicle, matching tour_prices_unique_combination. */
    private function pricesForDatabase(array $product): array
    {
        $preferredCurrency = $product['currency'];
        $selected = [];

        foreach ($product['prices'] as $price) {
            $key = json_encode([$price['package_name'], $price['vehicle_type']], JSON_THROW_ON_ERROR);
            if (!isset($selected[$key])
                || ($price['currency'] === $preferredCurrency
                    && $selected[$key]['currency'] !== $preferredCurrency)) {
                $selected[$key] = $price;
            }
        }

        // Original alternative-currency quotes remain in the JSON and descriptions.
        // No currency conversion is performed when only another currency is quoted.
        return array_values($selected);
    }

    /** Update a matching row or insert it, preserving IDs and created_at. */
    private function put(string $table, array $key, array $changes, array $defaults = [], bool $timestamps = true): int
    {
        $query = DB::table($table)->where($key);
        $matches = (clone $query)->get(['id']);
        if (count($matches) > 1) {
            throw new RuntimeException('Ambiguous existing rows in '.$table.': '.json_encode($key));
        }

        if (count($matches) === 1) {
            $id = (int) $matches[0]->id;
            if ($changes !== []) {
                if ($timestamps) {
                    $changes['updated_at'] = now();
                }
                DB::table($table)->where('id', $id)->update($changes);
            }
            return $id;
        }

        $row = array_merge($defaults, $changes, $key);
        if ($timestamps) {
            $row['created_at'] = now();
            $row['updated_at'] = now();
        }
        return (int) DB::table($table)->insertGetId($row);
    }

    private function validatePayload(array $data): void
    {
        $expected = [
            'the-city-pass',
            'global-village-entry-ticket',
            'louvre-general-admission-day-pass',
            'museum-of-the-future',
            'dubai-frame-entrance-ticket',
            'at-the-top-burj-khalifa-level-124-125',
            'at-the-top-burj-khalifa-sky-levels-and-sky-views-observatory',
            'at-the-top-burj-khalifa-with-dining-at-the-cafe',
            'at-the-top-burj-khalifa-dubai-aquarium-combo',
            'qasr-al-watan',
            'helicopter-tour-in-dubai',
            'the-view-at-the-palm-fast-track-admission',
            'the-green-planet-dubai-tickets-offers-timings-more',
            'at-the-top-burj-khalifa-lounge-access',
            'ce-la-vi-lunch-set-menu-with-burj-khalifa-views',
            'kaleidoscope-dinner-buffet',
            'aya-universe',
            'etihad-tower-observation-deck',
            'at-the-top-burj-khalifa-sky-level-148-125-124',
            'lotus-megayacht-shared-dinner-cruise',
            'aura-friday-night-brunch-in-the-lounge',
            'palm-monorail-gateway-to-atlantis-station-round-trip',
            'yas-marina-circuit-karting',
            'the-view-at-the-palm-general-admission',
            'the-mercedes-benz-off-road-experience-center',
            'city-sightseeing-dubai',
            'aura-lunch-in-the-sky',
            'museum-of-illusions',
            'at-mosphere-experiences-breakfast-afternoon-tea-lunch',
            'la-perle-by-dragone',
            'bustronomy-dubai-fine-dining-panoramic-tour',
            'aura-marina-view-evening-pool-experience',
            'dubai-miracle-garden',
            'ferrari-world-general-admission',
            'the-adventure-pass',
            'iconic-burj-al-arab-tour-on-jetski'
        ];
        $actual = array_column($data['tours'] ?? [], 'slug');
        sort($expected);
        sort($actual);
        if ($actual !== $expected
            || array_column($data['categories'] ?? [], 'slug') !== ['attractions']
            || array_column($data['subcategories'] ?? [], 'slug') !== ['entry-tickets']) {
            throw new RuntimeException('Expected the 36 screenshot products under Attractions / Entry Tickets.');
        }
        foreach ($data['tours'] as $tour) {
            if ($tour['category_slug'] !== 'attractions' || $tour['subcategory_slug'] !== 'entry-tickets') {
                throw new RuntimeException('Unexpected attraction taxonomy.');
            }
            $packageNames = array_column($tour['packages'], 'name');
            foreach ($tour['features'] as $feature) {
                if (!in_array($feature['inclusion_status'], ['included', 'optional', 'excluded'], true)) {
                    throw new RuntimeException('Unknown feature inclusion status.');
                }
            }
            foreach ($tour['prices'] as $price) {
                if (!in_array($price['package_name'], $packageNames, true)) {
                    throw new RuntimeException('Price refers to an unknown package.');
                }
                if ($price['currency'] !== 'PKR' || !is_numeric($price['adult_price']) || $price['adult_price'] <= 0) {
                    throw new RuntimeException('Expected a positive published PKR service quote.');
                }
            }
        }
    }

    private function validateSchema(): void
    {
        foreach ([
            'tour_categories', 'tour_subcategories', 'tours', 'tour_images',
            'tour_features', 'tour_feature', 'tour_itineraries', 'tour_packages', 'tour_prices',
        ] as $table) {
            if (!Schema::hasTable($table)) {
                throw new RuntimeException('Required table is missing: '.$table);
            }
        }
    }

    private function validateAssets(array $data): void
    {
        foreach ($data['tours'] as $tour) {
            $paths = array_merge(array_column($tour['images'], 'path'), array_column($tour['features'], 'icon'));
            if (!empty($tour['_source']['venue_map_path'])) {
                $paths[] = $tour['_source']['venue_map_path'];
            }
            foreach ($paths as $path) {
                if (!is_file(public_path($path))) {
                    throw new RuntimeException('Copy the bundled public assets before seeding. Missing: '.$path);
                }
            }
        }
    }

    private function metaDescription(string $text): string
    {
        // Unicode-aware without requiring mbstring.
        $chars = preg_split('//u', $text, -1, PREG_SPLIT_NO_EMPTY);
        return count($chars) <= 160 ? $text : implode('', array_slice($chars, 0, 157)).'...';
    }
}
