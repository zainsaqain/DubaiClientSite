<?php

namespace Tests\Feature;

use App\Models\Tour;
use App\Models\TourCategory;
use App\Models\TourSubcategory;
use App\Models\User;
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
}
