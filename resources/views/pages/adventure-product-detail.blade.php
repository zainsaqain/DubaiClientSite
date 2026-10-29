@php($product = config("adventure-products.{$productKey}"))

@extends('layouts.desert-adventures')

@section('title', $product['title'].' | Waheed Murad Tourism')

@section('content')
    <x-desert-adventures.product-detail :product="$product" />
@endsection
