@props(['job'])

<form action="{{ route('job.destroy', $job->id) }}" method="POST" class="delete-form">
    @csrf
    @method('DELETE')
    <div class="btn-group">
        <x-button-permission type="view" :permission="$userPermission" as="a" :href="route('job.show', $job->id)"
            class="btn btn-primary btn-sm" label="View" />
        <x-button-permission type="update" :permission="$userPermission" class="btn btn-warning btn-sm closeJobBtn"
            data-id="{{ $job->id }}" label="Close Job" data-target="#closeJob" data-toggle="modal" />
        <x-button-permission type="delete" :permission="$userPermission" class="btn btn-danger btn-sm delete-btn" label="Delete" />
    </div>
</form>
