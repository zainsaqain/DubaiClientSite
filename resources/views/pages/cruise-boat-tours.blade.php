@extends('layouts.desert-adventures')

@section('title', 'Cruise and Boat Tours | Waheed Murad Tourism')

@section('content')
    <x-desert-adventures.catalogue-listing :items="$items" label="Cruise & Boat Tours" title="Cruise & Boat Tours" description="Discover Dubai from a different angle — from relaxed dhow dinners and marina cruises to exhilarating speedboat journeys." />
@endsection
