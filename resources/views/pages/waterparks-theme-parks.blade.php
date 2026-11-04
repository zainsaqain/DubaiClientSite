@extends('layouts.desert-adventures')

@section('title', 'Waterparks & Theme Parks | Waheed Murad Tourism')

@section('content')
    <x-desert-adventures.catalogue-listing :items="$items" label="Waterparks & Theme Parks" title="Waterparks & Theme Parks" description="Make every day in Dubai more memorable with splash-filled adventures, thrilling rides and attractions for every age." />
@endsection
