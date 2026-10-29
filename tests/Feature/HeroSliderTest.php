<?php

namespace Tests\Feature;

use Tests\TestCase;

class HeroSliderTest extends TestCase
{
    /**
     * Test the homepage renders with the 4-slide hero banner and all requirements.
     */
    public function test_homepage_renders_all_four_hero_slides_and_content(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        // Verify all 4 images are connected
        $response->assertSee('images/hero-dubai-aquarium.png');
        $response->assertSee('images/airport-transfer.png');
        $response->assertSee('images/desert-safari.png');

        // Verify Badges
        $response->assertSee('EXPLORE DUBAI');
        $response->assertSee('DUBAI AIRPORT TRANSFERS');
        $response->assertSee('DUBAI DESERT SAFARI');

        // Verify Headings
        $response->assertSee('Discover Dubai&#039;s <span class="hero-gold-text">Best Attractions</span>', false);
        $response->assertSee('Arrive in Dubai. <span class="hero-gold-text">Travel in Comfort.</span>', false);
        $response->assertSee('Experience the <span class="hero-gold-text">Magic of the Desert</span>', false);

        // Verify Descriptions
        $response->assertSee('Browse unforgettable experiences and make the most of your Dubai adventure.');
        $response->assertSee('Enjoy pre-booked pick-up or drop-off between the airport and any hotel or residence in Dubai.');
        $response->assertSee('Browse unforgettable experiences and make the most of your Dubai adventure.');
        $response->assertSee('Ride the golden dunes, spot wildlife, enjoy desert dining and live entertainment.');

        // Verify Primary and Secondary Buttons
        $response->assertSee('Book Now');
        $response->assertSee('How It Works');
        $response->assertSee('Explore All');
        $response->assertSee('Explore Safari');

        // Verify Feature Icons
        $response->assertSee('Easy Booking');
        $response->assertSee('Door-to-door');
        $response->assertSee('Pre-booked');
        $response->assertSee('Dubai-wide');
        $response->assertSee('Iconic Places');
        $response->assertSee('Family Fun');
        $response->assertSee('Camel Rides');
        $response->assertSee('Golden Dunes');
        $response->assertSee('Desert Dining');

        // Verify Slider Controls & Accessibility
        $response->assertSee('hero-arrow-prev');
        $response->assertSee('hero-arrow-next');
        $response->assertSee('hero-pagination');
        $response->assertSee('aria-roledescription="carousel"', false);

        // Verify "Desert Safaris in Dubai" section matching user screenshot
        $response->assertSee('Desert');
        $response->assertSee('Safaris');
        $response->assertSee('in Dubai');
        $response->assertSee('The Fort - Lisaili Desert Experience');
        $response->assertSee('Evening Desert Safari in Dubai');
        $response->assertSee('Morning Desert Adventure');
        $response->assertSee('Dune Buggy Adventure in Dubai');
        $response->assertSee('PKR 7,618');
        $response->assertSee('PKR 49,937');
        $response->assertSee('PKR 36,856');
        $response->assertSee('PKR 61,558');
        $response->assertSee("2025 Travellers' Choice", false);
        $response->assertSee('View all Desert Safaris');
    }
}
