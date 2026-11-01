const sidebar = document.querySelector('[data-admin-sidebar]');
const toggle = document.querySelector('[data-admin-sidebar-toggle]');
const closeButton = document.querySelector('[data-admin-sidebar-close]');
const overlay = document.querySelector('[data-admin-sidebar-overlay]');

if (sidebar && toggle && closeButton && overlay) {
    const setOpen = (isOpen) => {
        document.documentElement.classList.toggle('wmt-admin-menu-open', isOpen);
        toggle.setAttribute('aria-expanded', String(isOpen));
        toggle.setAttribute('aria-label', isOpen ? 'Close admin menu' : 'Open admin menu');
    };

    toggle.addEventListener('click', () => {
        setOpen(!document.documentElement.classList.contains('wmt-admin-menu-open'));
    });

    closeButton.addEventListener('click', () => setOpen(false));
    overlay.addEventListener('click', () => setOpen(false));

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            setOpen(false);
        }
    });

    sidebar.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', () => {
            if (window.matchMedia('(max-width: 840px)').matches) {
                setOpen(false);
            }
        });
    });

    window.addEventListener('resize', () => {
        if (!window.matchMedia('(max-width: 840px)').matches) {
            setOpen(false);
        }
    });
}
