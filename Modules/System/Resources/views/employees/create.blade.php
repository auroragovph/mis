@extends('layouts.system')


@section('page-title', 'New Employee')

@section('action')
@endsection

@section('content')
<x-ui.card>
    <form id="ajax_form" action="">

        <h5>Personal Information</h5>
        <hr>
        <div class="row">
            <div class="col-md-4">
                <x-ui.form.input label="First Name" name="fname" required />
            </div>
            <div class="col-md-4">
                <x-ui.form.input label="Last Name" name="lname" required />
            </div>
            <div class="col-md-4">
                <x-ui.form.input label="Middle Name" name="mname" required />
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <x-ui.form.input label="Address" name="address" required />
            </div>
            <div class="col-md-6">
                <x-ui.form.input label="Contact Number" name="contact" />
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <x-ui.form.input type="date" label="Birthdate" name="bday" required />
            </div>
            <div class="col-md-4">
                <x-ui.form.select2 label="Civil Status" name="civil" required>
                    @foreach(config('static-lists.civilStatus') as $cs)
                        <option>{{ $cs }}</option>
                    @endforeach
                </x-ui.form.select2>
            </div>
            <div class="col-md-4">
                <x-ui.form.select2 label="Sex" name="civil" required>
                    <option>Male</option>
                    <option>Female</option>
                </x-ui.form.select2>
            </div>
        </div>

        <h5 class="mt-3">Employment Information</h5>
        <hr>

        <div class="row">
            <div class="col-md-6">
                <x-ui.form.input  label="Office" name="bday" required />
            </div>
            <div class="col-md-6">
                <x-ui.form.input label="ID Card" name="bday" required />

            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <x-ui.form.input  label="Position" name="bday" required />
            </div>
            <div class="col-md-6">
                <x-ui.form.input label="Status of Appointment" name="bday" required />

            </div>
        </div>

        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="liaisonCheckbox">
            <label class="form-check-label" for="liaisonCheckbox">Liaison Officer</label>
        </div>

        <hr>

        <button type="submit" class="btn btn-primary">Submit</button>

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
<script src="{{ asset('js/Modules/System/pages/ajax_form.js') }}"></script>
@endsection