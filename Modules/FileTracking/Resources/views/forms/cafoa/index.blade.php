@extends('layouts.master')


@section('page-title')
CAFOA
@endsection

@section('toolbar')
<!--begin::Toolbar-->
<div class="d-flex align-items-center">
    <!--begin::Button-->
    <a href="{{ route('fts.cafoa.create') }}" class="btn btn-primary font-weight-bold btn-sm px-3 font-size-base">
        <i class="fal fa-plus"></i> New CAFOA
    </a>
    <!--end::Button-->
   
</div>
<!--end::Toolbar-->
@endsection

@section('content')
@endsection


@section('css-vendor')
@endsection

@section('css-custom')
@endsection


@section('js-vendor')
@endsection

@section('js-custom')
@endsection