@extends('layouts.app')

@section('importedStyles')
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
    @include('includes.datatables-links')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
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
                                        <x-button-permission type="create" :permission="$userPermission" as="a"
                                            :href="route('job.create')" class="btn btn-white" label="Add Job" />
                                        <x-button-permission type="create" :permission="$userPermission" class="btn btn-warning"
                                            label="Upload CSV File" data-toggle="modal" data-target="#uploadJobCsv" />
                                        <x-button-permission type="delete" :permission="$userPermission" class="btn btn-primary"
                                            label="Remove Duplicates" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
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
                                                    <td>
                                                        <span class="right badge badge-{{ $job->jobStatus->color_scheme }}">
                                                            {{ $job->jobStatus->description }}
                                                        </span>
                                                    </td>
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
                                                        <form action="{{ route('job.destroy', $job->id) }}" method="POST"
                                                            class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <div class="btn-group">
                                                                <x-button-permission type="update" :permission="$userPermission"
                                                                    as="a" :href="route('job.show', $job->id)"
                                                                    class="btn btn-info btn-sm" label="Edit" />
                                                                <x-button-permission type="delete" :permission="$userPermission"
                                                                    class="btn btn-danger btn-sm" label="Delete" />
                                                            </div>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <!-- Modal -->
    <div class="modal fade" id="uploadJobCsv" role="dialog" aria-labelledby="uploadJobCsvTitle" aria-hidden="true">
        <div class="modal-dialog " role="document">

            <form action="{{ route('job.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="uploadJobCsvTitle">Upload CSV File</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <p>
                                    <i>Download the sample file to see the correct structure of the .csv file.
                                        <a href="#" download="Sample_CSV.csv">Sample
                                            CSV
                                        </a>
                                    </i>
                                </p>
                            </div>
                            <div class="col-md-12">
                                <x-select label="Client" name="client_id" :multiple="false">
                                    <option value="" selected="selected" disabled>- Select Client -</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->client_abbrevation }}</option>
                                    @endforeach
                                </x-select>

                                <x-select label="Job Type" name="job_type_id" :multiple="false">
                                    <option value="" selected="selected" disabled>- Select Job Type -</option>
                                </x-select>

                                <x-file name="file" label="Select CSV" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Upload Job</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('importedScripts')
    <script>
        var toastType = @json(session('success'));
    </script>
    <!-- Select2 -->
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    @include('includes.datatables-scripts')
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

    <script src="{{ asset('assets/js/job.js') }}"></script>
@endsection
