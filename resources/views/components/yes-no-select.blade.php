
<label for="{{ $name }}">{{ $label }}</label>
<select name="{{ $name }}" id="{{ $name }}" class="form-control">
    <option value="0" {{ old($name, $value) == 0 ? 'selected' : '' }}>Yes</option>
    <option value="1" {{ old($name, $value) == 1 ? 'selected' : '' }}>No</option>
</select>