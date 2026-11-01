<?php

namespace Tests\Feature\Admin;

use App\Models\CityTour;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CityTourCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_update_and_delete_a_city_tour(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);

        $this->actingAs($user)->post(route('admin.city-tours.store'), [
            'title' => 'Sharjah Culture Day', 'tour_type' => 'Culture', 'description' => 'A database-managed city culture tour.',
            'location' => 'Sharjah', 'price' => 12000, 'is_active' => true,
        ])->assertRedirect(route('admin.city-tours.index'));

        $tour = CityTour::query()->firstOrFail();
        $this->get(route('city-tours'))->assertOk()->assertSee('Sharjah Culture Day')->assertSee('PKR 12,000');

        $this->actingAs($user)->put(route('admin.city-tours.update', $tour), [
            'title' => $tour->title, 'tour_type' => 'Private culture', 'description' => 'An updated city culture tour.',
            'location' => 'Sharjah', 'price' => 13500, 'is_active' => true,
        ])->assertRedirect(route('admin.city-tours.index'));

        $this->assertDatabaseHas('city_tours', ['id' => $tour->id, 'tour_type' => 'Private culture', 'price' => 13500]);
        $this->actingAs($user)->delete(route('admin.city-tours.destroy', $tour))->assertRedirect(route('admin.city-tours.index'));
        $this->assertDatabaseMissing('city_tours', ['id' => $tour->id]);
    }
}
