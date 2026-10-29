import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Reusable Hero Slider component for Alpine.js
window.heroSlider = function(totalSlides = 4, interval = 5000) {
    return {
        activeSlide: 0,
        total: totalSlides,
        timer: null,
        interval: interval,
        isPaused: false,
        touchStartX: 0,
        touchEndX: 0,
        swipeThreshold: 45,

        init() {
            const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            if (!prefersReducedMotion) {
                this.startAutoplay();
            }
        },

        startAutoplay() {
            this.clearTimer();
            this.timer = setInterval(() => {
                if (!this.isPaused) {
                    this.next();
                }
            }, this.interval);
        },

        clearTimer() {
            if (this.timer) {
                clearInterval(this.timer);
                this.timer = null;
            }
        },

        pause() {
            this.isPaused = true;
        },

        resume() {
            this.isPaused = false;
        },

        next() {
            this.isPaused = false;
            this.activeSlide = (this.activeSlide + 1) % this.total;
            this.restartAutoplay();
        },

        prev() {
            this.isPaused = false;
            this.activeSlide = (this.activeSlide - 1 + this.total) % this.total;
            this.restartAutoplay();
        },

        goTo(index) {
            this.isPaused = false;
            this.activeSlide = index;
            this.restartAutoplay();
        },

        restartAutoplay() {
            const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            if (!prefersReducedMotion) {
                this.startAutoplay();
            }
        },

        handleTouchStart(e) {
            if (e.touches && e.touches.length > 0) {
                this.touchStartX = e.touches[0].clientX;
                this.touchEndX = e.touches[0].clientX;
            }
        },

        handleTouchMove(e) {
            if (e.touches && e.touches.length > 0) {
                this.touchEndX = e.touches[0].clientX;
            }
        },

        handleTouchEnd() {
            const diff = this.touchStartX - this.touchEndX;
            if (Math.abs(diff) > this.swipeThreshold) {
                if (diff > 0) {
                    this.next();
                } else {
                    this.prev();
                }
            }
            this.touchStartX = 0;
            this.touchEndX = 0;
        },

        handleKeydown(e) {
            if (e.key === 'ArrowLeft') {
                e.preventDefault();
                this.prev();
            } else if (e.key === 'ArrowRight') {
                e.preventDefault();
                this.next();
            }
        }
    };
};

Alpine.data('heroSlider', window.heroSlider);

Alpine.start();

const initialiseSectionReveals = () => {
    const revealTargets = document.querySelectorAll('.site-canvas > section, .site-canvas > .hero-slider-wrapper');
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (prefersReducedMotion || !('IntersectionObserver' in window)) {
        revealTargets.forEach((target) => target.classList.add('is-visible'));
        return;
    }

    const revealObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -42px' });

    revealTargets.forEach((target, index) => {
        target.classList.add('section-reveal');
        target.style.setProperty('--reveal-delay', `${Math.min(index * 45, 180)}ms`);

        if (target.classList.contains('hero-slider-wrapper')) {
            target.classList.add('is-visible');
        } else {
            revealObserver.observe(target);
        }
    });
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initialiseSectionReveals, { once: true });
} else {
    initialiseSectionReveals();
}
