@php
        $qai                         = "";
        $surveyor                    = "";
        $assessor                    = "";
        $qai_checkbox                = false;
        $surveyor_checkbox           = false;
        $assessor_checkbox           = false;
        $can_job_outcome_be_appealed = false;
        $is_active                   = false;


        $payment_terms               = "";
        $charge_by_property_rate     = ""; 

        if (isset($client)) {
            $can_job_outcome_be_appealed = $client_key_details->can_job_outcome_appealed;
            $is_active                   = $client_key_details->is_active;

            if (count($client_job_types) > 0) {
                $qai_found      = collect($client_job_types)->firstWhere('job_type_id', 1);
                $surveyor_found = collect($client_job_types)->firstWhere('job_type_id', 2);
                $assessor_found = collect($client_job_types)->firstWhere('job_type_id', 3);

                $qai               = $qai_found ? $qai_found['visit_duration'] : '';
                $surveyor          = $surveyor_found ? $surveyor_found['visit_duration'] : '';
                $assessor          = $assessor_found ? $assessor_found['visit_duration'] : '';
                $qai_checkbox      = $qai != "" ? true : false;
                $surveyor_checkbox = $surveyor != "" ? true : false;
                $assessor_checkbox = $qai_checkbox != "" ? true : false;

                $payment_terms               = $client_key_details->payment_terms;
                $charge_by_property_rate     = $client_key_details->charge_by_property_rate; 
            }
        
            
        }
