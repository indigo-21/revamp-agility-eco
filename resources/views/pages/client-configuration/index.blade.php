@extends('layouts.app')

@section('importedStyles')
    @include('includes.datatables-links')
    <link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
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
                                        <button type="button" class="w-25 btn btn-white">
                                            <i class="fa fa-plus-circle" aria-hidden="true"></i> Filter
                                        </button>
                                        <button type="button" class="w-25 btn btn-white">
                                            <i class="fa fa-plus-circle" aria-hidden="true"></i> Reset
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                    <div class="col-sm-12 col-lg-3">
                                        <x-select label="Client Status" name="client_status">
                                            <option selected="selected" disabled value="">-Client Status-</option>
                                            <option value="">-Select Client Status-</option>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </x-select> 
                                    </div>
                                    <div class="col-sm-12 col-lg-3">
                                        <x-select label="Client Name" name="client_name">
                                            <option selected="selected" disabled value="">-Client Name-</option>
                                            @foreach ($clients as $client)
                                                <option value="{{$client->client_user_id}}">{{$client->client_name}}</option>
                                            @endforeach
                                        </x-select> 
                                    </div>
                                    <div class="col-sm-12 col-lg-3">
                                        <x-select label="Client Type" name="client_type">
                                            <option selected="selected" disabled value="">-Client Type-</option>
                                            @foreach ($clients as $client)
                                                <option value="{{$client->client_type_id}}">{{$client->client_type}}</option>
                                            @endforeach
                                        </x-select> 
                                    </div>
                                    <div class="col-sm-12 col-lg-3">
                                        <x-select label="Job Type" name="job_type">
                                            <option selected="selected" disabled value="">-Job Type-</option>
                                            @foreach ($jobTypes as $jobType)
                                                <option value="{{$jobType->id}}">{{$jobType->type}}</option>
                                            @endforeach
                                        </x-select> 
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
                                    <a type="button" class="btn btn-block btn-white" href="{{route('client-configuration.create')}}">
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
                                    @foreach ($clients as $client)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>
                                                <strong>{{$client->client_name}}</strong><br>
                                                <small>{{$client->client_email}}</small><br>
                                                <small>{{$client->client_mobile}}</small><br>
                                                <small>{{$client->client_address1}} {{$client->client_address2}} {{$client->client_address3}} {{$client->client_city}} {{$client->client_country}} {{$client->client_postcode}}</small><br>
                                            </td>
                                            <td>{{$client->client_tla}}</td>
                                            <td>{{$client->client_type}}</td>
                                            <td>Job Type</td>
                                            <td>
                                                @if ($client->is_active == 1)
                                                    Active
                                                @else
                                                    Inactive
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-block btn-primary">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>&nbsp; View
                                                </button>
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
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="{{ asset('assets/js/client-configuration.js') }}"></script>
@endsection
