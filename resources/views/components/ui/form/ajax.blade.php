@props([
    'action' => '#',
    'method' => 'GET',
    'id'    => Str::random(),
])

@php($form_method = ($method == strtoupper('GET')) ? 'GET' : 'POST')

<form class="ajax_form" action="{{ $action }}" method="{{ $form_method }}" id="{{ $id }}">
    @csrf
    @method($method)
    {{ $slot }}
</form>


@once
    @push('styles')
        <link rel="stylesheet" href="{{ mix('css/whirl.css') }}">
    @endpush
    @push('js-lib')
        {{-- <script src="{{ mix('libraries/jquery/jquery.slim.min.js') }}"></script> --}}
        <script src="{{ mix('libraries/axios/axios.min.js') }}"></script>
        <script src="{{ mix('libraries/sweetalert2/sweetalert2.all.min.js') }}"></script>
    @endpush
    @push('js-custom')
        <script src="{{ mix('js/helpers/form.js') }}"></script>
    @endpush
@endonce
