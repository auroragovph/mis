@extends('layouts.master')


@section('page-title')
Travel Order
@endsection

@section('toolbar')

@endsection

@section('content')
<x-ui.card title="Travel Order Form">
<form method="POST" action="{{ route('fms.travel.order.store') }}">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <x-ui.form.select2 label="Employees" name="employees[]" multiple>
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}">{{ name_helper($employee->name) }} {{ $employee->position->position ?? '' }}</option>
                @endforeach
            </x-ui.form.select2>
        </div>
        <!--end::Group-->
    </div>


    <div class="row">
        <div class="col-md-6">
            <x-ui.form.input label="Departure" name="departure" type="date" required/>
        </div>
        <!--end::Group-->
        <!--begin::Group-->
        <div class="col-md-6">
            <x-ui.form.input label="Arrival" name="arrival" type="date" required/>
        </div>
        <!--end::Group-->
    </div>
    <div class="row">
        <div class="col-md-6">
            <x-ui.form.input label="Destination" name="destination" required/>
        </div>
        <!--end::Group-->

        <!--begin::Group-->
        <div class="col-md-6">
            <x-ui.form.select2 label="Charging Office" name="charging">
                @foreach($divisions as $division)
                    <option value="{{ $division->id }}">{{ office_helper($division) }}</option>
                @endforeach
            </x-ui.form.select2>
        </div>
        <!--end::Group-->
    </div>
    <div class="row">
        <div class="col-md-6">
            <x-ui.form.text-area label="Purpose" name="purpose" />
        </div>
        <!--end::Group-->
        <!--begin::Group-->
        <div class="col-md-6">
            <x-ui.form.text-area label="Special Instruction" name="instruction" />
        </div>
        <!--end::Group-->
    </div>

    <div class="row">
        <div class="col-md-12">
            <x-ui.form.select2 label="Requesting Officer" name="approval">
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}">{{ name_helper($employee->name) }}</option>
                @endforeach
            </x-ui.form.select2>
        </div>
        <!--end::Group-->
    </div>

    <div class="row">
        <div class="col-md-12">
            <x-ui.form.select2 label="Liaison Officer" name="liaison">
                @foreach($employees->where('liaison', true) as $employee)
                    <option value="{{ $employee->id }}">{{ name_helper($employee->name) }}</option>
                @endforeach
            </x-ui.form.select2>
        </div>
        <!--end::Group-->
    </div>

    <hr>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
</x-ui.card>
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
<script src="{{ asset('js/Modules/FileManagement/pages/forms/travel/order/create.js') }}"></script>
@endsection


