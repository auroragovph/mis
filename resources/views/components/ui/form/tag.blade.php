@php($rand = Str::random())

<div class="mb-3">
    <label class="form-label">{{ $label }}</label>
    <input id="choices_{{ $rand }}" type="text" class="form-control {{ $class ?? '' }}" {{ $attributes }} />

</div>

@once
    @push('styles')
        <link href="/tabler/libs/tom-select/css/tom-select.bootstrap5.min.css" rel="stylesheet" />
    @endpush
    @push('js-lib')
        <script src="/tabler/libs/tom-select/js/tom-select.complete.min.js"></script>
    @endpush
@endonce


@push('js-custom')
    <script>
        let el{{ $rand }} = document.querySelector('#choices_{{ $rand }}')
        new TomSelect(el{{ $rand }}, {
            persist: false,
            createOnBlur: true,
            create: true
        });
    </script>
@endpush
