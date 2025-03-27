<fieldset>
    <div class="row mb-3">
        <div class="col-md-4">
            <div class="form-group">
                <label for="measureCat" class="block">Measure CAT</label>
                <select class="js-example-basic-single col-sm-12" id="measureCatSelect" name="measure_cat">
                    <option value="AL">Alabama</option>
                    <option value="WY">Wyoming</option>
                </select>
            </div>
            <div class="form-group">
                <label for="measureFeeValue" class="block">Measure Fee Value</label>
                <input id="measureFeeValue" name="measure_fee_value" type="number" class="form-control">
            </div>
            <div class="form-group">
                <label for="measureFeeCurrency" class="block">Measure Fee Currency</label>
                <input id="measureFeeCurrency" name="measure_fee_currency" type="text" class="form-control"
                    value="GBP">
            </div>
            <div class="form-group">
                <label for="measureExpiryDate" class="block">Measure Expiry Date</label>
                <input id="measureExpiryDate" name="measure_expiry_date" class="form-control" type="date" />
            </div>
            <div class="form-group">
                <label for="measureCertificate" class="block">Measure Certificate</label>
                <input type="file" name="measure_certificate" id="measureCertificate">
            </div>
            <button class="btn btn-primary btn-small" id="measureDataAdd" type="button">Add</button>
        </div>
        <div class="col-md-8">
            <div class="dt-responsive table-responsive">
                <table id="measureTable" class="table table-striped table-bordered nowrap">
                    <thead>
                        <tr>
                            <th>Measure Cat</th>
                            <th>Measure Fee Value</th>
                            <th>Measure Fee Currency</th>
                            <th>Measure Expiry Date</th>
                            <th>Measure Certificate</th>
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
