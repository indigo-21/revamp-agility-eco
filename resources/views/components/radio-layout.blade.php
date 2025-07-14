@props(['label'])

<div {{ $attributes->merge(['class' => 'form-group clearfix']) }}>
    <label>{{ $label }}</label>
    <br>
    <div class="row">
        {{ $slot }}
    </div>
</div>
