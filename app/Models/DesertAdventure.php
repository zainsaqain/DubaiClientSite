<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesertAdventure extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'description',
        'location',
        'price',
        'duration',
        'image',
        'is_featured',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function imageUrl(): string
    {
        if (! $this->image) {
            return asset('images/desert-safari.png');
        }

        return str_starts_with($this->image, 'images/')
            ? asset($this->image)
            : asset('storage/'.$this->image);
    }

    /** @return array<string, mixed> */
    public function toCatalogueArray(): array
    {
        $catalogueItem = collect(config('desert-adventures.adventures', []))
            ->firstWhere('title', $this->title) ?? [];
        $category = match ($this->category) {
            'Desert Safaris' => 'safari',
            'Desert Experiences' => 'experience',
            'Dune Buggies' => 'buggy',
            default => 'school',
        };

        $image = ! $this->image
            ? 'images/desert-safari.png'
            : (str_starts_with($this->image, 'images/') ? $this->image : 'storage/'.$this->image);

        $result = array_merge($catalogueItem, [
            'title' => $this->title,
            'description' => $this->description,
            'price' => (float) $this->price,
            'pkr_price' => number_format((float) $this->price * 103),
            'category' => $category,
            'category_name' => $this->category,
            'time' => $catalogueItem['time'] ?? 'flexible',
            'location' => $catalogueItem['location'] ?? str($this->location)->lower()->replace(' ', '-')->toString(),
            'vehicle' => $catalogueItem['vehicle'] ?? '4x4',
            'is_bestseller' => $this->is_featured,
            'is_choice' => $catalogueItem['is_choice'] ?? false,
            'location_tag' => $this->location,
            'image' => $image,
            'gallery' => ($catalogueItem['image'] ?? null) === $this->image
                ? ($catalogueItem['gallery'] ?? [$image])
                : [$image],
        ]);

        if (! isset($result['route']) && ! isset($result['url'])) {
            $result['url'] = route('desert-adventures').'#all-desert-adventures';
        }

        if ($this->category === 'School Trips') {
            unset($result['route']);
            $result['url'] = route('desert-adventures').'#all-desert-adventures';
        }

        return $result;
    }

    /**
     * Apply the fields managed from the admin form to a rich public detail-page
     * template. The template still supplies the presentation-only content such
     * as the itinerary, while the business-facing information comes from the
     * database.
     *
     * @param  array<string, mixed>  $template
     * @return array<string, mixed>
     */
    public function toProductDetailArray(array $template): array
    {
        $image = ! $this->image
            ? ($template['gallery'][0] ?? 'images/desert-safari.png')
            : (str_starts_with($this->image, 'images/') ? $this->image : 'storage/'.$this->image);

        $categoryRoute = match ($this->category) {
            'Desert Safaris' => 'desert-safaris',
            'Desert Experiences' => 'desert-experiences',
            'Dune Buggies' => 'dune-buggies-category',
            'School Trips' => 'school-trips',
            default => $template['category_route'] ?? 'desert-safaris',
        };

        $gallery = $template['gallery'] ?? [];
        $gallery[0] = $image;

        $basePrice = (float) $this->price;
        $currency = $template['booking']['currency'] ?? 'AED';

        return array_replace($template, [
            'title' => $this->title,
            'category' => $this->category,
            'category_route' => $categoryRoute,
            'location' => $this->location,
            'gallery' => $gallery,
            'gallery_alt' => [$this->title, ...array_slice($template['gallery_alt'] ?? [], 1)],
            'about' => $this->description,
            'description' => $this->description,
            'duration' => $this->duration ?: ($template['duration'] ?? 'Flexible'),
            'pickup' => "Hotel or residence pick-up available from {$this->location}.",
            'booking' => [
                ...($template['booking'] ?? []),
                'currency' => $currency,
                'base_price' => $basePrice,
                'services' => [[
                    'label' => $this->title,
                    'price' => $basePrice,
                ]],
            ],
        ]);
    }
}
