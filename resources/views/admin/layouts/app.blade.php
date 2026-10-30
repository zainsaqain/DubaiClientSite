<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Waheed Murad Tourism administration dashboard">
    <title>@yield('title', 'Admin Dashboard') | Waheed Murad Tourism</title>
    @vite('resources/css/admin-dashboard.css')
</head>
<body class="wmt-admin-body">
    @yield('content')
</body>
</html>
