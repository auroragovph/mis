@extends('layouts.master')


@section('page-title')
Office Modules
@endsection

@section('toolbar')
@endsection

@section('content')
<!--begin::Profile Overview-->
<div class="d-flex flex-row">
    <!--begin::Aside-->
    <div class="flex-row-auto offcanvas-mobile w-300px w-xl-350px" id="kt_profile_aside">
        <!--begin::Profile Card-->
        <div class="card card-custom ">
            <!--begin::Body-->
            <div class="card-body pt-4">
               
                <h2 class="font-size-lg mt-5">Office Modules</h2>
                <div class="separator separator-dashed mb-5"></div>

                @include('system::modules._toolbar')

            </div>
            <!--end::Body-->
        </div>
        <!--end::Profile Card-->
    </div>
    <!--end::Aside-->
    <!--begin::Content-->
    <div class="flex-row-fluid ml-lg-8">
      
        <div class="tab-content" id="myTabContent5">
            @include('system::modules.hrmo')
            @include('system::modules.gso')
        </div>
    </div>
    <!--end::Content-->
</div>
<!--end::Profile Overview-->
@endsection


@section('css-vendor')
@endsection

@section('css-custom')
@endsection


@section('js-vendor')
@endsection

@section('js-custom')
@endsection


