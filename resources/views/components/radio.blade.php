@props(['label', 'name', 'id', 'checked' => false, 'value' => ""])

<div class="icheck-primary d-inline">
    <input type="radio" id="{{ $id }}" name="{{ $name }}" {{ $checked ? 'checked' : '' }}
        value="{{ $value }}">
    <label for="{{ $id }}">
        {{ $label }}
    </label>
</div>
