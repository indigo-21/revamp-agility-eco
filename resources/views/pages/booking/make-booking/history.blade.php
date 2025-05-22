@extends('layouts.app')

{{-- @section('importedStyles')
    <link rel="stylesheet" href="{{ asset('plugins/fullcalendar/main.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@endsection --}}

@section('content')
    <x-title-breadcrumbs title="History" :breadcrumbs="[
        ['title' => 'Dashboard', 'route' => '/', 'active' => ''],
        ['title' => 'Make Booking', 'route' => route('make-booking.index'), 'active' => ''],
        ['title' => 'History', 'route' => '', 'active' => 'active'],
    ]" />

    @include('pages.booking.history-content')
    
@endsection

{{-- @section('importedScripts')
    <!-- fullCalendar 2.2.5 -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/fullcalendar/main.js') }}"></script>
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('assets/js/make-booking.js') }}"></script>
@endsection --}}
