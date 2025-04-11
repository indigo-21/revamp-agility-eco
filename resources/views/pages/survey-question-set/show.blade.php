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
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>                                       
                                        <th>Question Number</th>
                                        <th>Measure Cat</th>
                                        <th>Inspection Stage</th>
                                        <th>Question</th>
                                        <th>Score Monitoring</th>
                                        <th>NC Severity</th>
                                        <th>Measure Type</th>
                                        <th>Innovation Product</th>
                                </thead>
                                <tbody>
                                    @foreach ($surveyQuestionSets as $surveyQuestion)
                                    <tr>
                                        <td>{{ $surveyQuestion['question_number'] }}</td>
                                        <td>{{ $surveyQuestion['measure_cat'] }}</td>
                                        <td>{{ $surveyQuestion['inspection_stage'] }}</td>
                                        <td>{{ $surveyQuestion['question'] }}</td>
                                        <td>{{ $surveyQuestion['score_monitoring'] }}</td>
                                        <td>{{ $surveyQuestion['nc_severity'] }}</td>
                                        <td>{{ $surveyQuestion['measure_type'] }}</td>
                                        <td>{{ $surveyQuestion['innovation_product'] }}</td>
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
    <script src="{{ asset('assets/js/property-inspector.js') }}"></script>
@endsection
