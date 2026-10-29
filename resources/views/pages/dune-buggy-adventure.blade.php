@extends('layouts.desert-adventures')

@section('title', 'Dune Buggy Adventure | Waheed Murad Tourism')

@section('content')
    <x-desert-adventures.product-detail :product="config('adventure-products.dune-buggy-adventure')" />
@endsection
