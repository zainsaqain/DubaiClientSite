<?php

namespace App\Models;

use Database\Factories\TourFeatureFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class TourFeature extends Model
{
    /** @use HasFactory<TourFeatureFactory> */
    use HasFactory;

    protected $fillable = ['name', 'icon', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function tours(): BelongsToMany
    {
        return $this->belongsToMany(Tour::class, 'tour_feature')->withPivot('inclusion_status');
    }

    /**
     * Return one of the public icon component's supported names.
     *
     * Older imports sometimes contain an image path instead of an icon name.
     * This keeps those records, while ensuring the public page always renders a
     * real SVG icon instead of exposing the path as visible text.
     */
    public function displayIcon(): string
    {
        $icon = Str::lower($this->icon ?: $this->name);

        return match (true) {
            str_contains($icon, 'transfer'), str_contains($icon, 'vehicle'), str_contains($icon, 'pickup'), str_contains($icon, 'car') => 'transfer',
            str_contains($icon, 'dune'), str_contains($icon, 'desert') => 'dune',
            str_contains($icon, 'tent'), str_contains($icon, 'camp'), str_contains($icon, 'visitor') => 'tent',
            str_contains($icon, 'sun'), str_contains($icon, 'sunset') => 'sun',
            str_contains($icon, 'falcon'), str_contains($icon, 'bird') => 'falcon',
            str_contains($icon, 'wild'), str_contains($icon, 'animal') => 'wildlife',
            str_contains($icon, 'camel') => 'camel',
            str_contains($icon, 'sand'), str_contains($icon, 'board') => 'sandboard',
            str_contains($icon, 'walk'), str_contains($icon, 'hike') => 'walk',
            str_contains($icon, 'bbq'), str_contains($icon, 'breakfast'), str_contains($icon, 'food') => 'bbq',
            str_contains($icon, 'drink'), str_contains($icon, 'beverage') => 'drinks',
            default => 'stars',
        };
    }
}
