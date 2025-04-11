@extends('layouts.app')
@section('importedStyles')
    @include('includes.datatables-links')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <style>
        .vertical-center {
            vertical-align: middle !important;
        }
    </style>
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Measure Configuration</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Measure Configuration</li>
                        <li class="breadcrumb-item active">{{ isset($measure) ? 'Edit Measure' : 'Add Measure' }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <div class="w-100 d-flex justify-content-between align-items-center">
                                <div class="left">
                                    <h3 class="card-title">
                                        <i class="fa fa-pencil-alt mr-2"></i>
                                        {{ isset($measure) ? 'Edit Measure' : 'Add Measure' }}
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <form id="measureForm"  method="POST"
                        action="{{ isset($measure) ? route('measure.update', $measure) : route('measure.store') }}">
                            @csrf
                            @if(isset($measure))
                                @method('PUT')
                             @endif
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <x-input name="measure_cat" label="Measure CAT" value="{{ isset($measure) ? $measure->measure_cat : '' }}" />
                                            </div>
                                            <div class="col-md-6">
                                                <x-yes-no-select name="cert_required" label="Measure Cert Required" value="{{ isset($measure) ? $measure->cert_required : '' }}" />

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <x-input name="measure_min_qual" label="Measure Min Qual" value="{{ isset($measure) ? $measure->measure_min_qual : '' }}" />
                                            </div>
                                            <div class="col-md-6">
                                                <x-input name="measure_duration" label="Measure Duration" value="{{ isset($measure) ? $measure->measure_duration : '' }}" />

                                            </div>
                                        </div>
                                      
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <x-textarea name="cert_description" label="Measure Cert Description" rows="5" value="{{ isset($measure) ? $measure->cert_description : '' }}" />
                                        </div>
                                        <div class="row">
                                            <x-textarea name="cert_remediation_advice" label="Measure Cert Remediation Advice" rows="5" value="{{ isset($measure) ? $measure->cert_remediation_advice : '' }}" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <a href="{{ route('measure.index') }}"><button type="button" class="btn btn-danger">Cancel</button></a>
                                <button type="submit" class="btn btn-primary" id="submitBtn">{{ isset($measure) ? 'Update' : 'Create'}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
@section('importedScripts')
    @include('includes.datatables-scripts')
    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
@endsection