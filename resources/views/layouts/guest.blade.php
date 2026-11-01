<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Account Access | Waheed Murad Tourism</title>

        @vite(['resources/css/app.css', 'resources/css/auth.css', 'resources/js/app.js'])
    </head>
    <body class="wmt-auth-body">
        <div class="wmt-auth-shell">
            <section class="wmt-auth-visual" aria-label="Waheed Murad Tourism">
                <a class="wmt-auth-brand" href="{{ route('home') }}">
                    <img src="{{ asset('images/waheed-murad-tourism-logo.jpeg') }}" alt="Waheed Murad Tourism">
                    <span><strong>WAHEED MURAD</strong><small>TOURISM</small></span>
                </a>
                <div class="wmt-auth-visual-copy">
                    <p>WAHEED MURAD TOURISM</p>
                    <h1>Every journey,<br><em>beautifully managed.</em></h1>
                    <span>Dubai experiences, thoughtfully curated for every guest.</span>
                </div>
                <div class="wmt-auth-visual-note"><b>✦</b> Your trusted Dubai travel partner</div>
            </section>

            <main class="wmt-auth-main">
                <a class="wmt-auth-mobile-brand" href="{{ route('home') }}">
                    <img src="{{ asset('images/waheed-murad-tourism-logo.jpeg') }}" alt="Waheed Murad Tourism">
                    <span>WAHEED MURAD <small>TOURISM</small></span>
                </a>
                <div class="wmt-auth-card">{{ $slot }}</div>
            </main>
        </div>
    </body>
</html>
