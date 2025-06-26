<div id="step1" class="card step active-step">
    <div class="card-header">
        <h3 class="card-title">Client Key Details</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <div class="row">
                    <div class="col-sm-12 col-lg-6">
                        <x-radio-layout label="Active">
                            <div class="col-md-6">
                                <x-radio label="Yes" name="is_active" id="active_yes" :checked="isset($client)
                                    ? ($client->clientKeyDetails->is_active == 1
                                        ? true
                                        : false)
                                    : true"
                                    :value="1" />
                            </div>
                            <div class="col-md-6">
                                <x-radio label="No" name="is_active" id="active_no" :checked="isset($client)
                                    ? ($client->clientKeyDetails->is_active == 0
                                        ? true
                                        : false)
                                    : false"
                                    :value="0" />
                            </div>
                        </x-radio-layout>

                        <x-input type="text" name="firstname" label="Client Name"
                            value="{{ isset($client) ? $client->user->firstname : '' }}" />

                        <x-input type="text" name="client_abbrevation" label="Client Abbrevation"
                            value="{{ isset($client) ? $client->client_abbrevation : '' }}" />

                        <x-input type="text" name="date_last_activated" label="Date Last Activated"
                            value="{{ isset($client) ? $client->date_last_activated : '' }}" :disabled="true" />
                    </div>

                    <div class="col-sm-12 col-lg-6">
                        <x-radio-layout label="Can Job Outcome be appealed?">
                            <div class="col-md-6">
                                <x-radio label="Yes" name="can_job_outcome_appealed"
                                    id="can_job_outcome_appealed_yes" :checked="isset($client)
                                        ? ($client->clientKeyDetails->can_job_outcome_appealed == 1
                                            ? true
                                            : false)
                                        : true" :value="1" />
                            </div>
                            <div class="col-md-6">
                                <x-radio label="No" name="can_job_outcome_appealed" id="can_job_outcome_appealed_no"
                                    :checked="isset($client)
                                        ? ($client->clientKeyDetails->can_job_outcome_appealed == 0
                                            ? true
                                            : false)
                                        : false" :value="0" />
                            </div>
                        </x-radio-layout>

                        <x-input type="text" name="organisation" label="Organisation"
                            value="{{ isset($client) ? $client->user->organisation : '' }}" />

                        <x-select label="Client Type" name="client_type_id">
                            <option selected="selected" disabled value="">-Select Client Type-</option>
                            @foreach ($clientTypes as $clientType)
                                <option
                                    {{ isset($client) && $client->client_type_id == $clientType->id ? 'selected' : '' }}
                                    value="{{ $clientType->id }}">{{ $clientType->name }}</option>
                            @endforeach
                        </x-select>

                        <x-input type="text" name="date_last_deactivated" label="Date Last Deactivated"
                            value="{{ isset($client) ? $client->date_last_deactivated : '' }}" :disabled="true" />
                    </div>

                </div>
            </div>
            <div class="col-sm-12 col-lg-12">
                <div class="row">
                    <div class="col-12 my-4 py-2">
                        <h3>Client Job Types</h3>
                    </div>

                    <div class="col-sm-12 col-lg-6">
                        <x-input type="text" class="job-types" name="qai_visit_duration"
                            label="QAI Visit Duration (hours)" :disabled="!isset($client) || !$client->clientJobTypes->contains('job_type_id', 1)"
                            value="{{ isset($client) ? $client->clientJobTypes->where('job_type_id', 1)->first()?->visit_duration : '' }}" />

                        <x-input type="text" class="job-types" name="surveyor_visit_duration"
                            label="Surveyor Visit Duration (hours)" :disabled="!isset($client) || !$client->clientJobTypes->contains('job_type_id', 2)"
                            value="{{ isset($client) ? $client->clientJobTypes->where('job_type_id', 2)->first()?->visit_duration : '' }}" />

                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <x-input type="text" class="job-types" name="assessor_visit_duration"
                            label="Assessor Visit Duration (hours)" :disabled="!isset($client) || !$client->clientJobTypes->contains('job_type_id', 3)"
                            value="{{ isset($client) ? $client->clientJobTypes->where('job_type_id', 3)->first()?->visit_duration : '' }}" />

                        <div class="form-group clearfix">
                            <label for="">Job Type</label>
                            <div class="row">
                                @foreach ($jobTypes as $jobType)
                                    <div class="col-4">
                                        <x-checkbox name="job_type_id[]" id="{{ $jobType->type }}"
                                            value="{{ $jobType->id }}" label="{{ $jobType->type }}"
                                            :checked="isset($client) &&
                                            $client->clientJobTypes->contains('job_type_id', $jobType->id)
                                                ? true
                                                : false" />
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-12">
                <div class="row">
                    <div class="col-12">
                        <div class="col-12 my-4 py-2">
                            <h3>Client Information</h3>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <x-input type="email" name="email" label="Exceptions Email"
                            value="{{ isset($client) ? $client->user->email : '' }}" />

                        <x-input type="text" name="mobile" label="Phone Number"
                            value="{{ isset($client) ? $client->user->mobile : '' }}" />

                        <x-input type="text" name="country" label="County"
                            value="{{ isset($client) ? $client->country : '' }}" />

                        <x-input type="text" name="postcode" label="Postcode"
                            value="{{ isset($client) ? $client->postcode : '' }}" />
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <x-input type="text" name="address1" label="Address 1"
                            value="{{ isset($client) ? $client->address1 : '' }}" />

                        <x-input type="text" name="address2" label="Address 2"
                            value="{{ isset($client) ? $client->address2 : '' }}" />

                        <x-input type="text" name="address3" label="Address 3"
                            value="{{ isset($client) ? $client->address3 : '' }}" />

                        <x-input type="text" name="city" label="City"
                            value="{{ isset($client) ? $client->city : '' }}" />

                    </div>

                </div>
            </div>
            <div class="col-sm-12 col-lg-12">
                <div class="row">
                    <div class="col-12 my-4 py-2">
                        <h3>Financial Information</h3>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <x-select label="Charging Scheme" name="charging_scheme_id">
                            <option selected="selected" disabled value="">-Select Charging Scheme-</option>
                            @foreach ($chargingSchemes as $chargingScheme)
                                <option value="{{ $chargingScheme->id }}"
                                    {{ isset($client) && $client->clientKeyDetails->charging_scheme_id == $chargingScheme->id ? 'selected' : '' }}>
                                    {{ $chargingScheme->name }}</option>
                            @endforeach
                        </x-select>

                        <x-input type="text" name="payment_terms" label="Payment Terms (days):"
                            value="{{ isset($client) ? $client->clientKeyDetails->payment_terms : '' }}" />
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <x-input type="text" name="charge_by_property_rate" label="Charge by Property Rate"
                            value="{{ isset($client) ? $client->clientKeyDetails->charge_by_property_rate : '' }}" />

                        <x-input type="text" name="currency" label="Currency"
                            value="{{ isset($client) ? $client->clientKeyDetails->currency : 'GBP' }}" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end align-items-center">
        <button class="btn btn-primary next w-25 mx-2" type="button">Next</button>
    </div>
</div>
