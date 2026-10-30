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

    public function test_authenticated_users_can_view_the_dattaable_admin_dashboard(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin');

        $response
            ->assertOk()
            ->assertSee('Daily Sales')
            ->assertSee('Recent Users')
            ->assertSee('/vendor/dattaable/assets/css/style.css')
            ->assertSee('/vendor/dattaable/assets/js/script.js');
    }
}
