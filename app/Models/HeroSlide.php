<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroSlide extends Model
{
    use HasFactory;

    protected $fillable = ['badge', 'heading', 'heading_highlight', 'description', 'image', 'image_alt', 'primary_label', 'primary_url', 'secondary_label', 'secondary_url', 'feature_one', 'feature_two', 'feature_three', 'display_order', 'is_active'];

    protected function casts(): array
    {
        return ['display_order' => 'integer', 'is_active' => 'boolean'];
    }

    public function imageUrl(): string
    {
        if (! $this->image) {
            return asset('images/hero-dubai-aquarium.png');
        }

        return str_starts_with($this->image, 'images/') ? asset($this->image) : asset('storage/'.$this->image);
    }

    /** @return array<string, mixed> */
    public function toHeroArray(): array
    {
        return [
            'id' => 'hero-slide-'.$this->id,
            'badge' => $this->badge,
            'heading' => $this->heading,
            'heading_highlight' => $this->heading_highlight,
            'description' => $this->description,
            'image' => $this->imageUrl(),
            'image_alt' => $this->image_alt ?: $this->heading,
            'primary_btn' => ['text' => $this->primary_label, 'url' => $this->primary_url, 'aria_label' => $this->primary_label.' — '.$this->heading],
            'secondary_btn' => ['text' => $this->secondary_label, 'url' => $this->secondary_url, 'aria_label' => $this->secondary_label.' — '.$this->heading],
            'features' => [
                ['name' => $this->feature_one, 'icon' => 'sparkles'],
                ['name' => $this->feature_two, 'icon' => 'users'],
                ['name' => $this->feature_three, 'icon' => 'calendar-check'],
            ],
        ];
    }
}
