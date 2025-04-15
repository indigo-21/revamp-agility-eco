@extends('layouts.app')

@section('importedStyles')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Scheme Configuration</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Scheme Configuration</li>
                        <li class="breadcrumb-item active">Create Form</li>
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
                                        <i class="fa fa-pencil-alt mr-2"></i>
                                        Create Scheme
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <form method="POST"
                            action="{{ isset($scheme) ? route('scheme.update', $scheme) : route('scheme.store') }}">
                            @csrf
                            @if (isset($scheme))
                                @method('PUT')
                            @endif
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <x-input name="short_name" label="Short Name"
                                            value="{{ isset($scheme) ? $scheme->short_name : '' }}" />

                                        <x-input name="long_name" label="Long Name"
                                            value="{{ isset($scheme) ? $scheme->long_name : '' }}" />

                                        <x-select label="Survey Question Set" name="survey_question_set_id"
                                            :multiple="false">
                                            <option selected="selected" disabled value="">- Survey Question Set -
                                            </option>
                                            @foreach ($survey_question_set as $question_set)
                                                <option value="{{ $question_set->id }}"
                                                    {{ isset($scheme) && $scheme->survey_question_set_id === $question_set->id ? 'selected' : '' }}>
                                                    {{ $question_set->question_set }}
                                                </option>
                                            @endforeach
                                        </x-select>
                                    </div>
                                    <div class="col-md-6">
                                        <x-textarea name="description" label="Description" rows="5"
                                            value="{{ isset($scheme) ? $scheme->description : '' }}" />

                                        {{-- <div class="form-group">
                                            <label>Textarea</label>
                                            <textarea class="form-control" rows="3" placeholder="Enter ..." data-qb-tmp-id="lt-970335" spellcheck="false"
                                                data-gramm="false" name="description">{{ isset($scheme) ? $scheme->description : '' }}</textarea>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary d-block m-auto w-100">Submit</button>
                            </div>
                        </form>
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
    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function() {
            $('.select2').select2();
        });
    </script>
@endsection
