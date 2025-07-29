@extends('layouts.app')

@section('importedStyles')
    {{-- <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}"> --}}
    @include('includes.datatables-links')
@endsection

@section('content')
    <x-title-breadcrumbs title="Reports" :breadcrumbs="[
        ['title' => 'Dashboard', 'route' => '/', 'active' => ''],
        ['title' => 'Reports', 'route' => '', 'active' => 'active'],
    ]" />

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card ">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-edit"></i>
                                List of Reports
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5 col-sm-3">
                                    <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist"
                                        aria-orientation="vertical">
                                        <a class="nav-link active" id="jobs-with-nc-tab" data-toggle="pill"
                                            href="#jobs-with-nc" role="tab" aria-controls="jobs-with-nc"
                                            aria-selected="true">Jobs with NC</a>
                                        <a class="nav-link" id="jobs-with-cat1-tab" data-toggle="pill"
                                            href="#jobs-with-cat1" role="tab" aria-controls="jobs-with-cat1"
                                            aria-selected="false">Jobs with CAT1</a>
                                        <a class="nav-link" id="unbooked-jobs-tab" data-toggle="pill" href="#unbooked-jobs"
                                            role="tab" aria-controls="unbooked-jobs" aria-selected="false">Unbooked
                                            Jobs</a>
                                        <a class="nav-link" id="booked-jobs-tab" data-toggle="pill" href="#booked-jobs"
                                            role="tab" aria-controls="booked-jobs" aria-selected="false">Booked Jobs</a>
                                        <a class="nav-link" id="completed-tab" data-toggle="pill" href="#completed"
                                            role="tab" aria-controls="completed" aria-selected="false">Completed during
                                            date range</a>
                                        <a class="nav-link" id="passed-remedial-tab" data-toggle="pill"
                                            href="#passed-remedial" role="tab" aria-controls="passed-remedial"
                                            aria-selected="false">Passed Remedial</a>
                                        <a class="nav-link" id="failed-questions-tab" data-toggle="pill"
                                            href="#failed-questions" role="tab" aria-controls="failed-questions"
                                            aria-selected="false">Failed Questions</a>
                                        {{-- <a class="nav-link" id="jobs-with-visits-tab" data-toggle="pill"
                                            href="#jobs-with-visits" role="tab" aria-controls="jobs-with-visits"
                                            aria-selected="false">Jobs with Visits</a> --}}

                                    </div>
                                </div>
                                <div class="col-7 col-sm-9">
                                    <div class="tab-content" id="vert-tabs-tabContent">
                                        <div class="tab-pane text-left fade show active" id="jobs-with-nc" role="tabpanel"
                                            aria-labelledby="jobs-with-nc-tab">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Job Number</th>
                                                        <th>Cert #</th>
                                                        <th>UMR</th>
                                                        <th>Property Inspector</th>
                                                        <th>Address</th>
                                                        <th>Postcode</th>
                                                        <th>Measure Type</th>
                                                        <th>Installer</th>
                                                        <th>Booked Date</th>
                                                        <th>Scheme</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($jobNC as $job)
                                                        <tr>
                                                            <td>{{ $job->job_number }}</td>
                                                            <td>{{ $job->cert_no }}</td>
                                                            <td>{{ $job->jobMeasure?->umr }}</td>
                                                            <td>{{ $job->propertyInspector?->user->firstname }}
                                                                {{ $job->propertyInspector?->user->lastname }}</td>
                                                            <td>{{ $job->property->address1 }}</td>
                                                            <td>{{ $job->property->postcode }}</td>
                                                            <td>{{ $job->jobMeasure->measure->measure_cat }}</td>
                                                            <td>{{ $job->installer->user->firstname ?? 'N/A' }}</td>
                                                            <td>{{ $job->booked_date ? \Carbon\Carbon::parse($job->booked_date)->format('d/m/Y') : 'N/A' }}
                                                            </td>
                                                            <td>{{ $job->scheme->short_name ?? 'N/A' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane fade" id="jobs-with-cat1" role="tabpanel"
                                            aria-labelledby="jobs-with-cat1-tab">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Job Number</th>
                                                        <th>Cert #</th>
                                                        <th>UMR</th>
                                                        <th>Property Inspector</th>
                                                        <th>Address</th>
                                                        <th>Postcode</th>
                                                        <th>Measure Type</th>
                                                        <th>Installer</th>
                                                        <th>Booked Date</th>
                                                        <th>Scheme</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($jobCat1 as $job)
                                                        <tr>
                                                            <td>{{ $job->job_number }}</td>
                                                            <td>{{ $job->cert_no }}</td>
                                                            <td>{{ $job->jobMeasure?->umr }}</td>
                                                            <td>{{ $job->propertyInspector?->user->firstname }}
                                                                {{ $job->propertyInspector?->user->lastname }}</td>
                                                            <td>{{ $job->property->address1 }}</td>
                                                            <td>{{ $job->property->postcode }}</td>
                                                            <td>{{ $job->jobMeasure->measure->measure_cat }}</td>
                                                            <td>{{ $job->installer->user->firstname ?? 'N/A' }}</td>
                                                            <td>{{ $job->booked_date ? \Carbon\Carbon::parse($job->booked_date)->format('d/m/Y') : 'N/A' }}
                                                            </td>
                                                            <td>{{ $job->scheme->short_name ?? 'N/A' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane fade" id="unbooked-jobs" role="tabpanel"
                                            aria-labelledby="unbooked-jobs-tab">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Job Number</th>
                                                        <th>Cert #</th>
                                                        <th>UMR</th>
                                                        <th>Property Inspector</th>
                                                        <th>Address</th>
                                                        <th>Postcode</th>
                                                        <th>Measure Type</th>
                                                        <th>Installer</th>
                                                        <th>Booked Date</th>
                                                        <th>Scheme</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($jobUnbooked as $job)
                                                        <tr>
                                                            <td>{{ $job->job_number }}</td>
                                                            <td>{{ $job->cert_no }}</td>
                                                            <td>{{ $job->jobMeasure?->umr }}</td>
                                                            <td>{{ $job->propertyInspector?->user->firstname }}
                                                                {{ $job->propertyInspector?->user->lastname }}</td>
                                                            <td>{{ $job->property->address1 }}</td>
                                                            <td>{{ $job->property->postcode }}</td>
                                                            <td>{{ $job->jobMeasure->measure->measure_cat }}</td>
                                                            <td>{{ $job->installer->user->firstname ?? 'N/A' }}</td>
                                                            <td>{{ $job->booked_date ? \Carbon\Carbon::parse($job->booked_date)->format('d/m/Y') : 'N/A' }}
                                                            </td>
                                                            <td>{{ $job->scheme->short_name ?? 'N/A' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane fade" id="booked-jobs" role="tabpanel"
                                            aria-labelledby="booked-jobs-tab">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Job Number</th>
                                                        <th>Cert #</th>
                                                        <th>UMR</th>
                                                        <th>Property Inspector</th>
                                                        <th>Address</th>
                                                        <th>Postcode</th>
                                                        <th>Measure Type</th>
                                                        <th>Installer</th>
                                                        <th>Booked Date</th>
                                                        <th>Scheme</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($jobBooked as $job)
                                                        <tr>
                                                            <td>{{ $job->job_number }}</td>
                                                            <td>{{ $job->cert_no }}</td>
                                                            <td>{{ $job->jobMeasure?->umr }}</td>
                                                            <td>{{ $job->propertyInspector?->user->firstname }}
                                                                {{ $job->propertyInspector?->user->lastname }}</td>
                                                            <td>{{ $job->property->address1 }}</td>
                                                            <td>{{ $job->property->postcode }}</td>
                                                            <td>{{ $job->jobMeasure->measure->measure_cat }}</td>
                                                            <td>{{ $job->installer->user->firstname ?? 'N/A' }}</td>
                                                            <td>{{ $job->booked_date ? \Carbon\Carbon::parse($job->booked_date)->format('d/m/Y') : 'N/A' }}
                                                            </td>
                                                            <td>{{ $job->scheme->short_name ?? 'N/A' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane fade" id="completed" role="tabpanel"
                                            aria-labelledby="completed-tab">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Job Number</th>
                                                        <th>Cert #</th>
                                                        <th>UMR</th>
                                                        <th>Property Inspector</th>
                                                        <th>Address</th>
                                                        <th>Postcode</th>
                                                        <th>Measure Type</th>
                                                        <th>Installer</th>
                                                        <th>Booked Date</th>
                                                        <th>Scheme</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($jobPassedRemedial as $job)
                                                        <tr>
                                                            <td>{{ $job->job_number }}</td>
                                                            <td>{{ $job->cert_no }}</td>
                                                            <td>{{ $job->jobMeasure?->umr }}</td>
                                                            <td>{{ $job->propertyInspector?->user->firstname }}
                                                                {{ $job->propertyInspector?->user->lastname }}</td>
                                                            <td>{{ $job->property->address1 }}</td>
                                                            <td>{{ $job->property->postcode }}</td>
                                                            <td>{{ $job->jobMeasure->measure->measure_cat }}</td>
                                                            <td>{{ $job->installer->user->firstname ?? 'N/A' }}</td>
                                                            <td>{{ $job->booked_date ? \Carbon\Carbon::parse($job->booked_date)->format('d/m/Y') : 'N/A' }}
                                                            </td>
                                                            <td>{{ $job->scheme->short_name ?? 'N/A' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane fade" id="passed-remedial" role="tabpanel"
                                            aria-labelledby="passed-remedial-tab">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Job Number</th>
                                                        <th>Cert #</th>
                                                        <th>UMR</th>
                                                        <th>Property Inspector</th>
                                                        <th>Address</th>
                                                        <th>Postcode</th>
                                                        <th>Measure Type</th>
                                                        <th>Installer</th>
                                                        <th>Booked Date</th>
                                                        <th>Scheme</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($jobCompleted as $job)
                                                        <tr>
                                                            <td>{{ $job->job_number }}</td>
                                                            <td>{{ $job->cert_no }}</td>
                                                            <td>{{ $job->jobMeasure?->umr }}</td>
                                                            <td>{{ $job->propertyInspector?->user->firstname }}
                                                                {{ $job->propertyInspector?->user->lastname }}</td>
                                                            <td>{{ $job->property->address1 }}</td>
                                                            <td>{{ $job->property->postcode }}</td>
                                                            <td>{{ $job->jobMeasure->measure->measure_cat }}</td>
                                                            <td>{{ $job->installer->user->firstname ?? 'N/A' }}</td>
                                                            <td>{{ $job->booked_date ? \Carbon\Carbon::parse($job->booked_date)->format('d/m/Y') : 'N/A' }}
                                                            </td>
                                                            <td>{{ $job->scheme->short_name ?? 'N/A' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane fade" id="failed-questions" role="tabpanel"
                                            aria-labelledby="failed-questions-tab">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Job Number</th>
                                                        <th>Cert #</th>
                                                        <th>UMR</th>
                                                        <th>Property Inspector</th>
                                                        <th>Measure Type</th>
                                                        {{-- <th>Address</th>
                                                        <th>Postcode</th> --}}
                                                        {{-- <th>Installer</th> --}}
                                                        <th>Question #</th>
                                                        <th>Pass / Fail</th>
                                                        <th>Last Comment</th>
                                                        <th>High / Low</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($failedQuestions as $failedQuestion)
                                                        <tr>
                                                            <td>{{ $failedQuestion->job->job_number }}</td>
                                                            <td>{{ $failedQuestion->job->cert_no }}</td>
                                                            <td>{{ $failedQuestion->job->jobMeasure?->umr }}</td>
                                                            <td>{{ $failedQuestion->job->propertyInspector?->user->firstname }}
                                                                {{ $failedQuestion->job->propertyInspector?->user->lastname }}
                                                            </td>
                                                            <td>{{ $failedQuestion->job->jobMeasure->measure->measure_cat }}
                                                            </td>
                                                            {{-- <td>{{ $failedQuestion->job->property->address1 }}</td>
                                                            <td>{{ $failedQuestion->job->property->postcode }}</td> --}}
                                                            <td>{{ $failedQuestion->job->installer->user->firstname ?? 'N/A' }}
                                                            </td>
                                                            <td>{{ $failedQuestion->pass_fail }}</td>
                                                            {{-- <td>{{ $failedQuestion->remediations?->where('role', 'Installer')?->last()?->comment ?? 'N/A' }}
                                                            </td> --}}
                                                            <td>{{ $failedQuestion->surveyQuestion->nc_severity }}</td>
                                                            <td>{{ $failedQuestion->surveyQuestion->question_number }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        {{-- <div class="tab-pane fade" id="jobs-with-visits" role="tabpanel"
                                            aria-labelledby="jobs-with-visits-tab">
                                            7
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('importedScripts')
    {{-- <script>
        var toastType = @json(session('success'));
    </script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script> --}}
    @include('includes.datatables-scripts')
    <script src="{{ asset('assets/js/global/table.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/scheme.js') }}"></script> --}}
@endsection
