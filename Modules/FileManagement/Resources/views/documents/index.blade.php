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
    @include('filemanagement::documents.callout')
</div>
@endsection


@section('css-vendor')
@endsection

@section('css-custom')
@endsection


@section('js-vendor')
@endsection

@section('js-custom')
<script>
$(document).ready(function () {
    $('.select2').select2({
        placeholder: "Select document type"
	});
});
</script>
@endsection


