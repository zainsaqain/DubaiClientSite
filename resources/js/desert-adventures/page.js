const queryAll = (selector) => Array.from(document.querySelectorAll(selector));

const cards = queryAll('[data-adventure]');
const list = document.querySelector('[data-adventure-list]');
const resultCount = document.querySelector('[data-product-count]');
const showingCount = document.querySelector('[data-showing-count]');
const showMore = document.querySelector('[data-show-more]');
const noResults = document.querySelector('[data-no-results]');
const activeFilterSummary = document.querySelector('[data-active-filter-summary]');
const activeFilterLabel = document.querySelector('[data-active-filter-label]');
let visibleLimit = 6;

const refreshCards = () => {
    const activeFilters = ['category', 'location', 'time', 'language', 'vehicle'].reduce((filters, type) => {
        filters[type] = queryAll(`[data-filter="${type}"]:checked`).map((input) => input.value);
        return filters;
    }, {});
    const selectedPrice = document.querySelector('[data-price-filter]:checked');
    const priceRange = selectedPrice
        ? {
              minimum: Number(selectedPrice.dataset.priceMin ?? 0),
              maximum: Number(selectedPrice.dataset.priceMax ?? selectedPrice.value),
              label: selectedPrice.dataset.filterLabel ?? selectedPrice.closest('label')?.textContent?.trim() ?? '',
          }
        : null;
    const search = document.querySelector('[data-adventure-search]')?.value.trim().toLowerCase() ?? '';
    const matches = cards.filter((card) => {
        const filtersMatch = Object.entries(activeFilters).every(([type, values]) => values.length === 0 || values.includes(card.dataset[type]));
        const priceMatches = !priceRange || (Number(card.dataset.price) >= priceRange.minimum && Number(card.dataset.price) <= priceRange.maximum);

        return filtersMatch && priceMatches && (!search || card.dataset.title.includes(search));
    });
    const selectedLabels = [
        ...queryAll('[data-filter]:checked').map((input) => input.dataset.filterLabel ?? input.closest('label')?.textContent?.trim() ?? ''),
        ...(priceRange?.label ? [priceRange.label] : []),
    ].filter(Boolean);
    cards.forEach((card) => { card.hidden = !matches.includes(card) || matches.indexOf(card) >= visibleLimit; });
    if (resultCount) { resultCount.textContent = matches.length; }
    if (showingCount) { showingCount.textContent = `Showing ${Math.min(matches.length, visibleLimit)} of ${matches.length} products`; }
    if (showMore) { showMore.hidden = matches.length <= visibleLimit; }
    if (noResults) { noResults.hidden = matches.length !== 0; }
    if (activeFilterSummary) { activeFilterSummary.hidden = selectedLabels.length === 0; }
    if (activeFilterLabel) { activeFilterLabel.textContent = selectedLabels.join(', '); }
};

queryAll('[data-filter], [data-price-filter]').forEach((input) => input.addEventListener('change', () => { visibleLimit = 6; refreshCards(); }));
document.querySelector('[data-adventure-search]')?.addEventListener('input', () => { visibleLimit = 6; refreshCards(); });
showMore?.addEventListener('click', () => { visibleLimit += 6; refreshCards(); });
queryAll('[data-clear-filters]').forEach((button) => button.addEventListener('click', () => { queryAll('[data-filter], [data-price-filter]').forEach((input) => { input.checked = false; }); visibleLimit = 6; refreshCards(); }));
document.querySelector('[data-sort]')?.addEventListener('change', (event) => {
    const cardsToSort = [...cards];
    const compare = { low: (a, b) => a.dataset.price - b.dataset.price, high: (a, b) => b.dataset.price - a.dataset.price, az: (a, b) => a.dataset.title.localeCompare(b.dataset.title), popular: () => 0 }[event.target.value];
    cardsToSort.sort(compare).forEach((card) => list?.append(card));
    refreshCards();
});
const filterToggle = document.querySelector('[data-filter-toggle]');
const filterGroups = document.querySelector('[data-filter-groups]');
filterToggle?.addEventListener('click', () => { const open = filterGroups?.hidden; if (filterGroups) { filterGroups.hidden = !open; } filterToggle.setAttribute('aria-expanded', String(open)); });
refreshCards();

const galleryMainImage = document.querySelector('[data-gallery-main]');
const galleryThumbnails = queryAll('[data-gallery-thumbnail]');

galleryThumbnails.forEach((thumbnail) => {
    thumbnail.addEventListener('click', () => {
        if (!galleryMainImage) {
            return;
        }

        galleryMainImage.src = thumbnail.dataset.image;
        galleryMainImage.alt = thumbnail.dataset.alt;
        galleryThumbnails.forEach((item) => item.setAttribute('aria-pressed', String(item === thumbnail)));
    });
});

