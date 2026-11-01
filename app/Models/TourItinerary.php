<?php

namespace App\Models;

use Database\Factories\TourItineraryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TourItinerary extends Model
{
    /** @use HasFactory<TourItineraryFactory> */
    use HasFactory;

    protected $fillable = ['tour_id', 'display_order', 'title', 'description', 'duration', 'duration_unit', 'icon'];

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }
}
