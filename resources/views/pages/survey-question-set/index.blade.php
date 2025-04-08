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

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="right w-100">
                                <div class="d-flex justify-content-end align-items-center">
                                    <button type="button" class=" btn btn-outline-primary mb-2" data-toggle="modal"
                                        data-target="#upload-csv">
                                        <i class="fa fa-plus-circle" aria-hidden="true"></i> Upload Question Set
                                    </button>
                                </div>
                            </div>
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
                                            <td>{{ $surveyQuestionSet['question_revision']}}</td>
                                            <td>{{ $surveyQuestionSet['updated_at']}}</td>
                                            <td>{{ $surveyQuestionSet['question_set']}}</td>
                                            <td></td>
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
                                <label for="question-revision">Question Revision</label>
                                <input type="text" name="question_revision" class="form-control" id="question-revision"
                                    placeholder="Question Revision">
                            </div>
                            <div class="form-group">
                                <label for="survey-question-set">Survey Question Set</label>
                                <input type="text" name="question_set" class="form-control" id="survey-question-set"
                                    placeholder="Survey Question Set">
                            </div>
                            <div class="form-group">
                                <label for="select-csv">Select CSV</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="question_set_file" class="custom-file-input"
                                            id="select-csv">
                                        <label class="custom-file-label" for="select-csv">Choose file</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text">Upload</span>
                                      </div>
                                </div>
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
    @include('includes.datatables-scripts')
    <script src="{{ asset('assets/js/property-inspector.js') }}"></script>
@endsection
