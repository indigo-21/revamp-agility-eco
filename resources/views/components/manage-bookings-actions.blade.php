@props(['job'])

<form action="{{ route('manage-booking.unbook', ['job_group' => $job->job_group]) }}" method="POST"
    class="unbook-job-form">
    @csrf
    <div class="btn-group">
        <x-button-permission type="create" :permission="$userPermission" as="a" :href="route('manage-booking.edit', [
            'job_group' => $job->job_group,
        ])"
            class="btn btn-sm btn-primary" label="Rebook" />
        <x-button-permission type="update" :permission="$userPermission" class="btn btn-sm btn-warning unbook-job" label="Unbook" />
        <x-button-permission type="delete" :permission="$userPermission" class="btn btn-sm btn-danger closeJob"
            data-job-number="{{ $job->job_group }}" label="Close" data-target="#closeJob" data-toggle="modal" />
        <x-button-permission type="view" :permission="$userPermission" as="a" :href="route('make-booking.show', [
            'job_group' => $job->job_group,
        ])"
            class="btn btn-sm btn-secondary" label="History" />
    </div>
</form>
