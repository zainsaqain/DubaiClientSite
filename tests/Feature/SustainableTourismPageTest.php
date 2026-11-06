<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SustainableTourismPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_sustainable_tourism_page_and_why_us_menu_link_render(): void
    {
        $this->get(route('sustainable-tourism'))
            ->assertOk()
            ->assertSee('Sustainable Tourism')
            ->assertSee('Operating sustainably')
            ->assertSee('Dubai Desert Conservation Reserve')
            ->assertSee('Empowering our communities');

        $this->get(route('why-us'))
            ->assertOk()
            ->assertSee(route('sustainable-tourism'), false);
    }
}
