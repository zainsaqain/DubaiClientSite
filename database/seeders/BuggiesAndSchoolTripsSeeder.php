<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use RuntimeException;

/**
 * Imports only the seven Dune Buggies and School Trips products.
 * No truncate, delete, detach, guessed child rate, or live network request.
 * Copy the JSON and public assets together with this class. See README.md.
 */
class BuggiesAndSchoolTripsSeeder extends Seeder
{
    // These must match the actual inclusion_status enum/check constraint.
    private const INCLUDED = 'included';

    private const OPTIONAL = 'optional';

    public function run(): void
    {
        $file = __DIR__.'/data/buggies_school_screenshots.json';
        if (! is_file($file)) {
            throw new RuntimeException('Missing seeder data: '.$file);
        }

        $data = json_decode((string) file_get_contents($file), true, 512, JSON_THROW_ON_ERROR);
        $this->validatePayload($data);
        $this->validateSchema();
        $this->validateAssets($data);

        DB::transaction(function () use ($data): void {
            // Existing category/subcategory metadata is intentionally preserved.
            $categoryId = $this->put('tour_categories', ['slug' => $data['category']['slug']], [], [
                'name' => $data['category']['name'],
                'description' => 'Desert experiences in Dubai.',
                'image' => $data['tours'][0]['main_image'],
                'display_order' => 1,
                'is_active' => true,
                'meta_title' => 'Desert Adventures | Waheed Murad Tourism',
                'meta_description' => 'Explore desert adventures in Dubai.',
            ]);

            $subcategoryIds = [];
            foreach ($data['subcategories'] as $subcategory) {
                $subcategoryIds[$subcategory['slug']] = $this->put('tour_subcategories', [
                    'tour_category_id' => $categoryId,
                    'slug' => $subcategory['slug'],
                ], [], [
                    'name' => $subcategory['name'],
                    'description' => $subcategory['description'],
                    'image' => $data['tours'][$subcategory['slug'] === 'dune-buggies' ? 2 : 3]['main_image'],
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
                $attributes['tour_category_id'] = $categoryId;
                // Single-FK schema: existing combo IDs are retained, but their primary
                // subcategory is assigned to Dune Buggies by this requested import.
                $attributes['tour_subcategory_id'] = $subcategoryIds[$product['subcategory_slug']];
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
                        'inclusion_status' => $feature['inclusion_status'] === 'optional'
                            ? self::OPTIONAL : self::INCLUDED,
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

                // Only the two verified buggy passenger/driver rates are per adult.
                // School and combo headline amounts remain starting prices, not tariffs.
                foreach ($product['prices'] as $price) {
                    $packageName = $price['package_name'];
                    if (! isset($packageIds[$packageName])) {
                        throw new RuntimeException('Unknown price package: '.$packageName);
                    }
                    $this->put('tour_prices', [
                        'tour_id' => $tourId,
                        'tour_package_id' => $packageIds[$packageName],
                        'vehicle_type' => $price['vehicle_type'],
                        'currency' => $price['currency'],
                    ], array_intersect_key($price, array_flip([
                        'vehicle_label', 'description', 'adult_price', 'child_price',
                        'child_min_age', 'child_max_age', 'infant_price', 'infant_max_age',
                        'minimum_guests', 'maximum_guests',
                    ])), ['is_active' => false]);
                }
            }
        });

        $this->command?->info('Imported 7 listed tours: 3 Dune Buggies and 4 School Trips. Existing combo slugs/IDs are reused; new unconfirmed packages/rates remain inactive.');
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
            'desert-dune-buggies-evening-safari-combo',
            'desert-dune-buggies-exclusive-desert-experience-combo',
            'dune-buggy-adventure-in-dubai',
            'three-day-camping-adventure',
            'a-morning-at-the-fort-lisaili',
            'overnight-wildlife-adventure',
            'morning-wildlife-safari',
        ];
        $subcategories = array_column($data['subcategories'] ?? [], 'slug');
        sort($subcategories);
        if (($data['category']['slug'] ?? null) !== 'desert-adventures'
            || $subcategories !== ['dune-buggies', 'school-trips']) {
            throw new RuntimeException('Unexpected category/subcategories in payload.');
        }
        $actual = array_column($data['tours'] ?? [], 'slug');
        sort($expected);
        sort($actual);
        if ($actual !== $expected) {
            throw new RuntimeException('Payload must contain exactly the seven Dune Buggies / School Trips tour slugs.');
        }
        foreach ($data['tours'] as $tour) {
            if (! in_array($tour['subcategory_slug'], ['dune-buggies', 'school-trips'], true)) {
                throw new RuntimeException('Unexpected tour subcategory.');
            }
            foreach ($tour['features'] as $feature) {
                if (! in_array($feature['inclusion_status'], ['included', 'optional'], true)) {
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
            'tour_categories', 'tour_subcategories', 'tours', 'tour_images',
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
            if (! empty($tour['_source']['dining_menu_path'])) {
                $paths[] = $tour['_source']['dining_menu_path'];
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
