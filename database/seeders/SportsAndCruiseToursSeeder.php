<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use RuntimeException;

/**
 * Imports the four Sports Events and four Cruise and Boat Tours products.
 * No truncate, delete, detach, guessed child rate, or live network request.
 * Copy the JSON and public assets together with this class. See README.md.
 */
class SportsAndCruiseToursSeeder extends Seeder
{
    // These must match the actual inclusion_status enum/check constraint.
    private const INCLUDED = 'included';

    private const OPTIONAL = 'optional';

    private const EXCLUDED = 'excluded';

    public function run(): void
    {
        $file = __DIR__.'/data/sports_cruise_screenshots.json';
        if (! is_file($file)) {
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
                // Both source sections list products directly under their category.
                $attributes['tour_subcategory_id'] = null;
                $attributes['languages'] = json_encode($product['languages'], JSON_THROW_ON_ERROR);

                $tourId = $this->put('tours', ['slug' => $product['slug']], $attributes, [
                    'status' => 'active',
                    'is_featured' => false, // Screenshot does not establish a featured flag.
                    'promotion_label' => null,
                    'display_order' => $product['display_order'],
                    'meta_title' => $product['name'].' | Waheed Murad Tourism',
                    'meta_description' => $this->metaDescription($product['about']),
                ]);

                foreach ($product['images'] as $image) {
                    $lookupPath = $image['path'];
                    if (! empty($image['legacy_path'])
                        && ! DB::table('tour_images')->where(['tour_id' => $tourId, 'path' => $lookupPath])->exists()
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
                    // Reuse an existing feature without changing its global icon or active flag.
                    $featureId = $this->put('tour_features', ['name' => $feature['name']], [], [
                        'icon' => $feature['icon'],
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
                        // New unpriced packages cannot be selected for online checkout.
                        // Re-running this seeder preserves an existing package's activation.
                        'is_active' => false,
                        'is_recommended' => false,
                        'badge_label' => null,
                        'display_order' => $package['display_order'],
                    ]);
                }

                // Only verified per-person quotes enter this table. The Topgolf
                // six-player voucher is preserved in its package, not adult_price.
                // The unique index is (tour_id, tour_package_id, vehicle_type):
                // currency is an updated attribute, never part of the lookup key.
                foreach ($this->pricesForDatabase($product) as $price) {
                    $packageName = $price['package_name'];
                    if (! isset($packageIds[$packageName])) {
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

        $this->command?->info('Imported 8 tours in Sports Events and Cruise and Boat Tours, with no subcategories. New packages and quoted rates remain inactive until confirmed.');
    }

    /** Keep one tariff per package/vehicle, matching tour_prices_unique_combination. */
    private function pricesForDatabase(array $product): array
    {
        $preferredCurrency = $product['currency'];
        $selected = [];

        foreach ($product['prices'] as $price) {
            $key = json_encode([$price['package_name'], $price['vehicle_type']], JSON_THROW_ON_ERROR);
            if (! isset($selected[$key])
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
            'dp-world-tour-championship',
            'formula-1-etihad-airways-abu-dhabi-grand-prix-2026-tickets',
            'emirates-dubai-7s',
            'topgolf',
            'luxury-cruise',
            'dubai-marina-dhow-cruise',
            'black-boats-atlantis-tour',
            'abra-tours',
        ];
        $categories = array_column($data['categories'] ?? [], 'slug');
        sort($categories);
        if ($categories !== ['cruise-and-boat-tours', 'sports-events']
            || ($data['subcategories'] ?? null) !== []) {
            throw new RuntimeException('Expected two direct categories and no subcategories.');
        }
        $actual = array_column($data['tours'] ?? [], 'slug');
        sort($expected);
        sort($actual);
        if ($actual !== $expected) {
            throw new RuntimeException('Payload must contain exactly the eight Sports Events / Cruise tour slugs.');
        }
        foreach ($data['tours'] as $tour) {
            if (! in_array($tour['category_slug'], ['sports-events', 'cruise-and-boat-tours'], true)) {
                throw new RuntimeException('Unexpected tour category.');
            }
            foreach ($tour['features'] as $feature) {
                if (! in_array($feature['inclusion_status'], ['included', 'optional', 'excluded'], true)) {
                    throw new RuntimeException('Unknown feature inclusion status.');
                }
            }
            foreach ($tour['prices'] as $price) {
                if (($price['price_basis'] ?? null) !== 'per_person') {
                    throw new RuntimeException('Only per-person quotes may be written to adult_price.');
                }
                if (! isset($price['adult_price']) || ! is_numeric($price['adult_price']) || (float) $price['adult_price'] <= 0) {
                    throw new RuntimeException('A verified positive adult_price is required for each price row.');
                }
            }
        }
    }

    private function validateSchema(): void
    {
        foreach ([
            'tour_categories', 'tours', 'tour_images',
            'tour_features', 'tour_feature', 'tour_itineraries', 'tour_packages', 'tour_prices',
        ] as $table) {
            if (! Schema::hasTable($table)) {
                throw new RuntimeException('Required table is missing: '.$table);
            }
        }
    }

    private function validateAssets(array $data): void
    {
        foreach ($data['tours'] as $tour) {
            $paths = array_merge(array_column($tour['images'], 'path'), array_column($tour['features'], 'icon'));
            if (! empty($tour['_source']['venue_map_path'])) {
                $paths[] = $tour['_source']['venue_map_path'];
            }
            foreach ($paths as $path) {
                if (! is_file(public_path($path))) {
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
