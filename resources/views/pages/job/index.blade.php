@extends('layouts.app')

@section('importedStyles')
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
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
                        <li class="breadcrumb-item active">Manage Jobs</li>
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
                                        <i class="fas fa-list mr-2"></i>
                                        List of Jobs
                                    </h3>
                                </div>
                                <div class="right">
                                    <div class="btn-group">
                                        <a class="btn btn-white" href="{{ route('job.create') }}">
                                            <i class="fa fa-plus-square mr-1" aria-hidden="true"></i> Add Job
                                        </a>
                                        <button class="btn btn-warning">Upload CSV File</button>
                                        <button class="btn btn-primary">Remove Duplicates</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th colspan="11">Job Details</th>
                                        <th colspan="3">Key Dates</th>
                                        <th rowspan="2">Action</th>
                                    </tr>
                                    <tr>
                                        <th>Job ID</th>
                                        <th>Job Number</th>
                                        <th>Cert#</th>
                                        <th>UMR</th>
                                        <th>Job Status</th>
                                        <th>Property Inspector</th>
                                        <th>Booked Date</th>
                                        <th>Postcode</th>
                                        <th>Installer</th>
                                        <th>Remediation Deadline</th>
                                        <th>NC Level</th>
                                        <th>Close Date</th>
                                        <th>Deadline</th>
                                        <th>Invoice Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jobs as $job)
                                        <tr>
                                            <td>{{ $job->id }}</td>
                                            <td>{{ $job->job_number }}</td>
                                            <td>{{ $job->cert_no }}</td>
                                            <td>{{ $job->jobMeasure?->umr }}</td>
                                            <td>{{ $job->jobStatus->description }}</td>
                                            <td>{{ $job->propertyInspector?->user->firstname }}
                                                {{ $job->propertyInspector?->user->lastname }}</td>
                                            <td>{{ $job->booked_date }}</td>
                                            <td>{{ $job->property->postcode }}</td>
                                            <td>{{ $job->installer?->user->firstname }}</td>
                                            <td>{{ $job->rework_deadline }}</td>
                                            <td>{{ $job->job_remediation_type }}</td>
                                            <td>{{ $job->close_date }}</td>
                                            <td>{{ $job->deadline }}</td>
                                            <td>{{ $job->invoice_status }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('job.show', $job->id) }}"
                                                        class="btn btn-info btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    {{-- <a href="{{ route('job.edit', $job->id) }}"
                                                        class="btn btn-primary btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a> --}}
                                                    <form action="{{ route('job.destroy', $job->id) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Are you sure you want to delete this job?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
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
    <script>
        var toastType = @json(session('success'));
    </script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    @include('includes.datatables-scripts')
    <script src="{{ asset('assets/js/job.js') }}"></script>
@endsection
