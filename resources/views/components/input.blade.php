@props(['class' => '', 'value' => '', 'name', 'label', 'type' => 'text', 'required' => false, 'disabled' => false, 'inputformat' => '[a-zA-Z\s]'])

{{-- <input 
    {{ $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) }}> --}}

<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <input type="{{ $type }}" class="form-control {{ $class }}" id="{{ $name }}"
        name="{{ $name }}" placeholder="Enter {{ $label }}" @disabled($disabled)
        value="{{ $value }}" @required($required) inputformat="{{ $inputformat }}" {{ $attributes }}>
    <div class="invalid-feedback"></div>
</div>
