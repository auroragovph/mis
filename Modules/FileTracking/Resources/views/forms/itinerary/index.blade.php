@extends('layouts.master')


@section('page-title')
Payroll
@endsection

@section('toolbar')
<!--begin::Toolbar-->
<div class="d-flex align-items-center">
    <!--begin::Button-->
    <a href="{{ route('fts.payroll.create') }}" class="btn btn-primary font-weight-bold btn-sm px-3 font-size-base">
        <i class="fal fa-plus"></i> New Payroll
    </a>
    <!--end::Button-->
   
</div>
<!--end::Toolbar-->
@endsection

@section('content')
<!--begin::Card-->
<div class="card card-custom">
    <div class="card-body">
        <!--begin: Search Form-->
        <!--begin::Search Form-->
        <div class="mb-7">
            <div class="row align-items-center">
                <div class="col-lg-9 col-xl-8">
                    <div class="row align-items-center">
                        <div class="col-md-4 my-2 my-md-0">
                            <div class="input-icon">
                                <input type="text" class="form-control" placeholder="Search..." id="kt_datatable_search_query" />
                                <span>
                                    <i class="flaticon2-search-1 text-muted"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        <!--end::Search Form-->
        <!--end: Search Form-->
        <!--begin: Datatable-->
        <div class="datatable datatable-bordered datatable-head-custom" id="ktdt_fts_itinerary"></div>
        <!--end: Datatable-->
    </div>
</div>
<!--end::Card-->
@endsection


@section('css-vendor')
@endsection

@section('css-custom')
@endsection


@section('js-vendor')
@endsection

@section('js-custom')
<script src="{{ asset('js/Modules/FileTracking/pages/forms/iot/index.js') }}"></script>
@endsection