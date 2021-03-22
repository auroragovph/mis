@extends('layouts.master')


@section('page-title')
Documents
@endsection

@section('toolbar')
@endsection

@section('content')
<div class="row">

    @include('filemanagement::documents.types')
    @include('filemanagement::documents.widget')
    {{-- @include('filemanagement::documents.callout') --}}
</div>
@endsection


@section('css-vendor')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
@endsection

@section('css-custom')

@endsection


@section('js-vendor')
<!-- Select2 -->
<script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
@endsection

@section('js-custom')
<script>
$(document).ready(function () {
    $('.select2').select2({
        placeholder: "Select from the list"
    });
});
</script>
@endsection


