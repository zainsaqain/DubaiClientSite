<?php

namespace Database\Seeders;

use App\Models\Tour;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RepairTourImagePathsSeeder extends Seeder
{
    public function run(): void
    {
        $repairedTours = 0;
        $repairedGalleryImages = 0;

        Tour::query()
            ->with(['category', 'images'])
            ->orderBy('id')
            ->each(function (Tour $tour) use (&$repairedTours, &$repairedGalleryImages): void {
                $fallbackPath = $this->fallbackPathFor($tour);
                $attributes = [];

                foreach (['thumbnail', 'main_image'] as $column) {
                    $repairedPath = $this->repairedPath($tour->{$column}, $fallbackPath);

                    if ($repairedPath !== null && $repairedPath !== $tour->{$column}) {
                        $attributes[$column] = $repairedPath;
                    }
                }

                if ($attributes !== []) {
                    $tour->update($attributes);
                    $repairedTours++;
                }

                foreach ($tour->images as $image) {
                    $repairedPath = $this->repairedPath($image->path, $fallbackPath);

                    if ($repairedPath !== null && $repairedPath !== $image->path) {
                        $image->update(['path' => $repairedPath]);
                        $repairedGalleryImages++;
                    }
                }
            });

        $this->command?->info("Repaired {$repairedTours} tour image records and {$repairedGalleryImages} gallery image records.");
    }

    private function repairedPath(?string $path, string $fallbackPath): ?string
    {
        if (blank($path)) {
            return $fallbackPath;
        }

        $path = ltrim(trim($path), '/');

        if (Str::startsWith($path, 'storage/')) {
            $storagePath = Str::after($path, 'storage/');

            return Storage::disk('public')->exists($storagePath) ? $storagePath : $fallbackPath;
        }

        if (Str::startsWith($path, 'images/')) {
            return File::exists(public_path($path)) ? null : $fallbackPath;
        }

        return Storage::disk('public')->exists($path) || File::exists(public_path($path))
            ? null
            : $fallbackPath;
    }

    private function fallbackPathFor(Tour $tour): string
    {
        return match ($tour->slug) {
            'morning-desert-adventure' => 'images/safaris/morning-desert-adventure.jpg',
            'evening-desert-safari-in-dubai' => 'images/safaris/evening-desert-safari.jpg',
            'the-fort-lisaili-desert-experience' => 'images/safaris/lisaili-desert-experience.jpg',
            'desert-dune-buggies-evening-safari-combo',
            'desert-dune-buggies-exclusive-desert-experience-combo',
            'dune-buggy-adventure' => 'images/safaris/dune-buggy-adventure.jpg',
            'camel-ride-in-dubai' => 'images/safaris/camel-ride-safari.jpg',
            default => match ($tour->category?->slug) {
                'desert-adventures' => 'images/desert-safari.png',
                'attractions' => 'images/dubai-attractions.jpg',
                'sports-events' => 'images/sports-events-dubai.png',
                'cruise-and-boat-tours' => 'images/cruise-dubai-marina.png',
                'waterparks-and-theme-parks' => 'images/water-theme-parks-dubai.png',
                'transfers' => 'images/airport-transfer.png',
                default => 'images/desert-safari.png',
            },
        };
    }
}
