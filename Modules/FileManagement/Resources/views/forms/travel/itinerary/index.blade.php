@extends('layouts.master')


@section('page-title')
Itinerary Of Travel
@endsection

@section('toolbar')
<!--begin::Toolbar-->
<div class="d-flex align-items-center">
    <!--begin::Button-->
    <a href="{{ route('fms.travel.itinerary.create') }}" class="btn btn-primary font-weight-bold btn-sm px-3 font-size-base">
        <i class="fal fa-plus"></i> New Itinerary
    </a>
    <!--end::Button-->
   
</div>
<!--end::Toolbar-->
@endsection

@section('content')
<x-ui.card>
    <table id="fms_afl_dt" class="table table-bordered table-striped table-sm">
        <thead>
              <tr>
                <th>QR</th>
                <th>Number</th>
                <th>Employees</th>
                <th>Destination</th>
                <th>Purpose</th>
                <th>Action</th>
              </tr>
        </thead>
    </table>
</x-ui.card>
@endsection


@section('css-vendor')
@endsection

@section('css-custom')
@endsection


@section('js-vendor')
@endsection

@section('js-custom')
<script src="{{ asset('js/Modules/FileManagement/pages/forms/travel-itinerary/index.js') }}"></script>
@endsection


