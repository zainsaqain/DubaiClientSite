@extends('layouts.desert-adventures')

@section('title', 'Travel Blog | Waheed Murad Tourism')

@section('content')
    @php($articles = config('travel-blogs.articles', []))

    <section class="da-blog-page da-container">
        <x-breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'Travel Blog']]" />
        <div class="da-blog-heading"><p>Travel inspiration</p><h1>Read our recent <span>blogs</span></h1><span>Static stories and ideas for the frontend preview.</span></div>
        <div class="da-blog-grid" id="blog-list">
            @foreach ($articles as $article)
                <article class="da-blog-card" id="{{ $article['slug'] }}"><img src="{{ asset($article['image']) }}" alt="{{ $article['title'] }}" loading="lazy"><div><small>Travel inspiration</small><h2>{{ $article['title'] }}</h2><p>{{ $article['excerpt'] }}</p><a href="{{ route('blogs') }}#{{ $article['slug'] }}">Read preview <span aria-hidden="true">→</span></a></div></article>
            @endforeach
        </div>
    </section>
@endsection
