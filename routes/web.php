<?php

use App\Http\Controllers\Admin\AttractionController;
use App\Http\Controllers\Admin\BankTransferPaymentController as AdminBankTransferPaymentController;
use App\Http\Controllers\Admin\BankTransferSettingController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\CityTourController;
use App\Http\Controllers\Admin\CruiseBoatTourController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DesertAdventureController;
use App\Http\Controllers\Admin\HeroSlideController;
use App\Http\Controllers\Admin\HomePromoCardController;
use App\Http\Controllers\Admin\HomeSignatureJourneyController;
use App\Http\Controllers\Admin\HomeTestimonialController;
use App\Http\Controllers\Admin\SportsEventController;
use App\Http\Controllers\Admin\TourCategoryContentBlockController;
use App\Http\Controllers\Admin\TourCategoryController;
use App\Http\Controllers\Admin\TourCategoryFaqController;
use App\Http\Controllers\Admin\TourController;
use App\Http\Controllers\Admin\TourFeatureController;
use App\Http\Controllers\Admin\TourSubcategoryController;
use App\Http\Controllers\Admin\TransferController;
use App\Http\Controllers\Admin\WaterparkThemeParkController;
use App\Http\Controllers\Admin\WhyUsFeatureController;
use App\Http\Controllers\BankTransferPaymentController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerAccountController;
use App\Http\Controllers\LegacyTourController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicCatalogueController;
use App\Models\DesertAdventure;
use App\Models\Tour;
use App\Models\TourCategory;
use App\Models\TourSubcategory;
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

/** @return array<string, mixed> */
$managedCatalogueItem = static function (Tour $tour): array {
    $item = $tour->toCatalogueArray();

    return [...$item,
        'category' => $tour->subcategory?->slug ?? $tour->category?->slug ?? 'experiences',
        'category_name' => $tour->subcategory?->name ?? $tour->category?->name ?? 'Experiences',
        'location_label' => $tour->location,
        'language' => str($tour->languages[0] ?? 'English')->lower()->toString(),
    ];
};

Route::get('/', [PublicCatalogueController::class, 'home'])->name('home');

