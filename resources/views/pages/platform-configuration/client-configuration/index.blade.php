@extends('layouts.app')

@section('importedStyles')
    @include('includes.datatables-links')
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
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
            {{-- <div class="row">
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
            </div> --}}
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <div class="w-100 d-flex justify-content-between align-items-center">
                                <div class="left">
                                    <h3 class="card-title">
                                        <i class="fas fa-list mr-2"></i>
                                        List of Clients
                                    </h3>
                                </div>
                                <div class="right">
                                    <x-button-permission type="create" :permission="$userPermission" as="a" :href="route('client-configuration.create')"
                                        class="btn btn-white" label="Add Client" />
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
                                            <td>{{ $client->id }}</td>
                                            <td>
                                                <strong>{{ $client->user->firstname }}
                                                    {{ $client->user->lastname }}</strong><br>
                                                <small>{{ $client->user->email }}</small><br>
                                                <small>{{ $client->user->mobile }}</small><br>
                                                <small>{{ $client->address1 }} {{ $client->city }}
                                                    {{ $client->country }}
                                                    {{ $client->postcode }}</small><br>
                                            </td>
                                            <td>{{ $client->client_abbrevation }}</td>
                                            <td>{{ $client->clientType->name }}</td>
                                            <td>
                                                @foreach ($client->clientJobTypes as $jobType)
                                                    <span class="badge badge-info">{{ $jobType->jobType->type }}</span>
                                                @endforeach
                                            </td>
                                            <td>
                                                @if ($client->clientKeyDetails->is_active === 1)
                                                    <span class="right badge badge-success">Active</span>
                                                @else
                                                    <span class="right badge badge-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <form action="{{ route('client-configuration.destroy', $client->id) }}"
                                                    method="POST" class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="btn-group">
                                                        <x-button-permission type="view" :permission="$userPermission" as="a"
                                                            :href="route('client-configuration.show', $client->id)" class="btn btn-primary btn-sm"
                                                            label="View" />
                                                        <x-button-permission type="update" :permission="$userPermission" as="a"
                                                            :href="route('client-configuration.edit', $client->id)" class="btn btn-warning btn-sm"
                                                            label="Edit" />
                                                        <x-button-permission type="delete" :permission="$userPermission"
                                                            class="btn btn-danger btn-sm delete-btn" label="Delete" />
                                                    </div>
                                                </form>
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
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/client-configuration.js') }}"></script>
@endsection
