@extends('layouts.master')


@section('page-title')
Source Of Funds
@endsection

@section('toolbar')
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <!--begin::Card-->
        <div class="card card-custom">
            <div class="card-header">
                <h3 class="card-title">Source of Fund Lists</h3>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Alias</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sofs as $sof)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $sof->name }}</td>
                                <td>{{ $sof->alias }}</td>
                                <td>{{ $sof->description }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!--end::Card-->
    </div>
    <div class="col-lg-4">
        @include('budget::source_of_funds.create')
    </div>
</div>
@endsection


@section('css-vendor')
@endsection

@section('css-custom')
@endsection


@section('js-vendor')
@endsection

@section('js-custom')
@endsection


