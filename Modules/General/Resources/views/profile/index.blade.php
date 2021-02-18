@extends('layouts.master')


@section('page-title')
Profile
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
               
                <div class="text-center mb-10">

                    <div class="symbol symbol-60 symbol-success symbol-xl-90 mt-10">
                        @if(authenticated()->employee->info['image'] == null)
                            <span class="symbol-label font-size-h1">{{ name_helper(authenticated()->employee->name, 'SYM-FL') }}</span>
                        @else 
                            <div class="symbol-label" style="background-image:url('{{ asset('storage/employees/profile/'.authenticated()->employee->info['image']) }}')"></div>
                        @endif
                    </div>

                    <h4 class="font-weight-bold my-2">{{ name_helper(authenticated()->employee->name, 'FL') }}</h4>
                    <div class="text-muted mb-2">{{ authenticated()->employee->position->position ?? 'N/A' }}</div>
                </div>

                <!--begin::Contact-->
                <div class="py-9">

                    <p class="font-weight-bold mr-2">
                        Office: <br>
                        <span class="text-muted font-weight-normal">{{ office_helper(authenticated()->employee->division) }}</span>
                    </p>

                    <p class="font-weight-bold mr-2">
                        Status of Appointment: <br>
                        <span class="text-muted font-weight-normal">{{ authenticated()->employee->employment['type'] }}</span>
                    </p>

                   
                </div>
                <!--end::Contact-->

                

                @include('general::profile.toolbar')

                

            </div>
            <!--end::Body-->
        </div>
        <!--end::Profile Card-->
    </div>
    <!--end::Aside-->
    <!--begin::Content-->
    <div class="flex-row-fluid ml-lg-8">
      
        <div class="tab-content" id="myTabContent5">
            @include('general::profile.information')
            @include('general::profile.employment')
            @include('general::profile.credentials')
            @include('general::profile.logs', ['logs' => $logs])
            


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


