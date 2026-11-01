<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeTestimonial extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'country', 'quote', 'rating', 'avatar', 'display_order', 'is_featured', 'is_active'];

    protected function casts(): array
    {
        return ['rating' => 'integer', 'display_order' => 'integer', 'is_featured' => 'boolean', 'is_active' => 'boolean'];
    }

    public function avatarUrl(): string
    {
        if (! $this->avatar) {
            return asset('images/waheed-murad-tourism-logo.jpeg');
        }

        return str_starts_with($this->avatar, 'images/') ? asset($this->avatar) : asset('storage/'.$this->avatar);
    }
}
