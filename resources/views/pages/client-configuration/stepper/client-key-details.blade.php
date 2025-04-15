<div id="step1" class="card card-primary card-outline step active-step">
    <div class="card-header">
        <h3 class="card-title">Client Key Details</h3>
    </div>
    <div class="card-body" id="clientKeyDetailsForm">
        <div class="row border-bottom">
            <div class="col-sm-12 col-lg-12">
                <div class="row">
                    <div class="col-sm-12 col-lg-4">
                        <x-input type="text" name="client_name" label="Client Name" :required="true" inputformat="[a-zA-Z\s]" />
                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <x-input type="text" name="organisation" label="Organisation" :required="true" inputformat="[a-zA-Z0-9!@#&()\-]" />
                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <x-input type="text" name="client_abbrevation" label="Client Abbrevation" :required="true" inputformat="[a-zA-Z\s]" />
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <x-select label="Client Type" name="client_type_id" :required="true">
                            <option selected="selected" disabled value="">-Select Client Type-</option>
                            @foreach ($clientTypes as $clientType )
                                <option selected="selected" value="{{$clientType->id}}">{{$clientType->name}}</option>
                            @endforeach
                        </x-select>   
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <x-input type="text" class="job-types" name="qai_visit_duration" label="QAI Visit Duration (hours)" inputformat="[0-9]" />
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <x-input type="text" class="job-types" name="assessor_visit_duration" label="Assessor Visit Duration (hours)" inputformat="[0-9]" />
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <x-input type="text" class="job-types" name="surveyor_visit_duration" label="Surveyor Visit Duration (hours)" inputformat="[0-9]" />
                    </div>
                    
                    <div class="col-sm-12 col-lg-12 row">
                        <div class="col-sm-12 col-lg-6">
                            <div class="form-group">
                                <label for="">Job Type</label>
                                <div class="row form-group">
                                    <div class="col-4">
                                        <x-checkbox name="qai" label="QAI" />
                                    </div>
                                    <div class="col-4">
                                        <x-checkbox name="assesor" label="Assessor" />
                                    </div>
                                    <div class="col-4">
                                        <x-checkbox name="surveyor" label="Surveyor" />
                                    </div>
                                    <div class="col-12">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-6">
                            <x-radio-layout label="Can Job Outcome be appealed?">
                                <div class="col-md-6">
                                    <x-radio label="Yes" name="can_job_outcome_be_appealed" id="can_job_outcome_be_appealed_yes" :checked="true" />
                                </div>
                                <div class="col-md-6">
                                    <x-radio label="No" name="can_job_outcome_be_appealed" id="can_job_outcome_be_appealed_no" />
                                </div>
                            </x-radio-layout>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <x-radio-layout label="Active">
                            <div class="col-md-6">
                                <x-radio label="Yes" name="active" id="active_yes" :checked="true" />
                            </div>
                            <div class="col-md-6">
                                <x-radio label="No" name="active" id="active_no" />
                            </div>
                        </x-radio-layout>
                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <x-input type="text" name="date_last_activated" label="Date Last Activated" value="" :disabled="true" />
                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <x-input type="text" name="date_last_deactivated" label="Date Last Deactivated" :disabled="true" />
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
                        <x-input type="email" name="exceptions_email" label="Exceptions Email" :required="true" />
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <x-input type="text" name="phone_number" label="Phone Number" :required="true" inputformat="[0-9]" />
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <x-input type="text" name="address1" label="Address 1" inputformat="[a-zA-Z0-9!@#&()\-]"/>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <x-input type="text" name="address2" label="Address 2" inputformat="[a-zA-Z0-9!@#&()\-]"/>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <x-input type="text" name="address3" label="Address 3" inputformat="[a-zA-Z0-9!@#&()\-]"/>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <x-input type="text" name="city" label="City" />
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <x-input type="text" name="country" label="Country" />
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <x-input type="text" name="postcode" label="Postcode" inputformat="[a-zA-Z0-9\s]"/>
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
                        <option value="{{$chargingScheme->id}}">{{$chargingScheme->name}}</option>
                    @endforeach
                </x-select>   
            </div>
            <div class="col-sm-12 col-lg-6">
                <div class="form-group">
                    <label for="paymentTerms">Payment Terms (days):</label>
                    <input type="text" class="form-control" id="paymentTerms" name="payment_terms" placeholder="Enter Days" required textpattern="[0-9]">
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-6">
                <x-input type="text" name="charge_by_property_rate" label="Charge by Property Rate" :required="true" inputformat="[0-9.]" />
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