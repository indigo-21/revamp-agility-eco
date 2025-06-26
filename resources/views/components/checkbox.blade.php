{{-- @props(['name', 'label', 'class' => '', 'type' => 'checkbox', 'required' => false, 'ischeck' => false])

<div class="form-group">
    <div class="custom-control custom-checkbox">
        <input class="custom-control-input custom-control-input-danger {{ $class }}" type="{{ $type }}"
            id="{{ $name }}" name="{{ $name }}" @required($required) @checked($ischeck)>
        <label for="{{ $name }}" class="custom-control-label">{{ $label }}</label>
    </div>
</div> --}}

@props(['name', 'value', 'label', 'ischeck' => false])

<div class="icheck-danger d-inline">
    <input type="checkbox" name="{{ $name }}" value="{{ $value }}" {{ $attributes }}
        @checked($ischeck)>
    <label for="{{ $label }}">
        {{ $label }}
    </label>
</div>
