<fieldset>
    <div class="row mb-3">
        <div class="col-md-4">
            <div class="form-group">
                <label for="qualificationName" class="block">Qualification Name</label>
                <input id="qualificationName" name="qualification_name" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label for="qualificationIssueDate" class="block">Qualification Issue Date</label>
                <input id="qualificationIssueDate" name="qualification_issue_date" class="form-control"
                    type="date" />
            </div>
            <div class="form-group">
                <label for="qualificationExpiryDate" class="block">Qualification Expiry Date</label>
                <input id="qualificationExpiryDate" class="form-control" name="qualification_expiry_date"
                    type="date" />
            </div>
            <div class="form-group">
                <label for="qualificationCertificate" class="block">Qualification Certificate</label>
                <input type="file" name="qualification_certificate" id="qualificationCertificate">
            </div>
            <div class="form-group">
                <label for="qualificationIssue" class="block">Qualification Issue</label>
                <input id="qualificationIssue" name="qualification_issue" type="text" class="form-control">
            </div>
            <button class="btn btn-primary btn-small" id="qualificationAdd" type="button">Add</button>
        </div>
        <div class="col-md-8">
            <div class="dt-responsive table-responsive">
                <table id="qualificationsTable" class="table table-striped table-bordered nowrap">
                    <thead>
                        <tr>
                            <th>Qualification Name</th>
                            <th>Qualification Issue Date</th>
                            <th>Qualification Expiry Date</th>
                            <th>Qualification Certificate</th>
                            <th>Qualification Issue</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</fieldset>
