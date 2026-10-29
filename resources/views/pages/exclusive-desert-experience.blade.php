@extends('layouts.desert-adventures')

@section('title', 'Exclusive Desert Experience | Waheed Murad Tourism')

@section('content')
    <x-desert-adventures.product-detail :product="config('adventure-products.exclusive-desert-experience')" />
@endsection
