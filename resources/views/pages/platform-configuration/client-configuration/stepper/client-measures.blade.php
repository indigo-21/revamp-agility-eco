<div id="step4" class="card step">
    <div class="card-header">
        <h3 class="card-title">Client Measures</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-md-6">
                        <x-select label="Measure CAT" name="measure_id">
                            <option selected="selected" disabled value="">-Select Measure-</option>
                            @foreach ($measures as $measure)
                                <option value="{{ $measure->id }}">{{ $measure->measure_cat }}</option>
                            @endforeach
                        </x-select>

                        <x-input type="text" name="measure_fee_value" label="Measure Fee Value" />
                    </div>
                    <div class="col-md-6">
                        <x-input type="text" name="measure_fee_currency" label="Measure Fee Currency"
                            :disabled="true" value="GBP" />

                        <button type="button" class="btn btn-block btn-outline-primary mt-5" id="addMeasures">
                            <i class="fa fa-plus-circle" aria-hidden="true"></i> Add to table
                        </button>
                    </div>
                </div>
            </div>
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
                        @if (isset($client))
                            @foreach ($client->clientMeasures as $clientMeasure)
                                <tr>
                                    <td>{{ $clientMeasure->measure->measure_cat }}</td>
                                    <td>{{ $clientMeasure->measure_fee }}</td>
                                    <td>{{ $clientMeasure->measure_fee_currency }}</td>
                                    <td>
                                        <button class="btn btn-danger btn-sm deleteRow" type="button">Delete</button>
                                    </td>
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
        <button type="button" class="btn btn-primary next w-25 mx-2">Next</button>
    </div>
</div>
