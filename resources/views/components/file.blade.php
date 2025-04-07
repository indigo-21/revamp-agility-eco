@props(['label', 'name'])

<div class="form-group">
    <label>{{ $label }}</label>
    <div class="input-group">
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="{{ $name }}" name="{{ $name }}">
            <label class="custom-file-label" for="{{ $name }}">Choose file</label>
        </div>
        <div class="input-group-append">
            <span class="input-group-text">Upload</span>
        </div>
    </div>
</div>
