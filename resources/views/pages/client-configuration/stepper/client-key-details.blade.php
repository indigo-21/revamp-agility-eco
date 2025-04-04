<div id="step1" class="card card-primary card-outline step active-step">
    <div class="card-header">
        <h3 class="card-title">Client Key Details</h3>
    </div>
    <div class="card-body" id="clientKeyDetailsForm">
        <div class="row border-bottom">
            <div class="col-sm-12 col-lg-12">
                <div class="row">
                    <div class="col-sm-12 col-lg-6">
                        <div class="form-group">
                            <label for="clientName">Client Name</label>
                            <input type="text" class="form-control" id="clientName" name="client_name" placeholder="Enter Client Name" required textpattern="[a-zA-Z\s]">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <div class="form-group">
                            <label for="clientAbbrevation">Client Abbrevation</label>
                            <input type="text" class="form-control" id="clientAbbrevation" name="client_abbrevation" placeholder="Enter Client Abbrevation" required textpattern="[a-zA-Z\s]">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <div class="form-group">
                            <label>Client Type</label>
                            <select class="form-control select2" style="width: 100%;">
                              <option selected="selected" value="" disabled>-Select Client Type-</option>
                              <option value="Test">Alaska</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <div class="form-group">
                            <label for="qaiVisiDuration">QAI Visit Duration (hours)</label>
                            <input type="text" class="form-control" id="qaiVisiDuration" name="qai_visit_duration" placeholder="Enter Hours" required textpattern="[0-9]">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-12 row">
                        <div class="col-sm-12 col-lg-6">
                            <label>Active</label>
                            <div class="row form-group">
                                <div class="col-6">
                                    <div class="form-group">
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input custom-control-input-danger" type="radio" id="customRadio1" name="customRadio1" checked>
                                            <label for="customRadio1" class="custom-control-label">Yes</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input custom-control-input-danger" type="radio" id="customRadio2" name="customRadio1">
                                            <label for="customRadio2" class="custom-control-label">No</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-6">
                            <label>Can Job Outcome be appealed?</label>
                            <div class="row form-group">
                                <div class="col-6">
                                    <div class="radio-group">
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input custom-control-input-danger" type="radio" id="customRadio3" name="customRadio2" checked>
                                            <label for="customRadio3" class="custom-control-label">Yes</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="radio-group">
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input custom-control-input-danger" type="radio" id="customRadio4" name="customRadio2">
                                            <label for="customRadio4" class="custom-control-label">No</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <div class="form-group">
                            <label for="assessorVisitDuration">Assessor Visit Duration (hours)</label>
                            <input type="text" class="form-control" id="assessorVisitDuration" name="assessor_visit_duration" placeholder="Enter Hours" required textpattern="[0-9]">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <div class="form-group">
                            <label for="surveyorVisitDuration">Surveyor Visit Duration (hours)</label>
                            <input type="text" class="form-control" id="surveyorVisitDuration" name="surveyor_visit_duration" placeholder="Enter Hours" required textpattern="[0-9]">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <div class="form-group">
                            <label for="dateLastActivated">Date Last Activated</label>
                            <input type="text" class="form-control" id="dateLastActivated" name="date_last_activated" disabled>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <div class="form-group">
                            <label for="">Job Type</label>
                            <div class="row form-group">
                                <div class="col-4">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input custom-control-input-danger" type="checkbox" id="customCheckbox1">
                                        <label for="customCheckbox1" class="custom-control-label">QAI</label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input custom-control-input-danger" type="checkbox" id="customCheckbox2">
                                        <label for="customCheckbox2" class="custom-control-label">Assessor</label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input custom-control-input-danger" type="checkbox" id="customCheckbox3">
                                        <label for="customCheckbox3" class="custom-control-label">Surveyor</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
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
                        <div class="form-group">
                            <label for="exceptionsEmail">Exceptions Email</label>
                            <input type="email" class="form-control" id="exceptionsEmail" name="exceptions_email" placeholder="Enter Email" required>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <div class="form-group">
                            <label for="phoneNumber">Phone Number</label>
                            <input type="text" class="form-control" id="phoneNumber" name="phone_number" placeholder="Enter Phone Number" required textpattern="[0-9]">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <div class="form-group">
                            <label for="addressOne">Address 1</label>
                            <input type="text" class="form-control" id="addressOne" name="anddress_one" placeholder="Enter Address" required textpattern="[a-zA-Z\s]">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <div class="form-group">
                            <label for="addressTwo">Address 2</label>
                            <input type="text" class="form-control" id="addressTwo" name="anddress_two" placeholder="Enter Address" required textpattern="[a-zA-Z\s]">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <div class="form-group">
                            <label for="addressThree">Address 3</label>
                            <input type="text" class="form-control" id="addressThree" name="anddress_three" placeholder="Enter Address" required textpattern="[a-zA-Z\s]">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control" id="city" name="city" placeholder="Enter City" required textpattern="[a-zA-Z\s]">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <div class="form-group">
                            <label for="country">Country</label>
                            <input type="text" class="form-control" id="country" name="country" placeholder="Enter Country" required textpattern="[a-zA-Z\s]">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <div class="form-group">
                            <label for="postcode">Postcode</label>
                            <input type="text" class="form-control" id="postcode" name="postcode" placeholder="Enter Postcode" required textpattern="[a-zA-Z0-9\s]">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-12">
                        <div class="form-group">
                            <label for="dateLastDeactivated">Date Last Deactivated</label>
                            <input type="text" class="form-control" id="dateLastDeactivated" name="date_last_deactivated" disabled>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 my-4 py-2">
                <h3 >Financial Information</h3>
            </div>
            <div class="col-sm-12 col-lg-6">
                <div class="form-group">
                    <label>Charging Scheme</label>
                    <select class="form-control select2" style="width: 100%;" required>
                      <option selected="selected" disabled>-Select Charging Scheme-</option>
                      <option>Measure</option>
                      <option>Property</option>
                    </select>
                    <div class="invalid-feedback"></div>
                  </div>
            </div>
            <div class="col-sm-12 col-lg-6">
                <div class="form-group">
                    <label for="paymentTerms">Payment Terms (days):</label>
                    <input type="text" class="form-control" id="paymentTerms" name="payment_terms" placeholder="Enter Days" required textpattern="[0-9]">
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-6">
                <div class="form-group">
                    <label for="chargeByPropertyRate">Charge by Property Rate</label>
                    <input type="text" class="form-control" id="chargeByPropertyRate" name="charge_by_property_rate" placeholder="Enter Property Rate" required textpattern="[0-9\s]">
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-6">
                <div class="form-group">
                    <label for="currency">Currency</label>
                    <input type="text" class="form-control" id="currency" name="currency" value="GBP" disabled>
                    <div class="invalid-feedback"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end align-items-center">
        <button class="btn btn-primary next w-25 mx-2" id="clientKeyDetails" formid="clientKeyDetailsForm">Next</button>
    </div>
</div>