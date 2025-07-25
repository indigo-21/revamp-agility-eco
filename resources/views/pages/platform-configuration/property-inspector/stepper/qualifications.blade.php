<div id="qualifications" class="card step">
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

                <x-input name="qualification_issue" label="Qualification Issue" />

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
                            <th>Qualification Issue</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($property_inspector) && $property_inspector->propertyInspectorQualifications)
                            @foreach ($property_inspector->propertyInspectorQualifications as $qualifications)
                                <tr>
                                    <td>{{ $qualifications->name }}</td>
                                    <td>{{ $qualifications->issue_date }}</td>
                                    <td>{{ $qualifications->expiry_date }}</td>
                                    <td>
                                        <img src="{{ asset("storage/qualification_certificate/$qualifications->certificate") }}"
                                            width="auto" height="150" />
                                    </td>
                                    <td>{{ $qualifications->qualification_issue }}</td>
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
        <button class="btn btn-success w-25 mx-2" type="button"
            id="submitButton">{{ isset($property_inspector) ? 'Update' : 'Submit' }}</button>
    </div>
</div>
