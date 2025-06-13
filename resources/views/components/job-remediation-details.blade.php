@props(['completedJob'])

<div class="card card-primary card-outline">
    <div class="card-body">
        <strong><i class="fas fa-book mr-1"></i> Job Number</strong>
        <p class="text-muted">
            {{ $completedJob->job->job_number }}
        </p>
        <hr>

        <strong><i class="fas fa-paperclip mr-1"></i> Question </strong>
        <p class="text-muted">
            {{ $completedJob->surveyQuestion->question_number }}
            {{ $completedJob->surveyQuestion->question }}
        </p>
        <hr>

        <strong><i class="fas fa-pencil-alt mr-1"></i> Result</strong>
        <p class="text-muted">{{ $completedJob->pass_fail }}</p>
        <hr>

        <strong><i class="far fa-file-alt mr-1"></i> Comments</strong>
        <p class="text-muted">{{ $completedJob->comments }}</p>
        <hr>

        <strong><i class="far fa-file-image mr-1"></i> Photos</strong>
        <div class="row mt-3">
            <div class="col-md-12">
                @foreach ($completedJob->completedJobPhotos as $completedJobPhoto)
                    <img src="{{ asset("storage/completed_job_photos/{$completedJobPhoto->filename}") }}" alt=""
                        width="100" height="100" class="img-thumbnail mb-2">
                @endforeach
            </div>
        </div>
        <hr>

        @if (auth()->user()->accountLevel->name != 'Installer')
            <strong><i class="fas fa-pencil-alt mr-1"></i> First Access on Failed
                JOB:</strong>
            <p class="text-muted">{{ $completedJob->installer_first_access }}</p>
            <hr>

            <strong><i class="fas fa-pencil-alt mr-1"></i> First Access on
                Specific Question:</strong>
            <p class="text-muted">{{ $completedJob->installer_first_access_completed_job }}</p>
        @endif

    </div>
    <!-- /.card-body -->
</div>
