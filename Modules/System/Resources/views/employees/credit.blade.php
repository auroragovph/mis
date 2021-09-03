@extends('system::layouts.master')


@section('page-title')
    @isset($employee)
        Update Employee
    @else 
        New Employee
    @endisset
@endsection

@section('action')
@endsection

@section('content')
<x-ui.card title="Employee Form">

    @isset($employee)
        <form id="ajax_form" action="{{ route('sys.admin.employee.update', $employee->id) }}" method="POST">
        @method('PATCH')
    @else 
        <form id="ajax_form" action="{{ route('sys.admin.employee.store') }}" method="POST">
    @endisset
        @csrf
        <div class="row">
            <div class="col-md-4">
                <x-ui.form.input label="First Name" name="fname" required :value="$employee->name['first'] ?? ''" />
            </div>
            <div class="col-md-4">
                <x-ui.form.input label="Last Name" name="lname" required :value="$employee->name['last'] ?? ''" />
            </div>
            <div class="col-md-4">
                <x-ui.form.input label="Middle Name" name="mname" :value="$employee->name['middle'] ?? ''" />
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <x-ui.form.input label="Address" name="address" required :value="$employee->info['address'] ?? ''" />
            </div>
            <div class="col-md-6">
                <x-ui.form.input label="Contact Number" name="contact" :value="$employee->info['contact'] ?? ''" />
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <x-ui.form.input type="date" label="Birthdate" name="bday" required :value="$employee->info['birthday'] ?? ''" />
            </div>
            <div class="col-md-4">
                <x-ui.form.choices label="Civil Status" name="civil" required>
                    @foreach(config('static-lists.civilStatus') as $cs)
                        <option {{ sh($cs, $employee->info['civilStatus'] ?? null) }}>{{ $cs }}</option>
                    @endforeach
                </x-ui.form.choices>
            </div>
            <div class="col-md-4">
                <x-ui.form.choices label="Sex" name="sex" required>
                    <option {{ sh($employee->info['sex'] ?? null, 'Male') }}>Male</option>
                    <option {{ sh($employee->info['sex'] ?? null, 'Female') }}>Female</option>
                </x-ui.form.choices>
            </div>
        </div>

        <h5 class="mt-3">Employment Information</h5>
        <hr>

        <div class="row">
            <div class="col-md-6">

                <x-ui.form.select2 label="Office" id="select2-office" name="division" required >
                    @foreach($divisions as $division)
                        <option {{ sh($division->id, $employee->division_id ?? null) }} value="{{ $division->id }}">{{ office_helper($division) }}</option>
                    @endforeach
                </x-ui.form.select2>

            </div>
            <div class="col-md-6">
                <x-ui.form.input label="ID Card" name="card" :value="$employee->card ?? null" />

            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <x-ui.form.select2 label="Position" name="position" required >
                    @foreach($positions as $position)
                        <option {{ sh($position->id, $employee->position_id ?? null) }} value="{{ $position->id }}">{{ $position->name }}</option>
                    @endforeach
                </x-ui.form.select2>
            </div>
            <div class="col-md-6">
                <x-ui.form.select2 label="Status of Appointment" name="appointment" required>
                    @foreach(config('static-lists.statusOfAppointment') as $appointment)
                        <option {{ sh($appointment, $employee->employment['type'] ?? null) }}>{{ $appointment }}</option>
                    @endforeach
                </x-ui.form.select2>

            </div>
        </div>

        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="liaisonCheckbox" name="liaison" {{ sh($employee->liaison ?? null, true, 'checked') }} >
            <label class="form-check-label" for="liaisonCheckbox">Liaison Officer</label>
        </div>

        <hr>

        <button type="submit" class="btn btn-primary">Submit</button>

    </form>
</x-ui.card>
@endsection