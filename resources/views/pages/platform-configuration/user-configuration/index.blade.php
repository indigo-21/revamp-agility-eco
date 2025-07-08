@extends('layouts.app')

@section('importedStyles')
    @include('includes.datatables-links')
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
@endsection

@section('content')
    <x-title-breadcrumbs title="User Configuration" :breadcrumbs="[
        ['title' => 'Dashboard', 'route' => '/', 'active' => ''],
        ['title' => 'User Configuration', 'route' => '', 'active' => 'active'],
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
                                        List of User
                                    </h3>
                                </div>
                                <div class="right">
                                    <x-button-permission type="create" :permission="$userPermission" as="a" :href="route('user-configuration.create')"
                                        class="btn btn-white" label="Add New User" />
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name </th>
                                        <th>Email</th>
                                        <th>Organisation</th>
                                        <th>Mobile</th>
                                        <th>Landline</th>
                                        <th>User Type</th>
                                        <th>Action</th>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->firstname }} {{ $user->lastname }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->organisation }}</td>
                                            <td>{{ $user->mobile }}</td>
                                            <td>{{ $user->landline }}</td>
                                            <td>{{ $user->accountLevel->name }}</td>
                                            <td>
                                                <form action="{{ route('user-configuration.destroy', $user->id) }}"
                                                    method="POST" class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="btn-group">
                                                        <x-button-permission type="update" :permission="$userPermission" as="a"
                                                            :href="route('user-configuration.edit', $user->id)" class="btn btn-primary btn-sm"
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
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('importedScripts')
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    @include('includes.datatables-scripts')
    <script src="{{ asset('assets/js/global/table.js') }}"></script>
    <script src="{{ asset('assets/js/user-configuration.js') }}"></script>
@endsection
