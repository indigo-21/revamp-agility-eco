@extends('layouts.app')

@section('importedStyles')
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
    @include('includes.datatables-links')
    <style>
        .vertical-center {
            vertical-align: middle !important;
        }
    </style>
@endsection
@section('content')
    <x-title-breadcrumbs title="Installer Configuration" :breadcrumbs="[
        ['title' => 'Dashboard', 'route' => '/', 'active' => ''],
        ['title' => 'Installer Configuration', 'route' => '', 'active' => 'active'],
    ]" />

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <div class="w-100 d-flex justify-content-between align-items-center">
                                <div class="left">
                                    <h3 class="card-title">
                                        <i class="fas fa-list mr-2"></i>
                                        List of Installers
                                    </h3>
                                </div>
                                <div class="right">
                                    <x-button-permission type="create" :permission="$userPermission" as="a" :href="route('installer-configuration.create')"
                                        class="btn btn-white" label="Add Installer" />
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="installerConfigurationTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Contact Number</th>
                                        <th>28 Day Reminder</th>
                                        <th>Action</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    @foreach ($installers as $installer)
                                        <tr>
                                            <td>{{ $installer->user->firstname }}</td>
                                            <td>{{ $installer->user->email }}</td>
                                            <td>{{ $installer->user->mobile }}</td>
                                            <td>{{ $installer->sent_available ? 'Yes' : 'No' }}</td>
                                            <td>
                                                <form
                                                    action="{{ route('installer-configuration.destroy', $installer->id) }}"
                                                    method="POST" class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="btn btn-group">
                                                        <a href="{{ route('installer-configuration.edit', $installer->id) }}"
                                                            class="btn bg-gradient-primary btn-sm">
                                                            <i class="fa fa-pencil-alt" aria-hidden="true"></i> Edit
                                                        </a>
                                                        <button type="button"
                                                            class="btn bg-gradient-danger btn-sm delete-btn">
                                                            <i class="fa fa-trash-alt" aria-hidden="true"></i> Remove
                                                        </button>
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
    <script>
        var toastType = @json(session('status'));
        let toastMessage = @json(session('message'));
    </script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    @include('includes.datatables-scripts')
    <script src="{{ asset('assets/js/installer-configuration.js') }}"></script>
@endsection
