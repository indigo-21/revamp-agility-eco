@props(['title', 'name', 'unit', 'value' => '', 'unitValue' => ''])

<div class="form-group">
    <label for="{{ $name }}">{{ $title }}</label>
    <div class="row">
        <div class="col-8">
            <input type="text" class="form-control" id="{{ $name }}" name="{{ $name }}"
                value="{{ $value }}" placeholder="{{ $title }}" inputformat="[a-zA-Z0-9!@#&()\-]">
        </div>
        <div class="col-4">
            <select class="form-control select2" style="width: 100%;" name="{{ $unit }}">
                <option value="" disabled {{ $unitValue == '' ? 'selected' : '' }}>-Select-</option>
                <option value="1" {{ $unitValue == '1' ? 'selected' : '' }}>Hours</option>
                <option value="2" {{ $unitValue == '2' ? 'selected' : '' }}>Days</option>
            </select>
        </div>
    </div>
</div>
