<div id="step4" class="card card-primary card-outline step">
    <div class="card-header">
        <h3 class="card-title">Client Measures</h3>
    </div>
    <div class="card-body">
        <div class="row border-bottom pb-3">
            <div class="col-sm-12 col-lg-6">
                <div class="form-group">
                    <label>Measure CAT</label>
                    <select class="form-control select2" style="width: 100%;">
                        <option selected="selected" disabled>-Select Measure-</option>
                        <option>Alaska</option>
                    </select>    
                </div>  
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="form-group">
                    <label for="measureFeeValue">Measure Fee Value</label>
                    <input type="text" class="form-control" id="measureFeeValue" name="measure_fee_value" placeholder="Enter Measure Fee Value">
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="form-group">
                    <label for="measureFeeCurrency">Measure Fee Currency</label>
                    <input type="text" class="form-control" id="measureFeeCurrency" name="measure_fee_value" value="GBP" disabled>
                </div>
            </div>
            <div class="col-sm-12 col-lg-6 offset-lg-3 text-center">
                <button class="btn btn-success w-50 mx-2">Add</button>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <table id="clientMeasureTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Measure</th>
                            <th>Charge Value</th>
                            <th>Currency</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Measure</td>
                            <td>Charge Value</td>
                            <td>Currency</td>
                            <td>Action</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end align-items-center">
        <button class="btn btn-secondary prev w-25 mx-2">Previous</button>
        <button class="btn btn-primary next w-25 mx-2">Next</button>
    </div>
</div>