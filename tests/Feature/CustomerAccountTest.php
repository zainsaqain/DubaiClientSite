<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerAccountTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_account_links_render_for_a_non_admin_user(): void
    {
        $user = User::factory()->create(['is_admin' => false, 'first_name' => 'Ayesha']);

        $this->actingAs($user)
            ->get(route('home'))
            ->assertOk()
            ->assertSee('Welcome, Ayesha')
            ->assertSee(route('account.dashboard'), false)
            ->assertSee(route('account.profile'), false)
            ->assertSee(route('account.orders'), false)
            ->assertSee(route('account.wishlist'), false);
    }

    public function test_customer_account_pages_are_available_only_to_non_admin_users(): void
    {
        $customer = User::factory()->create(['is_admin' => false]);
        $administrator = User::factory()->create(['is_admin' => true]);

        $this->actingAs($customer)->get(route('account.dashboard'))->assertOk()->assertSee('My Account');
        $this->actingAs($customer)->get(route('account.profile'))->assertOk()->assertSee('Edit Profile');
        $this->actingAs($customer)->get(route('account.orders'))->assertOk()->assertSee('Order History');
        $this->actingAs($customer)->get(route('account.wishlist'))->assertOk()->assertSee('My Wishlist');
        $this->actingAs($administrator)->get(route('account.dashboard'))->assertForbidden();
    }
}
