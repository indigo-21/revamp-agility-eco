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
                    <h1 class="m-0">Installer Portal</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"> <a href="{{ route('installer-portal.index') }}">Remediation</a></li>
                        <li class="breadcrumb-item active">Non-Compliances</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="callout callout-info">
                                <h3>Measure Cert Remediation Advice</h3>
                                <p>{{ $job->jobMeasure->measure->cert_remediation_advice }}</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{ $completedJobs->count() }}</h3>

                                    <p>Total Non-Compliances - Pending</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-times"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="callout callout-info">
                        <p>The measures that you installed and lodged with <b>{{ env('EMPLOYER') }}</b> having
                            certificate
                            number
                            <b>{{ $job->cert_no }}</b> and Unique Measure Reference (UMR)
                            <b>{{ $job->jobMeasure->umr }}</b>
                            at <b>{{ $job->property->address1 }} {{ $job->property->city }}
                                {{ $job->property->county }}
                                {{ $job->property->postcode }}</b> was subject to a Quality Audit Inspection. Some
                            of the
                            work done
                            has been deemed to be non-compliant on one or more points. <br><br>
                            Please review the findings of our inspection and use the form below to submit detailed
                            evidence
                            of the remediation work required to ensure compliance. Please ensure all work is done,
                            and
                            evidence submitted prior to deadline.<br><br>
                            Use "Add Comments" button to add comments. Use "Add Picture/File" to upload images,
                            manuals,
                            etc. Once all evidence has been uploaded for a particular question click on "Submit".
                            For
                            security reasones onlu files of type PDF and JPG can be uploaded. Max file size is: 50MB
                        </p>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-body">
                            <table id="remediationReviewTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Agility Eco Reference</th>
                                        <th>Non-Comliance Type</th>
                                        <th>Auditor Comments</th>
                                        <th>Installer Comments</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($completedJobs as $completedJob)
                                        @if ($completedJob->remediations->last()?->role == 'Agent' || $completedJob->remediations->isEmpty())
                                            <tr>
                                                <td>
                                                    {{ $completedJob->job->job_number }}{{ $completedJob->surveyQuestion->question_number }}
                                                </td>
                                                <td>
                                                    {{ $completedJob->surveyQuestion->nc_severity }}
                                                </td>
                                                <td>
                                                    {{ $completedJob->remediations->where('role', 'Agent')->last()?->comment }}
                                                </td>
                                                <td>
                                                    {{ $completedJob->remediations->where('role', 'Installer')->last()?->comment }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('installer-portal.edit', $completedJob->id) }}"
                                                        class="btn btn-primary btn-sm">View Details</a>
                                                </td>
                                            </tr>
                                        @endif
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
    <script src="{{ asset('assets/js/global/table.js') }}"></script>
@endsection
