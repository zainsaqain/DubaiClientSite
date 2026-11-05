<?php

namespace Tests\Feature;

use App\Models\Tour;
use App\Models\TourCategory;
use App\Models\TourPrice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_visitor_can_add_a_tour_to_the_cart_and_see_the_updated_cart_count(): void
    {
        $category = TourCategory::query()->create(['name' => 'Desert Adventures', 'slug' => 'desert-adventures', 'is_active' => true]);
        $tour = Tour::query()->create(['tour_category_id' => $category->id, 'name' => 'Evening Desert Safari', 'slug' => 'evening-desert-safari', 'starting_price' => 150, 'currency' => 'AED', 'status' => 'active']);
        $price = TourPrice::query()->create(['tour_id' => $tour->id, 'vehicle_type' => 'shared', 'adult_price' => 150, 'child_price' => 75, 'currency' => 'AED', 'is_active' => true]);

        $this->post(route('cart.store', $tour), [
            'tour_price_id' => $price->id,
            'travel_date' => now()->addDay()->toDateString(),
            'adults' => 2,
            'children' => 1,
            'infants' => 0,
        ])->assertRedirect(route('cart.index'));

        $this->get(route('cart.index'))
            ->assertOk()
            ->assertSee('Evening Desert Safari')
            ->assertSee('AED 375.00')
            ->assertSee('Cart, 1 items', false)
            ->assertSee('Your cart');
    }
}
