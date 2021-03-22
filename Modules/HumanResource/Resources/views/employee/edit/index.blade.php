@extends('layouts.master')

@php 
    $refferer = app('router')->getRoutes()->match(app('request')->create(url()->previous()))->getName();
@endphp

@section('page-title')
Edit Employee 
@endsection

@section('toolbar')
<!--begin::Toolbar-->
<div class="d-flex align-items-center">
    <!--begin::Button-->

    
    <a href="@if($refferer == 'sys.account.index') {{ route('sys.account.index') }} @else {{ route('hrm.employee.index') }} @endif" class="btn btn-primary font-weight-bold btn-sm px-3 font-size-base"><i class="fal fa-arrow-left"></i> Return back</a>
    
    <!--end::Button-->
</div>
<!--end::Toolbar-->
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
               
                <!--begin::User-->
                <div class="d-flex align-items-center mt-5">

                    <div class="symbol symbol-60 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center">

                        @if($employee->info['image'] == null)
                            <div class="symbol symbol-success mr-3">
                                <span class="symbol-label font-size-h1">{{ name_helper($employee->name, 'SYM-FL') }}</span>
                            </div>
                        @else 
                            <div class="symbol-label" style="background-image:url('{{ asset('storage/employees/profile/'.$employee->info['image']) }}')"></div>
                        @endif
                        
                    </div>

                    <div>
                        <a href="#" class="font-weight-bolder font-size-h5 text-dark-75 text-hover-primary">{{ name_helper($employee->name, 'FL') }}</a>
                        <div class="text-muted">{{ $employee->position->position ?? 'N/A' }}</div>
                        <div class="mt-2">
                            <a href="#" class="btn btn-sm btn-primary font-weight-bold mr-2 py-2 px-3 px-xxl-5 my-1">Chat</a>
                            <a href="#" class="btn btn-sm btn-success font-weight-bold py-2 px-3 px-xxl-5 my-1">Follow</a>
                        </div>
                    </div>
                </div>
                <!--end::User-->

                <!--begin::Contact-->
                <div class="py-9">

                    <p class="font-weight-bold mr-2">
                        Office: <br>
                        <span class="text-muted font-weight-normal">{{ office_helper($employee->division) }}</span>
                    </p>

                    <p class="font-weight-bold mr-2">
                        Status of Appointment: <br>
                        <span class="text-muted font-weight-normal">{{ $employee->employment['type'] }}</span>
                    </p>

                   
                </div>
                <!--end::Contact-->

                

                @include('humanresource::employee.edit.toolbar', ['refferer' => $refferer])

                

            </div>
            <!--end::Body-->
        </div>
        <!--end::Profile Card-->
    </div>
    <!--end::Aside-->
    <!--begin::Content-->
    <div class="flex-row-fluid ml-lg-8">
      
        <div class="tab-content" id="myTabContent5">

            @include('humanresource::employee.edit.information', ['refferer' => $refferer])
            @include('humanresource::employee.edit.employment')
            @include('humanresource::employee.edit.credentials')
            @include('humanresource::employee.edit.settings')
            @include('humanresource::employee.edit.acl', ['refferer' => $refferer])

            

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
<script src="{{ asset('js/Modules/HumanResource/employee/edit.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
@endsection


