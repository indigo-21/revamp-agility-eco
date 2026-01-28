<div class="row pt-4">
    <div class="col-md-12 mb-3">
        <h3>Remediation History</h3>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                @php
                    $job->loadMissing([
                        'remediation.user.accountLevel',
                        'remediation.remediationFiles',
                        'remediation.completedJob.surveyQuestion',
                    ]);

                    $remediationsGrouped = ($job->remediation ?? collect())
                        ->groupBy(fn($remediation) => $remediation->completedJob?->survey_question_id ?? 'unknown');
                @endphp

                @if ($remediationsGrouped->isEmpty())
                    <x-history :lists="collect()" />
                @else
                    <div class="row">
                        <div class="col-5 col-sm-3">
                            <div class="nav flex-column nav-tabs h-100" id="remediation-vert-tabs-tab-{{ $job->id }}" role="tablist" aria-orientation="vertical">
                                @foreach ($remediationsGrouped as $surveyQuestionId => $remediations)
                                    @php
                                        $firstRemediation = $remediations->first();
                                        $question = $firstRemediation?->completedJob?->surveyQuestion;
                                        $tabId = 'remediation-vert-tabs-' . $job->id . '-' . $surveyQuestionId;
                                        $tabLabel = $question?->question_number
                                            ?? ($surveyQuestionId === 'unknown' ? 'Unknown' : $surveyQuestionId);
                                    @endphp

                                    <a
                                        class="nav-link {{ $loop->first ? 'active' : '' }}"
                                        id="{{ $tabId }}-tab"
                                        data-toggle="pill"
                                        href="#{{ $tabId }}"
                                        role="tab"
                                        aria-controls="{{ $tabId }}"
                                        aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                                    >
                                        {{ $tabLabel }}
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-7 col-sm-9">
                            <div class="tab-content" id="remediation-vert-tabs-tabContent-{{ $job->id }}">
                                @foreach ($remediationsGrouped as $surveyQuestionId => $remediations)
                                    @php
                                        $tabId = 'remediation-vert-tabs-' . $job->id . '-' . $surveyQuestionId;
                                    @endphp

                                    <div
                                        class="tab-pane text-left fade {{ $loop->first ? 'show active' : '' }}"
                                        id="{{ $tabId }}"
                                        role="tabpanel"
                                        aria-labelledby="{{ $tabId }}-tab"
                                    >
                                        <x-history :lists="$remediations" />
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
