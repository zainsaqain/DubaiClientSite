<?php

namespace Tests\Feature;

use App\Models\Tour;
use App\Models\TourCategory;
use App\Models\TourPackage;
use App\Models\TourPrice;
use App\Models\TourSubcategory;
use App\Models\User;
use Database\Seeders\MorningDesertAdventureSeeder;
use Database\Seeders\TheFortLisailiDesertExperienceSeeder;
use Database\Seeders\TourManagementSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TourManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_a_tour_and_publish_it_to_its_subcategory_listing(): void
    {
        $user = User::factory()->create(['email_verified_at' => now(), 'is_admin' => true]);
        $category = TourCategory::query()->create(['name' => 'Desert Adventures', 'slug' => 'desert-adventures', 'is_active' => true]);
        $subcategory = TourSubcategory::query()->create(['tour_category_id' => $category->id, 'name' => 'Desert Safaris', 'slug' => 'desert-safaris', 'is_active' => true]);

        $this->actingAs($user)->get(route('admin.tours.create'))->assertOk()->assertSee('Create a complete tour');

        $this->actingAs($user)->post(route('admin.tours.store'), [
            'name' => 'Database Driven Sunset Safari',
            'tour_category_id' => $category->id,
            'tour_subcategory_id' => $subcategory->id,
            'location' => 'Dubai',
            'starting_price' => 499,
            'currency' => 'AED',
            'status' => 'active',
            'short_description' => 'Created through the unified tour management form.',
        ])->assertRedirect(route('admin.tours.index'));

        $this->assertDatabaseHas('tours', ['name' => 'Database Driven Sunset Safari', 'status' => 'active']);
        $this->get(route('desert-safaris'))->assertOk()->assertSee('Database Driven Sunset Safari');
        $this->get('/tours/database-driven-sunset-safari')->assertOk()->assertSee('Database Driven Sunset Safari');
    }

    public function test_admin_cannot_assign_a_subcategory_from_another_category(): void
    {
        $user = User::factory()->create(['email_verified_at' => now(), 'is_admin' => true]);
        $category = TourCategory::query()->create(['name' => 'Desert Adventures', 'slug' => 'desert-adventures', 'is_active' => true]);
        $otherCategory = TourCategory::query()->create(['name' => 'Attractions', 'slug' => 'attractions', 'is_active' => true]);
        $otherSubcategory = TourSubcategory::query()->create(['tour_category_id' => $otherCategory->id, 'name' => 'Entry Tickets', 'slug' => 'entry-tickets', 'is_active' => true]);

        $this->actingAs($user)->post(route('admin.tours.store'), [
            'name' => 'Invalid Tour',
            'tour_category_id' => $category->id,
            'tour_subcategory_id' => $otherSubcategory->id,
            'location' => 'Dubai',
            'starting_price' => 100,
            'currency' => 'AED',
            'status' => 'draft',
        ])->assertStatus(422);
    }

    public function test_admin_can_delete_a_tour_with_package_prices(): void
    {
        $user = User::factory()->create(['email_verified_at' => now(), 'is_admin' => true]);
        $category = TourCategory::query()->create(['name' => 'Desert Adventures', 'slug' => 'desert-adventures', 'is_active' => true]);
        $tour = Tour::query()->create([
            'tour_category_id' => $category->id,
            'name' => 'Deletable Desert Safari',
            'slug' => 'deletable-desert-safari',
            'location' => 'Dubai',
            'starting_price' => 299,
            'currency' => 'AED',
            'status' => 'draft',
        ]);
        $package = TourPackage::query()->create([
            'tour_id' => $tour->id,
            'name' => 'Standard Package',
        ]);
        TourPrice::query()->create([
            'tour_id' => $tour->id,
            'tour_package_id' => $package->id,
            'vehicle_type' => 'shared',
            'adult_price' => 299,
            'currency' => 'AED',
        ]);

        $this->actingAs($user)->delete(route('admin.tours.destroy', $tour))
            ->assertRedirect(route('admin.tours.index'));

        $this->assertDatabaseMissing('tours', ['id' => $tour->id]);
        $this->assertDatabaseMissing('tour_packages', ['id' => $package->id]);
        $this->assertDatabaseCount('tour_prices', 0);
    }

    public function test_admin_can_delete_multiple_tours_with_package_prices(): void
    {
        $user = User::factory()->create(['email_verified_at' => now(), 'is_admin' => true]);
        $category = TourCategory::query()->create(['name' => 'Desert Adventures', 'slug' => 'desert-adventures', 'is_active' => true]);
        $tours = collect(['First', 'Second'])->map(function (string $name) use ($category): Tour {
            $tour = Tour::query()->create([
                'tour_category_id' => $category->id,
                'name' => $name.' Deletable Desert Safari',
                'slug' => strtolower($name).'-deletable-desert-safari',
                'location' => 'Dubai',
                'starting_price' => 299,
                'currency' => 'AED',
                'status' => 'draft',
            ]);
            $package = TourPackage::query()->create(['tour_id' => $tour->id, 'name' => 'Standard Package']);
            TourPrice::query()->create(['tour_id' => $tour->id, 'tour_package_id' => $package->id, 'vehicle_type' => 'shared', 'adult_price' => 299, 'currency' => 'AED']);

            return $tour;
        });

        $this->actingAs($user)->get(route('admin.tours.index'))
            ->assertOk()
            ->assertSee('Delete selected')
            ->assertSee('data-select-all-tours', false);

        $this->actingAs($user)->delete(route('admin.tours.destroy-many'), [
            'tour_ids' => $tours->pluck('id')->all(),
        ])->assertRedirect(route('admin.tours.index'));

        $this->assertDatabaseCount('tours', 0);
        $this->assertDatabaseCount('tour_packages', 0);
        $this->assertDatabaseCount('tour_prices', 0);
    }

    public function test_morning_desert_adventure_seeder_creates_its_missing_tour(): void
    {
        $this->seed(MorningDesertAdventureSeeder::class);

        $tour = Tour::query()->where('slug', 'morning-desert-adventure')->firstOrFail();

        $this->assertSame('Morning Desert Adventure', $tour->name);
        $this->assertSame('active', $tour->status);
        $this->assertDatabaseHas('tour_categories', ['slug' => 'desert-adventures']);
        $this->assertDatabaseHas('tour_subcategories', ['slug' => 'desert-safaris']);
        $this->assertDatabaseCount('tour_packages', 2);
        $this->assertDatabaseCount('tour_prices', 3);
    }

    public function test_evening_desert_safari_details_and_active_feature_icons_are_seeded(): void
    {
        $category = TourCategory::query()->create(['name' => 'Desert Adventures', 'slug' => 'desert-adventures', 'is_active' => true]);
        $subcategory = TourSubcategory::query()->create(['tour_category_id' => $category->id, 'name' => 'Desert Safaris', 'slug' => 'desert-safaris', 'is_active' => true]);
        Tour::query()->create([
            'tour_category_id' => $category->id,
            'tour_subcategory_id' => $subcategory->id,
            'name' => 'Evening Desert Safari in Dubai',
            'slug' => 'evening-desert-safari-in-dubai',
            'location' => 'Dubai',
            'starting_price' => 1,
            'currency' => 'PKR',
            'status' => 'active',
        ]);

        $this->seed(TourManagementSeeder::class);

        $tour = Tour::query()->where('slug', 'evening-desert-safari-in-dubai')->firstOrFail();
        $this->assertSame(6, $tour->duration);
        $this->assertSame('hours', $tour->duration_unit);
        $this->assertSame('49937.00', $tour->starting_price);
        $this->assertDatabaseHas('tour_features', ['name' => 'Camel Ride', 'icon' => 'camel', 'is_active' => true]);
        $this->assertDatabaseCount('tour_itineraries', 7);
        $this->get('/tours/evening-desert-safari-in-dubai')->assertOk()->assertSee('BBQ dinner and entertainment')->assertSee('Camel Ride');
    }

    public function test_fort_lisaili_tour_is_seeded_with_its_gallery_itinerary_and_package_prices(): void
    {
        $category = TourCategory::query()->create(['name' => 'Desert Adventures', 'slug' => 'desert-adventures', 'is_active' => true]);
        $subcategory = TourSubcategory::query()->create(['tour_category_id' => $category->id, 'name' => 'Desert Safaris', 'slug' => 'desert-safaris', 'is_active' => true]);

        $this->seed(TheFortLisailiDesertExperienceSeeder::class);

        $tour = Tour::query()->where('slug', 'the-fort-lisaili-desert-experience')->firstOrFail();

        $this->assertSame($category->id, $tour->tour_category_id);
        $this->assertSame($subcategory->id, $tour->tour_subcategory_id);
        $this->assertSame('7618.00', $tour->starting_price);
        $this->assertDatabaseCount('tour_images', 2);
        $this->assertDatabaseCount('tour_itineraries', 7);
        $this->assertDatabaseCount('tour_packages', 5);
        $this->assertDatabaseCount('tour_prices', 5);

        $this->get('/tours/the-fort-lisaili-desert-experience')
            ->assertOk()
            ->assertSee('The Fort - Lisaili Desert Experience')
            ->assertSee('Sunset stop at the Aperol Spritz bar')
            ->assertSee('Exclusive Transfer');
    }
}