document.querySelector('[data-gallery-show-all]')?.addEventListener('click', () => {
    galleryThumbnails[0]?.focus();
});

document.querySelector('[data-video-preview]')?.addEventListener('click', (event) => {
    const status = document.querySelector('[data-video-status]');
    if (status) {
        status.textContent = 'Video preview is not available in this static demo.';
    }
    event.currentTarget.setAttribute('aria-pressed', 'true');
});

const bookingCard = document.querySelector('[data-booking-card]');

if (bookingCard) {
    const quantities = { adults: 1, children: 0, infants: 0 };
    const serviceSelect = bookingCard.querySelector('[data-booking-service]');
    const totalOutput = bookingCard.querySelector('[data-booking-total]');
    const status = bookingCard.querySelector('[data-booking-status]');
    const currency = bookingCard.dataset.currency ?? 'AED';
    const travelerToggle = bookingCard.querySelector('[data-traveler-toggle]');
    const travelerPicker = bookingCard.querySelector('[data-traveler-picker]');
    const travelerSummary = bookingCard.querySelector('[data-traveler-summary]');

    const refreshBookingTotal = () => {
        const selectedOption = serviceSelect?.selectedOptions[0];
        const adultPrice = Number(serviceSelect?.value ?? 0);
        const childPrice = Number(selectedOption?.dataset.childPrice ?? 0);
        const infantPrice = Number(selectedOption?.dataset.infantPrice ?? 0);
        const total = (adultPrice * quantities.adults) + (childPrice * quantities.children) + (infantPrice * quantities.infants);

        bookingCard.querySelectorAll('[data-quantity-output]').forEach((output) => {
            output.textContent = quantities[output.dataset.quantityOutput];
        });

        if (totalOutput) {
            totalOutput.textContent = `${currency} ${new Intl.NumberFormat('en-US').format(total)}`;
        }

        if (travelerSummary) {
            const travelerLabels = { adults: 'adult', children: 'child', infants: 'infant' };
            const travellers = Object.entries(quantities)
                .filter(([, quantity]) => quantity > 0)
                .map(([type, quantity]) => `${quantity} ${travelerLabels[type]}${quantity === 1 ? '' : 's'}`);
            travelerSummary.textContent = travellers.join(', ');
        }
    };

    bookingCard.querySelectorAll('[data-quantity-action]').forEach((button) => {
        button.addEventListener('click', () => {
            const quantity = button.dataset.quantity;
            const change = button.dataset.quantityAction === 'increase' ? 1 : -1;
            const minimum = quantity === 'adults' ? 1 : 0;
            quantities[quantity] = Math.max(minimum, quantities[quantity] + change);
            refreshBookingTotal();
        });
    });

    serviceSelect?.addEventListener('change', refreshBookingTotal);
    bookingCard.querySelectorAll('[data-booking-service-choice]').forEach((choice, index) => {
        choice.addEventListener('change', () => {
            if (!choice.checked || !serviceSelect) {
                return;
            }

            serviceSelect.selectedIndex = index;
            refreshBookingTotal();
        });
    });

    travelerToggle?.addEventListener('click', () => {
        const isOpen = travelerPicker?.hidden;
        if (travelerPicker) {
            travelerPicker.hidden = !isOpen;
        }
        travelerToggle.setAttribute('aria-expanded', String(isOpen));
    });

    bookingCard.querySelector('[data-traveler-confirm]')?.addEventListener('click', () => {
        if (travelerPicker) {
            travelerPicker.hidden = true;
        }
        travelerToggle?.setAttribute('aria-expanded', 'false');
    });
    bookingCard.querySelector('[data-check-availability]')?.addEventListener('click', () => {
        const selectedDate = bookingCard.querySelector('[data-booking-date]')?.value;
        if (status) {
            status.textContent = selectedDate
                ? `Your preferred date is ${selectedDate}. Our travel desk will confirm availability with you.`
                : 'Please choose your preferred date to continue.';
        }
    });

    refreshBookingTotal();
}

queryAll('[data-related-carousel]').forEach((carousel) => {
    const track = carousel.querySelector('[data-carousel-track]');
    const prevBtn = carousel.querySelector('[data-carousel-previous]');
    const nextBtn = carousel.querySelector('[data-carousel-next]');

    const scrollAmount = () => {
        const firstCard = track?.querySelector('.da-product-preview-card');
        return firstCard ? firstCard.getBoundingClientRect().width + 16 : Math.max((track?.clientWidth ?? 0) * 0.82, 260);
    };

    prevBtn?.addEventListener('click', () => {
        track?.scrollBy({ left: -scrollAmount(), behavior: 'smooth' });
    });

    nextBtn?.addEventListener('click', () => {
        track?.scrollBy({ left: scrollAmount(), behavior: 'smooth' });
    });
});

