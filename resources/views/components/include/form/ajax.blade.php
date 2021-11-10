@once

    @push('styles')
    <link href="{{ asset('tabler/libs/whirl/whirl.min.css') }}" rel="stylesheet">

    @endpush

    @push('js-lib')
        <script src="{{ asset('tabler/libs/form/serialize.js') }}"></script>
        <script src="{{ asset('tabler/libs/axios/axios.min.js') }}"></script>
        <script src="{{ asset('tabler/libs/sweetalert2/sweetalert2.all.min.js') }}"></script>
        <script src="{{ asset('tabler/libs/form/form.js') }}"></script>
    @endpush

@endonce
