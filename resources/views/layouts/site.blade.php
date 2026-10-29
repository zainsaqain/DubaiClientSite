<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Waheed Murad Tourism')</title>
    @vite(['resources/css/app.css', 'resources/js/site-shell.js'])
    @stack('page-assets')
</head>
<body class="wmt-site @yield('body-class')">
    @include('components.site.header')
    <main class="site-canvas">@yield('content')</main>
    @include('components.site.footer')
    <a class="floating-whatsapp" href="https://wa.me/971500000000" target="_blank" rel="noopener noreferrer" aria-label="Chat with Waheed Murad Tourism on WhatsApp">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M20.4 11.5a8.25 8.25 0 0 1-12.17 7.28L4 20l1.28-4.02A8.25 8.25 0 1 1 20.4 11.5Z"/><path d="M8.7 8.3c.22-.5.43-.52.65-.53h.55c.17 0 .37.07.44.34l.55 1.52c.08.22.04.45-.1.62l-.43.5c-.13.15-.08.3.02.44.3.51.79 1.12 1.7 1.55.15.07.26.06.36-.05l.56-.66c.14-.17.34-.2.54-.13l1.46.69c.23.11.3.25.27.47-.07.65-.42 1.19-.95 1.48-.3.16-.67.26-1.13.16-1.26-.28-2.9-1.31-4.02-2.6-1.13-1.3-1.73-2.82-1.62-3.82.05-.45.2-.84.38-1.13Z" stroke-linecap="round" stroke-linejoin="round"/></svg>
        <span>Chat on WhatsApp</span>
    </a>
</body>
</html>
