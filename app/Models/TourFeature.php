<?php

namespace App\Models;

use Database\Factories\TourFeatureFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
}
