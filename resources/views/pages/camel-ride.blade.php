@extends('layouts.desert-adventures')

@section('title', 'Camel Ride in Dubai | Waheed Murad Tourism')

@section('content')
    <x-desert-adventures.product-detail :product="config('adventure-products.camel-ride')" />
@endsection
