<div id="photo-and-id" class="card step">
    <div class="card-header">
        <h3 class="card-title">Photo and ID</h3>
    </div>
    <div class="card-body">
        @php
            $existingPhotoFilename = isset($property_inspector) ? ($property_inspector->user->photo ?? null) : null;
            $existingPhotoUrl = $existingPhotoFilename ? asset('storage/profile_images/' . $existingPhotoFilename) : null;
            $existingPhotoLocation = $existingPhotoFilename ? 'storage/profile_images/' . $existingPhotoFilename : null;

            $existingIdBadgeFilename = isset($property_inspector) ? ($property_inspector->id_badge ?? null) : null;
            $existingIdBadgeUrl = $existingIdBadgeFilename ? asset('storage/id_badge/' . $existingIdBadgeFilename) : null;
            $existingIdBadgeLocation = $existingIdBadgeFilename ? 'storage/id_badge/' . $existingIdBadgeFilename : null;
        @endphp

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
                    value="{{ isset($property_inspector) ? $property_inspector->id_issued : '' }}" :required="true" />

                <x-date name="id_expiry" label="ID Badge Expiry Date"
                    value="{{ isset($property_inspector) ? $property_inspector->id_expiry : '' }}" :required="true" />

                <x-input name="id_revision" label="ID Badge Rev"
                    value="{{ isset($property_inspector) ? $property_inspector->id_revision : '' }}"
                    :required="true" />

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

        <div class="row mt-3">
            <div class="col-12 col-md-6">
                <div class="border rounded bg-light d-flex align-items-center justify-content-center"
                    style="height: 260px; overflow: hidden;">
                    <img id="photoPreviewImg" alt="Photo preview"
                        src="{{ $existingPhotoUrl ?? '' }}"
                        style="max-width: 100%; max-height: 100%; object-fit: contain; {{ $existingPhotoUrl ? '' : 'display:none;' }}" />
                    <div id="photoPreviewPlaceholder" class="text-muted" style="{{ $existingPhotoUrl ? 'display:none;' : '' }}">
                        Photo
                    </div>
                </div>
                <small id="photoPreviewMeta" class="form-text text-muted mt-2"
                    data-existing-location="{{ $existingPhotoLocation ?? '' }}">
                    @if ($existingPhotoLocation)
                        Stored at: <a href="{{ $existingPhotoUrl }}" target="_blank" rel="noopener noreferrer">{{ $existingPhotoLocation }}</a>
                    @else
                        No photo uploaded yet.
                    @endif
                </small>
            </div>

            <div class="col-12 col-md-6 mt-3 mt-md-0">
                <div class="border rounded bg-light d-flex align-items-center justify-content-center"
                    style="height: 260px; overflow: hidden;">
                    <img id="idBadgePreviewImg" alt="ID badge preview"
                        src="{{ $existingIdBadgeUrl ?? '' }}"
                        style="max-width: 100%; max-height: 100%; object-fit: contain; {{ $existingIdBadgeUrl ? '' : 'display:none;' }}" />
                    <div id="idBadgePreviewPlaceholder" class="text-muted" style="{{ $existingIdBadgeUrl ? 'display:none;' : '' }}">
                        ID Badge
                    </div>
                </div>
                <small id="idBadgePreviewMeta" class="form-text text-muted mt-2"
                    data-existing-location="{{ $existingIdBadgeLocation ?? '' }}">
                    @if ($existingIdBadgeLocation)
                        Stored at: <a href="{{ $existingIdBadgeUrl }}" target="_blank" rel="noopener noreferrer">{{ $existingIdBadgeLocation }}</a>
                    @else
                        No ID badge uploaded yet.
                    @endif
                </small>
            </div>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end align-items-center">
        <button class="btn btn-secondary w-25 mx-2 prev" type="button">Previous</button>
        <button class="btn btn-primary next w-25 mx-2" type="button">Next</button>
    </div>
</div>
