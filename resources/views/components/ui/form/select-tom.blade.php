<div class="mb-3">
    <label class="form-label">{{ $label ?? '' }}</label>
    <select type="text" class="form-select tom-select {{ $class ?? '' }}" {{ $attributes }}>
        <option value="">{{ $placeholder ?? 'Select from the list' }}</option>
        {{ $slot }}
    </select>
</div>

@once
    @push('styles')
        <link href="{{ mix('libraries/tom-select/tom-select.bootstrap5.min.css') }}" rel="stylesheet" />
    @endpush
    @push('js-lib')
        <script src="{{ mix('libraries/tom-select/tom-select.complete.min.js') }}"></script>
        <script src="{{ mix('js/helpers/tom-select.init.js') }}"></script>
    @endpush
@endonce
