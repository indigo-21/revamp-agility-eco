@extends('layouts.app')

@section('importedStyles')
    @include('includes.datatables-links')
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
                    <h1 class="m-0">Client Configuration</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Client Configuration</li>
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
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="w-100 d-flex justify-content-between align-items-center">
                                <div class="left w-50">
                                    <h3>Filter</h3>
                                </div>
                                <div class="right w-50">
                                    <div class="d-flex justify-content-end align-items-center">
                                        <button type="button" class="w-25 btn btn-outline-primary">
                                            <i class="fa fa-plus-circle" aria-hidden="true"></i> Filter
                                        </button>
                                        <button type="button" class="w-25 btn btn-outline-danger">
                                            <i class="fa fa-plus-circle" aria-hidden="true"></i> Reset
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                    <div class="col-sm-12 col-lg-3">
                                        <div class="form-group">
                                            <label for="clientStatus">Client Status</label>
                                            <select class="custom-select rounded-0" id="clientStatus">
                                              <option>-Select Client Status-</option>
                                              <option>Active</option>
                                              <option>Inactive</option>
                                            </select>
                                          </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-3">
                                        <div class="form-group">
                                            <label for="clientName">Client Name</label>
                                            <select class="custom-select rounded-0" id="clientName">
                                              <option>-Select Client Name-</option>
                                              <option>Active</option>
                                              <option>Inactive</option>
                                            </select>
                                          </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-3">
                                        <div class="form-group">
                                            <label for="clientType">Client Type</label>
                                            <select class="custom-select rounded-0" id="clientType">
                                              <option>-Select Client Type-</option>
                                              <option>Active</option>
                                              <option>Inactive</option>
                                            </select>
                                          </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-3">
                                        <div class="form-group">
                                            <label for="jobType">Job Type</label>
                                            <select class="custom-select rounded-0" id="jobType">
                                              <option>-Select Job Type-</option>
                                              <option>Active</option>
                                              <option>Inactive</option>
                                            </select>
                                          </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <div class="w-100 d-flex justify-content-between align-items-center">
                                <div class="left">
                                    <h3 class="card-title">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        List of Clients
                                    </h3>
                                </div>
                                <div class="right">
                                    <a type="button" class="btn btn-block btn-outline-primary" href="{{route('client-configuration.create')}}">
                                        <i class="fa fa-plus-circle" aria-hidden="true"></i> Add Client
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="clientConfigurationTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Client ID</th>
                                        <th>Client Information</th>
                                        <th>Client TLA</th>
                                        <th>Client Type</th>
                                        <th>Job Type</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>
                                            <strong>Client Name</strong><br>
                                            <small>Client Email</small><br>
                                            <small>Client Landline</small><br>
                                            <small>Client Address</small><br>
                                        </td>
                                        <td>Client TLA</td>
                                        <td>Client Type</td>
                                        <td>Job Type</td>
                                        <td>Status</td>
                                        <td>
                                            <button type="button" class="btn btn-block btn-primary">
                                                <i class="fa fa-eye" aria-hidden="true"></i>&nbsp; View
                                            </button>
                                        </td>
                                    </tr>
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
    <script src="{{ asset('assets/js/client-configuration.js') }}"></script>
@endsection
