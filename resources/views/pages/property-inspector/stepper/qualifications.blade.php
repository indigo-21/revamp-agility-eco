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
                
                <button type="button" class="btn btn-block btn-outline-primary mt-5" id="addMeasures">
                    <i class="fa fa-plus-circle" aria-hidden="true"></i> Add to table
                </button>
            </div>
        </div>

        <div class="row ">
            <div class="col-md-12">
                <table id="qualificationsTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Rendering engine</th>
                            <th>Browser</th>
                            <th>Platform(s)</th>
                            <th>Engine version</th>
                            <th>CSS grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Trident</td>
                            <td>Internet
                                Explorer 4.0
                            </td>
                            <td>Win 95+</td>
                            <td> 4</td>
                            <td>X</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end align-items-center">
        <button class="btn btn-secondary w-25 mx-2 prev">Previous</button>
        <button class="btn btn-success w-25 mx-2">Finish</button>
    </div>
</div>
