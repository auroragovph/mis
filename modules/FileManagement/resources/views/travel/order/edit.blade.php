@extends('fms::layouts.master')


@section('page-pretitle', 'Travel')
@section('page-title', 'Orders')

@section('page-actions')
@endsection

@section('content')
<div class="row row-cards">
    <div class="col-8">
        <x-ui.card title="Travel Order Form">
            <form id="ajax_form" action="{{ route('fms.travel.order.update', $to->id) }}" method="POST">

                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-12">
                        <x-ui.form.choices label="Employees" name="employees[]" multiple required>

                            @php($emp_ids = collect($to->employees)->pluck('id')->toArray())


                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}"
                                    @if(in_array($employee->id, $emp_ids))
                                        selected
                                    @endif>{{ name($employee->name) }}</option>
                            @endforeach
                        </x-ui.form.choices>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <x-ui.form.input label="Departure" name="departure" type="date" :value="$to->departure->format('Y-m-d')" required />
                    </div>
                    <!--end::Group-->
                    <!--begin::Group-->
                    <div class="col-md-6">
                        <x-ui.form.input label="Arrival" name="arrival" type="date" :value="$to->departure->format('Y-m-d')" required />
                    </div>
                    <!--end::Group-->
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <x-ui.form.input label="Destination" name="destination" :value="$to->destination" required />
                    </div>
                    <!--end::Group-->

                    <!--begin::Group-->
                    <div class="col-md-6">
                        <x-ui.form.choices label="Charging Office" name="charging">
                            @foreach ($offices as $office)
                                <option {{ sh($office->id, $to->charging_id) }} value="{{ $office->id }}">{{ office($office) }}</option>
                            @endforeach
                        </x-ui.form.choices>
                    </div>
                    <!--end::Group-->
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-ui.form.text-area label="Purpose" name="purpose">{{ $to->purpose }}</x-ui.form.text-area>
                    </div>
                    <!--end::Group-->
                    <!--begin::Group-->
                    <div class="col-md-6">
                        <x-ui.form.text-area label="Special Instruction" name="instruction">{{ $to->instruction }}</x-ui.form.text-area>
                    </div>
                    <!--end::Group-->
                </div>

                <x-ui.form.choices label="Requesting Officer" name="requester">
                    @foreach ($employees as $employee)
                        <option {{ sh($employee->id, $to->signatories['requester']['id']) }} value="{{ $employee->id }}">{{ name($employee->name) }}</option>
                    @endforeach
                </x-ui.form.choices>


                    <x-ui.form.choices label="Liaison Officer" name="liaison">
                        @foreach ($employees->where('liaison', true) as $employee)
                            <option {{ sh($employee->id, $to->series->liaison_id) }} value="{{ $employee->id }}">{{ name($employee->name) }}</option>
                        @endforeach
                    </x-ui.form.choices>


                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </x-ui.card>
    </div>
</div>

<x-include.form.ajax />
@endsection

