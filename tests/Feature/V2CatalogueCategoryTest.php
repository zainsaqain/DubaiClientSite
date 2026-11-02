<?php

namespace Tests\Feature;

use App\Models\CatalogueCategory;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class V2CatalogueCategoryTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config()->set('database.connections.tourism_v2', config('database.connections.sqlite'));
        DB::purge('tourism_v2');

        Schema::create('users', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('is_admin')->default(false);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::connection('tourism_v2')->create('catalogue_categories', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('catalogue_categories')->restrictOnDelete();
            $table->unsignedTinyInteger('level');
            $table->string('name', 150);
            $table->string('slug', 180);
            $table->text('description')->nullable();
            $table->string('image_path')->nullable();
            $table->unsignedInteger('display_order')->default(0);
            $table->string('status', 20)->default('draft');
            $table->string('meta_title', 255)->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();

            $table->unique(['parent_id', 'slug']);
        });
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get(route('admin.v2.categories.index'))->assertRedirect(route('login'));
    }

    public function test_non_administrator_cannot_access_v2_catalogue_categories(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $this->actingAs($user)
            ->get(route('admin.v2.categories.index'))
            ->assertForbidden();
    }

    public function test_administrator_can_create_all_three_category_levels_but_not_a_fourth(): void
    {
        $administrator = User::factory()->create(['is_admin' => true]);

        $this->actingAs($administrator)
            ->post(route('admin.v2.categories.store'), $this->categoryData('Desert Adventures'))
            ->assertRedirect(route('admin.v2.categories.index'));

        $mainCategory = CatalogueCategory::query()->where('slug', 'desert-adventures')->firstOrFail();
        $this->assertSame(1, $mainCategory->level);

        $this->actingAs($administrator)
            ->post(route('admin.v2.categories.store'), $this->categoryData('Desert Safaris', $mainCategory->id))
            ->assertRedirect(route('admin.v2.categories.index'));

        $subcategory = CatalogueCategory::query()->where('slug', 'desert-safaris')->firstOrFail();
        $this->assertSame(2, $subcategory->level);

        $this->actingAs($administrator)
            ->post(route('admin.v2.categories.store'), $this->categoryData('Evening Safaris', $subcategory->id))
            ->assertRedirect(route('admin.v2.categories.index'));

        $childSubcategory = CatalogueCategory::query()->where('slug', 'evening-safaris')->firstOrFail();
        $this->assertSame(3, $childSubcategory->level);

        $this->actingAs($administrator)
            ->from(route('admin.v2.categories.create'))
            ->post(route('admin.v2.categories.store'), $this->categoryData('Too Deep', $childSubcategory->id))
            ->assertRedirect(route('admin.v2.categories.create'))
            ->assertSessionHasErrors('parent_id');

        $this->assertDatabaseMissing('catalogue_categories', ['slug' => 'too-deep'], 'tourism_v2');
    }

    /**
     * @return array<string, int|string>
     */
    private function categoryData(string $name, ?int $parentId = null): array
    {
        return [
            'name' => $name,
            'parent_id' => $parentId,
            'display_order' => 0,
            'status' => 'active',
        ];
    }
}
