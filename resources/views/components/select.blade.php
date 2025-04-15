@props(['label', 'name', 'required'=> false, 'multiple' => false])

<div class="form-group">
    <label>{{ $label }}</label>
    <select class="form-control select2 w-100" name="{{ $name }}" {{ $multiple ? 'multiple' : '' }} @required($required)>
        {{ $slot }}
    </select>
    <div class="invalid-feedback"></div>
</div>
{{-- 
<div class="form-group">
    <label>Multiple</label>
    <select class="form-control select2" multiple>
        <option>Alabama</option>
        <option>Alaska</option>
        <option>California</option>
        <option>Delaware</option>
        <option>Tennessee</option>
        <option>Texas</option>
        <option>Washington</option>
    </select>
</div> --}}
