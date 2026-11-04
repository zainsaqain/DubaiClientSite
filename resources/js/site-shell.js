const menuButton = document.querySelector('.menu-toggle');
const mobileNavigation = document.querySelector('.mobile-navigation');
const mobileSubmenuTriggers = Array.from(document.querySelectorAll('[data-mobile-submenu-target]'));
const mobileSubmenus = Array.from(document.querySelectorAll('.mobile-submenu-panel'));
const desktopMediaQuery = window.matchMedia('(min-width: 901px)');
const megaMenuItems = Array.from(document.querySelectorAll('[data-mega-menu], [data-attractions-mega-menu], [data-city-tours-mega-menu], [data-why-us-mega-menu], [data-category-mega-menu]'));

let megaMenuCloseTimer;

const triggerFor = (item) => item?.querySelector('.nav-trigger');

const setMegaMenuState = (item, isOpen) => {
    const trigger = triggerFor(item);

    if (!item || !trigger) {
        return;
    }

    item.classList.toggle('is-open', isOpen);
    trigger.setAttribute('aria-expanded', String(isOpen));
};

const closeMegaMenus = (except = null) => {
    window.clearTimeout(megaMenuCloseTimer);
    megaMenuItems.forEach((item) => {
        if (item !== except) {
            setMegaMenuState(item, false);
        }
    });
};

const scheduleMegaMenuClose = (item) => {
    window.clearTimeout(megaMenuCloseTimer);
    megaMenuCloseTimer = window.setTimeout(() => setMegaMenuState(item, false), 140);
};

const closeMobileSubmenus = () => {
    mobileNavigation?.classList.remove('is-submenu-open');
    mobileSubmenuTriggers.forEach((trigger) => trigger.setAttribute('aria-expanded', 'false'));
    mobileSubmenus.forEach((submenu) => submenu.setAttribute('aria-hidden', 'true'));
};

const openMobileSubmenu = (trigger) => {
    const submenu = document.getElementById(trigger.dataset.mobileSubmenuTarget);

    if (!mobileNavigation || !submenu) {
        return;
    }

    mobileNavigation.classList.add('is-submenu-open');
    mobileSubmenuTriggers.forEach((item) => item.setAttribute('aria-expanded', String(item === trigger)));
    mobileSubmenus.forEach((item) => item.setAttribute('aria-hidden', String(item !== submenu)));
};

const closeMobileNavigation = () => {
    closeMobileSubmenus();
    mobileNavigation?.classList.remove('is-open');
    menuButton?.setAttribute('aria-expanded', 'false');
    document.body.style.overflow = '';

    window.setTimeout(() => {
        if (mobileNavigation && !mobileNavigation.classList.contains('is-open')) {
            mobileNavigation.hidden = true;
            mobileNavigation.setAttribute('aria-hidden', 'true');
        }
    }, 320);
};

const openMobileNavigation = () => {
    if (!mobileNavigation) {
        return;
    }

    mobileNavigation.hidden = false;
    mobileNavigation.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
    window.requestAnimationFrame(() => mobileNavigation.classList.add('is-open'));
};

menuButton?.addEventListener('click', () => {
    if (menuButton.getAttribute('aria-expanded') === 'true') {
        closeMobileNavigation();
    } else {
        menuButton.setAttribute('aria-expanded', 'true');
        openMobileNavigation();
    }
});

mobileSubmenuTriggers.forEach((trigger) => trigger.addEventListener('click', () => openMobileSubmenu(trigger)));
document.querySelectorAll('.mobile-menu-back').forEach((button) => button.addEventListener('click', closeMobileSubmenus));

document.querySelectorAll('.mobile-menu-close, .mobile-menu-scrim, .mobile-navigation a').forEach((element) => {
    element.addEventListener('click', closeMobileNavigation);
});

megaMenuItems.forEach((item) => {
    const trigger = triggerFor(item);

    item.addEventListener('mouseenter', () => {
        if (desktopMediaQuery.matches) {
            window.clearTimeout(megaMenuCloseTimer);
            closeMegaMenus(item);
            setMegaMenuState(item, true);
        }
    });

    item.addEventListener('mouseleave', () => {
        if (desktopMediaQuery.matches) {
            scheduleMegaMenuClose(item);
        }
    });

    item.addEventListener('focusin', () => {
        if (desktopMediaQuery.matches) {
            window.clearTimeout(megaMenuCloseTimer);
            closeMegaMenus(item);
            setMegaMenuState(item, true);
        }
    });

    item.addEventListener('focusout', (event) => {
        if (desktopMediaQuery.matches && !item.contains(event.relatedTarget)) {
            scheduleMegaMenuClose(item);
        }
    });

    if (trigger instanceof HTMLButtonElement) {
        trigger.addEventListener('click', () => {
            if (desktopMediaQuery.matches) {
                const isOpen = item.classList.contains('is-open');
                closeMegaMenus(item);
                setMegaMenuState(item, !isOpen);
            }
        });

        trigger.addEventListener('keydown', (event) => {
            if (event.key === 'ArrowDown') {
                event.preventDefault();
                closeMegaMenus(item);
                setMegaMenuState(item, true);
                item.querySelector('.mega-menu a')?.focus();
            }
        });
    }
});

