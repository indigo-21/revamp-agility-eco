@props(['job'])

<x-button-permission type="view" :permission="$userPermission" as="a" :href="route('update-survey.edit', $job->id)" class="btn btn-primary btn-sm"
    label="Update Survey" />
