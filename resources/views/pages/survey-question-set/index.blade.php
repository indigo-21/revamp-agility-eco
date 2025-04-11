@extends('layouts.app')

@section('importedStyles')
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
                                    <button type="button" class=" btn btn-white mb-2" data-toggle="modal"
                                        data-target="#upload-csv">
                                        <i class="fa fa-plus-square mr-1" aria-hidden="true"></i> Upload Question Set
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Survey Question Revision</th>
                                        <th>Survey Question Last Update</th>
                                        <th>Survey Question Set</th>
                                        <th>Action</th>
                                </thead>
                                <tbody>
                                    @foreach ($surveyQuestionSets as $surveyQuestionSet)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $surveyQuestionSet['question_revision'] }}</td>
                                            <td>{{ $surveyQuestionSet['updated_at'] }}</td>
                                            <td>{{ $surveyQuestionSet['question_set'] }}</td>
                                            <td>
                                                <a href="{{ route('survey-question-set.show', $surveyQuestionSet) }}"
                                                    class="btn btn-primary btn-sm btn-block">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>&nbsp; View
                                                </a>
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

    <div class="modal fade" id="upload-csv">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Survey Question Set</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action=" {{ route('survey-question-set.store') }} " method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <x-input name="question_revision" label="Question Revision" type="text" />
                            </div>
                            <div class="form-group">
                                <x-input name="question_set" label="Survey Question Set" type="text" />
                            </div>
                            <div class="form-group">
                                <x-file name="question_set_file" label="Select CSV" />

                            </div>
                        </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection

@section('importedScripts')
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    @include('includes.datatables-scripts')
    <script src="{{ asset('assets/js/survey-question-set.js') }}"></script>
@endsection
