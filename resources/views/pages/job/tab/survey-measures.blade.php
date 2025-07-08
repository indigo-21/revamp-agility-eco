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
        <x-job-details label="Date Survey" value="{{ $job->first_visit_by }}" />
        <x-job-details label="Measure CAT" value="{{ $job->jobMeasure->measure->measure_cat }}" />
        <x-job-details label="Certificate Expiry"
            value="{{ $job->propertyInspector?->propertyInspectorMeasures->where('measure_id', $job->jobMeasure->measure_id)->first()?->expiry }}" />
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
                            @if (!$completedJob->surveyQuestion->score_monitoring)
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
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
