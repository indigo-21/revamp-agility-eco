<div class="row pt-4">
    <div class="col-md-12 mb-3">
        <h3>Job Status</h3>
    </div>
    <div class="col-md-6">
        <x-job-details label="Job Status" value="{{ $job->jobStatus->description }}" />
        <x-job-details label="Last Updated" value="{{ $job->last_update }}" />
        <x-job-details label="Job Deadline" value="{{ $job->deadline }}" />
        <x-job-details label="Job First Visit By" value="{{ $job->first_visit_by }}" />
        <x-job-details label="Job Schedule Date" value="{{ $job->schedule_date }}" />
        <x-job-details label="Assigend PI"
            value="{{ $job->propertyInspector->user->firstname }} 
            {{ $job->propertyInspector->user->lastname }}" />
    </div>
    <div class="col-md-6">
        <x-job-details label="CSV Filename" value="{{ $job->csv_filename }}" />
        <x-job-details label="# Attempts" value="{{ $job->max_attempts }}" />
        <x-job-details label="# No Shows" value="{{ $job->max_noshow }}" />
        <x-job-details label="# Remediation" value="{{ $job->max_remediation }}" />
        <x-job-details label="# Appeals" value="{{ $job->max_appeal }}" />

    </div>
</div>

<div class="row pt-4">
    <div class="col-md-6">
        <div class="row mb-3">
            <h3>Job Remediation</h3>
        </div>
        <x-job-details label="Non-Conformance Level" value="{{ $job->job_remediation_type }}" />
        <x-job-details label="Remediation Deadline" value="{{ $job->rework_deadline }}" />
        <x-job-details label="Installer" value="{{ $job->installer->user->firstname }}" />
        <x-job-details label="Installer Email Address" value="{{ $job->installer->user->email }}" />
        <x-job-details label="Installer Contact" value="{{ $job->installer->user->mobile }}" />
    </div>

    <div class="col-md-6">
        <div class="row mb-3">
            <h3>Job Financials</h3>
        </div>
        <x-job-details label="Job Close Date" value="{{ $job->close_date }}" />
        <x-job-details label="Job Invoice Status" value="{{ $job->invoice_status }}" />
    </div>
</div>
