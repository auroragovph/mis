<div class="form-group">
    <label style="font-weight: 400">{{ $label }}:</label>
    <select {{ $attributes }} class="form-control select2 {{ $class }}" style="width: 100%">
        <option value=""></option>
        {{ $slot }}
    </select>
</div>