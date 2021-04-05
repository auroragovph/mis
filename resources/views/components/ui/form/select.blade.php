<div class="form-group">
    <label>{{ $label }}</label>
    <select {{ $attributes }} name="{{ $name }}" class="form-control {{ $class }}" @if($required) required @endif>
        {{ $slot }}
    </select>
</div>