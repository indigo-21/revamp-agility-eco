@props(['lists'])

@forelse ($lists as $list)
    <!-- Post -->
    <div class="post">
        <div class="user-block d-flex ">
            <h6
                style="background-color: #e7493a; color: #fff; border-radius: 50%; height: 40px; width: 40px;display: flex; align-items: center; justify-content: center; margin-bottom: 0;">
                {{ Str::substr($list->user->firstname, 0, 1) }}{{ Str::substr($list->user->lastname, 0, 1) }}
            </h6>
            <div>
                <span class="username" style="margin-left: 15px;">
                    <a href="#">{{ $list->user->firstname }} {{ $list->user->lastname }} -
                        {{ $list->user->accountLevel->name }}</a>
                </span>
                <span class="description" style="margin-left: 15px;">
                    {{ Carbon\Carbon::parse($list->created_at)->format('F j, Y') }}
                    {{ $list->created_at->diffForHumans() }}
                </span>
            </div>
        </div>
        <!-- /.user-block -->
        <p>
            {{-- <strong>Question Number:</strong>
            {{ $list->completedJob->surveyQuestion->question_number }}
            <br>
            <strong>Question:</strong>
            {{ $list->completedJob->surveyQuestion->question }}
            <br> --}}
            <strong>Comment:</strong>
            {{ $list->comment }}
        </p>

        @forelse ($list->remediationFiles as $remediationFile)
            <ul class="list-unstyled">

                <li>
                    <a href="{{ asset("storage/remediation_files/{$remediationFile->filename}") }}" target="_blank"
                        class="btn-link text-danger">
                        @php
                            $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
                            $ext = strtolower(pathinfo($remediationFile->filename, PATHINFO_EXTENSION));
                        @endphp
                        <i
                            class="far fa-fw {{ in_array($ext, $imageExtensions) ? 'fa-file-image' : 'fa-file-pdf' }}"></i>
                        {{ $remediationFile->filename }}
                    </a>
                </li>
            </ul>
        @empty
        @endforelse
    </div>
    <!-- /.post -->
@empty
    <div>
        <span class="text-muted">No remediation comments found.</span>
    </div>
@endforelse
