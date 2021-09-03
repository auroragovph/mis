@extends('system::layouts.master')


@section('page-title', 'Employees')

@section('page-action')
<a href="{{ route('sys.admin.employee.create') }}" class="btn btn-primary btn-sm"> <i class="fas fa-plus"></i> New Employee</a>
@endsection

@section('content')
<x-ui.table.data-table-api title="Employee List" />

@endsection

