<div class="tab-pane fade text-left fade show active" aria-labelledby="failed-questions-tab">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Job Number</th>
                <th>Cert #</th>
                <th>UMR</th>
                <th>Property Inspector</th>
                <th>Measure Type</th>
                {{-- <th>Address</th>
                    <th>Postcode</th> --}}
                {{-- <th>Installer</th> --}}
                <th>Question #</th>
                <th>Pass / Fail</th>
                <th>Last Comment</th>
                <th>High / Low</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($failedQuestions as $failedQuestion)
                <tr>
                    <td>{{ $failedQuestion->job->job_number }}</td>
                    <td>{{ $failedQuestion->job->cert_no }}</td>
                    <td>{{ $failedQuestion->job->jobMeasure?->umr }}</td>
                    <td>{{ $failedQuestion->job->propertyInspector?->user->firstname }}
                        {{ $failedQuestion->job->propertyInspector?->user->lastname }}
                    </td>
                    <td>{{ $failedQuestion->job->jobMeasure->measure->measure_cat }}
                    </td>
                    {{-- <td>{{ $failedQuestion->job->property->address1 }}</td>
                    <td>{{ $failedQuestion->job->property->postcode }}</td> --}}
                    <td>{{ $failedQuestion->job->installer->user->firstname ?? 'N/A' }}
                    </td>
                    <td>{{ $failedQuestion->pass_fail }}</td>
                    {{-- <td>{{ $failedQuestion->remediations?->where('role', 'Installer')?->last()?->comment ?? 'N/A'
                        }}
                    </td> --}}
                    <td>{{ $failedQuestion->surveyQuestion->nc_severity }}</td>
                    <td>{{ $failedQuestion->surveyQuestion->question_number }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
