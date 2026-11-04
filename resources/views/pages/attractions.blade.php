@extends('layouts.desert-adventures')

@section('title', 'Dubai Attractions | Waheed Murad Tourism')

@section('content')
    <x-desert-adventures.catalogue-listing :items="collect($attractions)" label="Attractions" title="Dubai Attractions" description="Discover Dubai’s unforgettable landmarks, thrilling views and family-friendly experiences — all in one easy place." />
@endsection
