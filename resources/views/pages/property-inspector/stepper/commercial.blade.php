<div id="commercial" class="card card-primary card-outline step">
    <div class="card-header">
        <h3 class="card-title">Commercial</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-6">


                <x-radio-layout label="Charge by PROPERTY or MEASURE">
                    @foreach ($charging_schemes as $charging_scheme)
                        <div class="col-md-6">
                            <x-radio label="{{ $charging_scheme->name }}" name="charging_scheme_id"
                                id="charging_{{ $charging_scheme->name }}" :checked="$charging_scheme->name === 'Measure'"
                                value="{{ $charging_scheme->id }}" />
                        </div>
                    @endforeach
                </x-radio-layout>

                <x-input name="property_visit_fee" label="Property Visit Fee" type="number" :disabled="true"/>

                <x-input name="property_fee_currency" label="Fee Currency" value="GBP" :disabled="true"/>

                <x-input name="payment_terms" label="Payment Terms(days)" type="number" :disabled="true"/>

                <x-radio-layout label="VAT Registered">
                    <div class="col-md-6">
                        <x-radio label="Yes" name="vat" id="vat_yes" :checked="true" :value="1"/>
                    </div>
                    <div class="col-md-6">
                        <x-radio label="No" name="vat" id="vat_no" :value="0"/>
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
                        <x-radio label="Yes" name="audit_jobs" id="audit_yes" :checked="true" :value="1"/>
                    </div>
                    <div class="col-md-6">
                        <x-radio label="No" name="audit_jobs" id="audit_no" :value="0"/>
                    </div>
                </x-radio-layout>

                <x-select label="Postcode will visit" name="outward_postcode_id[]" :multiple="true">
                    @foreach ($outward_postcodes as $outward_postcode)
                        <option value="{{ $outward_postcode->id }}">{{ $outward_postcode->name }}</option>
                    @endforeach
                </x-select>

                <x-input name="hours_spent" label="Hours Spent Surveying in Typical Work Day" />

                <x-radio-layout label="Work on Saturday">
                    <div class="col-md-6">
                        <x-radio label="Yes" name="work_sat" id="wosat_yes" :value="1"/>
                    </div>
                    <div class="col-md-6">
                        <x-radio label="No" name="work_sat" id="wosat_no" :checked="true" :value="0"/>
                    </div>
                </x-radio-layout>

                <x-radio-layout label="Work on Sunday">
                    <div class="col-md-6">
                        <x-radio label="Yes" name="work_sun" id="wosun_yes" :value="1"/>
                    </div>
                    <div class="col-md-6">
                        <x-radio label="No" name="work_sun" id="wosun_no" :checked="true" :value="0"/>
                    </div>
                </x-radio-layout>

            </div>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end align-items-center">
        <button class="btn btn-secondary w-25 mx-2 prev" type="button">Previous</button>
        <button class="btn btn-primary next w-25 mx-2" type="button">Next</button>
    </div>
</div>
