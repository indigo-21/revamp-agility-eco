<div id="step3" class="card step">
    <div class="card-header">
        <h3 class="card-title">Client SLA Metrics</h3>
    </div>
    <div class="card-body">
        <div class="row validation-row">
            <div class="col-md-6">
                {{-- <x-input type="text" name="client_maximum_retries" label="Client Maximum Retries"
                    value="{{ isset($client) ? $client->clientSlaMetric->client_maximum_retries : '' }}"
                    inputformat="[0-9]" /> --}}

                <x-input type="text" name="job_deadline" label="Job deadline"
                    value="{{ isset($client) ? $client->clientSlaMetric->job_deadline : '' }}" inputformat="[0-9]" :required="true" />

                <x-input type="text" name="maximum_booking_attempts" label="Maximum Booking Attemtps"
                    value="{{ isset($client) ? $client->clientSlaMetric->maximum_booking_attempts : '' }}"
                    inputformat="[0-9]" :required="true" />

                <x-input type="text" name="maximum_remediation_attempts" label="Maximum Remediation Attemtps"
                    value="{{ isset($client) ? $client->clientSlaMetric->maximum_remediation_attempts : '' }}"
                    inputformat="[0-9]" :required="true" />
            </div>
            <div class="col-md-6">

                <x-input type="text" name="maximum_no_show" label="Maximum No Show"
                    value="{{ isset($client) ? $client->clientSlaMetric->maximum_no_show : '' }}" inputformat="[0-9]" :required="true" />

                <x-input type="text" name="maximum_number_appeals" label="Maximum Number of Appeals"
                    value="{{ isset($client) ? $client->clientSlaMetric->maximum_number_appeals : '' }}"
                    inputformat="[0-9]" :required="true" />
            </div>
            <div class="col-sm-12 col-lg-6">
                <x-client-sla-metrics title="CAT1 Remediate Notify" name="cat1_remediate_notify"
                    unit="cat1_remediate_notify_duration_unit"
                    value="{{ isset($client) ? $client->clientSlaMetric->cat1_remediate_notify : '' }}"
                    unitValue="{{ isset($client) ? $client->clientSlaMetric->cat1_remediate_notify_duration_unit : '' }}" />

                <x-client-sla-metrics title="CAT1 Remediate Complete" name="cat1_remediate_complete"
                    unit="cat1_remediate_complete_duration_unit"
                    value="{{ isset($client) ? $client->clientSlaMetric->cat1_remediate_complete : '' }}"
                    unitValue="{{ isset($client) ? $client->clientSlaMetric->cat1_remediate_complete_duration_unit : '' }}" />

                <x-client-sla-metrics title="CAT1 Reinspect Remediation" name="cat1_reinspect_remediation"
                    unit="cat1_reinspect_remediation_duration_unit"
                    value="{{ isset($client) ? $client->clientSlaMetric->cat1_reinspect_remediation : '' }}"
                    unitValue="{{ isset($client) ? $client->clientSlaMetric->cat1_reinspect_remediation_duration_unit : '' }}" />

                <x-client-sla-metrics title="CAT1 Challenge" name="cat1_challenge" unit="cat1_challenge_duration_unit"
                    value="{{ isset($client) ? $client->clientSlaMetric->cat1_challenge : '' }}"
                    unitValue="{{ isset($client) ? $client->clientSlaMetric->cat1_challenge_duration_unit : '' }}" />

                <x-client-sla-metrics title="CAT1 remediate no access" name="cat1_remediate_no_access"
                    unit="cat1_remediate_no_access_duration_unit"
                    value="{{ isset($client) ? $client->clientSlaMetric->cat1_remediate_no_access : '' }}"
                    unitValue="{{ isset($client) ? $client->clientSlaMetric->cat1_remediate_no_access_duration_unit : '' }}" />

                <x-client-sla-metrics title="CAT1 unremediated" name="cat1_unremediated"
                    unit="cat1_unremediated_duration_unit"
                    value="{{ isset($client) ? $client->clientSlaMetric->cat1_unremediated : '' }}"
                    unitValue="{{ isset($client) ? $client->clientSlaMetric->cat1_unremediated_duration_unit : '' }}" />
            </div>
            <div class="col-sm-12 col-lg-6">
                <x-client-sla-metrics title="NC Remediate Notify" name="nc_remediate_notify"
                    unit="nc_remediate_notify_duration_unit"
                    value="{{ isset($client) ? $client->clientSlaMetric->nc_remediate_notify : '' }}"
                    unitValue="{{ isset($client) ? $client->clientSlaMetric->nc_remediate_notify_duration_unit : '' }}" />

                <x-client-sla-metrics title="NC Remediate Complete" name="nc_remediate_complete"
                    unit="nc_remediate_complete_duration_unit"
                    value="{{ isset($client) ? $client->clientSlaMetric->nc_remediate_complete : '' }}"
                    unitValue="{{ isset($client) ? $client->clientSlaMetric->nc_remediate_complete_duration_unit : '' }}" />

                <x-client-sla-metrics title="NC Reinspect Remediation" name="nc_reinspect_remediation"
                    unit="nc_reinspect_remediation_duration_unit"
                    value="{{ isset($client) ? $client->clientSlaMetric->nc_reinspect_remediation : '' }}"
                    unitValue="{{ isset($client) ? $client->clientSlaMetric->nc_reinspect_remediation_duration_unit : '' }}" />

                <x-client-sla-metrics title="NC Challenge" name="nc_challenge" unit="nc_challenge_duration_unit"
                    value="{{ isset($client) ? $client->clientSlaMetric->nc_challenge : '' }}"
                    unitValue="{{ isset($client) ? $client->clientSlaMetric->nc_challenge_duration_unit : '' }}" />

                <x-client-sla-metrics title="NC remediate no access" name="nc_remediate_no_access"
                    unit="nc_remediate_no_access_duration_unit"
                    value="{{ isset($client) ? $client->clientSlaMetric->nc_remediate_no_access : '' }}"
                    unitValue="{{ isset($client) ? $client->clientSlaMetric->nc_remediate_no_access_duration_unit : '' }}" />

                <x-client-sla-metrics title="NC unremediated" name="nc_unremediated"
                    unit="nc_unremediated_duration_unit"
                    value="{{ isset($client) ? $client->clientSlaMetric->nc_unremediated : '' }}"
                    unitValue="{{ isset($client) ? $client->clientSlaMetric->nc_unremediated_duration_unit : '' }}" />

            </div>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end align-items-center">
        <button type="button" class="btn btn-secondary prev w-25 mx-2">Previous</button>
        <button type="button" class="btn btn-primary next w-25 mx-2">Next</button>
    </div>
</div>
