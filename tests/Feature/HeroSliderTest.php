<?php

namespace Tests\Feature;

use App\Models\HeroSlide;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HeroSliderTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_renders_active_database_hero_slides_only(): void
    {
        HeroSlide::query()->create([
            'badge' => 'DATABASE HERO',
            'heading' => 'Explore the Dubai skyline',
            'heading_highlight' => 'Dubai skyline',
            'description' => 'A homepage slide managed in the database.',
            'image' => 'images/hero-dubai-aquarium.png',
            'image_alt' => 'Dubai skyline',
            'primary_label' => 'Explore now',
            'primary_url' => '/search',
            'secondary_label' => 'Learn more',
            'secondary_url' => '/why-us',
            'feature_one' => 'Database managed',
            'feature_two' => 'Responsive',
            'feature_three' => 'Active only',
            'display_order' => 1,
            'is_active' => true,
        ]);
        HeroSlide::query()->create([
            'badge' => 'HIDDEN HERO',
            'heading' => 'Hidden slide',
            'heading_highlight' => 'Hidden',
            'description' => 'This must stay hidden.',
            'image' => 'images/hero-dubai-aquarium.png',
            'image_alt' => 'Hidden',
            'primary_label' => 'Hidden',
            'primary_url' => '/',
            'secondary_label' => 'Hidden',
            'secondary_url' => '/',
            'feature_one' => 'Hidden',
            'feature_two' => 'Hidden',
            'feature_three' => 'Hidden',
            'display_order' => 2,
            'is_active' => false,
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('DATABASE HERO')
            ->assertSee('Explore the <span class="hero-gold-text">Dubai skyline</span>', false)
            ->assertSee('A homepage slide managed in the database.')
            ->assertDontSee('HIDDEN HERO')
            ->assertSee('hero-arrow-prev')
            ->assertSee('hero-arrow-next')
            ->assertSee('hero-pagination');
    }
}
