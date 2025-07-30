@extends('layouts.app')
@section('importedStyles')
    @include('includes.datatables-links')
@endsection
@section('content')
    <x-title-breadcrumbs title="Update Survey" :breadcrumbs="[
        ['title' => 'Dashboard', 'route' => '/', 'active' => ''],
        ['title' => 'Update Survey', 'route' => '', 'active' => 'active'],
    ]" />
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
                                        List of Completed Jobs for Update Survey
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            {!! $dataTable->table() !!}
                            {{-- <table id="remediationReviewTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Job Number</th>
                                        <th>CAT Measure</th>
                                        <th>Cert No</th>
                                        <th>UMR</th>
                                        <th>Job Status</th>
                                        <th>Property Inspector</th>
                                        <th>Inspection Date</th>
                                        <th>Address</th>
                                        <th>Postcode</th>
                                        <th>Installer</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jobs as $job)
                                        <tr>
                                            <td>{{ $job->job_number }}</td>
                                            <td>{{ $job->jobMeasure->measure->measure_cat }}</td>
                                            <td>{{ $job->cert_no }}</td>
                                            <td>{{ $job->jobMeasure->umr }}</td>
                                            <td>
                                                <span class="right badge badge-{{ $job->jobStatus->color_scheme }}">
                                                    {{ $job->jobStatus->description }}
                                                </span>
                                            </td>
                                            <td>{{ $job->propertyInspector?->user->firstname }}
                                                {{ $job->propertyInspector?->user->lastname }}</td>
                                            <td>{{ $job->schedule_date }}</td>
                                            <td>{{ $job->property->address1 }}</td>
                                            <td>{{ $job->property->postcode }}</td>
                                            <td>{{ $job->installer->user->firstname }}</td>
                                            <td>
                                                <x-button-permission type="view" :permission="$userPermission" as="a"
                                                    :href="route('update-survey.edit', $job->id)" class="btn btn-primary btn-sm"
                                                    label="Update Survey" />
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table> --}}
                        </div>
                    </div>
                </div>
                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
@section('importedScripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    @include('includes.datatables-scripts')
    <script src="{{ asset('assets/js/update-survey.js') }}"></script>
@endsection
