@props(['job'])

<div class="btn-group">
    <x-button-permission type="create" :permission="$userPermission" as="a" :href="route('make-booking.edit', [
        'job_group' => $job->job_group,
    ])" class="btn btn-primary btn-sm"
        label="Book" />
    <x-button-permission type="update" :permission="$userPermission" as="a" :href="route('make-booking.editPI', [
        'job_group' => $job->job_group,
    ])" class="btn btn-info btn-sm"
        label="Edit PI" />
    <x-button-permission type="delete" :permission="$userPermission" class="btn btn-sm btn-danger closeJob"
        data-job-number="{{ $job->job_group }}" label="Close Job" data-target="#closeJob" data-toggle="modal" />
    <x-button-permission type="update" :permission="$userPermission" class="btn btn-sm btn-warning attemptMade"
        data-job-number="{{ $job->job_group }}" label="Attempt Made" data-target="#attemptMade" data-toggle="modal" />
    <x-button-permission type="view" :permission="$userPermission" as="a" :href="route('make-booking.show', [
        'job_group' => $job->job_group,
    ])"
        class="btn btn-sm btn-secondary" label="History" />
</div>