const recentlyViewed = document.querySelector('[data-recently-viewed]');

if (recentlyViewed) {
    const storageKey = 'wmt-recent-adventure-products';
    const currentProductKey = recentlyViewed.dataset.currentProduct;
    const recentCards = queryAll('[data-recent-product]');
    const validProductKeys = new Set([currentProductKey, ...recentCards.map((card) => card.dataset.recentProduct)]);
    const emptyState = recentlyViewed.querySelector('[data-recently-viewed-empty]');
    const recentList = recentlyViewed.querySelector('[data-recently-viewed-list]');
    let storedProductKeys = [];

    try {
        const rawValue = window.localStorage.getItem(storageKey);
        const storedValue = rawValue ? JSON.parse(rawValue) : [];
        if (Array.isArray(storedValue)) {
            const unique = Array.from(new Set(storedValue.filter((key) => typeof key === 'string' && validProductKeys.has(key))));
            storedProductKeys = unique;
        }
        const updatedList = Array.from(new Set([currentProductKey, ...storedProductKeys])).slice(0, 12);
        window.localStorage.setItem(storageKey, JSON.stringify(updatedList));
    } catch {
        storedProductKeys = [];
    }

    const productsToShow = storedProductKeys.filter((key) => key !== currentProductKey).slice(0, 4);

    recentCards.forEach((card) => {
        card.hidden = true;
    });

    productsToShow.forEach((key) => {
        const card = recentCards.find((c) => c.dataset.recentProduct === key);
        if (card) {
            card.hidden = false;
            recentList?.append(card);
        }
    });

    if (emptyState) {
        emptyState.hidden = productsToShow.length > 0;
    }
}

/* =====================================================
   CARD IMAGE CAROUSELS
   ===================================================== */
queryAll('[data-card-carousel]').forEach((carousel) => {
    const slides = Array.from(carousel.querySelectorAll('.da-card-slide'));
    const dots = Array.from(carousel.querySelectorAll('[data-card-dot]'));
    if (slides.length <= 1) { return; }
    let current = 0;

    const goTo = (index) => {
        slides[current].classList.remove('is-active');
        dots[current]?.classList.remove('is-active');
        current = (index + slides.length) % slides.length;
        slides[current].classList.add('is-active');
        dots[current]?.classList.add('is-active');
    };

    carousel.querySelector('[data-card-prev]')?.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        goTo(current - 1);
    });
    carousel.querySelector('[data-card-next]')?.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        goTo(current + 1);
    });
    dots.forEach((dot, i) => {
        dot.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            goTo(i);
        });
    });
});

/* =====================================================
   HERO GALLERY CAROUSEL (product detail)
   ===================================================== */
const heroCarousel = document.querySelector('[data-hero-carousel]');

if (heroCarousel) {
    const heroSlides = Array.from(heroCarousel.querySelectorAll('.da-hero-slide'));
    const heroDots = Array.from(heroCarousel.querySelectorAll('[data-hero-dot]'));
    let heroIndex = 0;

    const heroGoTo = (index) => {
        heroSlides[heroIndex].classList.remove('is-active');
        heroSlides[heroIndex].setAttribute('aria-hidden', 'true');
        heroDots[heroIndex]?.classList.remove('is-active');
        heroIndex = (index + heroSlides.length) % heroSlides.length;
        heroSlides[heroIndex].classList.add('is-active');
        heroSlides[heroIndex].setAttribute('aria-hidden', 'false');
        heroDots[heroIndex]?.classList.add('is-active');
    };

    heroCarousel.querySelector('[data-hero-prev]')?.addEventListener('click', () => heroGoTo(heroIndex - 1));
    heroCarousel.querySelector('[data-hero-next]')?.addEventListener('click', () => heroGoTo(heroIndex + 1));

    heroDots.forEach((dot, i) => {
        dot.addEventListener('click', () => heroGoTo(i));
    });

    heroCarousel.querySelector('[data-hero-see-all]')?.addEventListener('click', () => {
        heroGoTo(1);
    });

    // Keyboard navigation
    heroCarousel.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') { heroGoTo(heroIndex - 1); }
        if (e.key === 'ArrowRight') { heroGoTo(heroIndex + 1); }
    });
}
