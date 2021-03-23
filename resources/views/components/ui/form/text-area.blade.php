<div class="form-group">
    <label>{{ $label }}</label>
    <textarea name="{{ $name }}" cols="{{ $size[0] ?? 30 }}" rows="{{ $size[1] ?? 10 }}" class="form-control">{{ $value }}</textarea>
</div>