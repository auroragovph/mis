@extends('layouts.system')


@section('page-title', 'Office')

@section('toolbar')

@endsection

@section('content')
<div class="row">
    <div class="col-md-6 offset-md-3">
        <x-ui.card title="Update office">
            <form action="{{ route('sys.admin.division.update', $division->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-md-6">
                        <x-ui.form.input label="Name" name="name" required value="{{ $division->name }}" />
                    </div>
                    <div class="col-md-6">
                        <x-ui.form.input label="Alias" name="alias" value="{{ $division->alias }}" />
                    </div>
                </div>

                <x-ui.form.select2 label="Office" name="office" required>
                    @foreach($offices as $office)
                        <option {{ sh($office->id, $division->office_id) }} value="{{ $office->id }}">{{ office_name($office) }}</option>
                    @endforeach
                </x-ui.form.select2>
        
                <x-ui.form.select2 label="Division Head" name="division_head" required>
                    @foreach($employees as $employee)
                        <option {{ sh($employee->id, $division->head_id) }} value="{{ $employee->id }}">{{ name_helper($employee->name) }}</option>
                    @endforeach
                </x-ui.form.select2>
        
                <hr>
        
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
        </x-ui.card>
    </div>
</div>
@endsection


@section('css-vendor')

<link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
@endsection

@section('css-custom')
@endsection


@section('js-vendor')

<script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>


@endsection

@section('js-custom')
<script src="{{ asset('/js/Modules/System/select2-init.js') }}"></script>
@endsection


