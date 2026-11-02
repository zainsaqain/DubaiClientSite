<?php

namespace App\Models;

use Database\Factories\CatalogueCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CatalogueCategory extends Model
{
    /** @use HasFactory<CatalogueCategoryFactory> */
    use HasFactory;

    protected $connection = 'tourism_v2';

    protected $fillable = [
        'parent_id',
        'level',
        'name',
        'slug',
        'description',
        'image_path',
        'display_order',
        'status',
        'meta_title',
        'meta_description',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('display_order')->orderBy('name');
    }
}
