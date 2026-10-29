@props(['icon'])

@switch($icon)
    @case('landmark')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 2L2 7h20L12 2z"/>
            <path d="M4 11v8"/>
            <path d="M8 11v8"/>
            <path d="M12 11v8"/>
            <path d="M16 11v8"/>
            <path d="M20 11v8"/>
            <path d="M2 22h20"/>
            <path d="M2 11h20"/>
        </svg>
        @break

    @case('dunes')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"/>
            <polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/>
        </svg>
        @break

    @case('calendar-check')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
            <line x1="16" y1="2" x2="16" y2="6"/>
            <line x1="8" y1="2" x2="8" y2="6"/>
            <line x1="3" y1="10" x2="21" y2="10"/>
            <path d="m9 16 2 2 4-4"/>
        </svg>
        @break

    @case('route')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="6" cy="19" r="3"/>
            <path d="M9 19h8.5a3.5 3.5 0 0 0 0-7h-11a3.5 3.5 0 0 1 0-7H15"/>
            <circle cx="18" cy="5" r="3"/>
        </svg>
        @break

    @case('badge-check')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 2l2.4 2.5 3.4-.4 1.2 3.2 3.2 1.2-.4 3.4L24 14.3l-2.4 2.5.4 3.4-3.2 1.2-1.2 3.2-3.4-.4L12 26.6l-2.4-2.4-3.4.4-1.2-3.2-3.2-1.2.4-3.4L0 14.3l2.4-2.5-.4-3.4 3.2-1.2 1.2-3.2 3.4.4L12 2z"/>
            <path d="m8.5 12.5 2.5 2.5 5-5"/>
        </svg>
        @break

    @case('map-pin')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
            <circle cx="12" cy="10" r="3"/>
        </svg>
        @break

    @case('sparkles')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m12 3-1.9 5.8a2 2 0 0 1-1.3 1.3L3 12l5.8 1.9a2 2 0 0 1 1.3 1.3L12 21l1.9-5.8a2 2 0 0 1 1.3-1.3L21 12l-5.8-1.9a2 2 0 0 1-1.3-1.3L12 3z"/>
        </svg>
        @break

    @case('users')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
        </svg>
        @break

    @case('ticket')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"/>
            <path d="M13 5v2"/>
            <path d="M13 11v2"/>
            <path d="M13 17v2"/>
        </svg>
        @break

    @case('camel')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M4 18h16"/>
            <path d="M6 18v-4l2-2 3 1 2-2 3 1 2-2h2v4l-2 2v2"/>
            <circle cx="20" cy="9" r="1.5"/>
            <path d="M10 18v-3"/>
            <path d="M14 18v-3"/>
        </svg>
        @break

    @case('sun-dunes')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="7" r="4"/>
            <path d="M2 20c3-2 6-2 9 0s6 2 11 0"/>
            <path d="M5 16c2.5-1.5 5.5-1.5 8 0s5 1.5 9 0"/>
        </svg>
        @break

    @case('utensils')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 2v6a3 3 0 0 1-3 3 3 3 0 0 1-3-3V2"/>
            <path d="M15 11v11"/>
            <path d="M6 2v20"/>
            <path d="M6 6h4a2 2 0 0 0 2-2V2H4v2a2 2 0 0 0 2 2z"/>
        </svg>
        @break

    @default
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"/>
            <path d="m9 12 2 2 4-4"/>
        </svg>
@endswitch
