const menuButton = document.querySelector('.menu-toggle');
const mobileNavigation = document.querySelector('.mobile-navigation');
const mobileDesertMenuTrigger = document.querySelector('.mobile-menu-trigger');
const mobileDesertSubmenu = document.querySelector('.mobile-submenu-panel');
const desktopMediaQuery = window.matchMedia('(min-width: 901px)');
const megaMenuItems = Array.from(document.querySelectorAll('[data-mega-menu], [data-attractions-mega-menu], [data-city-tours-mega-menu], [data-why-us-mega-menu]'));

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

const openMobileDesertMenu = () => {
    if (!mobileNavigation || !mobileDesertSubmenu) {
        return;
    }

    mobileNavigation.classList.add('is-submenu-open');
    mobileDesertMenuTrigger?.setAttribute('aria-expanded', 'true');
    mobileDesertSubmenu.setAttribute('aria-hidden', 'false');
};

const closeMobileDesertMenu = () => {
    mobileNavigation?.classList.remove('is-submenu-open');
    mobileDesertMenuTrigger?.setAttribute('aria-expanded', 'false');
    mobileDesertSubmenu?.setAttribute('aria-hidden', 'true');
};

const closeMobileNavigation = () => {
    closeMobileDesertMenu();
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

mobileDesertMenuTrigger?.addEventListener('click', openMobileDesertMenu);
document.querySelector('.mobile-menu-back')?.addEventListener('click', closeMobileDesertMenu);

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

    trigger?.addEventListener('click', () => {
        if (desktopMediaQuery.matches) {
            const isOpen = item.classList.contains('is-open');
            closeMegaMenus(item);
            setMegaMenuState(item, !isOpen);
        }
    });

    trigger?.addEventListener('keydown', (event) => {
        if (event.key === 'ArrowDown') {
            event.preventDefault();
            closeMegaMenus(item);
            setMegaMenuState(item, true);
            item.querySelector('.mega-menu a')?.focus();
        }
    });
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
