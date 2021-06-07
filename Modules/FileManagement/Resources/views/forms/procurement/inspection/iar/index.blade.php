@extends('layouts.master')


@section('page-title')
Inspection and Acceptance Report
@endsection

@section('toolbar')
@endsection

@section('content')
<x-ui.card>
    <form action="{{ route('fms.procurement.iar.create') }}">
        @csrf
        <x-ui.form.input label="QR Number / PO Number" name="number" autofocus required/>
        <hr>
        <button type="submit" class="btn bg-gradient-primary"><i class="fas fa-search"></i> Search</button>
    </form>
</x-ui.card>
@endsection


@section('css-vendor')
@endsection

@section('css-custom')
@endsection


@section('js-vendor')
@endsection

@section('js-custom')
@endsection


