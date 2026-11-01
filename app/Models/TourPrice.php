<?php

namespace App\Models;

use Database\Factories\TourPriceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TourPrice extends Model
{
    /** @use HasFactory<TourPriceFactory> */
    use HasFactory;

    protected $fillable = ['tour_id', 'tour_package_id', 'vehicle_type', 'vehicle_label', 'description', 'adult_price', 'child_price', 'child_min_age', 'child_max_age', 'infant_price', 'infant_max_age', 'minimum_guests', 'maximum_guests', 'currency', 'is_active'];

    protected function casts(): array
    {
        return ['adult_price' => 'decimal:2', 'child_price' => 'decimal:2', 'infant_price' => 'decimal:2', 'is_active' => 'boolean'];
    }

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(TourPackage::class, 'tour_package_id');
    }
}
