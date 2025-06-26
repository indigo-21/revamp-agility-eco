<div class="row pt-4">
    <div class="col-md-12 mb-3">
        <h3>Remediation History</h3>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <x-history :lists="$job->remediation" />
            </div>
        </div>
    </div>
</div>
