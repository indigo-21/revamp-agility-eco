<div id="step4" class="card card-primary card-outline step">
    <div class="card-header">
        <h3 class="card-title">Client Measures</h3>
    </div>
    <div class="card-body">
        <div class="row border-bottom pb-3" id="clientMeasuresForm">
            <div class="col-sm-12 col-lg-3">
                <x-select label="Measure CAT" name="measure_cat" :required="true">
                        <option selected="selected" disabled value="">-Select Measure-</option>
                        @foreach ($measureCategories as $measureCategory )
                            <option value="{{$measureCategory->id}}">{{$measureCategory->measure_cat}}</option>
                        @endforeach
                </x-select>  
            </div>
            <div class="col-sm-6 col-lg-6">
                <div class="form-group">
                    <x-input type="text" name="measure_fee_value" label="Measure Fee Value" :required="true" inputformat="[0-9]" />
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                    <x-input type="text" name="measure_fee_currency" label="Measure Fee Currency" :disabled="true" value="GBP"/>
            
            </div>
            <div class="col-sm-12 col-lg-6 offset-lg-3 text-center">
                <button type="button" class="btn btn-success w-50 mx-2" id="clientMeasuresBtn" formid="clientMeasuresForm">Add</button>
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
                        @if (isset($client) && count($client_measures) > 0)
                            @foreach ( $client_measures as $client_measure )
                                <tr id="{{$client_measure->measure_id}}">
                                    <td>{{$client_measure->measure->measure_cat}}</td>
                                    <td>{{$client_measure->measure_fee}}</td>
                                    <td>GBP</td>
                                    <td><button class="btn btn-danger btn-sm deleteRow">Delete</button></td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end align-items-center">
        <button type="button" class="btn btn-secondary prev w-25 mx-2">Previous</button>
        <button type="button" class="btn btn-primary next w-25 mx-2" tableid="clientMeasureTable">Next</button>
    </div>
</div>