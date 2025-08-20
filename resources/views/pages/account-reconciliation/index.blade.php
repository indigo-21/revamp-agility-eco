@extends('layouts.app')

@section('importedStyles')
    @include('includes.datatables-links')
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('content')
    <x-title-breadcrumbs title="Account Reconciliation" :breadcrumbs="[
        ['title' => 'Dashboard', 'route' => '/', 'active' => ''],
        ['title' => 'Account Reconciliation', 'route' => '', 'active' => 'active'],
    ]" />

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
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
                            <form method="GET" action="{{ route('account-reconciliation.index') }}" id="filterForm">
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
                                        <div class="row mt-4">
                                            <div class="col-md-4">
                                                <x-radio label="All Jobs" name="invoice_status_id" id="all_jobs"
                                                    :value="0" :checked="request('invoice_status_id') == '0' ||
                                                        !request('invoice_status_id')" />
                                            </div>
                                            <div class="col-md-4">
                                                <x-radio label="Invoice Created" name="invoice_status_id"
                                                    id="invoice_created" :value="1" :checked="request('invoice_status_id') == '1'" />
                                            </div>
                                            <div class="col-md-4">
                                                <x-radio label="Invoice Needs Creating" name="invoice_status_id"
                                                    id="invoice_needs_creating" :value="2" :checked="request('invoice_status_id') == '2'" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="offset-md-1 col-md-4">
                                        <div class="small-box bg-white">
                                            <div class="inner">
                                                <h3>{{ $jobs->count() }}</h3>

                                                <p>No. of Jobs</p>
                                            </div>
                                            <div class="icon">
                                                <i class="fas fa-handshake"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="btn-group mt-5">
                                    <button class="btn btn-primary btn-flat float-right" type="submit">Filter</button>
                                    <a class="btn btn-default btn-flat float-right"
                                        href="{{ route('account-reconciliation.index') }}">Reset</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <div class="w-100 d-flex justify-content-between align-items-center">
                                <div class="left">
                                    <h3 class="card-title">
                                        <i class="fas fa-list mr-2"></i>
                                        List of Jobs
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered table-striped text-center">
                                        <thead>
                                            <tr>
                                                <th>Job Number</th>
                                                <th>Job Status</th>
                                                <th>Client</th>
                                                <th>Cert#</th>
                                                <th>UMR</th>
                                                <th>Property Inspector</th>
                                                <th>Address</th>
                                                <th>Close Date</th>
                                                <th>Invoice Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($jobs as $job)
                                                <tr>
                                                    <td>{{ $job->job_number }}</td>
                                                    <td>
                                                        <span
                                                            class="right badge badge-{{ $job->jobStatus->color_scheme }}">
                                                            {{ $job->jobStatus->description }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $job->client?->user->firstname }}
                                                        {{ $job->client?->user->lastname }}</td>
                                                    <td>{{ $job->cert_no }}</td>
                                                    <td>{{ $job->jobMeasure?->umr }}</td>
                                                    <td>{{ $job->propertyInspector?->user->firstname }}
                                                        {{ $job->propertyInspector?->user->lastname }}</td>
                                                    <td>{{ $job->property?->address1 }}, {{ $job->property?->postcode }}
                                                    </td>
                                                    <td>{{ $job->close_date }}</td>
                                                    <td>{{ $job->invoiceStatus?->name ?? 'N/A' }}</td>
                                                    <td>
                                                        <x-button-permission type="update" :permission="$userPermission"
                                                            class="btn btn-sm btn-warning invoiceBtn" label="Invoice"
                                                            data-id="{{ $job->id }}" />
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
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
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

    <script src="{{ asset('assets/js/global/table.js') }}"></script>
    <script src="{{ asset('assets/js/account-reconciliation.js') }}"></script>
@endsection
