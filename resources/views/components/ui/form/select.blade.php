<div class="mb-3">
    <div class="form-label">{{ $label }}</div>
    <select {{ $attributes }} class="form-select {{ $class }}">
        {{ $slot }}
    </select>
</div>
