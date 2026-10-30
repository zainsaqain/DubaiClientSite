<section class="mega-menu attractions-mega-menu" id="attractions-mega-menu" aria-label="Attractions menu">
    <div class="mega-menu-grid attractions-mega-menu-grid">
        <section class="mega-categories attractions-categories" aria-labelledby="attractions-categories-title">
            <p class="mega-eyebrow" id="attractions-categories-title">Explore attractions</p>
            <a class="mega-category" href="{{ url('/') }}#attractions">
                <img class="category-orb" src="{{ asset('images/dubai-attractions.png') }}" alt="">
                <span><b>Entry Tickets</b><small>Dubai's must-see landmarks</small></span>
            </a>
            <a class="mega-category" href="{{ url('/') }}#attractions">
                <img class="category-orb" src="{{ asset('images/global-village-dubai.png') }}" alt="">
                <span><b>UAE Passes</b><small>More places, one easy plan</small></span>
            </a>
        </section>

        <section class="mega-picks attractions-picks" aria-labelledby="attractions-picks-title">
            <p class="mega-eyebrow" id="attractions-picks-title">Trending attractions</p>
            <a href="{{ url('/') }}#attractions">At The Top, Burj Khalifa <span aria-hidden="true">→</span></a>
            <a href="{{ url('/') }}#attractions">Dubai Frame Entrance Ticket <span aria-hidden="true">→</span></a>
            <a href="{{ url('/') }}#attractions">Speed Boat Tour: Marina, Atlantis &amp; Palm <span aria-hidden="true">→</span></a>
            <a href="{{ url('/') }}#attractions">The Green Planet Dubai <span aria-hidden="true">→</span></a>
            <a href="{{ url('/') }}#attractions">Helicopter Tour in Dubai <span aria-hidden="true">→</span></a>
            <a class="mega-view-all" href="{{ url('/') }}#attractions">View all attractions <span aria-hidden="true">→</span></a>
        </section>

        <a class="attractions-menu-promo" href="{{ url('/') }}#attractions">
            <span class="attractions-menu-promo-copy">
                <small>Dubai city favourites</small>
                <strong>Build your perfect Dubai day</strong>
                <em>Explore tickets <span aria-hidden="true">→</span></em>
            </span>
        </a>
    </div>
</section>
