<?php

namespace App\Models;

use Database\Factories\TourFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tour extends Model
{
    /** @use HasFactory<TourFactory> */
    use HasFactory;

    protected $fillable = ['tour_category_id', 'tour_subcategory_id', 'name', 'slug', 'short_description', 'about', 'full_description', 'location', 'duration', 'duration_unit', 'languages', 'starting_price', 'currency', 'status', 'thumbnail', 'main_image', 'image_alt', 'pickup_information', 'highlights', 'know_before_you_go', 'age_policy', 'cancellation_policy', 'additional_notes', 'meta_title', 'meta_description', 'is_featured', 'is_bestseller', 'is_travellers_choice', 'is_original', 'location_badge', 'display_order', 'youtube_url'];

    protected function casts(): array
    {
        return ['languages' => 'array', 'starting_price' => 'decimal:2', 'is_featured' => 'boolean', 'is_bestseller' => 'boolean', 'is_travellers_choice' => 'boolean', 'is_original' => 'boolean'];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(TourCategory::class, 'tour_category_id');
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(TourSubcategory::class, 'tour_subcategory_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(TourImage::class)->orderBy('display_order');
    }

    public function features(): BelongsToMany
    {
        return $this->belongsToMany(TourFeature::class, 'tour_feature')->withPivot('inclusion_status');
    }

    public function itineraries(): HasMany
    {
        return $this->hasMany(TourItinerary::class)->orderBy('display_order');
    }

    public function packages(): HasMany
    {
        return $this->hasMany(TourPackage::class)->orderBy('display_order');
    }

    public function prices(): HasMany
    {
        return $this->hasMany(TourPrice::class);
    }

    public function availabilities(): HasMany
    {
        return $this->hasMany(TourAvailability::class);
    }

    public function isPublic(): bool
    {
        return $this->status === 'active';
    }

    public function imageUrl(?string $path = null): string
    {
        $path ??= $this->thumbnail ?: $this->main_image;

        if (! $path) {
            return asset('images/desert-safari.png');
        }

        return str_starts_with($path, 'images/') ? asset($path) : asset('storage/'.$path);
    }

    /** @return array<string, mixed> */
    public function toCatalogueArray(): array
    {
        $image = $this->thumbnail ?: $this->main_image;
        $categoryName = $this->subcategory?->name ?? $this->category?->name ?? 'Tours';
        $category = match ($categoryName) {
            'Desert Safaris' => 'safari',
            'Desert Experiences' => 'experience',
            'Dune Buggies' => 'buggy',
            default => 'school',
        };

        return [
            'title' => $this->name,
            'description' => $this->short_description ?: 'Explore a memorable experience with Waheed Murad Tourism.',
            'price' => (float) $this->starting_price,
            'pkr_price' => number_format((float) $this->starting_price * 103),
            'category' => $category,
            'category_name' => $categoryName,
            'time' => $this->duration ? $this->duration.' '.$this->duration_unit : 'flexible',
            'location' => str($this->location)->lower()->replace(' ', '-')->toString(),
            'vehicle' => '4x4',
            'is_bestseller' => $this->is_bestseller,
            'is_choice' => $this->is_travellers_choice,
            'location_tag' => $this->location_badge ?: $this->location,
            'image' => $image ? (str_starts_with($image, 'images/') ? $image : 'storage/'.$image) : 'images/desert-safari.png',
            'gallery' => $this->images->pluck('path')->prepend($image)->filter()->map(static fn (string $path): string => str_starts_with($path, 'images/') ? $path : 'storage/'.$path)->unique()->values()->all(),
            'url' => route('tours.show', $this),
        ];
    }
}
