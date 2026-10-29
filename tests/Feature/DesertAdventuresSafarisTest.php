<?php

namespace Tests\Feature;

use Tests\TestCase;

class DesertAdventuresSafarisTest extends TestCase
{
    /**
     * Test Desert Safaris category page renders with all required sections.
     */
    public function test_desert_safaris_category_page_renders_with_required_sections(): void
    {
        $response = $this->get('/desert-adventures/desert-safaris');

        $response->assertStatus(200);

        // Breadcrumbs
        $response->assertSee('Home');
        $response->assertSee('Desert Adventures');
        $response->assertSee('Desert Safaris');

        // Heading & intro
        $response->assertSee('Desert Safaris');
        $response->assertSee('Discover the wonders of the Dubai desert');

        // Target Section: Desert Safaris with Waheed Murad
        $response->assertSee('Desert Safaris with');
        $response->assertSee('Waheed Murad');

        // 3 Key story sub-sections
        $response->assertSee('An award-winning experience');
        $response->assertSee('Our ever-popular desert safari excursions have seen us win several awards');

        $response->assertSee('The Dubai Desert Conservation Reserve');
        $response->assertSee('vast, protected nature reserve that covers 225 square kilometres');

        $response->assertSee('Eco-friendly and sustainable practices');
        $response->assertSee('At Waheed Murad, we take pride in our sustainable tourism best practices');
        $response->assertSee('Travelife Partner sustainability award');

        // Target Section: Frequently Asked Questions
        $response->assertSee('Frequently asked');
        $response->assertSee('questions');
        $response->assertSee('What do you wear on a desert safari?');
        $response->assertSee('Where is a Dubai desert safari?');
        $response->assertSee('How long is a desert safari?');
        $response->assertSee('What is included in a desert safari in Dubai?');
        $response->assertSee('What is the price of a desert safari?');
    }

    /**
     * Test Evening Desert Safari product detail page renders with carousel and recently viewed sections.
     */
    public function test_evening_desert_safari_detail_page_renders_all_components(): void
    {
        $response = $this->get('/desert-adventures/desert-safaris/evening-desert-safari');

        $response->assertStatus(200);

        // Breadcrumbs and title
        $response->assertSee('Evening Desert Safari');
        $response->assertSee('Desert Safaris');

        // Target Section: Other experiences you might like
        $response->assertSee('Other');
        $response->assertSee('experiences');
        $response->assertSee('you might like');
        $response->assertSee('data-related-carousel', false);
        $response->assertSee('data-carousel-previous', false);
        $response->assertSee('data-carousel-next', false);

        // Product preview cards inside carousel
        $response->assertSee('Morning Desert Adventure');
        $response->assertSee('The Fort – Lisaili Desert Experience');
        $response->assertSee('Exclusive Desert Experience');
        $response->assertSee('Desert Dune Buggies &amp; Evening Safari Combo', false);

        // Target Section: Recently viewed
        $response->assertSee('Recently');
        $response->assertSee('viewed');
        $response->assertSee('data-recently-viewed', false);
        $response->assertSee('data-current-product="evening-desert-safari"', false);
        $response->assertSee('data-recently-viewed-empty', false);
        $response->assertSee('Open another experience to see it here.');
        $response->assertSee('data-recently-viewed-list', false);
    }
}
