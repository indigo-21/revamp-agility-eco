@props(['label'])

<div class="form-group clearfix">
    <label>{{ $label }}</label>
    <br>
    <div class="row">
        {{ $slot }}
    </div>
</div>
