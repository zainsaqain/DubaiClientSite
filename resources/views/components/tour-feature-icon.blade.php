@props(['name' => null])

@switch($name)
    @case('transfer')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M5 17h14M4 11l2-4h12l2 4M6 14h.01M18 14h.01M3 11v6h18v-6"/></svg>
        @break
    @case('dune')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M2 18c4-4 8 2 12-2s6-2 8 0M3 12c3-3 6 1 10-2s5-1 8 1"/></svg>
        @break
    @case('tent')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="m12 3 10 17H2L12 3Zm0 0v17M7 20l5-8 5 8"/></svg>
        @break
    @case('sun')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/></svg>
        @break
    @case('falcon')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M16 4s2 3 0 6c3 0 5 3 5 6-3 0-6-2-8-5 0 3-2 6-5 7 1-4 3-6 5-8-2 0-4-2-4-4 2 1 4 0 5-2 1 0 3-1 7 0Z"/></svg>
        @break
    @case('wildlife')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M6 3v5l3 3h6l3-3V3M9 8h6M8 11v6l4 4 4-4v-6"/></svg>
        @break
    @case('camel')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M4 18v-4c0-2 1-3 3-3 1 0 2 1 3 2 1-2 2-3 4-3s3 1 4 3v5M8 18v4M16 18v4M4 11V7l3-3h3v3"/></svg>
        @break
    @case('sandboard')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="5" r="2"/><path d="m15 11-3-2-3 2v4l3-1 3 1v-4ZM5 20c4-1 10-1 14 0"/></svg>
        @break
    @case('walk')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="13" cy="4" r="2"/><path d="m10 21 2-6 3 2v4M14 9l-3 4-3-2-2 4"/></svg>
        @break
    @case('stars')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M12 3a9 9 0 1 0 9 9c0-.46-.04-.92-.1-1.36a5.389 5.389 0 0 1-4.4 2.26 5.403 5.403 0 0 1-3.14-9.8c.44-.06.9-.1 1.36-.1h-2.72Z"/><path d="M19 5v4M21 7h-4"/></svg>
        @break
    @case('bbq')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M4 10h16a8 8 0 0 1-16 0ZM7 10V4M12 10V4M17 10V4M6 18l-2 3M18 18l2 3M12 18v3"/></svg>
        @break
    @case('drinks')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M6 4h12l-2 15a2 2 0 0 1-2 2H10a2 2 0 0 1-2-2L6 4ZM5 4h14M12 2v2"/></svg>
        @break
    @default
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="m12 3 2.05 5.95L20 11l-5.95 2.05L12 19l-2.05-5.95L4 11l5.95-2.05L12 3Z"/></svg>
@endswitch
