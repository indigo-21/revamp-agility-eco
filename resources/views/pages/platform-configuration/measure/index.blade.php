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
    <x-title-breadcrumbs title="Measure Configuration" :breadcrumbs="[
        ['title' => 'Dashboard', 'route' => '/', 'active' => ''],
        ['title' => 'Measure Configuration', 'route' => '', 'active' => 'active'],
    ]" />
    
    @if (session('success'))
        <div class="container-fluid">
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        </div>
    @endif
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
                                        List of Measures
                                    </h3>
                                </div>
                                <div class="right">
                                    <a type="button" class="btn btn-white" href="{{ route('measure.create') }}">
                                        <i class="fa fa-plus-square mr-1" aria-hidden="true"></i> Add Measure
                                    </a>

                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="installerConfigurationTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Measure CAT</th>
                                        <th>Measure Cert Description</th>
                                        <th>Measure Cert Required</th>
                                        <th>Measure Min Qual</th>
                                        <th>Action</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    @foreach ($measures as $measure)
                                        <tr>
                                            <td>{{ $measure->measure_cat }}</td>
                                            <td>{{ $measure->cert_description }}</td>
                                            <td>{{ $measure->cert_required == 0 ? 'Yes' : 'No' }}</td>
                                            <td>{{ $measure->measure_min_qual }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('measure.edit', $measure->id) }}"
                                                        class="btn btn-warning btn-sm">Edit</a>
                                                    <form action="{{ route('measure.destroy', $measure->id) }}"
                                                        method="POST" class="delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm delete-btn">Delete</button>
                                                    </form>
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
