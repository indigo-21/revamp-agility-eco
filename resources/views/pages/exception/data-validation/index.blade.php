@extends('layouts.app')
@section('importedStyles')
    @include('includes.datatables-links')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <style>
        .vertical-center {
            vertical-align: middle !important;
        }

        .selected {
            background-color: #007bff !important;
            color: white !important;
        }
    </style>
@endsection
@section('content')
    <x-title-breadcrumbs title="Data Validation Exception" :breadcrumbs="[
        ['title' => 'Dashboard', 'route' => '/', 'active' => ''],
        ['title' => 'Exception', 'route' => '', 'active' => 'active'],
        ['title' => 'Data Validation Exception', 'route' => '', 'active' => 'active'],
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
                                    <button type="button" class="minimize-btn" data-toggle="collapse"
                                        data-target="#filterBody" aria-expanded="true"><i class="fas fa-minus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="collapse show" id="filterBody">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Job Status</label>
                                        <div class="d-flex justify-content-around">
                                            <x-checkbox name="data_invalid_installer"
                                                label="Data Invalid (Installer)"></x-checkbox>
                                            <x-checkbox name="data_invalid_scheme"
                                                label="Data Invalid (Scheme)"></x-checkbox>
                                            <x-checkbox name="data_invalid_measure"
                                                label="Data Invalid (Measure)"></x-checkbox>
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
                                        List of Data Validation Exception
                                    </h3>
                                </div>
                                <div class="right">
                                    {{-- <form method="POST" action="{{ route('data-validation-exception.store') }}"
                                        id="reimportForm">
                                        @csrf --}}
                                    <x-button-permission type="create" :permission="$userPermission" class="btn btn-primary"
                                        label="Reimport" id="reimportBtn" />
                                    {{-- </form> --}}
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="mb-3 d-flex justify-content-end">
                                {{-- <x-button-permission type="create" :permission="$userPermission" class="btn btn-primary"
                                    label="Reimport" /> --}}
                                {{-- <x-button-permission type="delete" :permission="$userPermission" class="btn btn-danger"
                                    label="Remove Selected" /> --}}
                            </div>
                            <table id="dataValidationExceptionTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Job Number</th>
                                        <th>Date</th>
                                        <th>Job Status</th>
                                        <th>Measure Cat</th>
                                        <th>Installer</th>
                                        <th>Scheme</th>
                                        <th>Postcode</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jobs as $job)
                                        <tr>
                                            <td>{{ $job->job_number }}</td>
                                            <td>{{ $job->created_at }}</td>
                                            <td>
                                                <span class="right badge badge-{{ $job->jobStatus->color_scheme }}">
                                                    {{ $job->jobStatus->description }}
                                                </span>
                                            </td>
                                            <td>{{ $job->jobMeasure?->measure?->measure_cat ?: 'No Measure' }}</td>
                                            <td>{{ $job->installer?->user->firstname ?: 'No Installer' }}</td>
                                            <td>{{ $job->scheme?->short_name ?: 'No Scheme' }}</td>
                                            <td>{{ $job->property->postcode }}</td>
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
    <!-- SweetAlert2 -->
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/js/data-validation-exception.js') }}"></script>
@endsection
