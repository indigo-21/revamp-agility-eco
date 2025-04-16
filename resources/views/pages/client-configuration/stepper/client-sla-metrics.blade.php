<div id="step3" class="card card-primary card-outline step">
    <div class="card-header">
        <h3 class="card-title">Client SLA Metrics</h3>
    </div>
    <div class="card-body" id="clientSlaMetricsForm">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <div class="form-group">
                    <x-input type="text" name="client_maximum_retries" label="Client Maximum Retries"  inputformat="[0-9]" />
                </div>
            </div>
            <div class="col-sm-12 col-lg-6">
                <div class="form-group">
                    <x-input type="text" name="maximum_booking_attemps" label="Maximum Booking Attemtps"  inputformat="[0-9]" />
                </div>
            </div>
            <div class="col-sm-12 col-lg-6">
                <div class="form-group">
                    <x-input type="text" name="maximum_remediation_attemps" label="Maximum Remediation Attemtps"  inputformat="[0-9]" />
                </div>
            </div>
            <div class="col-sm-12 col-lg-4">
                <div class="form-group">
                    <x-input type="text" name="maximum_no_show" label="Maximum No Show"  inputformat="[0-9]" />
                </div>
            </div>
            <div class="col-sm-12 col-lg-4">
                <div class="form-group">
                    <x-input type="text" name="maximum_number_appeals" label="Maximum Number of Appeals"  inputformat="[0-9]" />
                </div>
            </div>
            <div class="col-sm-12 col-lg-4">
                <div class="form-group">
                    <x-input type="text" name="job_deadline" label="Job deadline"  inputformat="[0-9]" />
                </div>
            </div>
            <div class="col-sm-12 col-lg-6">
                <div class="form-group">
                    <label for="cat1RemediateNotify">CAT1 Remediate Notify</label>
                    <div class="row">
                        <div class="col-8">
                            <input type="text" class="form-control" id="cat1RemediateNotify" name="cat1_remediate_notify" placeholder="CAT1 Remediate Notify" inputformat="[a-zA-Z0-9!@#&()\-]">
                        </div>
                        <div class="col-4">
                            <select class="form-control select2" style="width: 100%;" name="cat1_remediate_notify_duration_unit">
                                <option selected="selected" value="" disabled>-Select-</option>
                                <option value="1">Hours</option>
                                <option value="2">Days</option>
                            </select>
                        </div>
                    </div>
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-6">
                <div class="form-group">
                    <label for="ncRemediateNotify">NC Remediate Notify</label>
                    <div class="row">
                        <div class="col-8">
                            <input type="text" class="form-control" id="ncRemediateNotify" name="nc_remediate_notify" placeholder="NC Remediate Notify">
                        </div>
                        <div class="col-4">
                            <select class="form-control select2" style="width: 100%;" name="nc_remediate_notify_duration_unit">
                                <option selected="selected" value="" disabled>-Select-</option>
                                <option value="1">Hours</option>
                                <option value="2">Days</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-6">
                <div class="form-group">
                    <label for="cat1RemediateComplete">CAT1 Remediate Complete</label>
                    <div class="row">
                        <div class="col-8">
                            <input type="text" class="form-control" id="cat1RemediateComplete" name="cat1_remediate_complete" placeholder="CAT1 Remediate Complete">
                        </div>
                        <div class="col-4">
                            <select class="form-control select2" style="width: 100%;" name="cat1_remediate_complete">
                                <option selected="selected" value="" disabled>-Select-</option>
                                <option value="1">Hours</option>
                                <option value="2">Days</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-6">
                <div class="form-group">
                    <label for="ncRemediateComplete">NC Remediate Complete</label>
                    <div class="row">
                        <div class="col-8">
                            <input type="text" class="form-control" id="ncRemediateComplete" name="nc_remediate_complete" placeholder="NC remediate complete">
                        </div>
                        <div class="col-4">
                            <select class="form-control select2" style="width: 100%;" name="nc_remediate_complete_duration_unit">
                                <option selected="selected" value="" disabled>-Select-</option>
                                <option value="1">Hours</option>
                                <option value="2">Days</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-6">
                <div class="form-group">
                    <label for="cat1ReinspectRemediation">CAT1 Reinspect Remediation</label>
                    <div class="row">
                        <div class="col-8">
                            <input type="text" class="form-control" id="cat1ReinspectRemediation" name="cat1_reinspect_remediation" placeholder="CAT1 Reinspect Remediation">
                        </div>
                        <div class="col-4">
                            <select class="form-control select2" style="width: 100%;" name="cat1_reinspect_remediation_duration_unit">
                                <option selected="selected" value="" disabled>-Select-</option>
                                <option value="1">Hours</option>
                                <option value="2">Days</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-6">
                <div class="form-group">
                    <label for="ncReinspectRemediation">NC Reinspect Remediation</label>
                    <div class="row">
                        <div class="col-8">
                            <input type="text" class="form-control" id="ncReinspectRemediation" name="nc_reinspect_remediation" placeholder="NC Reinspect Remediation">
                        </div>
                        <div class="col-4">
                            <select class="form-control select2" style="width: 100%;" name="nc_reinspect_remediation_duration_unit">
                                <option selected="selected" value="" disabled>-Select-</option>
                                <option value="1">Hours</option>
                                <option value="2">Days</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-6">
                <div class="form-group">
                    <label for="cat1Challenge">CAT1 Challenge</label>
                    <div class="row">
                        <div class="col-8">
                            <input type="text" class="form-control" id="cat1Challenge" name="cat1_challenge" placeholder="CAT1 Challenge">
                        </div>
                        <div class="col-4">
                            <select class="form-control select2" style="width: 100%;" name="cat1_challenge_duration_unit">
                                <option selected="selected" value="" disabled>-Select-</option>
                                <option value="1">Hours</option>
                                <option value="2">Days</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-6">
                <div class="form-group">
                    <label for="ncChallenge">NC challenge</label>
                    <div class="row">
                        <div class="col-8">
                            <input type="text" class="form-control" id="ncChallenge" name="nc_challenge" placeholder="NC challenge" >
                        </div>
                        <div class="col-4">
                            <select class="form-control select2" style="width: 100%;" name="nc_challenge_duration_unit">
                                <option selected="selected" value="" disabled>-Select-</option>
                                <option value="1">Hours</option>
                                <option value="2">Days</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-6">
                <div class="form-group">
                    <label for="cat1EemediateNoAccess">CAT1 remediate no access</label>
                    <div class="row">
                        <div class="col-8">
                            <input type="text" class="form-control" id="cat1EemediateNoAccess" name="cat1_remediate_no_access" placeholder="CAT1 remediate no access" >
                        </div>
                        <div class="col-4">
                            <select class="form-control select2" style="width: 100%;" name="cat1_remediate_no_access_duration_unit">
                                <option selected="selected" value="" disabled>-Select-</option>
                                <option value="1">Hours</option>
                                <option value="2">Days</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-6">
                <div class="form-group">
                    <label for="ncRemediateNoAccess">NC remediate no access</label>
                    <div class="row">
                        <div class="col-8">
                            <input type="text" class="form-control" id="ncRemediateNoAccess" name="nc_remediate_no_access" placeholder="NC remediate no access" >
                        </div>
                        <div class="col-4">
                            <select class="form-control select2" style="width: 100%;" name="nc_remediate_no_access_duration_unit">
                                <option selected="selected" value="" disabled>-Select-</option>
                                <option value="1">Hours</option>
                                <option value="2">Days</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-6">
                <div class="form-group">
                    <label for="cat1Unremediated">CAT1 unremediated</label>
                    <div class="row">
                        <div class="col-8">
                            <input type="text" class="form-control" id="cat1Unremediated" name="cat1_unremediated" placeholder="CAT1 Unremediated" >
                        </div>
                        <div class="col-4">
                            <select class="form-control select2" style="width: 100%;" name="cat1_unremediated_duration_unit">
                                <option selected="selected" value="" disabled>-Select-</option>
                                <option value="1">Hours</option>
                                <option value="2">Days</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-6">
                <div class="form-group">
                    <label for="ncUnremediated">NC unremediated</label>
                    <div class="row">
                        <div class="col-8">
                            <input type="text" class="form-control" id="ncUnremediated" name="nc_unremediated" placeholder="NC Unremediated">
                        </div>
                        <div class="col-4">
                            <select class="form-control select2" style="width: 100%;" name="nc_unremediated_duration_unit" >
                                <option selected="selected" value="" disabled>-Select-</option>
                                <option value="1">Hours</option>
                                <option value="2">Days</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end align-items-center">
        <button type="button" class="btn btn-secondary prev w-25 mx-2">Previous</button>
        <button type="button" class="btn btn-primary next w-25 mx-2" formid="clientSlaMetricsForm">Next</button>
    </div>
</div>