@extends('filemanagement::layouts.master')



@section('page-title')
Travel Order Update Form
@endsection

@section('content')
    <div class="row row-cards">
        <div class="col-md-8">
            <x-ui.card title="Travel Order Form">
                <form class="form" method="POST" action="{{ route('fms.travel.order.update', $to->id) }}">
                    @csrf
                    @method('PATCH')
                    <x-ui.form.choices label="Employees" name="employees[]" multiple required>
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}">
                                {{ name_helper($employee->name) }}
                                {{ $employee->position->position ?? '' }}
                            </option>
                        @endforeach
                    </x-ui.form.choices>

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
                                @foreach ($divisions as $division)
                                    <option value="{{ $division->id }}">{{ office_helper($division) }}</option>
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
                            <option value="{{ $employee->id }}">{{ name_helper($employee->name) }}</option>
                        @endforeach
                    </x-ui.form.choices>

                    @if (!request()->has('attachment') and request()->get('attachment') !== true)

                        <x-ui.form.choices label="Liaison Officer" name="liaison">
                            @foreach ($employees->where('liaison', true) as $employee)
                                <option value="{{ $employee->id }}">{{ name_helper($employee->name) }}</option>
                            @endforeach
                        </x-ui.form.choices>

                    @endif

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </x-ui.card>
        </div>
        <div class="col-md-4">
            <x-ui.card title="Instructions" />
        </div>
    </div>
@endsection


