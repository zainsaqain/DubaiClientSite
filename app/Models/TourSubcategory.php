<?php

namespace App\Models;

use Database\Factories\TourSubcategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class TourSubcategory extends Model
{
    /** @use HasFactory<TourSubcategoryFactory> */
    use HasFactory;

    protected $fillable = ['tour_category_id', 'name', 'slug', 'description', 'image', 'display_order', 'is_active', 'meta_title', 'meta_description'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function imageUrl(): ?string
    {
        if (blank($this->image)) {
            return null;
        }

        if (Storage::disk('public')->exists($this->image)) {
            return asset('storage/'.$this->image);
        }

        return is_file(public_path($this->image)) ? asset($this->image) : null;
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(TourCategory::class, 'tour_category_id');
    }

    public function tours(): HasMany
    {
        return $this->hasMany(Tour::class);
    }
}
