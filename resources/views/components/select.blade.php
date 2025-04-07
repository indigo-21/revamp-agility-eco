@props(['label', 'name', 'multiple'])

<div class="form-group">
    <label>{{ $label }}</label>
    <select class="form-control select2" name="{{ $name }}" {{ $multiple ? 'multiple' : '' }}>
        {{ $slot }}
    </select>
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
