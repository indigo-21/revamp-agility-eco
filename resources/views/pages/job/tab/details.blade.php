<div class="row pt-4">
    <div class="col-md-6">
        <div class="row mb-3">
            <h3>Job Details</h3>
        </div>
        <x-job-details label="Client" value="{{ $job->client->user->firstname }}" />
        <x-job-details label="Client Cert#" value="{{ $job->cert_no }}" />
        <x-job-details label="Client UMR" value="{{ $job->jobMeasure->umr }}" />
        <x-job-details label="Installer" value="{!! $job->installer?->user->firstname !!}" />
        <x-job-details label="Installer TMLN" value="{{ $job->sub_installer_tmln }}" />
        <x-job-details label="Sub-Installer" value="{{ $job->lodged_by_name }}" />
        <x-job-details label="Sub-Installer TMLN" value="{{ $job->lodged_by_tmln }}" />
    </div>

    <div class="col-md-6">
        <div class="row mb-3">
            <h3>Property Address</h3>
        </div>
        <x-job-details label="Address"
            value=" 
            {{ $job->property->house_flat_prefix }}
            {{ $job->property->address1 }} 
            {{ $job->property->address2 }} 
            {{ $job->property->address3 }}" />
        <x-job-details label="City" value="{{ $job->property->city }}" />
        <x-job-details label="County" value="{{ $job->property->county }}" />
        <x-job-details label="Postcode" value="{{ $job->property->postcode }}" />
    </div>

    <div class="col-md-6">
        <div class="row mb-3">
            <h3>Measure Details</h3>
        </div>
        <x-job-details label="Scheme" value="{{ $job->scheme?->short_name }}" />
        <x-job-details label="Measure CAT" value="{{ $job->jobMeasure->measure->measure_cat }}" />
        <x-job-details label="Measure Info" value="{{ $job->jobMeasure->info }}" />
    </div>

    <div class="col-md-6">
        <div class="row mb-3">
            <h3>Property Contact Details</h3>
        </div>
        <x-job-details label="Name" value="{{ $job->customer->customer_name }}" />
        <x-job-details label="Primary Contact Number" value="{{ $job->customer->customer_primary_tel }}" />
        <x-job-details label="Secondary Contact Number" value="{{ $job->customer->customer_secondary_tel }}" />
        <x-job-details label="Email" value="{{ $job->customer->customer_email }}" />
    </div>
</div>
