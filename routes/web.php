<?php

use App\Http\Controllers\Admin\AttractionController;
use App\Http\Controllers\Admin\CityTourController;
use App\Http\Controllers\Admin\CruiseBoatTourController;
use App\Http\Controllers\Admin\DesertAdventureController;
use App\Http\Controllers\Admin\HeroSlideController;
use App\Http\Controllers\Admin\HomePromoCardController;
use App\Http\Controllers\Admin\HomeSignatureJourneyController;
use App\Http\Controllers\Admin\HomeTestimonialController;
use App\Http\Controllers\Admin\SportsEventController;
use App\Http\Controllers\Admin\TourCategoryController;
use App\Http\Controllers\Admin\TourController;
use App\Http\Controllers\Admin\TourFeatureController;
use App\Http\Controllers\Admin\TourSubcategoryController;
use App\Http\Controllers\Admin\TransferController;
use App\Http\Controllers\Admin\WaterparkThemeParkController;
use App\Http\Controllers\Admin\WhyUsFeatureController;
use App\Http\Controllers\ProfileController;
use App\Models\Attraction;
use App\Models\CityTour;
use App\Models\CruiseBoatTour;
use App\Models\DesertAdventure;
use App\Models\HeroSlide;
use App\Models\HomePromoCard;
use App\Models\HomeSignatureJourney;
use App\Models\HomeTestimonial;
use App\Models\SportsEvent;
use App\Models\Tour;
use App\Models\Transfer;
use App\Models\WaterparkThemePark;
use App\Models\WhyUsFeature;
use Illuminate\Support\Facades\Route;

/** @return array<string, string> */
$tourListing = static function (Tour $tour): array {
    return [
        'image' => $tour->thumbnail ? (str_starts_with($tour->thumbnail, 'images/') ? $tour->thumbnail : 'storage/'.$tour->thumbnail) : ($tour->main_image ? (str_starts_with($tour->main_image, 'images/') ? $tour->main_image : 'storage/'.$tour->main_image) : 'images/desert-safari.png'),
        'title' => $tour->name,
        'tag' => $tour->subcategory?->name ?? $tour->category?->name ?? 'Tour',
        'description' => $tour->short_description ?: 'Explore Dubai with Waheed Murad Tourism.',
        'location' => $tour->location,
        'price' => $tour->currency.' '.number_format((float) $tour->starting_price),
        'url' => route('tours.show', $tour),
    ];
};

