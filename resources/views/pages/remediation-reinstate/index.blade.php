@extends('layouts.app')
@section('importedStyles')
    @include('includes.datatables-links')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Toastr -->
    {{-- <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}"> --}}
@endsection
@section('content')
    <x-title-breadcrumbs title="Remediation Reinstate" :breadcrumbs="[
        ['title' => 'Dashboard', 'route' => '/', 'active' => ''],
        ['title' => 'Remediation', 'route' => '', 'active' => 'active'],
        ['title' => 'Remedation Reinstate', 'route' => '', 'active' => 'active'],
    ]" />
    {{-- <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Remediation Review</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Remediation</li>
                        <li class="breadcrumb-item active">Remediation Review</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header --> --}}

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <div class="w-100 d-flex justify-content-between align-items-center">
                                <div class="left">
                                    <h3 class="card-title">
                                        <i class="fas fa-list mr-2"></i>
                                        List of Inspected Jobs with Identified Non-Comliance
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="remediationReviewTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Job Number</th>
                                        <th>Job Status</th>
                                        <th>Cert No</th>
                                        <th>UMR</th>
                                        <th>Installer</th>
                                        <th>Address</th>
                                        <th>Postcode</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jobs as $job)
                                        <tr>
                                            <td>{{ $job->job_number }}</td>
                                            <td>
                                                <span class="right badge badge-{{ $job->jobStatus->color_scheme }}">
                                                    {{ $job->jobStatus->description }}
                                                </span>
                                            </td>
                                            <td>{{ $job->cert_no }}</td>
                                            <td>{{ $job->jobMeasure->umr }}</td>
                                            <td>{{ $job->installer->user->firstname }}</td>
                                            <td>{{ $job->property->address1 }}</td>
                                            <td>{{ $job->property->postcode }}</td>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <x-button-permission type="create" :permission="$userPermission"
                                                        class="btn btn-primary btn-sm reinstateJob" label="Reinstate Job"
                                                        data-id="{{ $job->id }}" />
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
    {{-- <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script> --}}
    <script src="{{ asset('assets/js/global/table.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Toastr -->
    {{-- <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script> --}}
    <script src="{{ asset('assets/js/remediation-reinstate.js') }}"></script>
@endsection
