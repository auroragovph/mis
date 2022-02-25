@extends('hrm::layouts.master')

@section('page-title', 'Employees')

@section('page-actions')
<a href="{{ route('hrm.employee.create') }}" class="btn btn-primary">
    <x-ui.icon icon="plus" /> New Employee
</a>
@endsection

@section('content')
@endsection
