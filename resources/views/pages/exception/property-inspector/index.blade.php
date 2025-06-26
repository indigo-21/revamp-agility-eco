@extends('layouts.app')
@section('importedStyles')
    @include('includes.datatables-links')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <style>
        .vertical-center {
            vertical-align: middle !important;
        }
    </style>
@endsection
@section('content')
    <x-title-breadcrumbs title="Property Inspector Exception" :breadcrumbs="[
        ['title' => 'Dashboard', 'route' => '/', 'active' => ''],
        ['title' => 'Exception', 'route' => '', 'active' => 'active'],
        ['title' => 'Property Inspector Exception', 'route' => '', 'active' => 'active'],
    ]" />

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            {{-- <div class="row">
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <div class="w-100 d-flex justify-content-between align-items-center">
                                <div class="left">
                                    <h3 class="card-title">
                                        <i class="fas fa-search mr-2"></i>
                                        Filter
                                    </h3>
                                </div>
                                <div class="right">
                                    <button type="button" class="minimize-btn" data-toggle="collapse" data-target="#filterBody" aria-expanded="true"><i class="fas fa-minus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="collapse show" id="filterBody">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Job Status</label>
                                        <div class="d-flex justify-content-around">
                                            <x-checkbox name="firm_pi_decision" label="Firm PI Decision"></x-checkbox>
                                            <x-checkbox name="no_firm_pi"
                                                label="No Firm PI"></x-checkbox>
                                            <x-checkbox name="no_pi_available"
                                                label="No PI Available"></x-checkbox>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <x-select label="Client" name="client" :multiple="false">
                                            <option>- SELECT A CLIENT -</option>
                                        </x-select>
                                    </div>
                                    <div class="col-md-4">
                                        <x-select label="Outward Postcode" name="outward_postcode" :multiple="false">
                                            <option>- SELECT OURWARD POSTCODE -</option>
                                        </x-select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <x-date name="date_from" label="Date From" />
                                    </div>
                                    <div class="col-md-4">
                                        <x-date name="date_from" label="Date From" />
                                    </div>
                                    <div class="col-md-4">

                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-right">
                                    <a type="button" class="btn btn-primary" href="">
                                       Filter
                                    </a>
                                    <a type="button" class="btn btn-default" href="">
                                         Reset
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <div class="w-100 d-flex justify-content-between align-items-center">
                                <div class="left">
                                    <h3 class="card-title">
                                        <i class="fas fa-list mr-2"></i>
                                        List of Property Inspector Exception
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="installerConfigurationTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Job Number</th>
                                        <th>Deadline</th>
                                        <th>Ideal Visit By</th>
                                        <th>Extract From</th>
                                        <th>Job Status</th>
                                        <th>Client</th>
                                        <th>City</th>
                                        <th>Postcode</th>
                                        <th>Duration</th>
                                        <th>Action</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    @foreach ($jobs as $job)
                                        <tr>
                                            <td>{{ $job->job_group }}</td>
                                            <td>{{ $job->deadline }}</td>
                                            <td>{{ $job->first_visit_by }}</td>
                                            <td>{{ $job->created_at }}</td>
                                            <td>
                                                <span class="right badge badge-{{ $job->jobStatus->color_scheme }}">
                                                    {{ $job->jobStatus->description }}
                                                </span>
                                            </td>
                                            <td>{{ $job->client->user->firstname }} {{ $job->client->user->lastname }}</td>
                                            <td>{{ $job->property->city }}</td>
                                            <td>{{ $job->property->postcode }}</td>
                                            <td>{{ $job->duration }}</td>
                                            <td class="text-center">
                                                <x-button-permission type="create" :permission="$userPermission" as="a"
                                                    :href="route('property-inspector-exception.show', $job->job_group)" class="btn btn-primary btn-sm" label="View" />
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
    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script src="{{ asset('assets/js/global/table.js') }}"></script>
@endsection
