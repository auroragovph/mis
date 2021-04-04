<div class="form-group">
    <label>{{ $label }}</label>
    <select {{ $attributes }} name="{{ $name }}" class="form-control select2 {{ $class }}" @if($required) required @endif>
        <option value=""></option>
        {{ $slot }}
    </select>
</div>