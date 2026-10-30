<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" dir="ltr" data-pc-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Datta Able Bootstrap admin dashboard">
    <title>@yield('title', 'Dashboard') | {{ config('app.name', 'Dubai Tourism') }}</title>

    <link rel="icon" href="{{ asset('vendor/dattaable/assets/images/favicon.svg') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/dattaable/assets/fonts/phosphor/duotone/style.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/dattaable/assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/dattaable/assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/dattaable/assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/dattaable/assets/fonts/material.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/dattaable/assets/css/style.css') }}" id="main-style-link">
    @stack('styles')
</head>
<body>
    <div class="loader-bg fixed inset-0 bg-white dark:bg-themedark-cardbg z-[1034]">
        <div class="loader-track h-[5px] w-full inline-block absolute overflow-hidden top-0">
            <div class="loader-fill w-[300px] h-[5px] bg-primary-500 absolute top-0 left-0 animate-[hitZak_0.6s_ease-in-out_infinite_alternate]"></div>
        </div>
    </div>

    @include('admin.layouts.sidebar')
    @include('admin.layouts.header')

    @yield('content')

    <footer class="pc-footer">
        <div class="footer-wrapper container-fluid mx-10">
            <div class="grid grid-cols-12 gap-1.5">
                <div class="col-span-12 sm:col-span-6 my-1">
                    <p class="m-0">Dubai Tourism administration</p>
                </div>
                <div class="col-span-12 sm:col-span-6 my-1 justify-self-end">
                    <p class="inline-block max-sm:mr-3 sm:ml-2">Built with Datta Able</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="{{ asset('vendor/dattaable/assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('vendor/dattaable/assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/dattaable/assets/js/icon/custom-icon.js') }}"></script>
    <script src="{{ asset('vendor/dattaable/assets/js/plugins/feather.min.js') }}"></script>
    <script src="{{ asset('vendor/dattaable/assets/js/component.js') }}"></script>
    <script src="{{ asset('vendor/dattaable/assets/js/theme.js') }}"></script>
    <script src="{{ asset('vendor/dattaable/assets/js/script.js') }}"></script>
    <script>
        layout_change('false');
        layout_theme_sidebar_change('dark');
        change_box_container('false');
        layout_caption_change('true');
        layout_rtl_change('false');
        preset_change('preset-1');
        main_layout_change('vertical');
    </script>
    @stack('scripts')
</body>
</html>
