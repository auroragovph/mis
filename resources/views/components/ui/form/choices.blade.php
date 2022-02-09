<div class="mb-3">
    <label class="form-label">{{ $label }}</label>
    <select id="choices_{{ $rand }}" type="text" class="form-select {{ $class }}" {{ $attributes }}>
        <option value="">{{ $placeholder ?? 'Select from the list' }}</option>
        {{ $slot }}
    </select>
</div>
{{--
@once
    @push('styles')
        <link href="{{ mix('libraries/tom-select/tom-select.bootstrap5.min.css') }}" rel="stylesheet" />
    @endpush
    @push('js-lib')
        <script src="{{ mix('libraries/tom-select/tom-select.complete.min.js') }}"></script>
    @endpush
@endonce


@push('js-custom')
    <script>
        let el{{ $rand }} = document.querySelector('#choices_{{ $rand }}')
        new TomSelect(el{{ $rand }}, {
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            }
        });
    </script>
@endpush --}}
