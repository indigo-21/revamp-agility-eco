@extends('layouts.app')

@section('importedStyles')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- daterange picker -->
    {{-- <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}"> --}}
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    @include('includes.datatables-links')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Manage Jobs</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('job.index') }}">Manage Jobs</a>
                        </li>
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
                                    <button type="button" disabled id="client-job-type"
                                        class="stepper-nav text-left btn btn-block btn-primary">
                                        <i class="fa fa-circle-o" aria-hidden="true"></i> Client and Job Type
                                    </button>
                                    <button type="button" disabled id="property-details"
                                        class="stepper-nav text-left btn btn-block btn-outline-primary">
                                        <i class="fa fa-circle-o" aria-hidden="true"></i> Property Details
                                    </button>
                                    <button type="button" disabled id="measures"
                                        class="stepper-nav text-left btn btn-block btn-outline-primary">
                                        <i class="fa fa-circle-o" aria-hidden="true"></i> Measures
                                    </button>
                                    <button type="button" disabled id="job-notes"
                                        class="stepper-nav text-left btn btn-block btn-outline-primary">
                                        <i class="fa fa-circle-o" aria-hidden="true"></i> Job Notes
                                    </button>
                                    {{-- <button type="button" disabled id="job-data"
                                        class="stepper-nav text-left btn btn-block btn-outline-primary">
                                        <i class="fa fa-circle-o" aria-hidden="true"></i> Job Data
                                    </button> --}}
                                </div>

                                <div class="col-sm-12 col-lg-10">
                                    <form id="jobForm"
                                        action="{{ isset($job) ? route('job.update', $job->id) : route('job.store') }}"
                                        method="POST">
                                        @csrf
                                        @if (isset($job))
                                            @method('PUT')
                                        @endif
                                        @include('pages.job.stepper.client-job-type')
                                        @include('pages.job.stepper.property-details')
                                        @include('pages.job.stepper.measures')
                                        @include('pages.job.stepper.job-notes')
                                        {{-- @include('pages.job.stepper.job-data') --}}
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
    <!-- date-range-picker -->
    {{-- <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script> --}}
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    @include('includes.datatables-scripts')
    <script src="{{ asset('assets/js/job-stepper.js') }}"></script>
@endsection