@endphp
<div id="step1" class="card card-primary card-outline step active-step">
    <div class="card-header">
        <h3 class="card-title">Client Key Details</h3>
    </div>
    <div class="card-body" id="clientKeyDetailsForm">
        <div class="row border-bottom">
            <div class="col-sm-12 col-lg-12">
                <div class="row">
                    <div class="col-sm-12 col-lg-6">
                        <x-radio-layout label="Active">
                            <div class="col-md-6">
                                <x-radio label="Yes" name="active" id="active_yes" :checked="$is_active" />
                            </div>
                            <div class="col-md-6">
                                <x-radio label="No" name="active" id="active_no" :checked="!$is_active"/>
                            </div>
                        </x-radio-layout>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <x-radio-layout label="Can Job Outcome be appealed?">
                            <div class="col-md-6">
                                <x-radio label="Yes" name="can_job_outcome_be_appealed" id="can_job_outcome_be_appealed_yes" :checked="$can_job_outcome_be_appealed" />
                            </div>
                            <div class="col-md-6">
                                <x-radio label="No" name="can_job_outcome_be_appealed" id="can_job_outcome_be_appealed_no" :checked="!$can_job_outcome_be_appealed"/>
                            </div>
                        </x-radio-layout>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <x-input type="text" name="date_last_activated" label="Date Last Activated" value="{{ isset($client) ? $client->date_last_activated : '' }}" :disabled="true" />
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <x-select label="Client Type" name="client_type_id" :required="true">
                            <option selected="selected" disabled value="">-Select Client Type-</option>
                            @foreach ($clientTypes as $clientType )
                                <option {{isset($client) && $client->client_type_id == $clientType->id ? 'selected'  : ''}}  value="{{$clientType->id}}">{{$clientType->name}}</option>
                            @endforeach
                        </x-select>   
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <x-input type="text" name="date_last_deactivated" label="Date Last Deactivated" value="{{isset($client) ? $client->date_last_deactivated : ''}}" :disabled="true" />
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <x-input type="text" name="organisation" label="Organisation" :required="true" value="{{isset($client) ? $client->user->organisation : ''}}" inputformat="[a-zA-Z0-9!@#&()\-.\s]" />
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <x-input type="text" name="client_name" label="Client Name" :required="true" value="{{isset($client) ? $client->user->firstname : ''}}" inputformat="[a-zA-Z0-9!@#&()\-.\s]" />
                    </div>
                    
                    <div class="col-sm-12 col-lg-6">
                        <x-input type="text" name="client_abbrevation" label="Client Abbrevation" :required="true" value="{{isset($client) ? $client->client_abbrevation : ''}}" inputformat="[a-zA-Z0-9!@#&()\-.\s]" />
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-12">
                <div class="row">
                    <div class="col-12 my-4 py-2">
                        <h3>Client Job Types</h3>
                    </div>

                    <div class="col-sm-12 col-lg-6">
                        <x-input type="text" class="job-types" name="qai_visit_duration" label="QAI Visit Duration (hours)" value="{{$qai}}" inputformat="[0-9]" />
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <x-input type="text" class="job-types" name="assessor_visit_duration" label="Assessor Visit Duration (hours)" value="{{$assessor}}" inputformat="[0-9]" />
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <x-input type="text" class="job-types" name="surveyor_visit_duration" label="Surveyor Visit Duration (hours)" value="{{$surveyor}}" inputformat="[0-9]" />
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <div class="form-group">
                            <label for="">Job Type</label>
                            <div class="row">
                                <div class="col-4">
                                    <x-checkbox name="qai" label="QAI" ischeck="{{$qai_checkbox}}"/>
                                </div>
                                <div class="col-4">
                                    <x-checkbox name="assessor" label="Assessor" ischeck="{{$surveyor_checkbox}}"/>
                                </div>
                                <div class="col-4">
                                    <x-checkbox name="surveyor" label="Surveyor" ischeck="{{$assessor_checkbox}}"/>
                                </div>
                            </div>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-12">
                <div class="row">
                    <div class="col-12">
                        <div class="col-12 my-4 py-2">
                            <h3 >Client Information</h3>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <x-input type="email" name="exceptions_email" label="Exceptions Email" value="{{isset($client) ? $client->user->email : '' }}" :required="true" uniqueid="{{isset($client) ? $client->user->id : '' }}" />
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <x-input type="text" name="phone_number" label="Phone Number" :required="true" value="{{isset($client) ? $client->user->mobile : '' }}" inputformat="[0-9]" />
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <x-input type="text" name="address1" label="Address 1" value="{{isset($client) ? $client->address1 : '' }}" inputformat="[a-zA-Z0-9!@#&()\-.\s]"/>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <x-input type="text" name="address2" label="Address 2" value="{{isset($client) ? $client->address2 : '' }}" inputformat="[a-zA-Z0-9!@#&()\-.\s]"/>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <x-input type="text" name="address3" label="Address 3" value="{{isset($client) ? $client->address3 : '' }}" inputformat="[a-zA-Z0-9!@#&()\-.\s]"/>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <x-input type="text" name="city" value="{{isset($client) ? $client->city : '' }}" label="City" />
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <x-input type="text" name="country" value="{{isset($client) ? $client->country : '' }}" label="County" />
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <x-input type="text" name="postcode" value="{{isset($client) ? $client->postcode : '' }}" label="Postcode" inputformat="[a-zA-Z0-9\s]"/>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 my-4 py-2">
                <h3 >Financial Information</h3>
            </div>
            <div class="col-sm-12 col-lg-6">
                <x-select label="Charging Scheme" name="charging_scheme" :required="true">
                    <option selected="selected" disabled value="">-Select Charging Scheme-</option>
                    @foreach ($chargingSchemes as $chargingScheme):
                        <option {{isset($client) && $client_key_details->charging_scheme_id == $chargingScheme->id ? 'selected'  : ''}} value="{{$chargingScheme->id}}">{{$chargingScheme->name}}</option>
                    @endforeach
                </x-select>   
            </div>
            <div class="col-sm-12 col-lg-6">
                <div class="form-group">
                    <label for="paymentTerms">Payment Terms (days):</label>
                    <input type="text" class="form-control" id="paymentTerms" value="{{$payment_terms}}" name="payment_terms" placeholder="Enter Days" required textpattern="[0-9]">
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-6">
                <x-input type="text" name="charge_by_property_rate" label="Charge by Property Rate" value="{{$charge_by_property_rate}}" inputformat="[0-9.]" />
            </div>
            <div class="col-sm-12 col-lg-6">
                <x-input type="text" name="currency" label="Currency" :required="true" :disabled="true" value="GBP" />
            </div>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end align-items-center">
        <button type="button" class="btn btn-primary next w-25 mx-2" id="clientKeyDetails" formid="clientKeyDetailsForm">Next</button>
    </div>
</div>