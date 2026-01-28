@extends('layouts.app')

@section('importedStyles')
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
    @include('includes.datatables-links')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/queue-progress.css') }}">
@endsection

@section('content')
    <x-title-breadcrumbs title="Manage Jobs" :breadcrumbs="[
        ['title' => 'Dashboard', 'route' => '/', 'active' => ''],
        ['title' => 'Manage Jobs', 'route' => '', 'active' => 'active'],
    ]" />

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-8">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Filter</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i></button>
                            </div>
                        </div>

                        <div class="card-body" style="display: block;">
                            <form method="GET" action="{{ route('job.index') }}" id="filterForm">
                                @csrf
                                <div class="row mb-5">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <x-select label="Job Status" name="job_status_id" :multiple="false">
                                                    <option value="" {{ request('job_status_id') ? '' : 'selected' }}
                                                        disabled>-
                                                        Select Job Status
                                                        -
                                                    </option>
                                                    @foreach ($jobStatuses as $jobStatus)
                                                        <option value="{{ $jobStatus->id }}"
                                                            {{ request('job_status_id') == $jobStatus->id ? 'selected' : '' }}>
                                                            {{ $jobStatus->description }}
                                                        </option>
                                                    @endforeach
                                                </x-select>
                                            </div>
                                            <div class="col-md-6">
                                                <x-select label="Client" name="client" :multiple="false">
                                                    <option value="" disabled
                                                        {{ request('client') ? '' : 'selected' }}>- Select Client -
                                                    </option>
                                                    @foreach ($clients as $client)
                                                        <option value="{{ $client->id }}"
                                                            {{ request('client') == $client->id ? 'selected' : '' }}>
                                                            {{ $client->user->firstname }}
                                                            {{ $client->user->lastname }}
                                                        </option>
                                                    @endforeach
                                                </x-select>
                                            </div>
                                            <div class="col-md-6">
                                                <x-select label="Outward Postcode" name="outward_postcode"
                                                    :multiple="false">
                                                    <option value="" disabled
                                                        {{ request('outward_postcode') ? '' : 'selected' }}>- Select
                                                        Outward Postcode -</option>
                                                    @foreach ($outwardPostcodes as $outwardPostcode)
                                                        <option value="{{ $outwardPostcode->name }}"
                                                            {{ request('outward_postcode') == $outwardPostcode->name ? 'selected' : '' }}>
                                                            {{ $outwardPostcode->name }}
                                                        </option>
                                                    @endforeach
                                                </x-select>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Date Created:</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="far fa-calendar-alt"></i>
                                                            </span>
                                                        </div>
                                                        <input type="text" class="form-control float-right"
                                                            id="jobDateRange" name="job_date_range"
                                                            value="{{ request('job_date_range') }}">
                                                    </div>
                                                    <!-- /.input group -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-3">
                                                <x-radio label="Open Jobs" name="job_filter" id="open_jobs"
                                                    :value="1" :checked="request('job_filter') == 1" />
                                            </div>
                                            <div class="col-md-3">
                                                <x-radio label="Closed Jobs" name="job_filter" id="closed_jobs"
                                                    :value="2" :checked="request('job_filter') == 2" />
                                            </div>
                                            <div class="col-md-3">
                                                <x-radio label="NC > 28 Days" name="job_filter" id="sent_reminder"
                                                    :value="3" :checked="request('job_filter') == 3" />
                                            </div>
                                            <div class="col-md-3">
                                                <x-radio label="All Jobs" name="job_filter" id="all_jobs"
                                                    :value="4" :checked="request('job_filter') == 4 || !request('job_filter')" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="btn-group">
                                    <button class="btn btn-primary btn-flat float-right" type="submit">Filter</button>
                                    <a class="btn btn-default btn-flat float-right"
                                        href="{{ route('job.index') }}">Reset</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="small-box bg-white">
                        <div class="inner">
                            <h3 id="totalNoOfJobs">Loading...</h3>

                            <p>No. of Jobs</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-book"></i>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <a href="{{ route('property-inspector.index') }}">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Property Inspector</span>
                                        <span class="info-box-number text-center text-muted mb-0"><i
                                                class="fa fa-arrow-alt-circle-down"></i></span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('client-configuration.index') }}">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Clients</span>
                                        <span class="info-box-number text-center text-muted mb-0"><i
                                                class="fa fa-arrow-alt-circle-down"></i></span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('make-booking.index') }}">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Booking</span>
                                        <span class="info-box-number text-center text-muted mb-0"><i
                                                class="fa fa-arrow-alt-circle-down"></i></span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('remediation-review.index') }}">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Remediation Review</span>
                                        <span class="info-box-number text-center text-muted mb-0"><i
                                                class="fa fa-arrow-alt-circle-down"></i></span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('update-survey.index') }}">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Update Survey</span>
                                        <span class="info-box-number text-center text-muted mb-0"><i
                                                class="fa fa-arrow-alt-circle-down"></i></span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('open-nc.index') }}">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Open NC</span>
                                        <span class="info-box-number text-center text-muted mb-0"><i
                                                class="fa fa-arrow-alt-circle-down"></i></span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
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
                                            label="Remove Duplicates" id="removeDuplicates" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="col-md-12">
                                @if (session('success'))
                                    <div class="alert alert-success" id="successAlert">
                                        {{ session('success') }}
                                        @if (session('showProgress'))
                                            <button type="button" class="btn btn-sm btn-outline-secondary ml-2"
                                                id="hideProgressBtn">Hide Progress</button>
                                        @endif
                                    </div>

                                    @if (session('showProgress'))
                                        <div id="queueProgressContainer" class="mb-4">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h6 class="mb-0">Job Processing Progress</h6>
                                                <div class="d-flex align-items-center">
                                                    <span id="progressText" class="text-muted mr-3">Initializing...</span>
                                                    <button type="button" class="btn btn-sm btn-outline-primary"
                                                        id="refreshProgressBtn">
                                                        <i class="fas fa-sync-alt"></i> Refresh
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="progress mb-2" style="height: 25px;">
                                                <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated"
                                                    role="progressbar" id="progressBar" aria-valuenow="0"
                                                    aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                                    <span id="progressPercentage">0%</span>
                                                </div>
                                            </div>

                                            <div class="row text-center">
                                                <div class="col-md-3">
                                                    <small class="text-muted">Total Jobs</small>
                                                    <div class="font-weight-bold" id="totalJobs">
                                                        {{ session('dataCount', 0) }}</div>
                                                </div>
                                                <div class="col-md-3">
                                                    <small class="text-muted">Processed</small>
                                                    <div class="font-weight-bold text-success" id="processedJobs">0</div>
                                                </div>
                                                <div class="col-md-3">
                                                    <small class="text-muted">Pending</small>
                                                    <div class="font-weight-bold text-warning" id="pendingJobs">
                                                        {{ session('dataCount', 0) }}</div>
                                                </div>
                                                <div class="col-md-3">
                                                    <small class="text-muted">Failed</small>
                                                    <div class="font-weight-bold text-danger" id="failedJobs">0</div>
                                                </div>
                                            </div>

                                            <div class="mt-2">
                                                <small class="text-muted" id="statusText">Processing jobs in
                                                    background...</small>
                                            </div>
                                        </div>
                                    @endif
                                @endif

                            </div>
                            <table id="jobs-table" class="table table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th colspan="11">Job Details</th>
                                        <th colspan="4">Key Dates</th>
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
                                        <th>28-Reminder</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- DataTables will populate this -->
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
                                        <a href="{{ asset('assets/files/Example Job Import.csv') }}" download>Sample
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

                                <x-select label="Job Type" name="job_type_id" :multiple="false" :disabled="true">
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

    <!-- Modal -->
    <div class="modal fade" id="closeJob" role="dialog" aria-labelledby="closeJobLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" class="close-job-form">
                    @csrf
                    @method('PATCH')
                    <div class="modal-header">
                        <h5 class="modal-title" id="closeJobLabel">Close Job</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="text" value="" name="job_status_id" id="job_number_closed_job" hidden>
                        <x-select label="Reason" name="job_status_id" id="job_status" :multiple="false">
                            <option value="28">Wrong Contact Details</option>
                            <option value="15">Customer Refused</option>
                            <option value="27">Job Deadline Expired</option>
                            <option value="36">QA Requirement Achieved</option>
                        </x-select>

                        <x-textarea name="notes" label="Notes" rows="5" value="" required />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('importedScripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script>
        var toastType = @json(session('success'));
        var showProgress = @json(session('showProgress', false));
        var initialDataCount = @json(session('dataCount', 0));
    </script>
    <!-- Select2 -->
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    @include('includes.datatables-scripts')
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- InputMask -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <!-- date-range-picker -->
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('assets/js/job.js') }}"></script>    
@endsection
