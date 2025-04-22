<div id="client-job-type" class="card step active-step">
    <div class="card-header">
        <h3 class="card-title">Client & Job Type</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12 col-lg-6">
                <x-select label="Client" name="client_id" :multiple="false">
                    <option value="" selected="selected" disabled>- Select Client -</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->user->firstname }}</option>
                    @endforeach
                </x-select>
            </div>
            <div class="col-sm-12 col-lg-6">
                <x-select label="Job Type" name="job_type_id" :multiple="false">
                    <option value="" selected="selected" disabled>- Select Job Type -</option>
                </x-select>
            </div>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end align-items-center">
        <button class="btn btn-primary next w-25 mx-2" type="button">Next</button>
    </div>
</div>
