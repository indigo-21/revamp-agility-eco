<div id="commercial" class="card card-primary card-outline step">
    <div class="card-header">
        <h3 class="card-title">Commercial</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-6">
                <x-radio-layout label="Charge by PROPERTY or MEASURE">
                    <div class="col-md-6">
                        <x-radio label="Property" name="charging_mechanism" id="charging_property" :checked="true" />
                    </div>
                    <div class="col-md-6">
                        <x-radio label="Measure" name="charging_mechanism" id="charging_measure" />
                    </div>
                </x-radio-layout>

                <x-input name="property_visit_fee" label="Property Visit Fee" />

                <x-input name="property_fee_currency" label="Fee Currency" value="GBP" :disabled="true" />

                <x-input name="payment_terms" label="Payment Terms(days)" />

                <x-radio-layout label="VAT Registered">
                    <div class="col-md-6">
                        <x-radio label="Yes" name="vat" id="vat_yes" :checked="true" />
                    </div>
                    <div class="col-md-6">
                        <x-radio label="No" name="vat" id="vat_no" />
                    </div>
                </x-radio-layout>

                <x-input name="vat_no" label="Vat Registered Number" />

                {{-- <x-input name="self_bill_certificate_valid" label="Self Bill Certificate Valid" :disabled="true"/>

                <x-input name="self_bill_renewal" label="Self Bill Renewal" :disabled="true"/>

                <x-input name="self_bill_certificate" label="Self Bill Certificate" :disabled="true"/> --}}
            </div>

            <div class="col-12 col-md-6">

                <x-input name="registered_id_number" label="PI Registered ID Number" />

                <x-radio-layout label="Audit Jobs">
                    <div class="col-md-6">
                        <x-radio label="Yes" name="audit_jobs" id="audit_yes" :checked="true" />
                    </div>
                    <div class="col-md-6">
                        <x-radio label="No" name="audit_jobs" id="audit_no" />
                    </div>
                </x-radio-layout>

                <x-input name="hours_spent" label="Hours Spent Surveying in Typical Work Day" />

                <div class="form-group">
                    <label>Multiple</label>
                    <select class="select2" multiple="multiple" data-placeholder="Select a State" style="width: 100%;">
                        <option>Alabama</option>
                        <option>Alaska</option>
                        <option>California</option>
                        <option>Delaware</option>
                        <option>Tennessee</option>
                        <option>Texas</option>
                        <option>Washington</option>
                    </select>
                </div>

                <x-radio-layout label="Work on Saturday">
                    <div class="col-md-6">
                        <x-radio label="Yes" name="work_on_saturday" id="wosat_yes" :checked="true" />
                    </div>
                    <div class="col-md-6">
                        <x-radio label="No" name="work_on_saturday" id="wosat_no" />
                    </div>
                </x-radio-layout>

                <x-radio-layout label="Work on Sunday">
                    <div class="col-md-6">
                        <x-radio label="Yes" name="work_on_sunday" id="wosun_yes" :checked="true" />
                    </div>
                    <div class="col-md-6">
                        <x-radio label="No" name="work_on_sunday" id="wosun_yes" />
                    </div>
                </x-radio-layout>

            </div>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end align-items-center">
        <button class="btn btn-secondary w-25 mx-2 prev">Previous</button>
        <button class="btn btn-primary next w-25 mx-2">Next</button>
    </div>
</div>
