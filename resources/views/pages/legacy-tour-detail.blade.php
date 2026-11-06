@extends('layouts.desert-adventures')

@section('title', $legacyTour->title.' | Waheed Murad Tourism')

@section('content')
    <section class="da-intro da-container">
        <x-breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => $catalogueLabel, 'url' => $catalogueUrl], ['label' => $legacyTour->title]]" />
        <h1>{{ $legacyTour->title }}</h1>
        <p>{{ $legacyTour->description }}</p>
    </section>

    <section class="da-container">
        <article class="da-abu-story-panel">
            <img class="da-abu-story-image" src="{{ $legacyTour->imageUrl() }}" alt="{{ $legacyTour->title }}">
            <div>
                <p class="da-card-category">{{ $catalogueLabel }}</p>
                <h2>{{ $legacyTour->title }}</h2>
                <p>{{ $legacyTour->description }}</p>
                <p><strong>From PKR {{ number_format((float) $legacyTour->price) }}</strong></p>
                <a class="da-book-button" href="{{ $catalogueUrl }}">Back to {{ $catalogueLabel }}</a>
            </div>
        </article>
    </section>
@endsection
