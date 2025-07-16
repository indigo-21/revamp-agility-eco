@extends('layouts.app')

@section('importedStyles')
    @include('includes.datatables-links')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">

    @include('includes.datatables-links')
@endsection

@section('content')
    <x-title-breadcrumbs title="Client Configuration" :breadcrumbs="[
        ['title' => 'Dashboard', 'route' => '/', 'active' => ''],
        ['title' => 'Client Configuration', 'route' => '/client-configuration', 'active' => ''],
        ['title' => 'Client Form', 'route' => '', 'active' => 'active'],
    ]" />

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div id="formAlert" class="alert d-none" role="alert"></div>
                                </div>
                                <div class="col-12">
                                    <!-- Progress Bar -->
                                    <div class="progress w-100 mb-4">
                                        <div id="progress-bar" class="progress-bar bg-primary" style="width: 14%;">Step 1
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-2">
                                    <button type="button" disabled id="client-key-details"
                                        class="stepper-nav text-left btn btn-block btn-primary">
                                        <i class="fa fa-circle-o" aria-hidden="true"></i> Client Key Details
                                    </button>
                                    <button type="button" disabled id="client-sla-metrics"
                                        class="stepper-nav text-left btn btn-block btn-outline-primary">
                                        <i class="fa fa-circle-o" aria-hidden="true"></i> Client SLA Metrics
                                    </button>
                                    <button type="button" disabled id="client-measures"
                                        class="stepper-nav text-left btn btn-block btn-outline-primary">
                                        <i class="fa fa-circle-o" aria-hidden="true"></i> Client Measures
                                    </button>
                                    <button type="button" disabled id="installers"
                                        class="stepper-nav text-left btn btn-block btn-outline-primary">
                                        <i class="fa fa-circle-o" aria-hidden="true"></i> Installers
                                    </button>


                                </div>

                                <div class="col-sm-12 col-lg-10">
                                    <form method="POST" id="clientConfigurationForm"
                                        action="{{ isset($client) ? route('client-configuration.update', $client->id) : route('client-configuration.store') }}">
                                        @csrf
                                        @if (isset($client))
                                            @method('PUT')
                                        @endif
                                        @include('pages.platform-configuration.client-configuration.stepper.client-key-details')
                                        @include('pages.platform-configuration.client-configuration.stepper.client-sla-metrics')
                                        @include('pages.platform-configuration.client-configuration.stepper.client-measures')
                                        @include('pages.platform-configuration.client-configuration.stepper.installers')
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    </section>
    <!-- /.content -->
@endsection

@section('importedScripts')
    @include('includes.datatables-scripts')
    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('assets/js/client-configuration-form.js') }}"></script>
@endsection
