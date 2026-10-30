<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_the_existing_login_screen(): void
    {
        $response = $this->get('/admin');

        $response->assertRedirect(route('login', absolute: false));
    }

    public function test_authenticated_users_can_view_the_branded_admin_dashboard(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($user)->get('/admin');

        $response
            ->assertOk()
            ->assertSee('WAHEED MURAD')
            ->assertSee('Every journey')
            ->assertSee('Recent bookings')
            ->assertSee('admin-dashboard');
    }

    public function test_authenticated_users_can_open_the_admin_dashboard(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/admin')
            ->assertOk()
            ->assertSee('Recent bookings');
    }
}
