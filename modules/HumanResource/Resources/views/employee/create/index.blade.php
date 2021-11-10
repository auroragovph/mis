@extends('layouts.master')


@section('page-title')
Register New Employee
@endsection

@section('toolbar')
<!--begin::Toolbar-->
<div class="d-flex align-items-center">
    <!--begin::Button-->
    <a href="{{ route('hrm.employee.index') }}" class="btn btn-primary font-weight-bold btn-sm px-3 font-size-base">
        <i class="la la-reply"></i> Return back
    </a>
    <!--end::Button-->
   
</div>
<!--end::Toolbar-->
@endsection

@section('content')
<!--begin::Card-->
<div id="employee_card_wizard" class="card card-custom card-transparent" data-card="true">
    <div class="card-body p-0">
        <!--begin::Wizard-->
        <div class="wizard wizard-4" id="kt_wizard" data-wizard-state="step-first" data-wizard-clickable="true">

            @include('humanresource::employee.create.navigation')
            
            <!--begin::Card-->
            <div class="card card-custom card-shadowless rounded-top-0">
                <!--begin::Body-->
                <div class="card-body p-0">
                    <div class="row justify-content-center py-8 px-8 py-lg-15 px-lg-10">
                        <div class="col-xl-12 col-xxl-10">
                            <!--begin::Wizard Form-->
                            <form method="POST" class="form" id="kt_form" x-data="{ formData: {account: 'default'} }" action="{{ route('hrm.employee.store') }}">
                                @csrf
                                <div class="row justify-content-center">
                                    <div class="col-xl-9">

                                        @include('humanresource::employee.create.step1')
                                        @include('humanresource::employee.create.step2')
                                        @include('humanresource::employee.create.step3')
                                        @include('humanresource::employee.create.step4')

                                        <!--begin::Wizard Actions-->
                                        <div class="d-flex justify-content-between border-top pt-10 mt-15">
                                            <div class="mr-2">
                                                <button id="prev-step" class="btn btn-light-primary font-weight-bolder px-9 py-4" data-wizard-type="action-prev">Previous</button>
                                            </div>
                                            <div>
                                                <button class="btn btn-success font-weight-bolder px-9 py-4" data-wizard-type="action-submit">Submit</button>
                                                <button id="next-step" class="btn btn-primary font-weight-bolder px-9 py-4" data-wizard-type="action-next">Next</button>
                                            </div>
                                        </div>
                                        <!--end::Wizard Actions-->

                                    </div>
                                </div>
                            </form>
                            <!--end::Wizard Form-->
                        </div>
                    </div>
                </div>
                <!--end::Body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Wizard-->
    </div>
</div>
<!--end::Card-->
@endsection


@section('css-vendor')
<link rel="stylesheet" href="{{ asset('css/pages/wizard/wizard-4.css') }}">
@endsection

@section('css-custom')
@endsection


@section('js-vendor')
@endsection

@section('js-custom')
<script src="{{ asset('js/Modules/HumanResource/employee/create.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
@endsection


