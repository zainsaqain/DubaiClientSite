<?php

namespace App\Http\Controllers;

use App\Models\Attraction;
use App\Models\CityTour;
use App\Models\CruiseBoatTour;
use App\Models\SportsEvent;
use App\Models\Tour;
use App\Models\Transfer;
use App\Models\WaterparkThemePark;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LegacyTourController extends Controller
{
    /**
     * @var array<string, array{model: class-string<Model>, label: string, catalogue_route: string}>
     */
    private const LEGACY_TOUR_TYPES = [
        'attraction' => ['model' => Attraction::class, 'label' => 'Attractions', 'catalogue_route' => 'attractions'],
        'city-tour' => ['model' => CityTour::class, 'label' => 'City Tours', 'catalogue_route' => 'city-tours'],
        'cruise-boat-tour' => ['model' => CruiseBoatTour::class, 'label' => 'Cruise & Boat Tours', 'catalogue_route' => 'cruise-boat-tours'],
        'sports-event' => ['model' => SportsEvent::class, 'label' => 'Sports Events', 'catalogue_route' => 'sports-events'],
        'transfer' => ['model' => Transfer::class, 'label' => 'Transfers', 'catalogue_route' => 'transfers'],
        'waterpark-theme-park' => ['model' => WaterparkThemePark::class, 'label' => 'Waterparks & Theme Parks', 'catalogue_route' => 'waterparks-theme-parks'],
    ];

    public function show(string $type, int $legacyTour): View|RedirectResponse
    {
        $tourType = self::LEGACY_TOUR_TYPES[$type] ?? abort(404);
        $modelClass = $tourType['model'];
        $tour = $modelClass::query()->where('is_active', true)->findOrFail($legacyTour);
        $managedTour = Tour::query()->public()->where('name', $tour->getAttribute('title'))->first();

        if ($managedTour) {
            return redirect()->route('tours.show', $managedTour);
        }

        return view('pages.legacy-tour-detail', [
            'legacyTour' => $tour,
            'catalogueLabel' => $tourType['label'],
            'catalogueUrl' => route($tourType['catalogue_route']),
        ]);
    }
}
