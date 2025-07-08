@extends('layouts.app')

@section('importedStyles')
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
    @include('includes.datatables-links')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endsection

@section('content')
    <x-title-breadcrumbs title="Open NC" :breadcrumbs="[
        ['title' => 'Dashboard', 'route' => '/', 'active' => ''],
        ['title' => 'Open NC', 'route' => '', 'active' => 'active'],
    ]" />

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Filter</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i></button>
                            </div>
                        </div>

                        <div class="card-body" style="display: block;">
                            <form method="GET" action="{{ route('open-nc.index') }}" id="filterForm">
                                @csrf
                                <div class="row mb-5">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <x-select label="Job Status" name="job_status_id" :multiple="false">
                                                    <option value="" {{ request('job_status_id') ? '' : 'selected' }}
                                                        disabled>- Select Job Status
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
                                                            {{ $client->user->firstname }} {{ $client->user->lastname }}
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
                                                    <label>Created At:</label>
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
                                            <div class="col-md-4">
                                                <x-radio label="Open Jobs" name="job_filter" id="open_jobs"
                                                    :value="1" :checked="request('job_filter') == 1" />
                                            </div>
                                            <div class="col-md-4">
                                                <x-radio label="Closed Jobs" name="job_filter" id="closed_jobs"
                                                    :value="2" :checked="request('job_filter') == 2" />
                                            </div>
                                            <div class="col-md-4">
                                                <x-radio label="All Jobs" name="job_filter" id="all_jobs" :value="3"
                                                    :checked="request('job_filter') == 3 || !request('job_filter')" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 offset-md-1">
                                        <div class="small-box bg-default">
                                            <div class="inner">
                                                <h3 id="totalNoOfJobs">{{ $jobs->count() }}</h3>

                                                <p>No. of Jobs</p>
                                            </div>
                                            <div class="icon">
                                                <i class="fas fa-book"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="btn-group">
                                    <button class="btn btn-primary btn-flat float-right" type="submit">Filter</button>
                                    <a class="btn btn-default btn-flat float-right"
                                        href="{{ route('open-nc.index') }}">Reset</a>
                                </div>
                            </form>
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
                                                        <span
                                                            class="right badge badge-{{ $job->jobStatus->color_scheme }}">
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
                                                        <div class="btn-group">
                                                            <x-button-permission type="view" :permission="$userPermission"
                                                                as="a" :href="route('open-nc.show', $job->id)"
                                                                class="btn btn-primary btn-sm" label="View" />
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
