<?php

namespace Tests\Feature;

use App\Models\Tour;
use App\Models\TourCategory;
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

    public function test_customer_can_save_and_remove_a_public_tour_from_their_wishlist(): void
    {
        $customer = User::factory()->create(['is_admin' => false]);
        $category = TourCategory::query()->create([
            'name' => 'City Tours',
            'slug' => 'city-tours',
            'is_active' => true,
        ]);
        $tour = Tour::query()->create([
            'tour_category_id' => $category->id,
            'name' => 'Private City Tour',
            'slug' => 'private-city-tour',
            'location' => 'Dubai',
            'starting_price' => 250,
            'currency' => 'AED',
            'status' => 'active',
        ]);

        $this->actingAs($customer)
            ->from(route('tours.show', $tour))
            ->post(route('tours.wishlist.store', $tour))
            ->assertRedirect(route('tours.show', $tour));

        $this->actingAs($customer)
            ->post(route('tours.wishlist.store', $tour))
            ->assertSessionHas('wishlist-status');

        $this->assertDatabaseCount('wishlists', 1);
        $this->assertDatabaseHas('wishlists', ['user_id' => $customer->id, 'tour_id' => $tour->id]);

        $this->actingAs($customer)
            ->get(route('tours.show', $tour))
            ->assertOk()
            ->assertSee('data-gallery-open', false)
            ->assertSee('data-share-tour', false)
            ->assertSee('Saved')
            ->assertSee('Wishlist, 1 items');

        $this->actingAs($customer)
            ->get(route('account.wishlist'))
            ->assertOk()
            ->assertSee('Private City Tour')
            ->assertSee('Remove');

        $this->actingAs($customer)
            ->from(route('account.wishlist'))
            ->delete(route('tours.wishlist.destroy', $tour))
            ->assertRedirect(route('account.wishlist'));

        $this->assertDatabaseCount('wishlists', 0);
    }
}
