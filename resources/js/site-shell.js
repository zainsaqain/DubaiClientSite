const menuButton = document.querySelector('.menu-toggle');
const mobileNavigation = document.querySelector('.mobile-navigation');
const mobileDesertMenuTrigger = document.querySelector('.mobile-menu-trigger');
const mobileDesertSubmenu = document.querySelector('.mobile-submenu-panel');
const megaMenuItem = document.querySelector('[data-mega-menu]');
const megaMenuTrigger = megaMenuItem?.querySelector('.nav-trigger');
const desktopMediaQuery = window.matchMedia('(min-width: 901px)');

let megaMenuCloseTimer;

const setMegaMenuState = (isOpen) => {
    if (!megaMenuItem || !megaMenuTrigger) {
        return;
    }

    megaMenuItem.classList.toggle('is-open', isOpen);
    megaMenuTrigger.setAttribute('aria-expanded', String(isOpen));
};

const closeMegaMenu = () => {
    window.clearTimeout(megaMenuCloseTimer);
    setMegaMenuState(false);
};

const scheduleMegaMenuClose = () => {
    window.clearTimeout(megaMenuCloseTimer);
    megaMenuCloseTimer = window.setTimeout(closeMegaMenu, 140);
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

megaMenuItem?.addEventListener('mouseenter', () => {
    if (desktopMediaQuery.matches) {
        window.clearTimeout(megaMenuCloseTimer);
        setMegaMenuState(true);
    }
});

megaMenuItem?.addEventListener('mouseleave', () => {
    if (desktopMediaQuery.matches) {
        scheduleMegaMenuClose();
    }
});

megaMenuItem?.addEventListener('focusin', () => {
    if (desktopMediaQuery.matches) {
        window.clearTimeout(megaMenuCloseTimer);
        setMegaMenuState(true);
    }
});

megaMenuItem?.addEventListener('focusout', (event) => {
    if (desktopMediaQuery.matches && !megaMenuItem.contains(event.relatedTarget)) {
        scheduleMegaMenuClose();
    }
});

megaMenuTrigger?.addEventListener('click', () => {
    if (desktopMediaQuery.matches) {
        setMegaMenuState(!megaMenuItem.classList.contains('is-open'));
    }
});

megaMenuTrigger?.addEventListener('keydown', (event) => {
    if (event.key === 'ArrowDown') {
        event.preventDefault();
        setMegaMenuState(true);
        megaMenuItem?.querySelector('.mega-menu a')?.focus();
    }
});

document.addEventListener('click', (event) => {
    if (megaMenuItem && !megaMenuItem.contains(event.target)) {
        closeMegaMenu();
    }
});

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
        if (megaMenuItem?.classList.contains('is-open')) {
            closeMegaMenu();
            megaMenuTrigger?.focus();
        }

        if (mobileNavigation?.classList.contains('is-open')) {
            closeMobileNavigation();
        }
    }
});

desktopMediaQuery.addEventListener('change', closeMegaMenu);
