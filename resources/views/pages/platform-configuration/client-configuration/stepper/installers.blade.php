<div id="step5" class="card step">
    <div class="card-header">
        <h3 class="card-title">Installers</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label>List of Installers</label>

                    <select class="duallistbox" multiple="multiple" name="client_installers[]">
                        @foreach ($installers as $installer)
                            <option value="{{ $installer->id }}"
                                {{ isset($client) && $client->clientInstallers->contains('installer_id', $installer->id) ? 'selected' : '' }}>
                                {{ $installer->user->firstname }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end align-items-center">
        <button type="button" class="btn btn-secondary prev w-25 mx-2">Previous</button>
        <button type="button" class="btn btn-success w-25 mx-2" id="submitButton">Submit</button>
    </div>
</div>
