@extends('layouts.desert-adventures')

@section('title', 'Transfers | Waheed Murad Tourism')

@section('content')
    <x-desert-adventures.catalogue-listing :items="$items" label="Transfers" title="Private Transfers" description="From airport arrivals to private journeys beyond Dubai, travel in comfort with dependable door-to-door service." />
@endsection
