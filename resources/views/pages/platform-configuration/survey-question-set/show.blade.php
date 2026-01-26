@extends('layouts.app')

@section('importedStyles')
    @include('includes.datatables-links')
@endsection

@section('content')
    <x-title-breadcrumbs title="Survey Question Set" :breadcrumbs="[
        ['title' => 'Dashboard', 'route' => '/', 'active' => ''],
        ['title' => 'Survey Question Set', 'route' => '', 'active' => 'active'],
    ]" />

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">



            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-body">
                            <div class="row">
                                <!-- /.col -->
                                <div class="col-md-12 mb-4">
                                    <div class="text-center">
                                        <h3>{{ $surveyQuestionSets->question_revision }}</h3>
                                        <hr style="width: 50px; margin: auto; border: 1px solid #000;" class="mb-2">
                                        <h6>Question Set</h6>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="info-box bg-default">
                                        <span class="info-box-icon"><i class="fas fa-comments"></i></span>

                                        <div class="info-box-content">
                                            <span class="info-box-text">Total Questions</span>
                                            <span class="info-box-number">{{ $surveyQuestions->count() }}</span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                    <!-- /.info-box -->
                                </div>
                                <!-- /.col -->
                                <!-- /.col -->
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="info-box bg-default">
                                        <span class="info-box-icon"><i class="fas fa-clipboard"></i></span>

                                        <div class="info-box-content">
                                            <span class="info-box-text">Survey Revision</span>
                                            <span class="info-box-number">{{ $surveyQuestionSets->question_set_file }}</span>

                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                    <!-- /.info-box -->
                                </div>
                                <!-- /.col -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->








            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <div class="w-100 d-flex justify-content-between align-items-center">
                                <div class="left">
                                    <h3 class="card-title">
                                        <i class="fas fa-list mr-2"></i>
                                        List of Questions
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
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
                                    @foreach ($surveyQuestions as $surveyQuestion)
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
    <script src="{{ asset('assets/js/survey-question-set.js') }}"></script>
@endsection
