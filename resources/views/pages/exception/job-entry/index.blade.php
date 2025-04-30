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
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Job Entry Exeception</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Exeception</li>
                        <li class="breadcrumb-item active">Job Entry Exeception</li>
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
                                            <x-checkbox name="import_fail_inactive" label="Import Fail (inactive)"></x-checkbox>
                                            <x-checkbox name="import_fail_unspecified"
                                                label="Import Fail (unspecified)"></x-checkbox>
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
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <div class="w-100 d-flex justify-content-between align-items-center">
                                <div class="left">
                                    <h3 class="card-title">
                                        <i class="fas fa-list mr-2"></i>
                                        List of Job Entry Exception
                                    </h3>
                                </div>
                                <div class="right">
                                    <a type="button" class="btn btn-white" href="">
                                        <i class="fa fa-plus-square mr-1" aria-hidden="true"></i> Create Installer
                                    </a>
                                    <a type="button" class="btn bg-gradient-warning" href="">
                                        <i class="fa fa-upload mr-1" aria-hidden="true"></i> Upload CSV
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="installerConfigurationTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Job Number</th>
                                        <th>Date</th>
                                        <th>Job Status</th>
                                        <th>Certificate No.</th>
                                        <th>UMR</th>
                                        <th>City</th>
                                        <th>Postcode</th>
                                    </tr>

                                </thead>
                                <tbody>

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
@endsection