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
                                <x-radio label="Active" name="status" id="active" :checked="true" />
                            </div>
                            <div class="col-md-6">
                                <x-radio label="Inactive" name="inactive" id="audit_no" />
                            </div>
                        </x-radio-layout>

                        <x-radio-layout label="Does Property Inspector book their own jobs?">
                            <div class="col-md-6">
                                <x-radio label="Yes" name="can_book_jobs" id="cbj_yes" :checked="true" />
                            </div>
                            <div class="col-md-6">
                                <x-radio label="No" name="can_book_jobs" id="cbj_no" />
                            </div>
                        </x-radio-layout>

                        <x-radio-layout label="Can do QAI Jobs">
                            <div class="col-md-6">
                                <x-radio label="Yes" name="qai" id="qai_yes" :checked="true" />
                            </div>
                            <div class="col-md-6">
                                <x-radio label="No" name="qai" id="qai_no" />
                            </div>
                        </x-radio-layout>

                        <x-radio-layout label="Can do Assessor Jobs">
                            <div class="col-md-6">
                                <x-radio label="Yes" name="assessor" id="assessor_yes" :checked="true" />
                            </div>
                            <div class="col-md-6">
                                <x-radio label="No" name="assessor" id="assessor_no" />
                            </div>
                        </x-radio-layout>

                        <x-radio-layout label="Can do Surveyor Jobs">
                            <div class="col-md-6">
                                <x-radio label="Yes" name="surveyor" id="surveyor_yes" :checked="true" />
                            </div>
                            <div class="col-md-6">
                                <x-radio label="No" name="surveyor" id="surveyor_no" />
                            </div>
                        </x-radio-layout>

                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-6">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Employment Basis</label>
                            <select class="form-control select2" style="width: 100%;" name="employment_status_id">
                                <option selected="selected" disabled>- Employment Basis -</option>
                                <option>Alaska</option>
                            </select>
                        </div>

                        <x-input name="pi_employer" label="Employer" value="{{ env('EMPLOYER') }}" />

                        <x-input name="qai_rating" label="QAI Rating" />

                        <x-input name="assessor_rating" label="Assessor Rating" />

                        <x-input name="surveyor_rating" label="Surveyor Rating" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end align-items-center">
        <button class="btn btn-primary next w-25 mx-2">Next</button>
    </div>
</div>
