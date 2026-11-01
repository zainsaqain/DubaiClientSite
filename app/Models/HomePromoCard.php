<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomePromoCard extends Model
{
    use HasFactory;

    protected $fillable = ['eyebrow', 'title', 'description', 'image', 'button_label', 'button_url', 'display_order', 'is_active'];

    protected function casts(): array
    {
        return ['display_order' => 'integer', 'is_active' => 'boolean'];
    }

    public function imageUrl(): string
    {
        if (! $this->image) {
            return asset('images/dubai-adventure.png');
        }

        return str_starts_with($this->image, 'images/') ? asset($this->image) : asset('storage/'.$this->image);
    }

    /** @return array<string, string> */
    public function toPromoArray(): array
    {
        return [
            'eyebrow' => $this->eyebrow,
            'title' => $this->title,
            'description' => $this->description,
            'image' => $this->imageUrl(),
            'button_label' => $this->button_label,
            'url' => $this->button_url,
        ];
    }
}
