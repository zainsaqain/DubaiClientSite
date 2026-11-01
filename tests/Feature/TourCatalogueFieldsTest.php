<?php

namespace Tests\Feature;

use App\Models\Tour;
use App\Models\TourCategory;
use App\Models\TourFeature;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TourCatalogueFieldsTest extends TestCase
{
    use RefreshDatabase;

    public function test_administrator_can_save_reference_catalogue_fields_on_a_tour(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $category = TourCategory::query()->create([
            'name' => 'Desert Adventures',
            'slug' => 'desert-adventures',
            'is_active' => true,
        ]);

        $this->actingAs($admin)->get(route('admin.tours.create'))
            ->assertOk()
            ->assertSee('Experience time')
            ->assertSee('Promotion label')
            ->assertSee('Child age from')
            ->assertSee('Infant price');

        $this->actingAs($admin)->post(route('admin.tours.store'), [
            'name' => 'Evening Desert Safari',
            'tour_category_id' => $category->id,
            'location' => 'Dubai',
            'duration' => 6,
            'duration_unit' => 'hours',
            'experience_time' => 'evening',
            'starting_price' => 299,
            'currency' => 'AED',
            'status' => 'active',
            'promotion_label' => 'Up to 40% off',
            'packages' => [[
                'name' => 'House Beverages',
                'description' => 'Wine, beer and soft drinks with dinner.',
                'is_active' => true,
                'is_recommended' => true,
                'badge_label' => 'Top Choice',
            ]],
            'prices' => [[
                'package_index' => 0,
                'vehicle_type' => 'shared',
                'vehicle_label' => 'Toyota Land Cruiser',
                'description' => 'Hotel pick-up and drop-off in a shared 4x4.',
                'adult_price' => 299,
                'child_price' => 199,
                'child_min_age' => 5,
                'child_max_age' => 11,
                'infant_price' => 0,
                'infant_max_age' => 4,
                'minimum_guests' => 1,
                'maximum_guests' => 6,
            ]],
        ])->assertRedirect(route('admin.tours.index'));

        $this->assertDatabaseHas('tours', [
            'name' => 'Evening Desert Safari',
            'experience_time' => 'evening',
            'promotion_label' => 'Up to 40% off',
        ]);
        $this->assertDatabaseHas('tour_packages', [
            'name' => 'House Beverages',
            'is_recommended' => true,
            'badge_label' => 'Top Choice',
        ]);
        $this->assertDatabaseHas('tour_prices', [
            'vehicle_label' => 'Toyota Land Cruiser',
            'child_min_age' => 5,
            'child_max_age' => 11,
            'infant_price' => 0,
            'infant_max_age' => 4,
        ]);
    }

    public function test_experience_time_must_use_a_supported_public_filter_value(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $category = TourCategory::query()->create([
            'name' => 'Desert Adventures',
            'slug' => 'desert-adventures',
            'is_active' => true,
        ]);

        $this->actingAs($admin)->from(route('admin.tours.create'))->post(route('admin.tours.store'), [
            'name' => 'Invalid Time Safari',
            'tour_category_id' => $category->id,
            'location' => 'Dubai',
            'experience_time' => 'night',
            'starting_price' => 299,
            'currency' => 'AED',
            'status' => 'active',
        ])->assertRedirect(route('admin.tours.create'))
            ->assertSessionHasErrors('experience_time');
    }

    public function test_unselected_features_and_an_empty_itinerary_duration_unit_do_not_block_a_tour_save(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $category = TourCategory::query()->create([
            'name' => 'Desert Adventures',
            'slug' => 'desert-adventures',
            'is_active' => true,
        ]);
        $feature = TourFeature::query()->create(['name' => 'Camel Ride', 'is_active' => true]);

        $this->actingAs($admin)->post(route('admin.tours.store'), [
            'name' => 'Flexible Desert Safari',
            'tour_category_id' => $category->id,
            'location' => 'Dubai',
            'starting_price' => 299,
            'currency' => 'AED',
            'status' => 'active',
            'feature_status' => [$feature->id => ''],
            'itineraries' => [[
                'title' => 'Pickup',
                'duration' => 30,
                'duration_unit' => '',
                'description' => 'Hotel pickup.',
            ]],
        ])->assertRedirect(route('admin.tours.index'));

        $this->assertDatabaseHas('tours', ['name' => 'Flexible Desert Safari']);
    }

    public function test_administrator_can_upload_a_thumbnail_when_the_tour_has_no_existing_image(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create(['is_admin' => true]);
        $category = TourCategory::query()->create([
            'name' => 'Desert Adventures',
            'slug' => 'desert-adventures',
            'is_active' => true,
        ]);

        $this->actingAs($admin)->post(route('admin.tours.store'), [
            'name' => 'Safari With New Thumbnail',
            'tour_category_id' => $category->id,
            'location' => 'Dubai',
            'starting_price' => 299,
            'currency' => 'AED',
            'status' => 'active',
            'thumbnail' => UploadedFile::fake()->image('desert-safari.jpg'),
        ])->assertRedirect(route('admin.tours.index'));

        $tour = Tour::query()->where('name', 'Safari With New Thumbnail')->firstOrFail();

        Storage::disk('public')->assertExists($tour->thumbnail);
    }
}