Route::get('/dashboard', function () {
    if (request()->user()?->is_admin) {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('account.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/admin', [AdminDashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('admin.dashboard');

Route::get('/search', [PublicCatalogueController::class, 'search'])->name('tours.search');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/{tour:slug}', [CartController::class, 'store'])->middleware('throttle:20,1')->name('cart.store');
Route::delete('/cart/{lineId}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::get('/experiences/{category:slug}', [PublicCatalogueController::class, 'category'])->name('tour-categories.show');
Route::get('/experiences/{category:slug}/{subcategory:slug}', [PublicCatalogueController::class, 'subcategory'])->name('tour-subcategories.show');

Route::get('/tours/{tour:slug}', function (Tour $tour) {
    abort_unless($tour->isPublic(), 404);
    $tour->load(['category', 'subcategory', 'images', 'features', 'itineraries', 'packages.prices', 'prices.package', 'availabilities']);
    $relatedTours = Tour::query()->public()->with(['category', 'subcategory', 'images', 'prices'])
        ->whereKeyNot($tour->id)
        ->where(function ($query) use ($tour): void {
            $query->where('tour_subcategory_id', $tour->tour_subcategory_id)
                ->orWhere('tour_category_id', $tour->tour_category_id);
        })
        ->orderBy('display_order')->limit(4)->get();

    $recentTours = Tour::query()->public()->with(['category', 'subcategory', 'images', 'prices'])
        ->whereKeyNot($tour->id)
        ->orderByDesc('updated_at')
        ->limit(24)
        ->get();

    return view('pages.tour-detail', compact('tour', 'relatedTours', 'recentTours'));
})->name('tours.show');
Route::get('/legacy-tours/{type}/{legacyTour}', [LegacyTourController::class, 'show'])->name('legacy-tours.show');

Route::middleware('auth')->group(function () {
    Route::get('/tours/{tour:slug}/checkout', [CheckoutController::class, 'create'])->name('checkout.create');
    Route::post('/tours/{tour:slug}/checkout', [CheckoutController::class, 'store'])->middleware('throttle:10,1')->name('checkout.store');
    Route::get('/orders/{booking}/bank-transfer', [BankTransferPaymentController::class, 'show'])->name('bank-transfer.show');
    Route::post('/orders/{booking}/bank-transfer', [BankTransferPaymentController::class, 'submit'])->middleware('throttle:10,1')->name('bank-transfer.submit');
    Route::get('/orders/{booking}/bank-transfer/screenshot', [BankTransferPaymentController::class, 'screenshot'])->name('bank-transfer.screenshot');
});

Route::get('/desert-adventures', [PublicCatalogueController::class, 'desertAdventures'])->name('desert-adventures');
Route::get('/attractions', function () use ($tourListing) {
    $attractions = Tour::query()
        ->public()
        ->with(['category', 'subcategory'])
        ->whereHas('category', fn ($query) => $query->where('slug', 'attractions'))
        ->orderBy('display_order')
        ->get()
        ->map($tourListing)
        ->all();

    return view('pages.attractions', compact('attractions'));
})->name('attractions');
Route::get('/city-tours', function () use ($tourListing) {
    $category = TourCategory::query()
        ->where('slug', 'city-tours')
        ->where('is_active', true)
        ->with([
            'contentBlocks' => static function ($query): void {
                $query->where('is_active', true)->orderBy('display_order');
            },
            'faqs' => static function ($query): void {
                $query->where('is_active', true)->orderBy('display_order');
            },
            'subcategories' => static function ($query): void {
                $query->where('is_active', true)->orderBy('display_order');
            },
        ])
        ->first();

    $tours = Tour::query()
        ->public()
        ->with(['category', 'subcategory'])
        ->whereHas('category', fn ($query) => $query->where('slug', 'city-tours'))
        ->orderBy('display_order')
        ->get()
        ->map($tourListing)
        ->all();

    return view('pages.city-tours', compact('category', 'tours'));
})->name('city-tours');
Route::get('/culture', function () use ($tourListing) {
    $category = TourCategory::query()
        ->where('slug', 'city-tours')
        ->where('is_active', true)
        ->with([
            'contentBlocks' => static function ($query): void {
                $query->where('is_active', true)->orderBy('display_order');
            },
            'faqs' => static function ($query): void {
                $query->where('is_active', true)->orderBy('display_order');
            },
            'subcategories' => static function ($query): void {
                $query->where('is_active', true)->orderBy('display_order');
            },
        ])
        ->first();

    $tours = Tour::query()
        ->public()
        ->with(['category', 'subcategory'])
        ->whereHas('category', fn ($query) => $query->where('slug', 'city-tours'))
        ->orderBy('display_order')
        ->get()
        ->map($tourListing)
        ->all();

    return view('pages.city-tours', [
        'category' => $category,
        'tours' => $tours,
        'listingTitle' => 'Culture',
        'listingBreadcrumb' => 'Culture',
        'listingCategoryParent' => 'Why us',
        'listingCategoryName' => 'Culture',
        'listingCategoryValue' => 'city-tours',
        'hideReferenceContent' => true,
    ]);
})->name('culture');
Route::get('/nature', function () use ($tourListing) {
    $natureTourSlugs = [
        ['evening-desert-safari-in-dubai'],
        ['exclusive-desert-experience'],
        ['camel-ride'],
        ['private-al-ain-city-tour'],
        ['the-fort-lisaili-desert-experience', 'a-morning-at-the-fort-lisaili'],
    ];
    $availableTours = Tour::query()
        ->public()
        ->with(['category', 'subcategory'])
        ->whereIn('slug', collect($natureTourSlugs)->flatten())
        ->get()
        ->keyBy('slug');
    $tours = collect($natureTourSlugs)
        ->map(fn (array $slugs): ?Tour => collect($slugs)->map(fn (string $slug): ?Tour => $availableTours->get($slug))->first())
        ->filter()
        ->map($tourListing)
        ->values()
        ->all();

    return view('pages.city-tours', [
        'category' => null,
        'tours' => $tours,
        'listingTitle' => 'Nature',
        'listingBreadcrumb' => 'Nature',
        'listingCategoryParent' => 'Why us',
        'listingCategoryName' => 'Nature',
        'listingCategoryValue' => 'nature',
        'hideReferenceContent' => true,
    ]);
})->name('nature');
Route::get('/innovation', function () use ($tourListing) {
    $innovationTourNames = [
        'At the Top Burj Khalifa - Lounge Access',
        'Ce La Vi - Lunch set menu with Burj Khalifa views',
        'Kaleidoscope Dinner Buffet',
        'Etihad Tower Observation Deck',
        'At the Top Burj Khalifa - Sky Level 148 + 125 + 124',
        'Lotus Megayacht- shared dinner cruise',
        'Aura - Friday Night Brunch in the Lounge',
        'Museum of the Future',
        'Palm Monorail - Gateway to Atlantis Station - Round Trip',
        'Yas Marina Circuit - Karting',
        'Dubai Frame Entrance Ticket',
        'Aura - Lunch in the Sky',
    ];
    $availableTours = Tour::query()
        ->public()
        ->with(['category', 'subcategory'])
        ->whereIn('name', $innovationTourNames)
        ->get()
        ->keyBy('name');
    $tours = collect($innovationTourNames)
        ->map(fn (string $name): ?Tour => $availableTours->get($name))
        ->filter()
        ->map($tourListing)
        ->values()
        ->all();

    return view('pages.city-tours', [
        'category' => null,
        'tours' => $tours,
        'listingTitle' => 'Innovation',
        'listingBreadcrumb' => 'Innovation',
        'listingCategoryParent' => 'Why us',
        'listingCategoryName' => 'Innovation',
        'listingCategoryValue' => 'innovation',
        'hideReferenceContent' => true,
    ]);
})->name('innovation');
Route::get('/city-tours/{subcategory:slug}', [PublicCatalogueController::class, 'cityTourDestination'])
    ->name('city-tours.destination');

Route::get('/sports-events', function () use ($tourListing) {
    $events = Tour::query()
        ->public()
        ->with(['category', 'subcategory'])
        ->whereHas('category', fn ($query) => $query->where('slug', 'sports-events'))
        ->orderBy('display_order')
        ->get()
        ->map($tourListing)
        ->all();

    return view('pages.sports-events', compact('events'));
})->name('sports-events');
Route::get('/cruise-boat-tours', function () use ($managedCatalogueItem) {
    $items = Tour::query()->public()->with(['category', 'subcategory', 'images', 'prices'])
        ->whereHas('category', fn ($query) => $query->where('slug', 'cruise-and-boat-tours'))
        ->orderBy('display_order')->get()->map($managedCatalogueItem);

    return view('pages.cruise-boat-tours', compact('items'));
})->name('cruise-boat-tours');
Route::get('/waterparks-theme-parks', function () use ($managedCatalogueItem) {
    $items = Tour::query()->public()->with(['category', 'subcategory', 'images', 'prices'])
        ->whereHas('category', fn ($query) => $query->where('slug', 'waterparks-theme-parks'))
        ->orderBy('display_order')->get()->map($managedCatalogueItem);

    return view('pages.waterparks-theme-parks', compact('items'));
})->name('waterparks-theme-parks');
Route::get('/transfers', function () use ($managedCatalogueItem) {
    $items = Tour::query()->public()->with(['category', 'subcategory', 'images', 'prices'])
        ->whereHas('category', fn ($query) => $query->where('slug', 'transfers'))
        ->orderBy('display_order')->get()->map($managedCatalogueItem);

    return view('pages.transfers', compact('items'));
})->name('transfers');
Route::get('/why-us', function () {
    $features = WhyUsFeature::query()->where('is_active', true)->orderBy('display_order')->get();

    return view('pages.why-us', compact('features'));
})->name('why-us');
Route::view('/sustainable-tourism', 'pages.sustainable-tourism')->name('sustainable-tourism');
Route::view('/about-us', 'pages.about-us')->name('about-us');
Route::view('/where-to-find-us', 'pages.where-to-find-us')->name('where-to-find-us');
Route::view('/travel-agent-partners', 'pages.travel-agent-partners')->name('travel-agent-partners');
Route::view('/meetings-incentives-events', 'pages.meetings-incentives-events')->name('meetings-incentives-events');
Route::view('/signature-events', 'pages.signature-events')->name('signature-events');
Route::view('/guidelines', 'pages.guidelines')->name('guidelines');
Route::view('/cancellation-refund-policy', 'pages.cancellation-refund-policy')->name('cancellation-refund-policy');
Route::view('/terms-and-conditions', 'pages.terms-and-conditions')->name('terms-and-conditions');

Route::view('/dune-buggies', 'pages.dune-buggies')->name('dune-buggies');

Route::get('/desert-adventures/desert-safaris', function () {
    $category = TourCategory::query()
        ->where('slug', 'desert-adventures')
        ->where('is_active', true)
        ->firstOrFail();

    $subcategory = TourSubcategory::query()
        ->where('tour_category_id', $category->id)
        ->where('slug', 'desert-safaris')
        ->where('is_active', true)
        ->firstOrFail();

    $adventures = Tour::query()
        ->public()
        ->with(['category', 'subcategory', 'images', 'prices'])
        ->where('tour_category_id', $category->id)
        ->where('tour_subcategory_id', $subcategory->id)
        ->orderByDesc('is_featured')
        ->orderBy('display_order')
        ->get()
        ->map(fn (Tour $tour) => $tour->toCatalogueArray())
        ->all();

    return view('pages.desert-safaris', compact('adventures'));
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
    $adventures = Tour::query()->public()->with(['category', 'subcategory', 'images'])
        ->whereHas('subcategory', fn ($query) => $query->where('slug', 'dune-buggies'))
        ->orderBy('display_order')->get()->map(fn (Tour $tour) => $tour->toCatalogueArray())->all();

    return view('pages.dune-buggies', compact('adventures'));
})->name('dune-buggies-category');
Route::view('/desert-adventures/dune-buggies/dune-buggy-adventure', 'pages.dune-buggy-adventure')->name('dune-buggy-adventure');
Route::view('/desert-adventures/dune-buggies/dune-buggy-evening-safari-combo', 'pages.adventure-product-detail', ['productKey' => 'dune-buggy-evening-safari-combo'])->name('dune-buggy-evening-safari-combo');
Route::view('/desert-adventures/dune-buggies/dune-buggy-exclusive-experience-combo', 'pages.adventure-product-detail', ['productKey' => 'dune-buggy-exclusive-experience-combo'])->name('dune-buggy-exclusive-experience-combo');
Route::get('/desert-adventures/desert-experiences', function () {
    $adventures = Tour::query()->public()->with(['category', 'subcategory', 'images'])
        ->whereHas('subcategory', fn ($query) => $query->where('slug', 'desert-experiences'))
        ->orderBy('display_order')->get()->map(fn (Tour $tour) => $tour->toCatalogueArray())->all();

    return view('pages.desert-experiences', compact('adventures'));
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
    $adventures = Tour::query()->public()->with(['category', 'subcategory', 'images'])
        ->whereHas('subcategory', fn ($query) => $query->where('slug', 'school-trips'))
        ->orderBy('display_order')->get()->map(fn (Tour $tour) => $tour->toCatalogueArray())->all();

    return view('pages.school-trips', compact('adventures'));
})->name('school-trips');
Route::view('/desert-adventures/school-trips/morning-wildlife-safari', 'pages.adventure-product-detail', ['productKey' => 'morning-wildlife-safari'])->name('morning-wildlife-safari');
Route::view('/blogs', 'pages.blogs')->name('blogs');

Route::middleware('auth')->group(function () {
    Route::get('/my-account', [CustomerAccountController::class, 'dashboard'])->name('account.dashboard');
    Route::get('/my-account/profile', [CustomerAccountController::class, 'profile'])->name('account.profile');
    Route::patch('/my-account/profile', [CustomerAccountController::class, 'updateProfile'])->name('account.profile.update');
    Route::get('/my-account/orders', [CustomerAccountController::class, 'orders'])->name('account.orders');
    Route::get('/my-account/wishlist', [CustomerAccountController::class, 'wishlist'])->name('account.wishlist');
    Route::post('/tours/{tour:slug}/wishlist', [CustomerAccountController::class, 'storeWishlist'])->name('tours.wishlist.store');
    Route::delete('/tours/{tour:slug}/wishlist', [CustomerAccountController::class, 'destroyWishlist'])->name('tours.wishlist.destroy');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('bank-transfer-payments', [AdminBankTransferPaymentController::class, 'index'])->name('bank-transfer-payments.index');
    Route::get('bank-transfer-payments/{payment}', [AdminBankTransferPaymentController::class, 'show'])->name('bank-transfer-payments.show');
    Route::patch('bank-transfer-payments/{payment}/approve', [AdminBankTransferPaymentController::class, 'approve'])->name('bank-transfer-payments.approve');
    Route::patch('bank-transfer-payments/{payment}/reject', [AdminBankTransferPaymentController::class, 'reject'])->name('bank-transfer-payments.reject');
    Route::patch('bank-transfer-payments/{payment}/request-information', [AdminBankTransferPaymentController::class, 'requestInformation'])->name('bank-transfer-payments.request-information');
    Route::get('bank-transfer-settings', [BankTransferSettingController::class, 'edit'])->name('bank-transfer-settings.edit');
    Route::put('bank-transfer-settings', [BankTransferSettingController::class, 'update'])->name('bank-transfer-settings.update');
    Route::delete('bank-transfer-settings', [BankTransferSettingController::class, 'destroy'])->name('bank-transfer-settings.destroy');
    Route::get('tours/subcategories/options', [TourController::class, 'subcategories'])->name('tours.subcategories');
    Route::delete('tours', [TourController::class, 'destroyMany'])->name('tours.destroy-many');
    Route::resource('tours', TourController::class);
    Route::resource('tour-categories', TourCategoryController::class)->except('show');
    Route::resource('category-content-blocks', TourCategoryContentBlockController::class)->except('show');
    Route::resource('category-faqs', TourCategoryFaqController::class)->except('show');
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

Route::redirect('/cruise-and-boat-tours', '/cruise-boat-tours', 301);
Route::redirect('/waterparks-and-theme-parks', '/waterparks-theme-parks', 301);

Route::get('/{catalogueSlug}', [PublicCatalogueController::class, 'catalogueShortcut'])
    ->where('catalogueSlug', '[A-Za-z0-9-]+')
    ->name('catalogue.shortcut');
