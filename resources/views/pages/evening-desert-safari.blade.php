@extends('layouts.desert-adventures')

@section('title', 'Evening Desert Safari | Waheed Murad Tourism')

@section('content')
    <x-desert-adventures.product-detail :product="$product ?? config('adventure-products.evening-desert-safari')" />
@endsection
