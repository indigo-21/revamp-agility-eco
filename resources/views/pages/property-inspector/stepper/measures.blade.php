<div id="measures" class="card card-primary card-outline step">
    <div class="card-header">
        <h3 class="card-title">Measures</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label>Client Type</label>
                    <select class="form-control select2" style="width: 100%;">
                        <option selected="selected" disabled>-Select Client Type-</option>
                        <option>Alaska</option>
                    </select>
                </div>

                <x-input name="measure_fee_value" label="Measure Fee Value"/>

                <x-input name="measure_fee_currency" label="Measure Fee Currency" value="GBP"
                    :disabled="true" />
            </div>
            <div class="col-12 col-md-6">

                <x-date name="measure_expiry_date" label="Measure Expiry Date" />

                <x-file name="measure_certificate" label="Measure Certificate" />

                <button type="button" class="btn btn-block btn-outline-primary mt-5" id="addMeasures">
                    <i class="fa fa-plus-circle" aria-hidden="true"></i> Add to table
                </button>
            </div>
        </div>

        <div class="row ">
            <div class="col-md-12">
                <table id="measuresTable" class="table table-bordered table-striped">
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
        <button class="btn btn-primary next w-25 mx-2">Next</button>
    </div>
</div>
