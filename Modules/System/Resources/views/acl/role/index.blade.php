@extends('layouts.master')


@section('page-title')
Roles
@endsection

@section('toolbar')
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
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
                <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable_role_list" data-api="{{ route('sys.acl.role.lists') }}"></div>
                <!--end: Datatable-->
            </div>
        </div>
        <!--end::Card-->
    </div>
    <div class="col-lg-4">
        
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
<script src="{{ asset('js/Modules/System/pages/acl/role/index.js') }}"></script>
@endsection


