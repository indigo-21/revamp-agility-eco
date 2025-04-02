<div id="photo-and-id" class="card card-primary card-outline step">
    <div class="card-header">
        <h3 class="card-title">Photo and ID</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-6">
                <x-file name="photo" label="Photo" />
            </div>
            <div class="col-12 col-md-6">
                <x-date name="photo_expiry" label="Photo Expiry Date" />
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6">
                <x-file name="id_badge" label="ID Badge" />
            </div>

            <div class="col-12 col-md-6">

                <x-date name="id_issued" label="ID Badge Issue Date" />

                <x-date name="id_expiry" label="ID Badge Expiry Date" />

                <x-date name="id_revision" label="ID Badge Rev" />

                <div class="form-group">
                    <label>ID Return</label>
                    <select class="form-control select2" style="width: 100%;" name="id_location">
                        <option selected="selected" disabled>-Select Location-</option>
                        <option>Alaska</option>
                    </select>
                </div>

                <x-date name="id_returned" label="Date ID Badge Returned" />

            </div>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end align-items-center">
        <button class="btn btn-secondary w-25 mx-2 prev">Previous</button>
        <button class="btn btn-primary next w-25 mx-2">Next</button>
    </div>
</div>