Route::get('/', function () {
    $heroSlides = HeroSlide::query()->where('is_active', true)->orderBy('display_order')->get()
        ->map(fn (HeroSlide $slide) => $slide->toHeroArray())->all();
    $cityTourPromos = HomePromoCard::query()->where('is_active', true)->orderBy('display_order')->get()
        ->map(fn (HomePromoCard $card) => $card->toPromoArray())->all();
    $signatureJourneys = HomeSignatureJourney::query()->where('is_active', true)->orderBy('display_order')->get();
    $testimonials = HomeTestimonial::query()->where('is_active', true)->orderBy('display_order')->get();

    return view('welcome', compact('heroSlides', 'cityTourPromos', 'signatureJourneys', 'testimonials'));
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::view('/admin', 'admin.dashboard.index')
    ->middleware(['auth', 'verified'])
    ->name('admin.dashboard');

Route::get('/tours/{tour:slug}', function (Tour $tour) {
    abort_unless($tour->isPublic(), 404);
    $tour->load(['category', 'subcategory', 'images', 'features', 'itineraries', 'packages.prices', 'prices.package', 'availabilities']);
    $relatedTours = Tour::query()->with(['category', 'subcategory'])
        ->where('status', 'active')
        ->whereKeyNot($tour->id)
        ->where(function ($query) use ($tour): void {
            $query->where('tour_subcategory_id', $tour->tour_subcategory_id)
                ->orWhere('tour_category_id', $tour->tour_category_id);
        })
        ->orderBy('display_order')->limit(4)->get();

    return view('pages.tour-detail', compact('tour', 'relatedTours'));
})->name('tours.show');

Route::get('/desert-adventures', function () {
    $managedAdventures = DesertAdventure::query()
        ->where('is_active', true)
        ->latest()
        ->get()
        ->map(fn (DesertAdventure $adventure) => $adventure->toCatalogueArray())
        ->all();

    $tourManagerAdventures = Tour::query()->with(['category', 'subcategory', 'images'])
        ->where('status', 'active')->whereHas('category', fn ($query) => $query->where('slug', 'desert-adventures'))
        ->orderBy('display_order')->get()->map(fn (Tour $tour) => $tour->toCatalogueArray())->all();

    return view('pages.desert-adventures', ['adventures' => array_merge($tourManagerAdventures, $managedAdventures ?: config('desert-adventures.adventures', []))]);
})->name('desert-adventures');
Route::get('/attractions', function () use ($tourListing) {
    $attractions = Attraction::query()->where('is_active', true)->latest()->get()
        ->map(fn (Attraction $attraction) => $attraction->toPublicArray())->all();

    $managed = Tour::query()->with(['category', 'subcategory'])->where('status', 'active')->whereHas('category', fn ($query) => $query->where('slug', 'attractions'))->orderBy('display_order')->get()->map($tourListing)->all();
    $attractions = array_merge($managed, $attractions);

    return view('pages.attractions', compact('attractions'));
})->name('attractions');
Route::get('/city-tours', function () use ($tourListing) {
    $tours = CityTour::query()->where('is_active', true)->latest()->get()
        ->map(fn (CityTour $tour) => $tour->toPublicArray())->all();

    $managed = Tour::query()->with(['category', 'subcategory'])->where('status', 'active')->whereHas('category', fn ($query) => $query->where('slug', 'city-tours'))->orderBy('display_order')->get()->map($tourListing)->all();
    $tours = array_merge($managed, $tours);

    return view('pages.city-tours', compact('tours'));
})->name('city-tours');

Route::get('/sports-events', function () use ($tourListing) {
    $events = SportsEvent::query()
        ->where('is_active', true)
        ->latest()
        ->get()
        ->map(fn (SportsEvent $event) => $event->toPublicArray())
        ->all();

    $managed = Tour::query()->with(['category', 'subcategory'])->where('status', 'active')->whereHas('category', fn ($query) => $query->where('slug', 'sports-events'))->orderBy('display_order')->get()->map($tourListing)->all();
    $events = array_merge($managed, $events);

    return view('pages.sports-events', compact('events'));
})->name('sports-events');
Route::get('/cruise-boat-tours', function () use ($tourListing) {
    $cruises = CruiseBoatTour::query()
        ->where('is_active', true)
        ->latest()
        ->get()
        ->map(fn (CruiseBoatTour $tour) => $tour->toPublicArray())
        ->all();

    $managed = Tour::query()->with(['category', 'subcategory'])->where('status', 'active')->whereHas('category', fn ($query) => $query->where('slug', 'cruise-and-boat-tours'))->orderBy('display_order')->get()->map($tourListing)->all();
    $cruises = array_merge($managed, $cruises);

    return view('pages.cruise-boat-tours', compact('cruises'));
})->name('cruise-boat-tours');
Route::get('/waterparks-theme-parks', function () use ($tourListing) {
    $parks = WaterparkThemePark::query()->where('is_active', true)->latest()->get()
        ->map(fn (WaterparkThemePark $park) => $park->toPublicArray())->all();

    $managed = Tour::query()->with(['category', 'subcategory'])->where('status', 'active')->whereHas('category', fn ($query) => $query->where('slug', 'waterparks-theme-parks'))->orderBy('display_order')->get()->map($tourListing)->all();
    $parks = array_merge($managed, $parks);

    return view('pages.waterparks-theme-parks', compact('parks'));
})->name('waterparks-theme-parks');
Route::get('/transfers', function () use ($tourListing) {
    $transfers = Transfer::query()->where('is_active', true)->latest()->get()
        ->map(fn (Transfer $transfer) => $transfer->toPublicArray())->all();

    $managed = Tour::query()->with(['category', 'subcategory'])->where('status', 'active')->whereHas('category', fn ($query) => $query->where('slug', 'transfers'))->orderBy('display_order')->get()->map($tourListing)->all();
    $transfers = array_merge($managed, $transfers);

    return view('pages.transfers', compact('transfers'));
})->name('transfers');
Route::get('/why-us', function () {
    $features = WhyUsFeature::query()->where('is_active', true)->orderBy('display_order')->get();

    return view('pages.why-us', compact('features'));
})->name('why-us');

Route::view('/dune-buggies', 'pages.dune-buggies')->name('dune-buggies');

Route::get('/desert-adventures/desert-safaris', function () {
    $adventures = DesertAdventure::query()
        ->where('is_active', true)
        ->where('category', 'Desert Safaris')
        ->latest()
        ->get()
        ->map(fn (DesertAdventure $adventure) => $adventure->toCatalogueArray())
        ->all();

    $tourManagerAdventures = Tour::query()->with(['category', 'subcategory', 'images'])
        ->where('status', 'active')->whereHas('subcategory', fn ($query) => $query->where('slug', 'desert-safaris'))
        ->orderBy('display_order')->get()->map(fn (Tour $tour) => $tour->toCatalogueArray())->all();

    return view('pages.desert-safaris', ['adventures' => array_merge($tourManagerAdventures, $adventures ?: config('desert-safaris.adventures', []))]);
})->name('desert-safaris');
Route::view('/desert-adventures/desert-safaris/morning-desert-adventure', 'pages.morning-desert-adventure')->name('morning-desert-adventure');
Route::get('/desert-adventures/desert-safaris/evening-desert-safari', function () {
    $template = config('adventure-products.evening-desert-safari');
    $adventure = DesertAdventure::query()
        ->where('is_active', true)
        ->where('title', 'Evening Desert Safari in Dubai')
        ->first();

    return view('pages.evening-desert-safari', [
        'product' => $adventure
            ? $adventure->toProductDetailArray($template)
            : $template,
    ]);
})->name('evening-desert-safari');
Route::view('/desert-adventures/desert-safaris/overnight-wildlife-adventure', 'pages.adventure-product-detail', ['productKey' => 'overnight-wildlife-adventure'])->name('overnight-wildlife-adventure');
Route::get('/desert-adventures/dune-buggies', function () {
    $adventures = DesertAdventure::query()
        ->where('is_active', true)
        ->where('category', 'Dune Buggies')
        ->latest()
        ->get()
        ->map(fn (DesertAdventure $adventure) => $adventure->toCatalogueArray())
        ->all();

    $tourManagerAdventures = Tour::query()->with(['category', 'subcategory', 'images'])
        ->where('status', 'active')->whereHas('subcategory', fn ($query) => $query->where('slug', 'dune-buggies'))
        ->orderBy('display_order')->get()->map(fn (Tour $tour) => $tour->toCatalogueArray())->all();

    return view('pages.dune-buggies', ['adventures' => array_merge($tourManagerAdventures, $adventures ?: config('dune-buggies.adventures', []))]);
})->name('dune-buggies-category');
Route::view('/desert-adventures/dune-buggies/dune-buggy-adventure', 'pages.dune-buggy-adventure')->name('dune-buggy-adventure');
Route::view('/desert-adventures/dune-buggies/dune-buggy-evening-safari-combo', 'pages.adventure-product-detail', ['productKey' => 'dune-buggy-evening-safari-combo'])->name('dune-buggy-evening-safari-combo');
Route::view('/desert-adventures/dune-buggies/dune-buggy-exclusive-experience-combo', 'pages.adventure-product-detail', ['productKey' => 'dune-buggy-exclusive-experience-combo'])->name('dune-buggy-exclusive-experience-combo');
Route::get('/desert-adventures/desert-experiences', function () {
    $adventures = DesertAdventure::query()
        ->where('is_active', true)
        ->where('category', 'Desert Experiences')
        ->latest()
        ->get()
        ->map(fn (DesertAdventure $adventure) => $adventure->toCatalogueArray())
        ->all();

    $tourManagerAdventures = Tour::query()->with(['category', 'subcategory', 'images'])
        ->where('status', 'active')->whereHas('subcategory', fn ($query) => $query->where('slug', 'desert-experiences'))
        ->orderBy('display_order')->get()->map(fn (Tour $tour) => $tour->toCatalogueArray())->all();

    return view('pages.desert-experiences', ['adventures' => array_merge($tourManagerAdventures, $adventures ?: config('desert-experiences.adventures', []))]);
})->name('desert-experiences');
Route::view('/desert-adventures/desert-experiences/exclusive-desert-experience', 'pages.exclusive-desert-experience')->name('exclusive-desert-experience');
Route::view('/desert-adventures/desert-experiences/camel-ride', 'pages.camel-ride')->name('camel-ride');
Route::view('/desert-adventures/desert-experiences/adventure-pass', 'pages.adventure-product-detail', ['productKey' => 'adventure-pass'])->name('adventure-pass');
Route::view('/desert-adventures/desert-experiences/fort-lisaili-desert-experience', 'pages.adventure-product-detail', ['productKey' => 'fort-lisaili-desert-experience'])->name('fort-lisaili-desert-experience');
Route::view('/desert-adventures/desert-experiences/vantage-desert-experience', 'pages.adventure-product-detail', ['productKey' => 'vantage-desert-experience'])->name('vantage-desert-experience');
Route::view('/desert-adventures/desert-experiences/wadi-adventures', 'pages.adventure-product-detail', ['productKey' => 'wadi-adventures'])->name('wadi-adventures');
Route::view('/desert-adventures/desert-experiences/three-day-camping-adventure', 'pages.adventure-product-detail', ['productKey' => 'three-day-camping-adventure'])->name('three-day-camping-adventure');
Route::view('/desert-adventures/desert-experiences/morning-at-the-fort-lisaili', 'pages.adventure-product-detail', ['productKey' => 'morning-at-the-fort-lisaili'])->name('morning-at-the-fort-lisaili');
Route::get('/desert-adventures/school-trips', function () {
    $adventures = DesertAdventure::query()
        ->where('is_active', true)
        ->where('category', 'School Trips')
        ->latest()
        ->get()
        ->map(fn (DesertAdventure $adventure) => $adventure->toCatalogueArray())
        ->all();

    $tourManagerAdventures = Tour::query()->with(['category', 'subcategory', 'images'])
        ->where('status', 'active')->whereHas('subcategory', fn ($query) => $query->where('slug', 'school-trips'))
        ->orderBy('display_order')->get()->map(fn (Tour $tour) => $tour->toCatalogueArray())->all();

    return view('pages.school-trips', ['adventures' => array_merge($tourManagerAdventures, $adventures ?: config('school-trips.adventures', []))]);
})->name('school-trips');
Route::view('/desert-adventures/school-trips/morning-wildlife-safari', 'pages.adventure-product-detail', ['productKey' => 'morning-wildlife-safari'])->name('morning-wildlife-safari');
Route::view('/blogs', 'pages.blogs')->name('blogs');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('tours/subcategories/options', [TourController::class, 'subcategories'])->name('tours.subcategories');
    Route::resource('tours', TourController::class);
    Route::resource('tour-categories', TourCategoryController::class)->except('show');
    Route::resource('tour-subcategories', TourSubcategoryController::class)->except('show');
    Route::resource('tour-features', TourFeatureController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('desert-adventures', DesertAdventureController::class)->except('show');
    Route::resource('sports-events', SportsEventController::class)->except('show');
    Route::resource('cruise-boat-tours', CruiseBoatTourController::class)->except('show');
    Route::resource('attractions', AttractionController::class)->except('show');
    Route::resource('city-tours', CityTourController::class)->except('show');
    Route::resource('waterparks-theme-parks', WaterparkThemeParkController::class)->except('show');
    Route::resource('transfers', TransferController::class)->except('show');
    Route::resource('why-us', WhyUsFeatureController::class)->except('show');
    Route::resource('home/hero', HeroSlideController::class)->names('home.hero')->except('show');
    Route::resource('home/promo-cards', HomePromoCardController::class)->names('home.promo-cards')->except('show');
    Route::resource('home/signature-journeys', HomeSignatureJourneyController::class)->names('home.signature-journeys')->except('show');
    Route::resource('home/testimonials', HomeTestimonialController::class)->names('home.testimonials')->except('show');
});

require __DIR__.'/auth.php';
