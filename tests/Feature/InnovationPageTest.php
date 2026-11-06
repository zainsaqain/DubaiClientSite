<?php

namespace Tests\Feature;

use App\Models\Tour;
use App\Models\TourCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InnovationPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_innovation_page_shows_the_selected_innovation_tours_and_is_linked_from_why_us(): void
    {
        $attractionsCategory = TourCategory::query()->create([
            'name' => 'Attractions',
            'slug' => 'attractions',
            'is_active' => true,
        ]);
        $desertCategory = TourCategory::query()->create([
            'name' => 'Desert Adventures',
            'slug' => 'desert-adventures',
            'is_active' => true,
        ]);
        Tour::query()->create([
            'tour_category_id' => $attractionsCategory->id,
            'name' => 'Museum of the Future',
            'slug' => 'museum-of-the-future',
            'location' => 'Dubai',
            'starting_price' => 13004,
            'currency' => 'PKR',
            'status' => 'active',
        ]);
        Tour::query()->create([
            'tour_category_id' => $attractionsCategory->id,
            'name' => 'Dubai Frame Entrance Ticket',
            'slug' => 'dubai-frame-entrance-ticket',
            'location' => 'Dubai',
            'starting_price' => 4840,
            'currency' => 'PKR',
            'status' => 'active',
        ]);
        Tour::query()->create([
            'tour_category_id' => $desertCategory->id,
            'name' => 'Unrelated Desert Tour',
            'slug' => 'unrelated-desert-tour',
            'location' => 'Dubai',
            'starting_price' => 1000,
            'currency' => 'PKR',
            'status' => 'active',
        ]);

        $this->get(route('innovation'))
            ->assertOk()
            ->assertSee('Innovation')
            ->assertSee('Museum of the Future')
            ->assertSee('Dubai Frame Entrance Ticket')
            ->assertDontSee('Unrelated Desert Tour')
            ->assertSee('Dubai (2)');

        $this->get(route('why-us'))
            ->assertOk()
            ->assertSee(route('innovation'), false);
    }
}
