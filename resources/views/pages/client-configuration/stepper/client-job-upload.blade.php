<div id="step2" class="card card-primary card-outline step">
    <div class="card-header">
        <h3 class="card-title">Client Job Upload</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6 col-lg-12 row">
                <div class="col-sm-12 col-lg-4">
                    <label for="">Manual Job Entry?</label>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input custom-control-input-danger" type="radio" id="customRadio1" name="manual_job_entry">
                                    <label for="customRadio1" class="custom-control-label">Yes</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input custom-control-input-danger" type="radio" id="customRadio2" name="manual_job_entry">
                                    <label for="customRadio2" class="custom-control-label">No</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-4">
                    <label for="">Web Job Upload?</label>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input custom-control-input-danger" type="radio" id="customRadio3" name="web_job_upload">
                                    <label for="customRadio3" class="custom-control-label">Yes</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input custom-control-input-danger" type="radio" id="customRadio4" name="web_job_upload">
                                    <label for="customRadio4" class="custom-control-label">No</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-4">
                    <label for="">CSV via SFTP Job Upload?</label>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input custom-control-input-danger" type="radio" id="customRadio5" name="csv_sftp_job_upload">
                                    <label for="customRadio5" class="custom-control-label">Yes</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input custom-control-input-danger" type="radio" id="customRadio6" name="csv_sftp_job_upload">
                                    <label for="customRadio6" class="custom-control-label">No</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-12 row">
                <div class="col-sm-12 col-lg-4">
                    <div class="form-group">
                        <label for="endpoint">Endpoint</label>
                        <input type="text" class="form-control" id="endpoint" name="endpoint" placeholder="Enter Endpoint">
                    </div>
                </div>
                <div class="col-sm-12 col-lg-4">
                    <div class="form-group">
                        <label for="sftp">SFTP</label>
                        <input type="text" class="form-control" id="sftp" name="sftp" placeholder="Enter SFTP">
                    </div>
                </div>
                <div class="col-sm-12 col-lg-4">
                    <div class="form-group">
                        <label for="sftpLocation">SFTP Location</label>
                        <input type="text" class="form-control" id="sftpLocation" name="sftp_location" placeholder="Enter SFTP Location">
                    </div>
                </div>
            </div>




        </div>
    </div>
    <div class="card-footer d-flex justify-content-end align-items-center">
        <button class="btn btn-secondary prev w-25 mx-2">Previous</button>
        <button class="btn btn-primary next w-25 mx-2">Next</button>
    </div>
</div>