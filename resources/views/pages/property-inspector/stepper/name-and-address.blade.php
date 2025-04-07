<div id="name-and-address" class="card card-primary card-outline step">
    <div class="card-header">
        <h3 class="card-title">Name and Address</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-6">

                <x-input name="firstname" label="First Name" />

                <x-input name="lastname" label="Last Name" />

                <x-input name="mobile" label="Mobile" />

                <x-input name="landline" label="Landline" />

                <x-input name="email" label="Email" type="email" />

                <x-input name="username" label="Username" />

                <x-input name="organisation" label="Organisation" />
            </div>
            <div class="col-12 col-md-6">
                <x-input name="address1" label="Address 1" />

                <x-input name="address2" label="Address 2" />

                <x-input name="address3" label="Address 3" />

                <x-input name="city" label="City" />

                <x-input name="county" label="County" />

                <x-input name="postcode" label="Postcode" />

            </div>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end align-items-center">
        <button class="btn btn-secondary w-25 mx-2 prev" type="button">Previous</button>
        <button class="btn btn-primary next w-25 mx-2" type="button">Next</button>
    </div>
</div>
