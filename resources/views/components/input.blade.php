@props(['disabled' => false, 'value' => '', 'name', 'label', 'type' => 'text'])

{{-- <input 
    {{ $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) }}> --}}

<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <input type="{{ $type }}" class="form-control" id="{{ $name }}" name="{{ $name }}"
        placeholder="Enter {{ $label }}" @disabled($disabled) value="{{ $value }}">
</div>
