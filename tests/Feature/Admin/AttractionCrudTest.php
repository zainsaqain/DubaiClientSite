<?php

namespace Tests\Feature\Admin;

use App\Models\Attraction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttractionCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_update_and_delete_an_attraction(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);

        $this->actingAs($user)->post(route('admin.attractions.store'), [
            'title' => 'Dubai Museum Experience', 'attraction_type' => 'Culture',
            'description' => 'A database-managed culture experience in Dubai.', 'location' => 'Dubai',
            'price' => 5500, 'is_active' => true,
        ])->assertRedirect(route('admin.attractions.index'));

        $attraction = Attraction::query()->firstOrFail();

        $this->get(route('attractions'))->assertOk()->assertSee('Dubai Museum Experience')->assertSee('PKR 5,500');

        $this->actingAs($user)->put(route('admin.attractions.update', $attraction), [
            'title' => $attraction->title, 'attraction_type' => 'Museum',
            'description' => 'An updated culture experience in Dubai.', 'location' => 'Dubai',
            'price' => 6500, 'is_active' => true,
        ])->assertRedirect(route('admin.attractions.index'));

        $this->assertDatabaseHas('attractions', ['id' => $attraction->id, 'attraction_type' => 'Museum', 'price' => 6500]);

        $this->actingAs($user)->delete(route('admin.attractions.destroy', $attraction))
            ->assertRedirect(route('admin.attractions.index'));

        $this->assertDatabaseMissing('attractions', ['id' => $attraction->id]);
    }
}
