@extends('layouts.app')

@section('importedStyles')
    @include('includes.datatables-links')
    <link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <style>
        .step {
            display: none;
        }
        .active-step {
            display: block;
        }
    </style>
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
                                    <h3>Creating New Client</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
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
                                    <button type="button" disabled id="client-job-upload" class="stepper-nav text-left btn btn-block btn-outline-primary">
                                        <i class="fa fa-circle-o" aria-hidden="true"></i> Client Job Upload
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
                                    <button type="button" disabled id="client-job-status" class="stepper-nav text-left btn btn-block btn-outline-primary">
                                        <i class="fa fa-circle-o" aria-hidden="true"></i> Client Job Status
                                    </button>
                                    <button type="button" disabled id="account" class="stepper-nav text-left btn btn-block btn-outline-primary">
                                        <i class="fa fa-circle-o" aria-hidden="true"></i> Account
                                    </button>
                                </div>
                                
                                <div class="col-sm-12 col-lg-9">
                                    @include('pages.client-configuration.stepper.client-key-details')
                                    @include('pages.client-configuration.stepper.client-job-upload')
                                    @include('pages.client-configuration.stepper.client-sla-metrics')
                                    @include('pages.client-configuration.stepper.client-measures')
                                    @include('pages.client-configuration.stepper.installers')
                                    @include('pages.client-configuration.stepper.client-job-status')
                                    @include('pages.client-configuration.stepper.account')
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
    <script src="{{ asset('assets/js/client-configuration.js') }}"></script>
@endsection
