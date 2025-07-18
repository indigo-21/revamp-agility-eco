@props(['job'])

<div class="btn-group">
    <x-button-permission type="create" :permission="$userPermission" as="a" :href="route('remediation-review.show', $job->id)" class="btn btn-primary btn-sm"
        label="View Details" />
    <x-button-permission type="delete" :permission="$userPermission" class="btn btn-danger btn-sm closeJob" label="Close Job"
        data-target="#closeJob" data-toggle="modal" data-id="{{ $job->id }}" />
</div>
