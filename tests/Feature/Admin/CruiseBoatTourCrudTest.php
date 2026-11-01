<?php

namespace Tests\Feature\Admin;

use App\Models\CruiseBoatTour;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CruiseBoatTourCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_update_and_delete_a_cruise_boat_tour(): void
    {
        $user = User::factory()->create(['email_verified_at' => now(), 'is_admin' => true]);

        $this->actingAs($user)
            ->post(route('admin.cruise-boat-tours.store'), [
                'title' => 'Dubai Sunset Yacht Escape',
                'tour_type' => 'Luxury yacht',
                'description' => 'A premium sunset tour from Dubai Marina.',
                'location' => 'Dubai Marina',
                'price' => 18000,
                'is_featured' => true,
                'is_active' => true,
            ])
            ->assertRedirect(route('admin.cruise-boat-tours.index'));

        $tour = CruiseBoatTour::query()->firstOrFail();

        $this->get(route('cruise-boat-tours'))
            ->assertOk()
            ->assertSee('Dubai Sunset Yacht Escape')
            ->assertSee('PKR 18,000');

        $this->actingAs($user)
            ->put(route('admin.cruise-boat-tours.update', $tour), [
                'title' => $tour->title,
                'tour_type' => 'Private yacht',
                'description' => 'An updated premium sunset tour from Dubai Marina.',
                'location' => $tour->location,
                'price' => 19500,
                'is_active' => true,
            ])
            ->assertRedirect(route('admin.cruise-boat-tours.index'));

        $this->assertDatabaseHas('cruise_boat_tours', [
            'id' => $tour->id,
            'tour_type' => 'Private yacht',
            'price' => 19500,
        ]);

        $this->actingAs($user)
            ->delete(route('admin.cruise-boat-tours.destroy', $tour))
            ->assertRedirect(route('admin.cruise-boat-tours.index'));

        $this->assertDatabaseMissing('cruise_boat_tours', ['id' => $tour->id]);
    }
}
