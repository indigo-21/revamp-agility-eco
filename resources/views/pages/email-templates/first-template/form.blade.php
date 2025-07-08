@extends('layouts.app')

@section('importedStyles')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
@endsection
@section('content')
    <x-email-template-create :messageTemplate="isset($messageTemplate) ? $messageTemplate : null" :url="$url" title="First Template" :remediationType="true">
        <strong>Installer Name:</strong>
        <p class="text-muted">
            _INSTALLER_NAME_
        </p>

        <hr>

        <strong>Client:</strong>
        <p class="text-muted">
            _CLIENT_
        </p>

        <hr>

        <strong>Cert Number:</strong>
        <p class="text-muted">
            _CERT_NO_
        </p>

        <hr>

        <strong>UMR:</strong>
        <p class="text-muted">
            _UMR_
        </p>

        <hr>

        <strong>Inspection Date:</strong>
        <p class="text-muted">
            _INSPECTION_DATE_
        </p>

        <hr>

        <strong>NC type:</strong>
        <p class="text-muted">
            _NC_TYPE_
        </p>

        <hr>

        <strong>Remediation Deadline:</strong>
        <p class="text-muted">
            _REMEDIATION_DEADLINE_
        </p>

        <hr>

        <strong>Housename Number:</strong>
        <p class="text-muted">
            _HOUSENAME_NUMBER_
        </p>

        <hr>

        <strong>Address Line 1:</strong>
        <p class="text-muted">
            _ADDRESS_LINE_1_
        </p>

        <hr>

        <strong>Postcode:</strong>
        <p class="text-muted">
            _POSTCODE_
        </p>

        <hr>

        <strong>Link:</strong>
        <p class="text-muted">
            _LINK_
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
