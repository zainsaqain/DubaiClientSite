<?php

namespace Tests\Feature;

use App\Models\Tour;
use App\Models\TourCategory;
use App\Models\TourSubcategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_administrator_can_manage_and_search_categories_while_duplicate_slugs_are_rejected(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)->post(route('admin.tour-categories.store'), [
            'name' => 'Dubai Experiences',
            'slug' => 'dubai-experiences',
            'description' => 'Curated activities in Dubai.',
            'display_order' => 3,
            'is_active' => true,
            'meta_title' => 'Dubai Experiences',
            'meta_description' => 'Browse Dubai experiences.',
        ])->assertRedirect(route('admin.tour-categories.index'));

        $category = TourCategory::query()->where('slug', 'dubai-experiences')->firstOrFail();

        $this->actingAs($admin)->get(route('admin.tour-categories.index', ['search' => 'Experiences']))
            ->assertOk()
            ->assertSee('Dubai Experiences');

        $this->actingAs($admin)->put(route('admin.tour-categories.update', $category), [
            'name' => 'Dubai Experience Collection',
            'slug' => 'dubai-experiences',
            'description' => 'Updated curated activities in Dubai.',
            'display_order' => 5,
            'is_active' => false,
            'meta_title' => 'Dubai Experience Collection',
            'meta_description' => 'Updated Dubai experiences.',
        ])->assertRedirect(route('admin.tour-categories.index'));

        $this->assertDatabaseHas('tour_categories', [
            'id' => $category->id,
            'name' => 'Dubai Experience Collection',
            'is_active' => false,
            'display_order' => 5,
        ]);

        $this->actingAs($admin)->post(route('admin.tour-categories.store'), [
            'name' => 'Duplicate Category',
            'slug' => 'dubai-experiences',
        ])->assertSessionHasErrors('slug');
    }

    public function test_administrator_can_assign_subcategories_to_a_parent_and_cannot_delete_referenced_hierarchy(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $category = TourCategory::query()->create([
            'name' => 'Desert Adventures',
            'slug' => 'desert-adventures',
            'is_active' => true,
        ]);

        $this->actingAs($admin)->post(route('admin.tour-subcategories.store'), [
            'tour_category_id' => $category->id,
            'name' => 'Desert Safaris',
            'slug' => 'desert-safaris',
            'description' => 'Guided desert safaris.',
            'display_order' => 1,
            'is_active' => true,
            'meta_title' => 'Desert Safaris',
            'meta_description' => 'Desert safari experiences.',
        ])->assertRedirect(route('admin.tour-subcategories.index'));

        $subcategory = TourSubcategory::query()->where('slug', 'desert-safaris')->firstOrFail();

        $this->assertSame($category->id, $subcategory->tour_category_id);

        $this->actingAs($admin)->get(route('admin.tour-subcategories.index', ['search' => 'Desert Adventures']))
            ->assertOk()
            ->assertSee('Desert Safaris');

        $this->actingAs($admin)->post(route('admin.tour-subcategories.store'), [
            'tour_category_id' => $category->id,
            'name' => 'Duplicate Subcategory',
            'slug' => 'desert-safaris',
        ])->assertSessionHasErrors('slug');

        Tour::query()->create([
            'tour_category_id' => $category->id,
            'tour_subcategory_id' => $subcategory->id,
            'name' => 'Protected Safari',
            'slug' => 'protected-safari',
            'location' => 'Dubai',
            'starting_price' => 300,
            'currency' => 'AED',
            'status' => 'active',
        ]);

        $this->actingAs($admin)->delete(route('admin.tour-subcategories.destroy', $subcategory))
            ->assertSessionHas('error');
        $this->assertDatabaseHas('tour_subcategories', ['id' => $subcategory->id]);

        $this->actingAs($admin)->delete(route('admin.tour-categories.destroy', $category))
            ->assertSessionHas('error');
        $this->assertDatabaseHas('tour_categories', ['id' => $category->id]);
    }

    public function test_public_catalogues_hide_tours_with_inactive_parents_or_subcategories(): void
    {
        $activeCategory = TourCategory::query()->create([
            'name' => 'Desert Adventures',
            'slug' => 'desert-adventures',
            'is_active' => true,
        ]);
        $activeSubcategory = TourSubcategory::query()->create([
            'tour_category_id' => $activeCategory->id,
            'name' => 'Desert Safaris',
            'slug' => 'desert-safaris',
            'is_active' => true,
        ]);
        $inactiveSubcategory = TourSubcategory::query()->create([
            'tour_category_id' => $activeCategory->id,
            'name' => 'Hidden Safaris',
            'slug' => 'hidden-safaris',
            'is_active' => false,
        ]);
        $inactiveCategory = TourCategory::query()->create([
            'name' => 'Inactive Adventures',
            'slug' => 'inactive-adventures',
            'is_active' => false,
        ]);

        Tour::query()->create([
            'tour_category_id' => $activeCategory->id,
            'tour_subcategory_id' => $activeSubcategory->id,
            'name' => 'Visible Safari',
            'slug' => 'visible-safari',
            'location' => 'Dubai',
            'starting_price' => 350,
            'currency' => 'AED',
            'status' => 'active',
        ]);
        Tour::query()->create([
            'tour_category_id' => $activeCategory->id,
            'tour_subcategory_id' => $inactiveSubcategory->id,
            'name' => 'Inactive Subcategory Safari',
            'slug' => 'inactive-subcategory-safari',
            'location' => 'Dubai',
            'starting_price' => 350,
            'currency' => 'AED',
            'status' => 'active',
        ]);
        Tour::query()->create([
            'tour_category_id' => $inactiveCategory->id,
            'name' => 'Inactive Category Safari',
            'slug' => 'inactive-category-safari',
            'location' => 'Dubai',
            'starting_price' => 350,
            'currency' => 'AED',
            'status' => 'active',
        ]);

        $this->get(route('desert-safaris'))
            ->assertOk()
            ->assertSee('Visible Safari')
            ->assertDontSee('Inactive Subcategory Safari');

        $this->get('/tours/inactive-subcategory-safari')->assertNotFound();
        $this->get('/tours/inactive-category-safari')->assertNotFound();
    }
}
