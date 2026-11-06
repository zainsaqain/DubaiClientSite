<?php

namespace Tests\Feature;

use App\Models\TourCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttractionsNavigationTest extends TestCase
{
    use RefreshDatabase;

    public function test_attractions_navigation_uses_the_dedicated_attractions_page(): void
    {
        TourCategory::query()->create([
            'name' => 'Attractions',
            'slug' => 'attractions',
            'is_active' => true,
        ]);

        $this->get(route('attractions'))
            ->assertOk()
            ->assertSee('href="'.route('attractions').'"', false)
            ->assertDontSee('href="'.route('tour-categories.show', ['category' => 'attractions']).'"', false);
    }
}
