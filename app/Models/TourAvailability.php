<?php

namespace App\Models;

use Database\Factories\TourAvailabilityFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TourAvailability extends Model
{
    /** @use HasFactory<TourAvailabilityFactory> */
    use HasFactory;

    protected $fillable = ['tour_id', 'available_date', 'start_time', 'capacity', 'booking_cutoff_hours', 'is_blocked'];

    protected function casts(): array
    {
        return ['available_date' => 'date', 'is_blocked' => 'boolean'];
    }

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }
}
