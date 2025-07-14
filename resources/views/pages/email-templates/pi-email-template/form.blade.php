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
        <div class="table-responsive">
            <table class="table">
                <tbody>
                    <tr>
                        <th>Start Date</th>
                        <td>_START_DATE_</td>
                    </tr>
                    <tr>
                        <th>End Date</th>
                        <td>_END_DATE_</td>
                    </tr>
                    <tr>
                        <th>PI Name</th>
                        <td>_PI_NAME_</td>
                    </tr>
                    <tr>
                        <th>Reason</th>
                        <td>_REASON_</td>
                    </tr>
                </tbody>
            </table>
        </div>
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
