<div class="tab-pane text-left fade show active" aria-labelledby="jobs-with-nc-tab">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Job Number</th>
                <th>Cert #</th>
                <th>UMR</th>
                <th>Property Inspector</th>
                <th>Address</th>
                <th>Postcode</th>
                <th>Measure Type</th>
                <th>Installer</th>
                <th>Booked Date</th>
                <th>Scheme</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jobNC as $job)
                <tr>
                    <td>{{ $job->job_number }}</td>
                    <td>{{ $job->cert_no }}</td>
                    <td>{{ $job->jobMeasure?->umr }}</td>
                    <td>{{ $job->propertyInspector?->user->firstname }}
                        {{ $job->propertyInspector?->user->lastname }}</td>
                    <td>{{ $job->property->address1 }}</td>
                    <td>{{ $job->property->postcode }}</td>
                    <td>{{ $job->jobMeasure->measure->measure_cat }}</td>
                    <td>{{ $job->installer->user->firstname ?? 'N/A' }}</td>
                    <td>{{ $job->booked_date ? \Carbon\Carbon::parse($job->booked_date)->format('d/m/Y') : 'N/A' }}
                    </td>
                    <td>{{ $job->scheme->short_name ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
