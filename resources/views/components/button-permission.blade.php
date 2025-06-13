@props([
    'permission', // 1 = view, 2 = view/update/create, 3 = all
    'type', // 'view', 'create', 'update', 'delete'
    'as' => 'button', // 'button' or 'a'
    'href' => null, // for <a> tag
    'label' => null,
    'class' => '',
    'dataToggle' => null, // for modal
    'dataTarget' => null, // for modal
])

@php
    $canShow = false;
    if ($type === 'view') {
        $canShow = $permission >= 1;
    } elseif (in_array($type, ['create', 'update'])) {
        $canShow = $permission >= 2;
    } elseif ($type === 'delete') {
        $canShow = $permission == 3;
    }
@endphp

@if ($canShow)
    @if ($as === 'a')
        <a href="{{ $href }}" class="{{ $class }}" {{ $attributes }}>
            {{ $label ?? ucfirst($type) }}
        </a>
    @else
        <button type="button" class="{{ $class }}"
            @if($dataToggle) data-toggle="{{ $dataToggle }}" @endif
            @if($dataTarget) data-target="{{ $dataTarget }}" @endif
            {{ $attributes }}>
            {{ $label ?? ucfirst($type) }}
        </button>
    @endif
@endif