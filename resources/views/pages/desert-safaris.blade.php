@extends('layouts.desert-adventures')

@section('title', 'Desert Safaris | Waheed Murad Tourism')

@section('content')
    @php($adventures = config('desert-safaris.adventures', []))
    <section class="da-category-hero da-container">
        <x-breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'Desert Adventures', 'url' => route('desert-adventures')], ['label' => 'Desert Safaris']]" />
        <h1>Desert Safaris</h1>
        <p>Discover the wonders of the Dubai desert on an unforgettable desert safari. Travel across rolling sand dunes in a comfortable 4x4, spot fascinating wildlife, and enjoy expertly prepared food under the stars in a traditional Bedouin setting.</p>
        <div class="da-feature-list">
            <article>
                <span class="da-feature-orb-mint">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect x="3" y="11" width="18" height="7" rx="2"/>
                        <path d="M5 11l2.2-5h9.6l2.2 5"/>
                        <circle cx="7" cy="15" r="1.2" fill="currentColor"/>
                        <circle cx="17" cy="15" r="1.2" fill="currentColor"/>
                        <path d="M9 18v1.5M15 18v1.5"/>
                    </svg>
                </span>
                <div>
                    <b>Transfers from Dubai</b>
                    <small>Shared or Private</small>
                </div>
            </article>
            <article>
                <span class="da-feature-orb-mint">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="6" cy="17" r="2.5"/>
                        <circle cx="18" cy="17" r="2.5"/>
                        <path d="M8.5 17h7M3.5 17H2v-3l2-3 4-1 3 3h4l2-3 4 3v4h-1.5M7 10l2.5-4h4.5l2 4"/>
                    </svg>
                </span>
                <div>
                    <b>Dune Drive</b>
                    <small>Wildlife Spotting</small>
                </div>
            </article>
            <article>
                <span class="da-feature-orb-mint">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M2 19c4-2 8-2 12 0M10 18c3-2 7-2 12 1"/>
                        <path d="M17 10c0-1.5 1-2.5 2-2.5h1.5v1.5L19 10v4"/>
                        <path d="M14 14c.5-2 1.5-3 3-3s2.5 1 2.5 3v4M15 17v2M18 17v2"/>
                        <path d="M6 14v-5M4 9c1-1 2-1 2 0M8 9c-1-1-2-1-2 0M4 11c1-1 2-1 2 0M8 11c-1-1-2-1-2 0"/>
                    </svg>
                </span>
                <div>
                    <b>Desert Activities</b>
                    <small>Camel Rides &amp; Sandboarding</small>
                </div>
            </article>
            <article>
                <span class="da-feature-orb-mint">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M14 8h7l-1 12H15L14 8ZM17 8V3l2-1"/>
                        <path d="M3 13c0-2 2-3 5-3s5 1 5 3v1H3v-1ZM3 17h10v1a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-1ZM2 15h12"/>
                    </svg>
                </span>
                <div>
                    <b>Food &amp; Refreshments</b>
                    <small>BBQs, breakfast &amp; more</small>
                </div>
            </article>
        </div>
    </section>
    <section class="da-container da-catalogue da-category-catalogue" aria-label="Desert safari adventures">
        <aside class="da-filter-sidebar" data-filters>
            <div class="da-filter-heading">
                <strong>Filter by</strong>
                <button type="button" data-filter-toggle aria-expanded="false">Filters <b>⌄</b></button>
            </div>
            <div class="da-filter-groups" data-filter-groups>
                <details open>
                    <summary>Category <b>⌃</b></summary>
                    <p class="da-filter-parent">Desert Adventures</p>
                    <label><input type="checkbox" value="safari" data-filter="category"> Desert Safaris ({{ count($adventures) }})</label>
                </details>
                <details open>
                    <summary>Location <b>⌃</b></summary>
                    <label><input type="checkbox" value="dubai" data-filter="location"> Dubai ({{ count($adventures) }})</label>
                </details>
                <details>
                    <summary>Time <b>⌄</b></summary>
                    <label><input type="checkbox" value="morning" data-filter="time"> Morning</label>
                    <label><input type="checkbox" value="evening" data-filter="time"> Evening</label>
                </details>
                <details>
                    <summary>Price <b>⌄</b></summary>
                    <label><input type="radio" name="price" value="500" data-price-filter> Under AED 500</label>
                    <label><input type="radio" name="price" value="99999" data-price-filter> AED 500+</label>
                </details>
            </div>
        </aside>
        <div class="da-results">
            <div class="da-results-top">
                <strong><span data-product-count>{{ count($adventures) }}</span> products found</strong>
                <label>Sort by <select data-sort><option value="popular">Most Popular</option><option value="low">Price: Low to High</option><option value="high">Price: High to Low</option><option value="az">Name: A–Z</option></select></label>
            </div>
            <div class="da-adventure-list" data-adventure-list>
                @foreach ($adventures as $adventure)
                    <x-desert-adventures.adventure-card :adventure="$adventure" />
                @endforeach
            </div>
            <p class="da-no-results" data-no-results hidden>No safaris match your filters. <button type="button" data-clear-filters>Clear filters</button></p>
            <div class="da-show-more-wrap da-category-count"><span data-showing-count>Showing {{ count($adventures) }} of {{ count($adventures) }} products</span></div>
        </div>
    </section>

    <section class="da-desert-story da-container da-category-story" aria-label="About Desert Safaris">
        <h2 class="da-section-title">Desert Safaris with <span>Waheed Adventures</span></h2>
        <article class="da-story-row">
            <img src="{{ asset('images/desert-safari.png') }}" alt="Waheed Murad desert safari guides in the dunes" loading="lazy">
            <div>
                <h3>An award-winning experience</h3>
                <p>Our ever-popular desert safari excursions have seen us win several awards and become one of Dubai and the UAE’s most iconic adventures. Our expert desert safari team are brimming with local knowledge, speak multiple languages, and are committed to the highest standards of service and safety. Our unmissable trips into the desert are the perfect way to experience Dubai’s staggering natural beauty.</p>
            </div>
        </article>
        <article class="da-story-row da-story-row--reverse">
            <div>
                <h3>The Dubai Desert Conservation Reserve</h3>
                <p>Our desert safari tours take place in the wonderful surroundings of the Dubai Desert Conservation Reserve (DDCR), a vast, protected nature reserve that covers 225 square kilometres. A 45-minute drive from downtown Dubai, the DDCR features breathtaking red sand dunes and is bustling with stunning native animals and plants.</p>
            </div>
            <img src="{{ asset('images/desert-oasis-morning.png') }}" alt="Arabian oryx and wildlife in the Dubai Desert Conservation Reserve" loading="lazy">
        </article>
        <article class="da-story-row">
            <img src="{{ asset('images/desert-dune-drive.png') }}" alt="Desert sandboarding and travellers in the Dubai dunes" loading="lazy">
            <div>
                <h3>Eco-friendly and sustainable practices</h3>
                <p>At Waheed Murad, we take pride in our sustainable tourism best practices, which are at the heart of our desert safari experiences. From zero plastic initiatives and extensive quarterly clean-ups, to guides certified by the DDCR, our efforts to protect the desert ecosystem have been internationally recognised by the prestigious Travelife Partner sustainability award.</p>
            </div>
        </article>
    </section>

    <section class="da-container da-faq da-category-faq" aria-label="Frequently Asked Questions">
        <h2 class="da-section-title">Frequently asked <span>questions</span></h2>
        <div class="da-faq-list">
            <details>
                <summary>What do you wear on a desert safari?<b>+</b></summary>
                <p>You should wear lightweight, breathable clothing for a desert safari. Choose natural materials like cotton and linen to stay cool in the desert heat and go for a long-sleeved option to avoid over-exposure or burns. In the winter months – the coldest being January – you may also want to bring a jumper, as it can drop to around 15°C at night.</p>
            </details>
            <details>
                <summary>Where is a Dubai desert safari?<b>+</b></summary>
                <p>Our desert safaris take place in the Dubai Desert Conservation Reserve (DDCR), which is roughly a 45-minute drive from central Dubai. The DDCR is one of the largest protected nature reserves in the UAE and covers 5% of Dubai’s total landmass. This vast expanse of sandy dunes is home to an incredible variety of native plants and animals, like the Arabian oryx and Sindh saw-scaled viper. On a desert safari in Dubai with Waheed Murad, you can explore this spectacular, rugged terrain in an air-conditioned 4x4, watch mesmerising sunrises and sunsets, and enjoy superb traditional Emirati hospitality.</p>
            </details>
            <details>
                <summary>How long is a desert safari?<b>+</b></summary>
                <p>Our desert safaris vary in length, with our shortest experience – our Morning Desert Adventure – taking around five hours. Longer excursions, like our Evening Desert Safari, last approximately 7–8 hours. You can also book shorter desert experiences, such as a trip to The Fort – Lisaili, and choose additional activities like quad bike rides and dune buggy driving as add-ons.</p>
            </details>
            <details>
                <summary>What is included in a desert safari in Dubai?<b>+</b></summary>
                <p>You get an incredible variety of activities and extras included in a Dubai desert safari with Waheed Murad. All our desert safaris feature an amazing drive through the sand dunes in an air-conditioned 4x4, when you can spot a huge range of wildlife. You’ll also be treated to a camel ride, an optional sandboarding lesson, and various refreshments. Our Evening Desert Safari includes a stop to watch the sunset and a delicious BBQ dinner in a traditional Bedouin setting with unlimited soft drinks. On our Morning Desert Safari, you’ll receive a tasty breakfast box.</p>
            </details>
            <details>
                <summary>What is the price of a desert safari?<b>+</b></summary>
                <p>The price of our desert safaris varies depending on the experience you book and add-ons you choose. The Fort – Lisaili is a fantastic introduction to the desert and a trip to this beautiful traditional setting costs just AED 175 with a shared return transfer from Dubai. Meanwhile, our Morning Desert Adventure starts from AED 325 while our Evening Desert Safari starts from AED 485.</p>
            </details>
        </div>
    </section>
@endsection
