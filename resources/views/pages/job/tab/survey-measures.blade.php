<div class="row pt-4">
    <div class="col-md-12 mb-3">
        <h3>Job Status</h3>
    </div>
    <div class="col-md-6">
        <x-job-details label="Survey Question Set" value="{{ $job->scheme->surveyQuestionSet->question_revision }}" />
        <x-job-details label="Revision Number" value="{{ $job->scheme->surveyQuestionSet->question_set }}" />
        <x-job-details label="Survey Question Last Update" value="{{ $job->scheme->surveyQuestionSet->created_at }}" />
        <x-job-details label="PI Registered Number" value="{{ $job->propertyInspector->registered_id_number }}" />
    </div>
    <div class="col-md-6">
        <x-job-details label="Date Survey" value="{{ $job->first_visit_by }}" />
        <x-job-details label="Measure CAT" value="{{ $job->jobMeasure->measure->measure_cat }}" />
        <x-job-details label="Certificate Expiry"
            value="{{ $job->propertyInspector->propertyInspectorMeasures
            ->where('measure_id', $job->jobMeasure->measure_id)
            ->first()?->expiry }}" />
    </div>
</div>
