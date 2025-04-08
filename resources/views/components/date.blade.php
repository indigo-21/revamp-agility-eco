@props(['label', 'name', 'value' => ''])

<div class="form-group">
    <label>{{ $label }}</label>
    <div class="input-group date" id="{{ $name }}" data-target-input="nearest">
        <input type="text" class="form-control datetimepicker-input" data-target="#{{ $name }}"
            name="{{ $name }}" value="{{ $value }}">
        <div class="input-group-append" data-target="#{{ $name }}" data-toggle="datetimepicker">
            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
        </div>
    </div>
</div>
