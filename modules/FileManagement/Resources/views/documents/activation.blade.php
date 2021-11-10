@extends('layouts.master')


@section('page-title')
Document Activation
@endsection

@section('toolbar')
@endsection

@section('content')
<div class="row">
    <div class="col-xl-12">
        <x-ui.card >
            <form action="{{ route('fms.documents.activation.submit') }}" method="POST">
                @csrf

                <x-ui.form.input label="Document ID" type="text" name="document" value="{{ old('document') }}" required autofocus />
                <x-ui.form.input label="Liaison QR" type="password" name="liaison" required />

                <hr>
                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
            </form>
        </x-ui.card>
    </div>
</div>
@endsection


@section('css-vendor')
@endsection

@section('css-custom')
@endsection


@section('js-vendor')
@endsection

@section('js-custom')
<script src="{{ asset('js/Modules/FileManagement/pages/documents/activation.js') }}"></script>
@endsection


