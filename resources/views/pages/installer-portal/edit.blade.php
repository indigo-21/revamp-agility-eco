@extends('layouts.app')
@section('importedStyles')
    @include('includes.datatables-links')
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/dropzone/min/dropzone.min.css') }}">
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Installer Portal</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"> <a href="{{ route('installer-portal.index') }}">Remediation</a></li>
                        <li class="breadcrumb-item "> <a
                                href="{{ route('installer-portal.show', $completedJob->job->id) }}"> Non-Compliances </a>
                        </li>
                        <li class="breadcrumb-item ">{{ $completedJob->surveyQuestion->question_number }}</li>
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
                <div class="col-7 col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <x-remediation-history :remediations="$remediations" />
                        </div>
                    </div>
                    <!-- /.card -->
                    <div class="card" id="actions">
                        <div class="card-body">
                            <x-textarea name="comment" label="Notes" rows="5" value="" required />
                            @include('includes.upload-image')
                            <input type="hidden" id="completedJobId" name="completedJobId" value="{{ $completedJob->id }}">
                            <input type="hidden" id="jobId" name="jobId" value="{{ $completedJob->job_id }}">
                            <button class="btn btn-primary mt-4 float-right start" type="submit">Submit
                                Remediation</button>
                        </div>
                    </div>

                </div>
                <!-- /.col -->

                <div class="col-5 col-lg-4">
                    <x-job-remediation-details :completedJob="$completedJob" />
                </div>
                <!-- /.col -->
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
@section('importedScripts')
    @include('includes.datatables-scripts')
    <script src="{{ asset('plugins/dropzone/min/dropzone.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/js/installer-portal.js') }}"></script>
@endsection
