<div id="measures" class="card step">
    <div class="card-header">
        <h3 class="card-title">Measures</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-md-6">
                        <x-input name="umr" label="UMR" type="number" value="" />

                        <x-select label="Measure CAT" name="measure_id" :multiple="false">
                            <option value="" selected="selected" disabled>- Select Measure -</option>
                            @foreach ($measures as $measure)
                                <option value="{{ $measure->id }}">{{ $measure->measure_cat }}</option>
                            @endforeach
                        </x-select>
                    </div>
                    <div class="col-md-6">
                        <x-input name="info" label="Info" type="text" value="" />

                        <button type="button" class="btn btn-block btn-outline-primary mt-5" id="addMeasures">
                            <i class="fa fa-plus-circle" aria-hidden="true"></i> Add to table
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <table id="measuresTable" class="table table-bordered table-striped text-center">
                    <thead>
                        <tr>
                            <th>Job Suffix</th>
                            <th>UMR</th>
                            <th>Measure CAT</th>
                            <th>Info</th>
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
        <button class="btn btn-primary next w-25 mx-2" type="button">Next</button>
    </div>
</div>
