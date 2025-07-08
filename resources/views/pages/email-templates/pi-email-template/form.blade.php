@extends('layouts.app')

@section('importedStyles')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
@endsection
@section('content')
    <x-email-template-create :messageTemplate="isset($messageTemplate) ? $messageTemplate : null" :url="$url" title="PI Email Template">
        <strong>Start Date</strong>
        <p class="text-muted">
            _START_DATE_
        </p>

        <hr>

        <strong>End Date</strong>
        <p class="text-muted">
            _END_DATE_
        </p>

        <hr>

        <strong>PI Name</strong>
        <p class="text-muted">
            _PI_NAME_
        </p>

        <hr>

        <strong>Reason</strong>
        <p class="text-muted">
            _REASON_
        </p>

        <hr>
    </x-email-template-create>
@endsection
@section('importedScripts')
    <!-- Select2 -->
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('assets/js/global/email-template.js') }}"></script>
@endsection
