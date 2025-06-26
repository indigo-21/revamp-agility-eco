<div class="row pt-4">
    <div class="col-md-12 mb-3">
        <h3>Update Survey History</h3>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                @forelse ($updateSurveys as $updateSurvey)
                    <!-- Post -->
                    <div class="post">
                        <div class="user-block d-flex ">
                            <h6
                                style="background-color: #e7493a; color: #fff; border-radius: 50%; height: 40px; width: 40px;display: flex; align-items: center; justify-content: center; margin-bottom: 0;">
                                {{ Str::substr($updateSurvey->user->firstname, 0, 1) }}{{ Str::substr($updateSurvey->user->lastname, 0, 1) }}
                            </h6>
                            <div>
                                <span class="username" style="margin-left: 15px;">
                                    <a href="#">{{ $updateSurvey->user->firstname }}
                                        {{ $updateSurvey->user->lastname }} -
                                        {{ $updateSurvey->user->accountLevel->name }}</a>
                                </span>
                                <span class="description" style="margin-left: 15px;">
                                    {{ Carbon\Carbon::parse($updateSurvey->created_at)->format('F j, Y') }}
                                    {{ $updateSurvey->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                        <!-- /.user-block -->
                        <p>
                            <strong>Question Number:</strong>
                            {{ $updateSurvey->completedJob->surveyQuestion->question_number }}
                            <br>
                            <strong>Question:</strong>
                            {{ $updateSurvey->completedJob->surveyQuestion->question }}
                            <br>
                            <strong>Update Outcome:</strong>
                            {!! $updateSurvey->update_outcome !!}
                        </p>
                    </div>
                    <!-- /.post -->
                @empty
                    <span class="text-muted">No updates available</span>
                @endforelse

            </div>
        </div>
    </div>
</div>
