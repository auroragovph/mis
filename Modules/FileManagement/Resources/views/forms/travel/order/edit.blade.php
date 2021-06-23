@extends('layouts.master')


@section('page-title')
Travel Order Update Form
@endsection

@section('toolbar')

@endsection

@section('content')
<x-ui.card>
<form class="form" id="kt_form" method="POST" action="{{ route('fms.travel.order.update', $to->id) }}">
    @csrf
    @method('PATCH')
    <div class="row">
        <div class="col-md-12">
            <x-ui.form.select2 label="Employees" name="employees[]" multiple>
                @php($emp = $to->lists->pluck('employee_id')->toArray())
                @foreach($employees as $employee)
                    <option @if(in_array($employee->id, $emp)) selected @endif value="{{ $employee->id }}">{{ name_helper($employee->name) }} {{ $employee->position->position ?? '' }}</option>
                @endforeach
            </x-ui.form.select2>
        </div>
        <!--end::Group-->
    </div>


    <div class="row">
        <div class="col-md-6">
            <x-ui.form.input label="Departure" name="departure" type="date" :value="$to->departure" required/>
        </div>
        <!--end::Group-->
        <!--begin::Group-->
        <div class="col-md-6">
            <x-ui.form.input label="Arrival" name="arrival" type="date" :value="$to->arrival" required/>
        </div>
        <!--end::Group-->
    </div>
    <div class="row">
        <div class="col-md-6">
            <x-ui.form.input label="Destination" name="destination" :value="$to->destination" required/>
        </div>
        <!--end::Group-->

        <!--begin::Group-->
        <div class="col-md-6">
            <x-ui.form.select2 label="Charging Office" name="charging">
                @foreach($divisions as $division)
                    <option {{ sh($division->id, $to->charging_id) }} value="{{ $division->id }}">{{ office_helper($division) }}</option>
                @endforeach
            </x-ui.form.select2>
        </div>
        <!--end::Group-->
    </div>
    <div class="row">
        <div class="col-md-6">
            <x-ui.form.text-area label="Purpose" name="purpose" :value="$to->destination" />
        </div>
        <!--end::Group-->
        <!--begin::Group-->
        <div class="col-md-6">
            <x-ui.form.text-area label="Special Instruction" name="instruction" :value="$to->instruction" />
        </div>
        <!--end::Group-->
    </div>

    <div class="row">
        <div class="col-md-12">
            <x-ui.form.select2 label="Approval Officer" name="approval">
                @foreach($employees as $employee)
                    <option {{ sh($employee->id, $to->approval_id) }} value="{{ $employee->id }}">{{ name_helper($employee->name) }}</option>
                @endforeach
            </x-ui.form.select2>
        </div>
        <!--end::Group-->
    </div>

    <div class="row">
        <div class="col-md-12">
            <x-ui.form.select2 label="Liaison Officer" name="liaison">
                @foreach($employees->where('liaison', true) as $employee)
                    <option {{ sh($employee->id, $to->document->liaison_id) }} value="{{ $employee->id }}">{{ name_helper($employee->name) }}</option>
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


