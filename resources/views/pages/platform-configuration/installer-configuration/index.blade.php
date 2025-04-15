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
                    <h1 class="m-0">Installer Configuration</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Installer Configuration</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

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
                                    <a type="button" class="btn btn-white"
                                        href="{{route('installer-configuration.create')}}">
                                        <i class="fa fa-plus-square mr-1" aria-hidden="true"></i> Create Installer
                                    </a>
                                    {{-- <a type="button" class="btn bg-gradient-warning" href="">
                                        <i class="fa fa-upload mr-1" aria-hidden="true"></i> Upload CSV
                                    </a> --}}
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
                                        <th>Action</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    @foreach ($installers as $installer)
                                        <tr>
                                            <td>{{ $installer->user->firstname }}</td>
                                            <td>{{ $installer->user->email }}</td>
                                            <td>{{ $installer->user->mobile }}</td>
                                            <td>
                                                <div>
                                                    <button type="button" class="btn bg-gradient-primary">
                                                        <i class="fa fa-pencil-alt" aria-hidden="true"></i>&nbsp; Edit
                                                    </button>
                                                    <button type="button" class="btn bg-gradient-danger">
                                                        <i class="fa fa-trash-alt" aria-hidden="true"></i>&nbsp; Remove
                                                    </button>
                                                </div>

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
    <script src="{{ asset('assets/js/installer-configuration.js') }}"></script>
@endsection