document.addEventListener('click', (event) => {
    if (!megaMenuItems.some((item) => item.contains(event.target))) {
        closeMegaMenus();
    }
});

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
        const openMenu = megaMenuItems.find((item) => item.classList.contains('is-open'));

        if (openMenu) {
            closeMegaMenus();
            triggerFor(openMenu)?.focus();
        }

        if (mobileNavigation?.classList.contains('is-open')) {
            closeMobileNavigation();
        }
    }
});

desktopMediaQuery.addEventListener('change', () => closeMegaMenus());

const primaryNavigation = document.querySelector('.primary-navigation');

if (primaryNavigation) {
    const navigationPlaceholder = document.createElement('div');
    let navigationStart = 0;

    navigationPlaceholder.className = 'primary-navigation-placeholder';
    primaryNavigation.after(navigationPlaceholder);

    const resetNavigation = () => {
        primaryNavigation.classList.remove('is-scroll-fixed');
        navigationPlaceholder.style.height = '';
    };

    const measureNavigation = () => {
        resetNavigation();
        navigationStart = primaryNavigation.getBoundingClientRect().top + window.scrollY;
    };

    const updateNavigation = () => {
        if (!desktopMediaQuery.matches) {
            resetNavigation();
            return;
        }

        const shouldFixNavigation = window.scrollY >= navigationStart;

        primaryNavigation.classList.toggle('is-scroll-fixed', shouldFixNavigation);
        navigationPlaceholder.style.height = shouldFixNavigation ? `${primaryNavigation.offsetHeight}px` : '';
    };

    measureNavigation();
    updateNavigation();

    window.addEventListener('scroll', updateNavigation, { passive: true });
    window.addEventListener('resize', () => {
        measureNavigation();
        updateNavigation();
    });
    desktopMediaQuery.addEventListener('change', () => {
        measureNavigation();
        updateNavigation();
    });
}

const languageOptions = Array.from(document.querySelectorAll('[data-language-option]'));
const currencyOptions = Array.from(document.querySelectorAll('[data-currency-option]'));
const languageCurrent = document.querySelector('[data-language-current]');
const currencyCurrent = document.querySelector('[data-currency-current]');
const languagePreference = document.querySelector('[data-language-preference]');
const currencyPreference = document.querySelector('[data-currency-preference]');
const languageStorageKey = 'wmt-language';
const currencyStorageKey = 'wmt-currency';
const currencyToAed = {
    AED: 1,
    USD: 3.6725,
    GBP: 4.7,
    EUR: 4,
    AUD: 2.4,
    CAD: 2.69,
    ZAR: 0.2,
    INR: 0.044,
    PKR: 0.013,
    SGD: 2.7,
    PHP: 0.064,
    BHD: 9.74,
    BRL: 0.69,
    CNY: 0.51,
    DKK: 0.536,
    HKD: 0.47,
    IDR: 0.00023,
    JPY: 0.024,
    KWD: 11.9,
    MYR: 0.84,
    MXN: 0.22,
    NOK: 0.35,
    NZD: 2.2,
    OMR: 9.54,
    QAR: 1.01,
    SAR: 0.98,
    SEK: 0.35,
    CHF: 4.2,
    THB: 0.1,
    TRY: 0.11,
};

const closeFooterPreferences = (except = null) => {
    [languagePreference, currencyPreference].forEach((preference) => {
        if (preference && preference !== except) {
            preference.removeAttribute('open');
        }
    });
};

[languagePreference, currencyPreference].forEach((preference) => {
    preference?.addEventListener('toggle', () => {
        if (preference.open) {
            closeFooterPreferences(preference);
        }
    });
});

const selectedLanguage = () => window.localStorage.getItem(languageStorageKey) || 'en';

const updateLanguageUi = (language) => {
    const option = languageOptions.find((item) => item.dataset.language === language) || languageOptions[0];
    const label = option?.textContent.trim() || 'English';

    if (languageCurrent) {
        languageCurrent.textContent = label;
    }

    languageOptions.forEach((item) => item.classList.toggle('is-selected', item === option));
    document.documentElement.lang = language;
    document.documentElement.dir = ['ar', 'ur'].includes(language) ? 'rtl' : 'ltr';
};

const clearGoogleTranslationCookie = () => {
    document.cookie = 'googtrans=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/;SameSite=Lax';
};

