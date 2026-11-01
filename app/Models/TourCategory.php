<?php

namespace App\Models;

use Database\Factories\TourCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TourCategory extends Model
{
    /** @use HasFactory<TourCategoryFactory> */
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'image', 'display_order', 'is_active', 'meta_title', 'meta_description'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function subcategories(): HasMany
    {
        return $this->hasMany(TourSubcategory::class);
    }

    public function tours(): HasMany
    {
        return $this->hasMany(Tour::class);
    }
}
