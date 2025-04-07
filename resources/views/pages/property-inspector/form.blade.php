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
                    <h1 class="m-0">Property Inspector</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('property-inspector.index') }}">Property Inspector</a>
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
                        <div class="card-header">
                            <div class="w-100 d-flex justify-content-between align-items-center">
                                <div class="left w-50">
                                    <h3>Creating New Property Inspector</h3>
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
                                        <div id="progress-bar" class="progress-bar bg-primary" style="width: 14%;">Step 1
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-2">
                                    <button type="button" disabled id="job-skills"
                                        class="stepper-nav text-left btn btn-block btn-primary">
                                        <i class="fa fa-circle-o" aria-hidden="true"></i> Job Skills
                                    </button>
                                    <button type="button" disabled id="photo-and-id"
                                        class="stepper-nav text-left btn btn-block btn-outline-primary">
                                        <i class="fa fa-circle-o" aria-hidden="true"></i> Photo and ID
                                    </button>
                                    <button type="button" disabled id="name-and-address"
                                        class="stepper-nav text-left btn btn-block btn-outline-primary">
                                        <i class="fa fa-circle-o" aria-hidden="true"></i> Name and Address
                                    </button>
                                    <button type="button" disabled id="commercial"
                                        class="stepper-nav text-left btn btn-block btn-outline-primary">
                                        <i class="fa fa-circle-o" aria-hidden="true"></i> Commercial
                                    </button>
                                    <button type="button" disabled id="measures"
                                        class="stepper-nav text-left btn btn-block btn-outline-primary">
                                        <i class="fa fa-circle-o" aria-hidden="true"></i> Measures
                                    </button>
                                    <button type="button" disabled id="qualifications"
                                        class="stepper-nav text-left btn btn-block btn-outline-primary">
                                        <i class="fa fa-circle-o" aria-hidden="true"></i> Qualifications
                                    </button>
                                </div>

                                <div class="col-sm-12 col-lg-10">
                                    <form id="propertyInpectorForm" action="{{ route('property-inspector.store') }}">
                                        @include('pages.property-inspector.stepper.job-skills')
                                        @include('pages.property-inspector.stepper.photo-and-id')
                                        @include('pages.property-inspector.stepper.name-and-address')
                                        @include('pages.property-inspector.stepper.commercial')
                                        @include('pages.property-inspector.stepper.measures')
                                        @include('pages.property-inspector.stepper.qualifications')
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
    <!-- date-range-picker -->
    {{-- <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script> --}}
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/property-inspector-stepper.js') }}"></script>
    @include('includes.datatables-scripts')
@endsection
