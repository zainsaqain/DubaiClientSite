<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::view('/desert-adventures', 'pages.desert-adventures')->name('desert-adventures');

Route::view('/dune-buggies', 'pages.dune-buggies')->name('dune-buggies');

Route::view('/desert-adventures/desert-safaris', 'pages.desert-safaris')->name('desert-safaris');
Route::view('/desert-adventures/desert-safaris/morning-desert-adventure', 'pages.morning-desert-adventure')->name('morning-desert-adventure');
Route::view('/desert-adventures/desert-safaris/evening-desert-safari', 'pages.evening-desert-safari')->name('evening-desert-safari');
Route::view('/desert-adventures/desert-safaris/overnight-wildlife-adventure', 'pages.adventure-product-detail', ['productKey' => 'overnight-wildlife-adventure'])->name('overnight-wildlife-adventure');
Route::view('/desert-adventures/dune-buggies', 'pages.dune-buggies')->name('dune-buggies-category');
Route::view('/desert-adventures/dune-buggies/dune-buggy-adventure', 'pages.dune-buggy-adventure')->name('dune-buggy-adventure');
Route::view('/desert-adventures/dune-buggies/dune-buggy-evening-safari-combo', 'pages.adventure-product-detail', ['productKey' => 'dune-buggy-evening-safari-combo'])->name('dune-buggy-evening-safari-combo');
Route::view('/desert-adventures/dune-buggies/dune-buggy-exclusive-experience-combo', 'pages.adventure-product-detail', ['productKey' => 'dune-buggy-exclusive-experience-combo'])->name('dune-buggy-exclusive-experience-combo');
Route::view('/desert-adventures/desert-experiences', 'pages.desert-experiences')->name('desert-experiences');
Route::view('/desert-adventures/desert-experiences/exclusive-desert-experience', 'pages.exclusive-desert-experience')->name('exclusive-desert-experience');
Route::view('/desert-adventures/desert-experiences/camel-ride', 'pages.camel-ride')->name('camel-ride');
Route::view('/desert-adventures/desert-experiences/adventure-pass', 'pages.adventure-product-detail', ['productKey' => 'adventure-pass'])->name('adventure-pass');
Route::view('/desert-adventures/desert-experiences/fort-lisaili-desert-experience', 'pages.adventure-product-detail', ['productKey' => 'fort-lisaili-desert-experience'])->name('fort-lisaili-desert-experience');
Route::view('/desert-adventures/desert-experiences/vantage-desert-experience', 'pages.adventure-product-detail', ['productKey' => 'vantage-desert-experience'])->name('vantage-desert-experience');
Route::view('/desert-adventures/desert-experiences/wadi-adventures', 'pages.adventure-product-detail', ['productKey' => 'wadi-adventures'])->name('wadi-adventures');
Route::view('/desert-adventures/desert-experiences/three-day-camping-adventure', 'pages.adventure-product-detail', ['productKey' => 'three-day-camping-adventure'])->name('three-day-camping-adventure');
Route::view('/desert-adventures/desert-experiences/morning-at-the-fort-lisaili', 'pages.adventure-product-detail', ['productKey' => 'morning-at-the-fort-lisaili'])->name('morning-at-the-fort-lisaili');
Route::view('/desert-adventures/school-trips', 'pages.school-trips')->name('school-trips');
Route::view('/desert-adventures/school-trips/morning-wildlife-safari', 'pages.adventure-product-detail', ['productKey' => 'morning-wildlife-safari'])->name('morning-wildlife-safari');
Route::view('/blogs', 'pages.blogs')->name('blogs');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
