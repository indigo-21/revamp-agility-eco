@props(['label', 'name', 'id', 'checked' => false])

<div class="icheck-primary d-inline">
    <input type="radio" id="{{ $id }}" name="{{ $name }}" {{ $checked ? 'checked' : '' }}>
    <label for="{{ $id }}">
        {{ $label }}
    </label>
</div>
