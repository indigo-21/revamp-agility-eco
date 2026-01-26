@extends('layouts.app')

@section('importedStyles')
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
    @include('includes.datatables-links')
@endsection

@section('content')
    <x-title-breadcrumbs title="Scheme" :breadcrumbs="[
        ['title' => 'Dashboard', 'route' => '/', 'active' => ''],
        ['title' => 'Scheme', 'route' => '', 'active' => 'active'],
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
                                        List of Schemes
                                    </h3>
                                </div>
                                <div class="right">
                                    <a class="btn btn-white mb-2" href="{{ route('scheme.create') }}">
                                        <i class="fa fa-plus-square mr-1" aria-hidden="true"></i> Add Scheme
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Scheme Short Name</th>
                                        <th>Scheme Long Name</th>
                                        <th>Scheme Question Set</th>
                                        <th>Scheme Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($schemes as $scheme)
                                        <tr>
                                            <td>
                                                {{ $scheme->short_name }}
                                            </td>
                                            <td>
                                                {{ $scheme->long_name }}
                                            </td>
                                            <td>
                                                {{ $scheme->surveyQuestionSet->question_revision }}
                                            </td>
                                            <td>
                                                {{ $scheme->description }}
                                            </td>
                                            <td>
                                                <form action="{{ route('scheme.destroy', $scheme->id) }}" method="POST"
                                                    class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="btn-group">
                                                        <x-button-permission type="update" :permission="$userPermission" as="a"
                                                            :href="route('scheme.edit', $scheme->id)" class="btn btn-primary btn-sm"
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
    <script>
        var toastType = @json(session('success'));
    </script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    @include('includes.datatables-scripts')
    <script src="{{ asset('assets/js/scheme.js') }}"></script>
@endsection
