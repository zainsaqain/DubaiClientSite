const queryAll = (selector) => Array.from(document.querySelectorAll(selector));

const cards = queryAll('[data-adventure]');
const list = document.querySelector('[data-adventure-list]');
const resultCount = document.querySelector('[data-product-count]');
const showingCount = document.querySelector('[data-showing-count]');
const showMore = document.querySelector('[data-show-more]');
const noResults = document.querySelector('[data-no-results]');
let visibleLimit = 6;

const refreshCards = () => {
    const activeFilters = ['category', 'location', 'time', 'vehicle'].reduce((filters, type) => {
        filters[type] = queryAll(`[data-filter="${type}"]:checked`).map((input) => input.value);
        return filters;
    }, {});
    const price = document.querySelector('[data-price-filter]:checked')?.value;
    const search = document.querySelector('[data-adventure-search]')?.value.trim().toLowerCase() ?? '';
    const matches = cards.filter((card) => Object.entries(activeFilters).every(([type, values]) => values.length === 0 || values.includes(card.dataset[type])) && (!price || Number(card.dataset.price) <= Number(price)) && (!search || card.dataset.title.includes(search)));
    cards.forEach((card) => { card.hidden = !matches.includes(card) || matches.indexOf(card) >= visibleLimit; });
    if (resultCount) { resultCount.textContent = matches.length; }
    if (showingCount) { showingCount.textContent = `Showing ${Math.min(matches.length, visibleLimit)} of ${matches.length} products`; }
    if (showMore) { showMore.hidden = matches.length <= visibleLimit; }
    if (noResults) { noResults.hidden = matches.length !== 0; }
};

queryAll('[data-filter], [data-price-filter]').forEach((input) => input.addEventListener('change', () => { visibleLimit = 6; refreshCards(); }));
document.querySelector('[data-adventure-search]')?.addEventListener('input', () => { visibleLimit = 6; refreshCards(); });
showMore?.addEventListener('click', () => { visibleLimit += 6; refreshCards(); });
document.querySelector('[data-clear-filters]')?.addEventListener('click', () => { queryAll('[data-filter], [data-price-filter]').forEach((input) => { input.checked = false; }); visibleLimit = 6; refreshCards(); });
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
    const quantities = { adults: 1, children: 0 };
    const serviceSelect = bookingCard.querySelector('[data-booking-service]');
    const totalOutput = bookingCard.querySelector('[data-booking-total]');
    const status = bookingCard.querySelector('[data-booking-status]');
    const currency = bookingCard.dataset.currency ?? 'AED';

    const refreshBookingTotal = () => {
        const servicePrice = Number(serviceSelect?.value ?? 0);
        const total = (servicePrice * quantities.adults) + Math.round(servicePrice * 0.5 * quantities.children);

        bookingCard.querySelectorAll('[data-quantity-output]').forEach((output) => {
            output.textContent = quantities[output.dataset.quantityOutput];
        });

        if (totalOutput) {
            totalOutput.textContent = `${currency} ${new Intl.NumberFormat('en-US').format(total)}`;
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
    const scrollAmount = () => Math.max(track?.clientWidth * 0.82 ?? 0, 260);

    carousel.querySelector('[data-carousel-previous]')?.addEventListener('click', () => {
        track?.scrollBy({ left: -scrollAmount(), behavior: 'smooth' });
    });

    carousel.querySelector('[data-carousel-next]')?.addEventListener('click', () => {
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
        const storedValue = JSON.parse(window.localStorage.getItem(storageKey) ?? '[]');
        storedProductKeys = Array.isArray(storedValue)
            ? storedValue.filter((key) => typeof key === 'string' && validProductKeys.has(key))
            : [];
        window.localStorage.setItem(storageKey, JSON.stringify([currentProductKey, ...storedProductKeys.filter((key) => key !== currentProductKey)].slice(0, 12)));
    } catch {
        storedProductKeys = [];
    }

    const productsToShow = storedProductKeys.filter((key) => key !== currentProductKey).slice(0, 4);
    recentCards.forEach((card) => {
        const isVisible = productsToShow.includes(card.dataset.recentProduct);
        card.hidden = !isVisible;

        if (isVisible) {
            recentList?.append(card);
        }
    });

    if (emptyState) {
        emptyState.hidden = productsToShow.length > 0;
    }
}
