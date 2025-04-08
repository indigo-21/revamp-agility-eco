<div id="job-skills" class="card card-primary card-outline step active-step">
    <div class="card-header">
        <h3 class="card-title">Job Skills</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12 col-lg-6">
                <div class="row">
                    <div class="col-12">

                        <x-radio-layout label="Status">
                            <div class="col-md-6">
                                <x-radio label="Active" name="status" id="active" :checked="isset($property_inspector)
                                    ? ($property_inspector->status == 1
                                        ? true
                                        : false)
                                    : true"
                                    :value="1" />
                            </div>
                            <div class="col-md-6">
                                <x-radio label="Inactive" name="status" id="inactive" :checked="isset($property_inspector)
                                    ? ($property_inspector->status == 0
                                        ? true
                                        : false)
                                    : false"
                                    :value="0" />
                            </div>
                        </x-radio-layout>

                        <x-radio-layout label="Does Property Inspector book their own jobs?">
                            <div class="col-md-6">
                                <x-radio label="Yes" name="can_book_jobs" id="cbj_yes" :checked="isset($property_inspector)
                                    ? ($property_inspector->can_book_jobs == 1
                                        ? true
                                        : false)
                                    : true"
                                    :value="1" />
                            </div>
                            <div class="col-md-6">
                                <x-radio label="No" name="can_book_jobs" id="cbj_no" :checked="isset($property_inspector)
                                    ? ($property_inspector->can_book_jobs == 0
                                        ? true
                                        : false)
                                    : false"
                                    :value="0" />
                            </div>
                        </x-radio-layout>

                        <x-radio-layout label="Can do QAI Jobs">
                            <div class="col-md-6">
                                <x-radio label="Yes" name="qai" id="qai_yes" :checked="isset($property_inspector)
                                    ? ($property_inspector->qai == 1
                                        ? true
                                        : false)
                                    : true"
                                    :value="1" />
                            </div>
                            <div class="col-md-6">
                                <x-radio label="No" name="qai" id="qai_no" :checked="isset($property_inspector)
                                    ? ($property_inspector->qai == 0
                                        ? true
                                        : false)
                                    : false"
                                    :value="0" />
                            </div>
                        </x-radio-layout>

                        <x-radio-layout label="Can do Assessor Jobs">
                            <div class="col-md-6">
                                <x-radio label="Yes" name="assessor" id="assessor_yes" :checked="isset($property_inspector)
                                    ? ($property_inspector->assessor == 1
                                        ? true
                                        : false)
                                    : true"
                                    :value="1" />
                            </div>
                            <div class="col-md-6">
                                <x-radio label="No" name="assessor" id="assessor_no" :checked="isset($property_inspector)
                                    ? ($property_inspector->assessor == 0
                                        ? true
                                        : false)
                                    : false"
                                    :value="0" />
                            </div>
                        </x-radio-layout>

                        <x-radio-layout label="Can do Surveyor Jobs">
                            <div class="col-md-6">
                                <x-radio label="Yes" name="surveyor" id="surveyor_yes" :checked="isset($property_inspector)
                                    ? ($property_inspector->surveyor == 1
                                        ? true
                                        : false)
                                    : true"
                                    :value="1" />
                            </div>
                            <div class="col-md-6">
                                <x-radio label="No" name="surveyor" id="surveyor_no" :checked="isset($property_inspector)
                                    ? ($property_inspector->surveyor == 0
                                        ? true
                                        : false)
                                    : false"
                                    :value="0" />
                            </div>
                        </x-radio-layout>

                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-6">
                <div class="row">
                    <div class="col-md-12">

                        <x-select label="Employment Basis" name="account_level_id" :multiple="false">
                            <option selected="selected" disabled value="">- Employement Basis -</option>
                            @foreach ($employment_basis as $employment)
                                <option value="{{ $employment->id }}" 
                                    {{ isset($property_inspector) && $property_inspector->user->account_level_id === $employment->id ? 'selected' : '' }}>
                                    {{ $employment->name }}
                                </option>
                            @endforeach
                        </x-select>

                        <x-input name="pi_employer" label="Employer"
                            value="{{ isset($property_inspector) ? $property_inspector->pi_employer : env('EMPLOYER') }}" />

                        <x-input name="qai_rating" label="QAI Rating" type="number"
                            value="{{ isset($property_inspector) ? $property_inspector->qai_rating : '' }}" />

                        <x-input name="assessor_rating" label="Assessor Rating" type="number"
                            value="{{ isset($property_inspector) ? $property_inspector->assessor_rating : '' }}" />

                        <x-input name="surveyor_rating" label="Surveyor Rating" type="number"
                            value="{{ isset($property_inspector) ? $property_inspector->surveyor_rating : '' }}" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end align-items-center">
        <button class="btn btn-primary next w-25 mx-2" type="button">Next</button>
    </div>
</div>
