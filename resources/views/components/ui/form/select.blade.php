<div class="form-group">
    <label>{{ $label }}</label>
    <select {{ $attributes }} class="form-control {{ $class }}">
        {{ $slot }}
    </select>
</div>