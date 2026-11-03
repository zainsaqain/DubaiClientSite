<?php

namespace App\Models;

use Database\Factories\TourFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Tour extends Model
{
    /** @use HasFactory<TourFactory> */
    use HasFactory;

    protected $fillable = ['tour_category_id', 'tour_subcategory_id', 'name', 'slug', 'short_description', 'about', 'full_description', 'location', 'duration', 'duration_unit', 'experience_time', 'languages', 'starting_price', 'currency', 'status', 'thumbnail', 'main_image', 'image_alt', 'pickup_information', 'highlights', 'know_before_you_go', 'age_policy', 'cancellation_policy', 'additional_notes', 'meta_title', 'meta_description', 'is_featured', 'is_bestseller', 'is_travellers_choice', 'is_original', 'location_badge', 'promotion_label', 'display_order', 'youtube_url'];

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
        if ($this->status !== 'active' || ! $this->category()->where('is_active', true)->exists()) {
            return false;
        }

        return ! $this->tour_subcategory_id
            || $this->subcategory()->where('is_active', true)->exists();
    }

    public function scopePublic(Builder $query): Builder
    {
        return $query
            ->where('status', 'active')
            ->whereHas('category', fn (Builder $categoryQuery): Builder => $categoryQuery->where('is_active', true))
            ->where(function (Builder $tourQuery): void {
                $tourQuery
                    ->whereNull('tour_subcategory_id')
                    ->orWhereHas('subcategory', fn (Builder $subcategoryQuery): Builder => $subcategoryQuery->where('is_active', true));
            });
    }

    public function imageUrl(?string $path = null): string
    {
        $path ??= $this->thumbnail ?: $this->main_image;

        if (blank($path)) {
            return asset('images/desert-safari.png');
        }

        if (Storage::disk('public')->exists($path)) {
            return asset('storage/'.$path);
        }

        if (is_file(public_path($path))) {
            return asset($path);
        }

        return asset('images/desert-safari.png');
    }

    /** @return array<string, mixed> */
    public function toCatalogueArray(): array
    {
        $image = $this->thumbnail ?: $this->main_image;
        $lowestPrice = $this->relationLoaded('prices')
            ? $this->prices->where('is_active', true)->pluck('adult_price')->filter()->min()
            : null;
        $categoryName = $this->subcategory?->name ?? $this->category?->name ?? 'Tours';
        $category = $this->subcategory?->slug ?? $this->category?->slug ?? 'tours';

        return [
            'title' => $this->name,
            'description' => $this->short_description ?: 'Explore a memorable experience with Waheed Murad Tourism.',
            'price' => (float) ($lowestPrice ?? $this->starting_price),
            'price_label' => $this->currency.' '.number_format((float) ($lowestPrice ?? $this->starting_price)),
            'pkr_price' => number_format((float) ($lowestPrice ?? $this->starting_price) * 103),
            'category' => $category,
            'category_name' => $categoryName,
            'time' => $this->experience_time ?: ($this->duration ? $this->duration.' '.$this->duration_unit : 'flexible'),
            'location' => str($this->location)->lower()->replace(' ', '-')->toString(),
            'vehicle' => $this->relationLoaded('prices')
                ? ($this->prices->pluck('vehicle_type')->filter()->first() ?: 'standard')
                : 'standard',
            'languages' => $this->languages ?? [],
            'is_bestseller' => $this->is_bestseller,
            'is_choice' => $this->is_travellers_choice,
            'location_tag' => $this->location_badge ?: $this->location,
            'promotion_label' => $this->promotion_label,
            'image' => $this->imageUrl($image),
            'gallery' => $this->images->pluck('path')->prepend($image)->filter()->map(fn (string $path): string => $this->imageUrl($path))->unique()->values()->all(),
            'url' => route('tours.show', $this),
        ];
    }
}
