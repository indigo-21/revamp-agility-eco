@extends('layouts.app')

@section('importedStyles')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
@endsection
@section('content')
    <x-email-template-create :messageTemplate="isset($messageTemplate) ? $messageTemplate : null" :url="$url" title="Second Template" :remediationType="true">
        <div class="table-responsive">
            <table class="table">
                <tbody>
                    <tr>
                        <th>Installer Name:</th>
                        <td>_INSTALLER_NAME_</td>
                    </tr>
                    <tr>
                        <th>Client:</th>
                        <td>_CLIENT_</td>
                    </tr>
                    <tr>
                        <th>Cert Number:</th>
                        <td>_CERT_NO_</td>
                    </tr>
                    <tr>
                        <th>UMR:</th>
                        <td>_UMR_</td>
                    </tr>
                    <tr>
                        <th>Inspection Date:</th>
                        <td>_INSPECTION_DATE_</td>
                    </tr>
                    <tr>
                        <th>NC type:</th>
                        <td>_NC_TYPE_</td>
                    </tr>
                    <tr>
                        <th>Remediation Deadline:</th>
                        <td>_REMEDIATION_DEADLINE_</td>
                    </tr>
                    <tr>
                        <th>Housename Number:</th>
                        <td>_HOUSENAME_NUMBER_</td>
                    </tr>
                    <tr>
                        <th>Address Line 1:</th>
                        <td>_ADDRESS_LINE_1_</td>
                    </tr>
                    <tr>
                        <th>Postcode:</th>
                        <td>_POSTCODE_</td>
                    </tr>
                    <tr>
                        <th>Link:</th>
                        <td>_LINK_</td>
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