const setGoogleTranslationCookie = (language) => {
    document.cookie = `googtrans=/en/${language};path=/;SameSite=Lax`;
};

const loadGoogleTranslate = () => {
    if (document.querySelector('script[data-wmt-google-translate]')) {
        setGoogleLanguage(language);
        return;
    }

    window.wmtGoogleTranslateInit = () => {
        new window.google.translate.TranslateElement({
            pageLanguage: 'en',
            autoDisplay: false,
        }, 'wmt-google-translate');
    };

    const script = document.createElement('script');
    script.dataset.wmtGoogleTranslate = 'true';
    script.src = 'https://translate.google.com/translate_a/element.js?cb=wmtGoogleTranslateInit';
    document.head.append(script);
};

const pricePattern = /\b(AED|USD|GBP|EUR|AUD|CAD|ZAR|INR|PKR|SGD|PHP|BHD|BRL|CNY|DKK|HKD|IDR|JPY|KWD|MYR|MXN|NOK|NZD|OMR|QAR|SAR|SEK|CHF|THB|TRY)\s*([\d,]+(?:\.\d{1,2})?)/g;
const originalPriceText = new WeakMap();
const formatAmount = (amount, currency) => new Intl.NumberFormat(undefined, {
    maximumFractionDigits: currency === 'PKR' || currency === 'INR' ? 0 : 2,
}).format(amount);

const updatePriceText = (node, currency) => {
    const originalText = originalPriceText.get(node) || node.nodeValue;

    if (!originalPriceText.has(node) && !pricePattern.test(originalText)) {
        pricePattern.lastIndex = 0;
        return;
    }

    pricePattern.lastIndex = 0;
    originalPriceText.set(node, originalText);
    node.nodeValue = originalText.replace(pricePattern, (match, sourceCurrency, rawAmount) => {
        const sourceRate = currencyToAed[sourceCurrency];
        const targetRate = currencyToAed[currency];
        const amount = Number(rawAmount.replaceAll(',', ''));

        if (!sourceRate || !targetRate || Number.isNaN(amount)) {
            return match;
        }

        return `${currency} ${formatAmount((amount * sourceRate) / targetRate, currency)}`;
    });
};

const updatePrices = (currency) => {
    const walker = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT, {
        acceptNode(node) {
            if (!node.nodeValue || !pricePattern.test(node.nodeValue) || ['SCRIPT', 'STYLE'].includes(node.parentElement?.tagName)) {
                pricePattern.lastIndex = 0;
                return NodeFilter.FILTER_REJECT;
            }

            pricePattern.lastIndex = 0;
            return NodeFilter.FILTER_ACCEPT;
        },
    });
    const priceNodes = [];
    let node = walker.nextNode();

    while (node) {
        priceNodes.push(node);
        node = walker.nextNode();
    }

    priceNodes.forEach((priceNode) => updatePriceText(priceNode, currency));
};

const updateCurrencyUi = (currency) => {
    const option = currencyOptions.find((item) => item.dataset.currency === currency) || currencyOptions.find((item) => item.dataset.currency === 'PKR');
    const code = option?.dataset.currency || 'PKR';

    if (currencyCurrent) {
        currencyCurrent.textContent = code;
    }

    currencyOptions.forEach((item) => item.classList.toggle('is-selected', item === option));
    updatePrices(code);
};

languageOptions.forEach((option) => {
    option.addEventListener('click', () => {
        const language = option.dataset.language;
        window.localStorage.setItem(languageStorageKey, language);
        updateLanguageUi(language);
        languagePreference?.removeAttribute('open');

        if (language === 'en') {
            clearGoogleTranslationCookie();
        } else {
            setGoogleTranslationCookie(language);
        }

        window.location.reload();
    });
});

currencyOptions.forEach((option) => {
    option.addEventListener('click', () => {
        const currency = option.dataset.currency;
        window.localStorage.setItem(currencyStorageKey, currency);
        updateCurrencyUi(currency);
        currencyPreference?.removeAttribute('open');
    });
});

updateLanguageUi(selectedLanguage());
updateCurrencyUi(window.localStorage.getItem(currencyStorageKey) || 'PKR');

if (selectedLanguage() !== 'en') {
    setGoogleTranslationCookie(selectedLanguage());
    loadGoogleTranslate();
} else {
    clearGoogleTranslationCookie();
}

const priceObserver = new MutationObserver(() => {
    window.clearTimeout(window.wmtPriceRefreshTimer);
    window.wmtPriceRefreshTimer = window.setTimeout(() => updateCurrencyUi(window.localStorage.getItem(currencyStorageKey) || 'PKR'), 80);
});

priceObserver.observe(document.body, { childList: true, subtree: true });
