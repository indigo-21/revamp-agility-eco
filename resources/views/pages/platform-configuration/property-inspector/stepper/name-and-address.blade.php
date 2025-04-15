<div id="name-and-address" class="card card-primary card-outline step">
    <div class="card-header">
        <h3 class="card-title">Name and Address</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-6">

                <x-input name="firstname" label="First Name"
                    value="{{ isset($property_inspector) ? $property_inspector->user->firstname : '' }}" />

                <x-input name="lastname" label="Last Name"
                    value="{{ isset($property_inspector) ? $property_inspector->user->lastname : '' }}" />

                <x-input name="mobile" label="Mobile"
                    value="{{ isset($property_inspector) ? $property_inspector->user->mobile : '' }}" />

                <x-input name="landline" label="Landline"
                    value="{{ isset($property_inspector) ? $property_inspector->user->landline : '' }}" />

                <x-input name="email" label="Email" type="email"
                    value="{{ isset($property_inspector) ? $property_inspector->user->email : '' }}" />

                <x-input name="organisation" label="Organisation"
                    value="{{ isset($property_inspector) ? $property_inspector->user->organisation : '' }}" />
            </div>
            <div class="col-12 col-md-6">
                <x-input name="address1" label="Address 1"
                    value="{{ isset($property_inspector) ? $property_inspector->address1 : '' }}" />

                <x-input name="address2" label="Address 2"
                    value="{{ isset($property_inspector) ? $property_inspector->address2 : '' }}" />

                <x-input name="address3" label="Address 3"
                    value="{{ isset($property_inspector) ? $property_inspector->address3 : '' }}" />

                <x-input name="city" label="City"
                    value="{{ isset($property_inspector) ? $property_inspector->city : '' }}" />

                <x-input name="county" label="County"
                    value="{{ isset($property_inspector) ? $property_inspector->county : '' }}" />

                <x-input name="postcode" label="Postcode"
                    value="{{ isset($property_inspector) ? $property_inspector->postcode : '' }}" />

            </div>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end align-items-center">
        <button class="btn btn-secondary w-25 mx-2 prev" type="button">Previous</button>
        <button class="btn btn-primary next w-25 mx-2" type="button">Next</button>
    </div>
</div>
