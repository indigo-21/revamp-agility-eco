<div id="property-details" class="card step">
    <div class="card-header">
        <h3 class="card-title">Property Details</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12 col-lg-6">
                <x-input name="cert_no" label="Cert Number" type="number" value="" />

                <x-input name="lodged_by_tmln" label="Lodged by TMLN" type="text" value="" />

                <x-input name="lodged_by_name" label="Lodged by Name" type="text" value="" />

                <x-select label="Sub Installer Name" name="installer_id" :multiple="false">
                    <option value="" selected="selected" disabled>- Select Installer -</option>
                </x-select>

                <x-input name="sub_installer_tmln" label="Sub Installer TMLN" type="text" value="" />

                <x-input name="sub_installer_tmln" label="Sub Installer TMLN" type="text" value="" />

                <x-select label="Scheme" name="scheme_id" :multiple="false">
                    <option value="" selected="selected" disabled>- Select Scheme -</option>
                    @foreach ($schemes as $scheme)
                        <option value="{{ $scheme->id }}">{{ $scheme->short_name }}</option>
                    @endforeach
                </x-select>
            </div>
            <div class="col-sm-12 col-lg-6">
                <x-input name="house_flat_prefix" label="Property Number" type="number" value="" />

                <x-input name="address1" label="Prorperty Address 1" type="text" value="" />

                <x-input name="address2" label="Prorperty Address 2" type="text" value="" />

                <x-input name="address" label="Prorperty Address 3" type="text" value="" />

                <x-input name="city" label="Property City" type="number" value="" />

                <x-input name="county" label="Property County" type="number" value="" />

                <x-input name="postcode" label="Property Postcode" type="number" value="" />

                <x-input name="customer_name" label="Customer Name" type="number" value="" />

                <x-input name="customer_email" label="Customer Email" type="number" value="" />

                <x-input name="customer_primary_tel" label="Customer Primary Tel" type="number" value="" />

                <x-input name="customer_secondary_tel" label="Customer Secondary Tel" type="number" value="" />

            </div>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end align-items-center">
        <button class="btn btn-secondary w-25 mx-2 prev" type="button">Previous</button>
        <button class="btn btn-primary next w-25 mx-2" type="button">Next</button>
    </div>
</div>
