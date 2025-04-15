@props(['name', 'label', 'value' => '', 'rows' => 4])

<label for="{{ $name }}">{{ $label }}</label>
<textarea name="{{ $name }}" id="{{ $name }}" class="form-control" rows="{{ $rows }}"
    placeholder="Enter {{ $label }}">{{ $value }}
</textarea>
