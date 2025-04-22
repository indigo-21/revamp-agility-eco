@extends('layouts.app')

@section('importedStyles')
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
    @include('includes.datatables-links')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Survey Question Set</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Survey Question Set</li>
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
                                        List of Survey Questions
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
                                                {{ $scheme->surveyQuestionSet->question_set }}
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
                                                        <a class="btn btn-primary btn-sm"
                                                            href="{{ route('scheme.edit', $scheme->id) }}">
                                                            <i class="fas fa-pencil-alt"></i>Edit
                                                        </a>
                                                        <button type="button" class="btn btn-danger btn-sm delete-btn">
                                                            <i class="fas fa-trash"></i>Delete
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