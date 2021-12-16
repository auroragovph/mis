{{-- <div class="form-group">
    <label>{{ $label }}</label>
    <textarea {{ $attributes }} cols="{{ $size[0] ?? 30 }}" rows="{{ $size[1] ?? 10 }}"
        class="form-control {{ $class }}">{{ $slot }}</textarea>
</div>\ --}}

<div class="mb-3">
    <label class="form-label">{{ $label }}</label>
    <textarea class="form-control {{ $class }}" {{ $attributes }} cols="{{ $size[0] ?? 30 }}" rows="{{ $size[1] ?? 10 }}">{{ $slot }}</textarea>
</div>
