<!--begin::Group-->
<div class="form-group">
    <label>{{ $label }}</label>
    <input {{ $attributes }} type="{{ $type }}" class="form-control {{ $class }}" name="{{ $name }}" value="{{ $value }}" @if($required) required @endif/>
</div>