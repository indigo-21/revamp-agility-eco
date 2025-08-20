@extends('layouts.app')

@section('importedStyles')
    @include('includes.datatables-links')
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <style>
        .vertical-center {
            vertical-align: middle !important;
        }
    </style>
@endsection

@section('content')
    <x-title-breadcrumbs title="Client Configuration" :breadcrumbs="[
        ['title' => 'Dashboard', 'route' => '/', 'active' => ''],
        ['title' => 'Client Configuration', 'route' => '', 'active' => 'active'],
    ]" />

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
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
                            <form method="GET" action="{{ route('client-configuration.index') }}" id="filterForm">
                                @csrf
                                <div class="row">
                                    <div class="col-md-7">
                                        <x-select label="Client Name" name="client_name">
                                            <option selected="selected" disabled value="">-Client Name-
                                            </option>
                                            @foreach ($clients as $client)
                                                <option value="{{ $client->id }}"
                                                    {{ request('client_name') == (int) $client->id ? 'selected' : '' }}>
                                                    {{ $client->user->firstname }}</option>
                                            @endforeach
                                        </x-select>
                                        <x-select label="Client Type" name="client_type_id">
                                            <option selected="selected" disabled value="">-Client Type-
                                            </option>
                                            @foreach ($clientTypes as $clientType)
                                                <option value="{{ $clientType->id }}"
                                                    {{ request('client_type_id') == $clientType->id ? 'selected' : '' }}>
                                                    {{ $clientType->name }}</option>
                                            @endforeach
                                        </x-select>

                                        <x-select label="Job Type" name="job_type_id">
                                            <option selected="selected" disabled value="">-Job Type-</option>
                                            @foreach ($jobTypes as $jobType)
                                                <option value="{{ $jobType->id }}"
                                                    {{ request('job_type_id') == $jobType->id ? 'selected' : '' }}>
                                                    {{ $jobType->type }}</option>
                                            @endforeach
                                        </x-select>
                                    </div>
                                    <div class="offset-md-1 col-md-4">
                                        <div class="small-box bg-white">
                                            <div class="inner">
                                                <h3>{{ $clients->count() }}</h3>

                                                <p>No. of Clients</p>
                                            </div>
                                            <div class="icon">
                                                <i class="fas fa-handshake"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-3">
                                        <x-radio label="Active" name="status" id="active_status" :value="1"
                                            :checked="request('status') == '1' || !request('status')" />
                                    </div>
                                    <div class="col-md-3">
                                        <x-radio label="Deactivated" name="status" id="deactive_status" :value="0"
                                            :checked="request('status') == '0'" />
                                    </div>
                                </div>
                                <div class="btn-group mt-5">
                                    <button class="btn btn-primary btn-flat float-right" type="submit">Filter</button>
                                    <a class="btn btn-default btn-flat float-right"
                                        href="{{ route('client-configuration.index') }}">Reset</a>
                                </div>
                            </form>
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
