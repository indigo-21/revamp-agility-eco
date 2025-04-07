<div id="qualifications" class="card card-primary card-outline step">
    <div class="card-header">
        <h3 class="card-title">Qualifications</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-6">

                <x-input name="qualification_name" label="Qualification Name" />

                <x-date name="qualification_issue_date" label="Qualification Issue Date" />

                <x-date name="qualification_expiry_date" label="Qualification Expiry Date" />
            </div>
            <div class="col-12 col-md-6">

                <x-file name="qualification_certificate" label="Qualification Certificate" />

                <x-date name="qualification_issue" label="Qualification Issue" />
                
                <button type="button" class="btn btn-block btn-outline-primary mt-5" id="addQualifications">
                    <i class="fa fa-plus-circle" aria-hidden="true"></i> Add to table
                </button>
            </div>
        </div>

        <div class="row ">
            <div class="col-md-12">
                <table id="qualificationsTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Issue Date</th>
                            <th>Expiry Date</th>
                            <th>Certificate</th>
                            <th>Issue</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end align-items-center">
        <button class="btn btn-secondary w-25 mx-2 prev" type="button">Previous</button>
        <button class="btn btn-success w-25 mx-2" type="button" id="submitButton">Submit</button>
    </div>
</div>
