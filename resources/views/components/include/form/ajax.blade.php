@once

    @push('styles')
    <link href="{{ asset('libs/whirl/whirl.min.css') }}" rel="stylesheet">

    @endpush

    @push('js-lib')
        <script src="{{ asset('libs/form/serialize.js') }}"></script>
        <script src="{{ asset('libs/axios/axios.min.js') }}"></script>
        <script src="{{ asset('libs/sweetalert2/sweetalert2.all.min.js') }}"></script>
        <script src="{{ asset('libs/form/form.js') }}"></script>
    @endpush

@endonce
