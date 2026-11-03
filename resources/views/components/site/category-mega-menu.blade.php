@props(['category'])

<section class="mega-menu" aria-label="{{ $category->name }} menu">
    <div class="mega-menu-grid">
        <section class="mega-categories">
            <p class="mega-eyebrow">Categories</p>
            @forelse($category->subcategories as $subcategory)
                @php
                    $representativeTour = $subcategory->tours->first();
                    $subcategoryUrl = $category->slug === 'desert-adventures'
                        ? url('/desert-adventures/'.$subcategory->slug)
                        : ($category->slug === 'city-tours'
                            ? route('city-tours.destination', $subcategory)
                            : route('tour-subcategories.show', [$category, $subcategory]));
        $image = $subcategory->imageUrl() ?? $representativeTour?->imageUrl();
                @endphp
                <a class="mega-category" href="{{ $subcategoryUrl }}">
                    <img class="category-orb" src="{{ $image ?: asset('images/desert-safari.png') }}" alt="{{ $subcategory->name }}">
                    <span><b>{{ $subcategory->name }}</b><small>{{ $subcategory->tours_count }} experience{{ $subcategory->tours_count === 1 ? '' : 's' }}</small></span>
                </a>
            @empty
                <p class="mega-category"><span><b>Explore {{ $category->name }}</b><small>Browse current experiences</small></span></p>
            @endforelse
        </section>
        <section class="mega-picks">
            <p class="mega-eyebrow">Top picks</p>
            @foreach($category->tours as $tour)
                <a href="{{ route('tours.show', $tour) }}">{{ $tour->name }} <span aria-hidden="true">→</span></a>
            @endforeach
        </section>
    </div>
</section>
