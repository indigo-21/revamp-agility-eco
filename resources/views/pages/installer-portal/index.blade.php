@extends('layouts.app')
@section('importedStyles')
    @include('includes.datatables-links')
@endsection
@section('content')
    <x-title-breadcrumbs title="Installer Portal" :breadcrumbs="[
        ['title' => 'Dashboard', 'route' => '/', 'active' => ''],
        ['title' => 'Remediation', 'route' => '', 'active' => 'active'],
        ['title' => 'Installer Portal', 'route' => '', 'active' => 'active'],
    ]" />

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-info alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="icon fas fa-info"></i> List of Inspected Jobs with identified Non-Compliances.
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="callout callout-info">
                        <p>The measures that you installed and lodged were subject to a Quality Audit Inspection. Some of
                            the work done has been deemed to be non-compliant on one or more points. For each Measure listed
                            please click on "View Details" to see why the Measure was deemed non-compliant and provide
                            evidence of remedial work to bring the measure to the required standard or full documentation of
                            why you feel the findings are incorrect.</p>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-body">
                            <table id="remediationReviewTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Client</th>
                                        <th>Cert No</th>
                                        <th>UMR</th>
                                        <th>CAT Measure</th>
                                        <th>Address</th>
                                        <th>Postcode</th>
                                        <th>Non-Comliance Type</th>
                                        <th>Inspection Date</th>
                                        <th>Remediation Deadline</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jobs as $job)
                                        <tr>
                                            <td>{{ $job->client->user->firstname }}
                                                {{ $job->client->user->lastname }}</td>
                                            <td>{{ $job->cert_no }}</td>
                                            <td>{{ $job->jobMeasure->umr }}</td>
                                            <td>{{ $job->jobMeasure->measure->measure_cat }}</td>
                                            <td>{{ $job->property->address1 }} {{ $job->property->city }}
                                            </td>
                                            <td>{{ $job->property->postcode }}</td>
                                            <td>{{ $job->job_remediation_type }}</td>
                                            <td>{{ \Carbon\Carbon::parse($job->schedule_date)->format('M d Y') }}
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($job->rework_deadline)->format('M d Y') }}
                                            </td>
                                            <td>
                                                <x-button-permission type="view" :permission="$userPermission" as="a"
                                                    :href="route('installer-portal.show', $job->id)" class="btn btn-primary btn-sm" label="View Details" />
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
    <script src="{{ asset('assets/js/remediation-review.js') }}"></script>
@endsection
