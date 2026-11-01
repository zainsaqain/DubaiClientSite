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

    public function test_normal_authenticated_users_are_forbidden_from_the_admin_dashboard(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/admin')
            ->assertForbidden();
    }

    public function test_normal_authenticated_users_are_forbidden_from_admin_crud_routes(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.attractions.index'))
            ->assertForbidden();
    }

    public function test_administrators_can_open_admin_crud_routes(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->get(route('admin.attractions.index'))
            ->assertOk();
    }

    public function test_dashboard_route_redirects_administrators_to_the_admin_dashboard(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->get('/dashboard')
            ->assertRedirect(route('admin.dashboard', absolute: false));
    }

    public function test_dashboard_route_redirects_normal_users_to_the_home_page(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/dashboard')
            ->assertRedirect(route('home', absolute: false));
    }
}
