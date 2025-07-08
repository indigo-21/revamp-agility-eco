@extends('layouts.app')
@section('importedStyles')
    @include('includes.datatables-links')
@endsection
@section('content')
        <x-email-template-index :messageTemplates="$messageTemplates" :url="$url" title="Remediation Template" />

@endsection
@section('importedScripts')
    @include('includes.datatables-scripts')
    <script src="{{ asset('assets/js/global/table.js') }}"></script>
@endsection
