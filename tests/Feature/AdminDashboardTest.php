<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Tour;
use App\Models\TourCategory;
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
            ->assertDontSee('Recent bookings')
            ->assertDontSee('Messages waiting')
            ->assertDontSee('Keep the day moving')
            ->assertSee('admin-dashboard');
    }

    public function test_normal_authenticated_users_are_forbidden_from_the_admin_dashboard(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/admin')
            ->assertForbidden();
    }

    public function test_dashboard_displays_live_booking_and_payment_metrics(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $customer = User::factory()->create(['is_admin' => false]);
        $category = TourCategory::query()->create(['name' => 'Desert Adventures', 'slug' => 'desert-adventures', 'is_active' => true]);
        $tour = Tour::query()->create(['tour_category_id' => $category->id, 'name' => 'Evening Desert Safari', 'slug' => 'evening-desert-safari', 'starting_price' => 350, 'currency' => 'AED', 'status' => 'active']);

        Booking::query()->create(['user_id' => $customer->id, 'tour_id' => $tour->id, 'order_number' => 'WMT-PAID-001', 'travel_date' => now()->addWeek(), 'adults' => 1, 'amount' => 350, 'currency' => 'AED', 'payment_method' => 'direct_bank_transfer', 'payment_status' => 'paid', 'status' => 'confirmed']);
        Booking::query()->create(['user_id' => $customer->id, 'tour_id' => $tour->id, 'order_number' => 'WMT-PENDING-002', 'travel_date' => now()->addWeeks(2), 'adults' => 2, 'amount' => 700, 'currency' => 'AED', 'payment_method' => 'direct_bank_transfer', 'payment_status' => 'pending_payment', 'status' => 'pending_payment']);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Total bookings')
            ->assertSee('AED 350.00')
            ->assertSee('Pending bookings')
            ->assertSee('Confirmed bookings')
            ->assertSee('Evening Desert Safari');
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
