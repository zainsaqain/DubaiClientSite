<?php

namespace App\Models;

use Database\Factories\TourImageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TourImage extends Model
{
    /** @use HasFactory<TourImageFactory> */
    use HasFactory;

    protected $fillable = ['tour_id', 'path', 'alt', 'caption', 'display_order'];

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }
}
