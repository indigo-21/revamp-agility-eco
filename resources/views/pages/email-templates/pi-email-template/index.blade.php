@extends('layouts.app')
@section('importedStyles')
    @include('includes.datatables-links')
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
@endsection
@section('content')

    <x-email-template-index :messageTemplates="$messageTemplates" :url="$url" title="PI Email Templates"/>
    
@endsection
@section('importedScripts')
    @include('includes.datatables-scripts')
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/js/global/table.js') }}"></script>
    <script src="{{ asset('assets/js/global/email.js') }}"></script>
@endsection
