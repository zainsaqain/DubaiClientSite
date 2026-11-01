<?php

namespace Tests\Feature\Admin;

use App\Models\SportsEvent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SportsEventCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_update_and_delete_a_sports_event(): void
    {
        $user = User::factory()->create(['email_verified_at' => now(), 'is_admin' => true]);

        $this->actingAs($user)
            ->post(route('admin.sports-events.store'), [
                'title' => 'Dubai Tennis Finals',
                'event_type' => 'Tennis',
                'description' => 'A premium tennis event in Dubai.',
                'location' => 'Dubai',
                'price' => 25000,
                'is_featured' => true,
                'is_active' => true,
            ])
            ->assertRedirect(route('admin.sports-events.index'));

        $event = SportsEvent::query()->firstOrFail();

        $this->assertDatabaseHas('sports_events', [
            'title' => 'Dubai Tennis Finals',
            'event_type' => 'Tennis',
            'is_active' => true,
        ]);

        $this->get(route('sports-events'))
            ->assertOk()
            ->assertSee('Dubai Tennis Finals')
            ->assertSee('PKR 25,000');

        $this->actingAs($user)
            ->put(route('admin.sports-events.update', $event), [
                'title' => 'Dubai Tennis Finals',
                'event_type' => 'Tennis',
                'description' => 'An updated premium tennis event in Dubai.',
                'location' => 'Dubai',
                'price' => 27500,
                'is_active' => true,
            ])
            ->assertRedirect(route('admin.sports-events.index'));

        $this->assertDatabaseHas('sports_events', [
            'id' => $event->id,
            'price' => 27500,
        ]);

        $this->actingAs($user)
            ->delete(route('admin.sports-events.destroy', $event))
            ->assertRedirect(route('admin.sports-events.index'));

        $this->assertDatabaseMissing('sports_events', ['id' => $event->id]);
    }
}
