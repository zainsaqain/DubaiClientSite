<?php

namespace Tests\Feature\Admin;

use App\Models\DesertAdventure;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DesertAdventureCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_and_manage_a_desert_adventure(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);

        $this->actingAs($user)
            ->get(route('admin.desert-adventures.index'))
            ->assertOk()
            ->assertSee('All desert adventures');

        $this->actingAs($user)
            ->post(route('admin.desert-adventures.store'), [
                'title' => 'Private Sunset Safari',
                'category' => 'Desert Safaris',
                'description' => 'A private golden-hour journey through the Dubai desert.',
                'location' => 'Dubai',
                'price' => 695,
                'duration' => '5 hours',
                'is_featured' => true,
                'is_active' => true,
            ])
            ->assertRedirect(route('admin.desert-adventures.index'));

        $this->assertDatabaseHas('desert_adventures', [
            'title' => 'Private Sunset Safari',
            'category' => 'Desert Safaris',
            'is_featured' => true,
            'is_active' => true,
        ]);

        $this->get(route('desert-adventures'))
            ->assertOk()
            ->assertSee('Private Sunset Safari');
    }

    public function test_admin_can_change_an_adventure_category(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $adventure = DesertAdventure::query()->create([
            'title' => 'Editable School Trip',
            'category' => 'School Trips',
            'description' => 'A school trip that can be moved to another category.',
            'location' => 'Dubai',
            'price' => 450,
            'is_active' => true,
        ]);

        $this->actingAs($user)
            ->put(route('admin.desert-adventures.update', $adventure), [
                'title' => $adventure->title,
                'category' => 'Desert Safaris',
                'description' => $adventure->description,
                'location' => $adventure->location,
                'price' => $adventure->price,
                'duration' => $adventure->duration,
                'is_active' => true,
            ])
            ->assertRedirect(route('admin.desert-adventures.index'));

        $this->assertDatabaseHas('desert_adventures', [
            'id' => $adventure->id,
            'category' => 'Desert Safaris',
        ]);
    }

    public function test_live_school_trips_page_uses_database_adventures(): void
    {
        DesertAdventure::query()->create([
            'title' => 'Database Managed School Trip',
            'category' => 'School Trips',
            'description' => 'A school group experience served directly from the database.',
            'location' => 'Dubai',
            'price' => 600,
            'is_active' => true,
        ]);

        $this->get(route('school-trips'))
            ->assertOk()
            ->assertSee('Database Managed School Trip');
    }

    public function test_each_desert_category_page_uses_its_database_records(): void
    {
        $categories = [
            'Desert Safaris' => ['desert-safaris', 'Dynamic Safari'],
            'Desert Experiences' => ['desert-experiences', 'Dynamic Experience'],
            'Dune Buggies' => ['dune-buggies-category', 'Dynamic Buggy'],
        ];

        foreach ($categories as $category => [$route, $title]) {
            DesertAdventure::query()->create([
                'title' => $title,
                'category' => $category,
                'description' => 'A database-backed category experience.',
                'location' => 'Dubai',
                'price' => 500,
                'is_active' => true,
            ]);

            $this->get(route($route))
                ->assertOk()
                ->assertSee($title);
        }
    }
}
