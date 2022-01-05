@extends('fms::layouts.master')


@section('page-pretitle', 'Travel')
@section('page-title', 'Orders')

@section('page-actions')
@endsection

@section('content')
<div class="row row-cards">
    <div class="col-8">
        <x-ui.card title="Travel Order Form">
            <form id="ajax_form" action="{{ route('fms.travel.order.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <x-ui.form.choices label="Employees" name="employees[]" multiple required>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">{{ name($employee->name) }}</option>
                            @endforeach
                        </x-ui.form.choices>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <x-ui.form.input label="Departure" name="departure" type="date" required />
                    </div>
                    <!--end::Group-->
                    <!--begin::Group-->
                    <div class="col-md-6">
                        <x-ui.form.input label="Arrival" name="arrival" type="date" required />
                    </div>
                    <!--end::Group-->
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <x-ui.form.input label="Destination" name="destination" required />
                    </div>
                    <!--end::Group-->

                    <!--begin::Group-->
                    <div class="col-md-6">
                        <x-ui.form.choices label="Charging Office" name="charging">
                            @foreach ($offices as $office)
                                <option value="{{ $office->id }}">{{ office($office) }}</option>
                            @endforeach
                        </x-ui.form.choices>
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

                <x-ui.form.choices label="Requesting Officer" name="requester">
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->id }}">{{ name($employee->name) }}</option>
                    @endforeach
                </x-ui.form.choices>

                @if (!request()->has('attachment') and request()->get('attachment') !== true)

                    <x-ui.form.choices label="Liaison Officer" name="liaison">
                        @foreach ($employees->where('liaison', true) as $employee)
                            <option value="{{ $employee->id }}">{{ name($employee->name) }}</option>
                        @endforeach
                    </x-ui.form.choices>

                @endif

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </x-ui.card>
    </div>
</div>

<x-include.form.ajax />
@endsection

