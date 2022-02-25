@extends('hrm::layouts.master')

@section('page-pretitle', 'Employee')
@section('page-title', 'Create New Employee')

@section('page-actions')
@endsection

@section('content')
<div class="row">
    <div class="col">
        <x-ui.card title="Employee Form">

            <x-ui.form.ajax method="POST" :action="route('hrm.employee.store')">

                <h3>Personal Information</h3>
                <hr class="my-2">

                <div class="row">
                    <div class="col">
                        <x-ui.form.input label="Last Name" name="last_name" required/>
                    </div>
                    <div class="col">
                        <x-ui.form.input label="First Name" name="first_name" required/>
                    </div>
                    <div class="col">
                        <x-ui.form.input label="Middle Name" name="middle_name" />
                    </div>
                    <div class="col">
                        <x-ui.form.input label="Suffix / Title" name="suffix_name" />
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <x-ui.form.input label="Address" name="address" required/>
                    </div>
                    <div class="col">
                        <x-ui.form.select-tom label="Civil Status" name="civil_status" required>
                            <option>Married</option>
                            <option>Widowed</option>
                            <option>Separated</option>
                            <option>Divorced</option>
                            <option>Single</option>
                        </x-ui.form.select-tom>
                    </div>
                    <div class="col">
                        <x-ui.form.input type="date" label="Birthdate" name="birthdate" required/>
                    </div>
                </div>

                <h3 class="mt-3">Employment Information</h3>
                <hr class="my-2">

                <div class="row">
                    <div class="col">
                        <x-ui.form.select-tom label="Office" name="Office" required>
                            @foreach($offices as $office)
                                <option value="{{ $office->id }}">{{ $office->name }}</option>
                            @endforeach
                        </x-ui.form.select-tom>
                    </div>
                    <div class="col">
                        @include('hrm::components.office')
                    </div>
                </div>

            </x-ui.form.ajax>

        </x-ui.card>
    </div>
</div>
@endsection
