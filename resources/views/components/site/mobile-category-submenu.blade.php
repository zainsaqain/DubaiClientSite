@props(['category'])

<section class="mobile-submenu-panel" id="mobile-category-menu-{{ $category->id }}" aria-label="{{ $category->name }} submenu" aria-hidden="true">
    <div class="mobile-menu-bar mobile-submenu-bar"><button class="mobile-menu-back" type="button"><span aria-hidden="true">‹</span> Back</button><button class="mobile-menu-close" type="button" aria-label="Close navigation">×</button></div>
    <div class="mobile-submenu-content">
        <p class="mobile-submenu-eyebrow">EXPLORE</p>
        <h2>{{ $category->name }}</h2>
        @foreach($category->subcategories as $subcategory)
            @php
                $representativeTour = $subcategory->tours->first();
                $subcategoryUrl = $category->slug === 'desert-adventures'
                    ? url('/desert-adventures/'.$subcategory->slug)
                    : ($category->slug === 'city-tours'
                        ? route('city-tours.destination', $subcategory)
                        : route('tour-subcategories.show', [$category, $subcategory]));
                $image = $subcategory->imageUrl() ?? $representativeTour?->imageUrl();
            @endphp
            <a class="mobile-submenu-category" href="{{ $subcategoryUrl }}"><img class="category-orb" src="{{ $image ?: asset('images/desert-safari.png') }}" alt="{{ $subcategory->name }}"><span><b>{{ $subcategory->name }}</b><small>{{ $subcategory->tours_count }} experience{{ $subcategory->tours_count === 1 ? '' : 's' }}</small></span><i aria-hidden="true">›</i></a>
        @endforeach
    </div>
</section>
