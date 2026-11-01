<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhyUsFeature extends Model
{
    use HasFactory;

    protected $fillable = ['eyebrow', 'title', 'description', 'image', 'link_label', 'link_url', 'display_order', 'is_reversed', 'is_active'];

    protected function casts(): array
    {
        return ['display_order' => 'integer', 'is_reversed' => 'boolean', 'is_active' => 'boolean'];
    }

    public function imageUrl(): string
    {
        if (! $this->image) {
            return asset('images/desert-safari.png');
        }

        return str_starts_with($this->image, 'images/') ? asset($this->image) : asset('storage/'.$this->image);
    }

    public function publicImagePath(): string
    {
        return ! $this->image ? 'images/desert-safari.png' : (str_starts_with($this->image, 'images/') ? $this->image : 'storage/'.$this->image);
    }
}
