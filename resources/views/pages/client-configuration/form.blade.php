@extends('layouts.app')

@section('importedStyles')
    @include('includes.datatables-links')
    <link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{asset('plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css')}}">
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    
    @include('includes.datatables-links')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Client Configuration</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('client-configuration.index')}}">Client Configuration</a></li>
                        <li class="breadcrumb-item active">Create Form</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="w-100 d-flex justify-content-between align-items-center">
                                <div class="left w-50">
                                    <h3>
                                        @if (isset($client))
                                            Update 
                                        @else
                                            Creating New
                                        @endif
                                        Client
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div id="formAlert" class="alert d-none" role="alert"></div>
                                </div>
                                 <div class="col-12">
                                    <!-- Progress Bar -->
                                    <div class="progress w-100 mb-4">
                                        <div id="progress-bar" class="progress-bar bg-primary" style="width: 14%;">Step 1</div>
                                    </div>
                                 </div>
                                <div class="col-sm-12 col-lg-3">
                                    <button type="button" disabled id="client-key-details" class="stepper-nav text-left btn btn-block btn-primary">
                                        <i class="fa fa-circle-o" aria-hidden="true"></i> Client Key Details
                                    </button>
                                    <button type="button" disabled id="client-sla-metrics" class="stepper-nav text-left btn btn-block btn-outline-primary">
                                        <i class="fa fa-circle-o" aria-hidden="true"></i> Client SLA Metrics
                                    </button>
                                    <button type="button" disabled id="client-measures" class="stepper-nav text-left btn btn-block btn-outline-primary">
                                        <i class="fa fa-circle-o" aria-hidden="true"></i> Client Measures
                                    </button>
                                    <button type="button" disabled id="installers" class="stepper-nav text-left btn btn-block btn-outline-primary">
                                        <i class="fa fa-circle-o" aria-hidden="true"></i> Installers
                                    </button>
                                    
                                    
                                </div>
                                
                                <div class="col-sm-12 col-lg-9">
                                    <form id="clientConfigurationForm" action="{{ isset($client) ? route('client-configuration.update', $client->id) : route('client-configuration.store') }}" clientid="{{isset($client) ? $client->id : "" }}">
                                        @include('pages.client-configuration.stepper.client-key-details')
                                        @include('pages.client-configuration.stepper.client-sla-metrics')
                                        @include('pages.client-configuration.stepper.client-measures')
                                        @include('pages.client-configuration.stepper.installers')
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
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script src="{{asset('plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js')}}"></script>
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/property-inspector-stepper.js') }}"></script> --}}
    <script src="{{ asset('assets/js/client-configuration-form.js') }}"></script>
    <script src="{{ asset('assets/js/global/validation.js') }}"></script>
@endsection
