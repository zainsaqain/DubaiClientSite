<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSignatureJourney extends Model
{
    use HasFactory;

    protected $fillable = ['badge', 'caption', 'eyebrow', 'title', 'highlight', 'description', 'point_one', 'point_two', 'point_three', 'button_label', 'button_url', 'image', 'display_order', 'is_active'];

    protected function casts(): array
    {
        return ['display_order' => 'integer', 'is_active' => 'boolean'];
    }

    public function imageUrl(): string
    {
        if (! $this->image) {
            return asset('images/camel-desert-journey.png');
        }

        return str_starts_with($this->image, 'images/') ? asset($this->image) : asset('storage/'.$this->image);
    }
}
