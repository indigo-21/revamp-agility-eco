<div class="row pt-4">
    <div class="col-md-12 mb-3">
        <h3>Job Status</h3>
    </div>
    <div class="col-md-6">
        <x-job-details label="Survey Question Set" value="{{ $job->scheme?->surveyQuestionSet->question_revision }}" />
        <x-job-details label="Revision Number" value="{{ $job->scheme?->surveyQuestionSet->question_set }}" />
        <x-job-details label="Survey Question Last Update" value="{{ $job->scheme?->surveyQuestionSet->created_at }}" />
        <x-job-details label="PI Registered Number" value="{{ $job->propertyInspector?->registered_id_number }}" />
    </div>
    <div class="col-md-6">
        <x-job-details label="Date Survey" value="{{ $job->schedule_date }}" />
        <x-job-details label="Measure CAT" value="{{ $job->jobMeasure?->measure->measure_cat }}" />
    </div>
    <div class="col-md-12">
        <div class="card">
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
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($job->completedJobs as $completedJob)
                            @if ($completedJob->surveyQuestion->score_monitoring)
                                <tr>
                                    <td>{{ $completedJob->surveyQuestion->question_number }}</td>
                                    <td>{{ $completedJob->surveyQuestion->question }}</td>
                                    <td>{{ $completedJob->pass_fail }}</td>
                                    <td>{{ $completedJob->comments }}</td>
                                    <td>
                                        @forelse ($completedJob->completedJobPhotos as $completedJobPhoto)
                                            <button type="button" class="btn p-0" data-toggle="modal" data-target="#imageModal-{{ $completedJobPhoto->id }}" aria-label="Open image" onclick="$('#imageModal-{{ $completedJobPhoto->id }}').modal('show');">
                                                <img src="{{ asset("storage/completed_job_photos/{$completedJobPhoto->filename}") }}"
                                                    alt="" width="50" height="70"
                                                    style="object-fit: cover; margin: 5px;">
                                            </button>

                                            <!-- Modal for this image -->
                                            <div class="modal fade" id="imageModal-{{ $completedJobPhoto->id }}" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel-{{ $completedJobPhoto->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="imageModalLabel-{{ $completedJobPhoto->id }}">Image Preview</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <img src="{{ asset("storage/completed_job_photos/{$completedJobPhoto->filename}") }}" class="img-fluid" alt="Preview">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <span class="badge badge-warning">No Photo</span>
                                        @endforelse
                                    </td>
                                    <td>{{ $completedJob->time }}</td>
                                    <td>{{ $completedJob->created_at }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- modals for each image are rendered inline above; no custom scripts required -->
