@extends('layouts.site')

@section('body-class', 'da-site')

@push('page-assets')
    @vite(['resources/css/desert-adventures/page.css', 'resources/js/desert-adventures/page.js'])
@endpush
