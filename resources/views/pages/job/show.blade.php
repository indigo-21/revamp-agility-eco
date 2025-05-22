@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Job Details</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/job">Manage Jobs</a></li>
                        <li class="breadcrumb-item active">Job Details</li>
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
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <h1>{{ $job->job_number }}</h1>
                                    <p>{{ $job->jobStatus->description }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <ul class="nav nav-tabs" id="custom-content-above-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="custom-content-above-status-tab"
                                                data-toggle="pill" href="#custom-content-above-status" role="tab"
                                                aria-controls="custom-content-above-status" aria-selected="true">Status</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-content-above-details-tab" data-toggle="pill"
                                                href="#custom-content-above-details" role="tab"
                                                aria-controls="custom-content-above-details"
                                                aria-selected="false">Details</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-content-above-booking-history-tab"
                                                data-toggle="pill" href="#custom-content-above-booking-history"
                                                role="tab" aria-controls="custom-content-above-booking-history"
                                                aria-selected="false">Booking History</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-content-above-survey-sm-tab" data-toggle="pill"
                                                href="#custom-content-above-survey-sm" role="tab"
                                                aria-controls="custom-content-above-survey-sm" aria-selected="false">Survey
                                                SM</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-content-above-survey-measures-tab"
                                                data-toggle="pill" href="#custom-content-above-survey-measures"
                                                role="tab" aria-controls="custom-content-above-survey-measures"
                                                aria-selected="false">Survey Measures</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-content-above-update-survey-history-tab"
                                                data-toggle="pill" href="#custom-content-above-update-survey-history"
                                                role="tab" aria-controls="custom-content-above-update-survey-history"
                                                aria-selected="false">Update Survey History</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-content-above-remediation-history-tab"
                                                data-toggle="pill" href="#custom-content-above-remediation-history"
                                                role="tab" aria-controls="custom-content-above-remediation-history"
                                                aria-selected="false">Remediation History</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-content-above-invoice-history-tab"
                                                data-toggle="pill" href="#custom-content-above-invoice-history"
                                                role="tab" aria-controls="custom-content-above-invoice-history"
                                                aria-selected="false">Invoice History</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="custom-content-above-tabContent">
                                        <div class="tab-pane fade show active" id="custom-content-above-status"
                                            role="tabpanel" aria-labelledby="custom-content-above-status-tab">
                                            @include('pages.job.tab.status')
                                        </div>
                                        <div class="tab-pane fade" id="custom-content-above-details" role="tabpanel"
                                            aria-labelledby="custom-content-above-details-tab">
                                            @include('pages.job.tab.details')
                                        </div>
                                        <div class="tab-pane fade" id="custom-content-above-booking-history"
                                            role="tabpanel" aria-labelledby="custom-content-above-booking-history-tab">
                                            @include('pages.job.tab.booking-history')
                                        </div>
                                        <div class="tab-pane fade" id="custom-content-above-survey-sm" role="tabpanel"
                                            aria-labelledby="custom-content-above-survey-sm-tab">
                                            @include('pages.job.tab.survey-sm')
                                        </div>
                                        <div class="tab-pane fade" id="custom-content-above-survey-measures"
                                            role="tabpanel" aria-labelledby="custom-content-above-survey-measures-tab">
                                            @include('pages.job.tab.survey-measures')
                                        </div>
                                        <div class="tab-pane fade" id="custom-content-above-update-survey-history"
                                            role="tabpanel"
                                            aria-labelledby="custom-content-above-update-survey-history-tab">
                                            @include('pages.job.tab.update-survey-history')
                                        </div>
                                        <div class="tab-pane fade" id="custom-content-above-remediation-history"
                                            role="tabpanel"
                                            aria-labelledby="custom-content-above-remediation-history-tab">
                                            @include('pages.job.tab.remediation-history')
                                        </div>
                                        <div class="tab-pane fade" id="custom-content-above-invoice-history"
                                            role="tabpanel" aria-labelledby="custom-content-above-invoice-history-tab">
                                            @include('pages.job.tab.invoice-history')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
