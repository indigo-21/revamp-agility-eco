@extends('layouts.app')
@section('importedStyles')
    @include('includes.datatables-links')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
@endsection
@section('content')
    <x-title-breadcrumbs title="Restore Max Attempts" :breadcrumbs="[
        ['title' => 'Dashboard', 'route' => '/', 'active' => ''],
        ['title' => 'Restore Max Attempts', 'route' => '', 'active' => 'active'],
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
                                        List of Jobs with Max Attempts Reached
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
                                        <th>Postcode</th>
                                        <th>Address</th>
                                        <th>Owner Name</th>
                                        <th>Contact Number</th>
                                        <th>Last Attempt Made</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jobs as $job)
                                        <tr>
                                            <td>{{ $job->job_number }}</td>
                                            <td>{{ $job->property->address1 }}</td>
                                            <td>{{ $job->property->postcode }}</td>
                                            <td>{{ $job->customer->customer_name }}</td>
                                            <td>{{ $job->customer->customer_primary_tel }}</td>
                                            <td>{{ $job->related_bookings->last()->created_at }}</td>
                                            <td>
                                                <form action="" method="POST" class="restoreMaxAttemptsForm">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="btn-group">
                                                        <x-button-permission type="create" :permission="$userPermission"
                                                            class="btn btn-primary btn-sm restoreMaxAttempts"
                                                            label="Restore Max Attempts" data-id="{{ $job->id }}" />
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
    <!-- SweetAlert2 -->
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/js/global/table.js') }}"></script>
    <script src="{{ asset('assets/js/restore-max-attempts.js') }}"></script>
@endsection
