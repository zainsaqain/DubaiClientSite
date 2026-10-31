<?php

use App\Http\Controllers\Admin\DesertAdventureController;
use App\Http\Controllers\ProfileController;
use App\Models\DesertAdventure;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::view('/admin', 'admin.dashboard.index')
    ->middleware(['auth', 'verified'])
    ->name('admin.dashboard');

Route::get('/desert-adventures', function () {
    $managedAdventures = DesertAdventure::query()
        ->where('is_active', true)
        ->latest()
        ->get()
        ->map(fn (DesertAdventure $adventure) => $adventure->toCatalogueArray())
        ->all();

    return view('pages.desert-adventures', [
        'adventures' => $managedAdventures ?: config('desert-adventures.adventures', []),
    ]);
})->name('desert-adventures');
Route::view('/attractions', 'pages.attractions')->name('attractions');
Route::view('/city-tours', 'pages.city-tours')->name('city-tours');

Route::view('/sports-events', 'pages.sports-events')->name('sports-events');
Route::view('/cruise-boat-tours', 'pages.cruise-boat-tours')->name('cruise-boat-tours');
Route::view('/waterparks-theme-parks', 'pages.waterparks-theme-parks')->name('waterparks-theme-parks');
Route::view('/transfers', 'pages.transfers')->name('transfers');
Route::view('/why-us', 'pages.why-us')->name('why-us');

Route::view('/dune-buggies', 'pages.dune-buggies')->name('dune-buggies');

Route::get('/desert-adventures/desert-safaris', function () {
    $adventures = DesertAdventure::query()
        ->where('is_active', true)
        ->where('category', 'Desert Safaris')
        ->latest()
        ->get()
        ->map(fn (DesertAdventure $adventure) => $adventure->toCatalogueArray())
        ->all();

    return view('pages.desert-safaris', [
        'adventures' => $adventures ?: config('desert-safaris.adventures', []),
    ]);
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

    return view('pages.dune-buggies', [
        'adventures' => $adventures ?: config('dune-buggies.adventures', []),
    ]);
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

    return view('pages.desert-experiences', [
        'adventures' => $adventures ?: config('desert-experiences.adventures', []),
    ]);
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

    return view('pages.school-trips', [
        'adventures' => $adventures ?: config('school-trips.adventures', []),
    ]);
})->name('school-trips');
Route::view('/desert-adventures/school-trips/morning-wildlife-safari', 'pages.adventure-product-detail', ['productKey' => 'morning-wildlife-safari'])->name('morning-wildlife-safari');
Route::view('/blogs', 'pages.blogs')->name('blogs');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->prefix('admin')->as('admin.')->group(function () {
    Route::resource('desert-adventures', DesertAdventureController::class)->except('show');
});

require __DIR__.'/auth.php';
