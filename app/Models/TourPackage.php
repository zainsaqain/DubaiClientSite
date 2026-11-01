<?php

namespace App\Models;

use Database\Factories\TourPackageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TourPackage extends Model
{
    /** @use HasFactory<TourPackageFactory> */
    use HasFactory;

    protected $fillable = ['tour_id', 'name', 'description', 'is_active', 'display_order'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

    public function prices(): HasMany
    {
        return $this->hasMany(TourPrice::class);
    }
}
