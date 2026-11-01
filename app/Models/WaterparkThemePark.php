<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaterparkThemePark extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'park_type', 'description', 'location', 'price', 'image', 'is_featured', 'is_active'];

    protected function casts(): array
    {
        return ['price' => 'decimal:2', 'is_featured' => 'boolean', 'is_active' => 'boolean'];
    }

    public function imageUrl(): string
    {
        if (! $this->image) {
            return asset('images/water-theme-parks-dubai.png');
        }

        return str_starts_with($this->image, 'images/') ? asset($this->image) : asset('storage/'.$this->image);
    }

    /** @return array<string, string> */
    public function toPublicArray(): array
    {
        return [
            'title' => $this->title,
            'image' => ! $this->image ? 'images/water-theme-parks-dubai.png' : (str_starts_with($this->image, 'images/') ? $this->image : 'storage/'.$this->image),
            'tag' => $this->park_type,
            'description' => $this->description,
            'location' => $this->location,
            'price' => 'PKR '.number_format((float) $this->price),
        ];
    }
}
