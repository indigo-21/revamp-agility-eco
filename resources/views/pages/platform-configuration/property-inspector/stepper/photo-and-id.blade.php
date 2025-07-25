<div id="photo-and-id" class="card step">
    <div class="card-header">
        <h3 class="card-title">Photo and ID</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-6">
                <x-file name="photo" label="Photo" />
            </div>
            <div class="col-12 col-md-6">
                <x-date name="photo_expiry" label="Photo Expiry Date"
                    value="{{ isset($property_inspector) ? $property_inspector->photo_expiry : '' }}" />
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6">
                <x-file name="id_badge" label="ID Badge" />
            </div>

            <div class="col-12 col-md-6">

                <x-date name="id_issued" label="ID Badge Issue Date"
                    value="{{ isset($property_inspector) ? $property_inspector->id_issued : '' }}" />

                <x-date name="id_expiry" label="ID Badge Expiry Date"
                    value="{{ isset($property_inspector) ? $property_inspector->id_expiry : '' }}" />

                <x-input name="id_revision" label="ID Badge Rev"
                    value="{{ isset($property_inspector) ? $property_inspector->id_revision : '' }}" />

                <x-select label="ID Badge Location" name="id_location" :multiple="false">
                    <option value="With Property Inspector"
                        {{ isset($property_inspector) && $property_inspector->id_location === 'With Property Inspector' ? 'selected' : '' }}>
                        With Property Inspector
                    </option>
                    <option value="At {{ env('EMPLOYER') }}"
                        {{ isset($property_inspector) && $property_inspector->id_location === 'At' . env('EMPLOYER') ? 'selected' : '' }}>
                        At {{ env('EMPLOYER') }}
                    </option>
                </x-select>

                <x-date name="id_return" label="Date ID Badge Returned"
                    value="{{ isset($property_inspector) ? $property_inspector->id_return : '' }}" />

            </div>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end align-items-center">
        <button class="btn btn-secondary w-25 mx-2 prev" type="button">Previous</button>
        <button class="btn btn-primary next w-25 mx-2" type="button">Next</button>
    </div>
</div>
