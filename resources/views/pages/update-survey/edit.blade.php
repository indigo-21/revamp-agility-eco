@extends('layouts.app')
@section('importedStyles')
    @include('includes.datatables-links')
    <link rel="stylesheet" href="{{ asset('plugins/dropzone/min/dropzone.min.css') }}">
@endsection
@section('content')
    <x-title-breadcrumbs title="Update Survey" :breadcrumbs="[
        ['title' => 'Dashboard', 'route' => '/', 'active' => ''],
        ['title' => 'Update Survey', 'route' => '/update-survey', 'active' => ''],
        ['title' => 'Job Number: ' . $job->job_number, 'route' => '', 'active' => 'active'],
    ]" />

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-3 col-sm-12">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <h3 class="profile-username text-center">{{ $job->job_number }}</h3>
                            <p class="text-muted text-center">
                                <span class="right badge badge-{{ $job->jobStatus->color_scheme }}">
                                    {{ $job->jobStatus->description }} -
                                    {{ $job->job_remediation_type === '' ? 'Passed' : $job->job_remediation_type }}
                                </span>
                            </p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Measure CAT</b> <a
                                        class="float-right">{{ $job->jobMeasure->measure->measure_cat }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Survey Question Set</b> <a
                                        class="float-right">{{ $job->scheme->surveyQuestionSet->question_set }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Revision Number</b> <a
                                        class="float-right">{{ $job->scheme->surveyQuestionSet->question_revision }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Date of Survey</b> <a class="float-right">{{ $job->schedule_date }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Property Inspector</b> <a class="float-right">
                                        {{ $job->propertyInspector?->user->firstname }}
                                        {{ $job->propertyInspector?->user->lastname }}
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <b>Installer</b> <a class="float-right">
                                        {{ $job->installer?->user->firstname }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <div class="col-md-9 col-sm-12">
                    <div class="card card-primary card-outline">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="remediationReviewTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Question Number</th>
                                        <th>Question</th>
                                        <th>Pass / Fail</th>
                                        <th>Comments</th>
                                        <th>Photo</th>
                                        <th>Time</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($job->completedJobs as $completedJob)
                                        <tr>
                                            <td>{{ $completedJob->surveyQuestion->question_number }}</td>
                                            <td>{{ $completedJob->surveyQuestion->question }}</td>
                                            <td>{{ $completedJob->pass_fail }}</td>
                                            <td>{{ $completedJob->comments }}</td>
                                            <td>
                                                @forelse ($completedJob->completedJobPhotos as $completedJobPhoto)
                                                    <img src="{{ asset("storage/completed_job_photos/{$completedJobPhoto->filename}") }}"
                                                        alt="" width="50" height="70"
                                                        style="object-fit: cover; margin: 5px;">
                                                @empty
                                                    <span class="badge badge-warning">No Photo</span>
                                                @endforelse
                                            </td>
                                            <td>{{ $completedJob->time }}</td>
                                            <td>{{ $completedJob->created_at }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <x-button-permission type="create" :permission="$userPermission"
                                                        class="btn btn-primary btn-sm passFail" label="Pass/Fail"
                                                        data-target="#updateSurveyModal" data-toggle="modal"
                                                        data-completed-job-data="{{ $completedJob }}"
                                                        data-utv-allowed="{{ $completedJob->surveyQuestion->unable_to_validate_allowed }}"
                                                        data-na-allowed="{{ $completedJob->surveyQuestion->na_allowed }}" />
                                                    <x-button-permission type="create" :permission="$userPermission"
                                                        class="btn btn-warning btn-sm editComments" label="Comments"
                                                        data-target="#addCommentModal" data-toggle="modal"
                                                        data-completed-job-data="{{ $completedJob }}" />
                                                    <x-button-permission type="create" :permission="$userPermission" as="a"
                                                        :href="route('update-survey.show', $completedJob->id)" class="btn btn-secondary btn-sm" label="Images" />
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="updateSurveyModal" tabindex="-1" role="dialog"
            aria-labelledby="updateSurveyModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form action="" method="POST" id="updatePassFail">
                        @method('PATCH')
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Edit Pass/Fail</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="job_id" value="{{ $job->id }}">
                            <x-select label="Select" name="pass_fail" :multiple="false" id="pass_fail">
                                <option value="Passed">Passed</option>
                                <option value="Non-Compliant">Non-Compliant</option>
                                {{-- <option value="Unable to Validate">Unable to Validate</option>
                            <option value="N/A">N/A</option> --}}
                            </x-select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addCommentModal" tabindex="-1" role="dialog" aria-labelledby="addCommentModalTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">

                    <form action="" method="POST" id="updateCommentForm">
                        @method('PATCH')
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Edit Comments</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="job_id" value="{{ $job->id }}">
                            <x-textarea name="comments" label="Comments" rows="3" placeholder="Enter Comments" />
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>

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
    <script src="{{ asset('assets/js/update-survey.js') }}"></script>
@endsection
