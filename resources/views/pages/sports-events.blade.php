@extends('layouts.desert-adventures')

@section('title', 'Sports Events | Waheed Murad Tourism')

@section('content')
    <x-desert-adventures.catalogue-listing :items="collect($events)" label="Sports Events" title="Sports Events" description="From championship golf to race weekends, discover standout sports experiences across the UAE." />
@endsection
