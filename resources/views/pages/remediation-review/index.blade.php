@extends('layouts.app')
@section('importedStyles')
    @include('includes.datatables-links')
@endsection
@section('content')
    <!-- Content Header (Page header) -->
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
    <!-- /.content-header -->

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
                                        <th>CAT Measure</th>
                                        <th>Address</th>
                                        <th>Postcode</th>
                                        <th>Non-Comliance Type</th>
                                        <th>Inspection Date</th>
                                        <th>Evidence Submission Date</th>
                                        <th>Remediation Deadline</th>
                                        <th>Reinspect Deadline</th>
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
                                            <td>{{ $job->jobMeasure->measure->measure_cat }}</td>
                                            <td>{{ $job->property->address1 }}</td>
                                            <td>{{ $job->property->postcode }}</td>
                                            <td>{{ $job->job_remediation_type }}</td>
                                            <td>{{ $job->schedule_date }}</td>
                                            <td>{{ $job->remediation->last()?->created_at }}</td>
                                            <td>{{ $job->rework_deadline }}</td>
                                            <td>{{ Carbon\Carbon::parse($job->remediation->last()?->created_at)->addDays(21)->format('Y-m-d H:i:s') }}
                                            </td>
                                            <td>
                                                <a href="{{ route('remediation-review.show', $job->id) }}"
                                                    class="btn btn-primary btn-sm">View Details</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
    <script src="{{ asset('assets/js/global/table.js') }}"></script>
@endsection
