@extends('layouts.desert-adventures')

@section('title', 'Morning Desert Adventure | Waheed Murad Tourism')

@section('content')
    <x-desert-adventures.product-detail :product="config('adventure-products.morning-desert-adventure')" />
@endsection
