<?php

namespace App\Models;

use Database\Factories\TourCategoryFaqFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TourCategoryFaq extends Model
{
    /** @use HasFactory<TourCategoryFaqFactory> */
    use HasFactory;

    protected $fillable = [
        'tour_category_id',
        'question',
        'answer',
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
