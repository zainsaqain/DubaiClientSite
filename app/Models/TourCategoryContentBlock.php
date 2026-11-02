<?php

namespace App\Models;

use Database\Factories\TourCategoryContentBlockFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TourCategoryContentBlock extends Model
{
    /** @use HasFactory<TourCategoryContentBlockFactory> */
    use HasFactory;

    protected $fillable = [
        'tour_category_id',
        'heading',
        'body',
        'image',
        'image_alt',
        'layout',
        'display_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(TourCategory::class, 'tour_category_id');
    }
}
