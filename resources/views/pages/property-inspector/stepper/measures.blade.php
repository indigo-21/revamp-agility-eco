<div id="measures" class="card card-primary card-outline step">
    <div class="card-header">
        <h3 class="card-title">Measures</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-6">

                <x-select label="Measure CAT" name="measure_id" :multiple="false">
                    <option selected="selected" disabled>- Select Measure CAT -</option>
                    @foreach ($measures as $measure)
                        <option value="{{ $measure->id }}">{{ $measure->measure_cat }}</option>
                    @endforeach

                </x-select>

                <x-input name="measure_fee_value" label="Measure Fee Value" type="number" />

                <x-input name="measure_fee_currency" label="Measure Fee Currency" value="GBP" :disabled="true" />
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
                            <th>Measure Cat</th>
                            <th>Measure Fee Value</th>
                            <th>Measure Fee Currency</th>
                            <th>Measure Expiry Date</th>
                            <th>Measure Certicate</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($property_inspector) && $property_inspector->propertyInspectorMeasures)
                            @foreach ($property_inspector->propertyInspectorMeasures as $pi_measure)
                                <tr>
                                    <td>{{ $pi_measure->measure->measure_cat }}</td>
                                    <td>{{ $pi_measure->fee_value }}</td>
                                    <td>{{ $pi_measure->fee_currency }}</td>
                                    <td>{{ $pi_measure->expiry }}</td>
                                    <td>
                                        <img src="{{ asset("storage/measure_certificate/$pi_measure->cert") }}"
                                            width="auto" height="150" />
                                    </td>
                                    <td>
                                        <button class="btn btn-danger btn-sm deleteRow">Delete</button>
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
        <button class="btn btn-secondary w-25 mx-2 prev" type="button">Previous</button>
        <button class="btn btn-primary next w-25 mx-2" type="button">Next</button>
    </div>
</div>
