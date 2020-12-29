@extends('layouts.clean')


@section('page-title')
Welcome
@endsection

@section('toolbar')

@endsection

@section('content')
<!--begin::Row-->
<div class="row">
    <div class="col-xl-12">
        <!--begin::Engage Widget 7-->
        <div class="card card-custom card-stretch gutter-b">
            <div class="card-body d-flex p-0">
                <div class="flex-grow-1 p-12 card-rounded bgi-no-repeat d-flex flex-column justify-content-center align-items-start" style="background-color: #FFF4DE; background-position: right bottom; background-size: auto 100%; background-image: url({{ asset('media/svg/humans/custom-8.svg') }})">
                    <h4 class="text-danger font-weight-bolder m-0">Welcome to new Management Information System</h4>
                    <p class="text-dark-50 my-5 font-size-xl font-weight-bold">Please update your profile and account credentials for the first time.</p>
                </div>
            </div>
        </div>
        <!--end::Engage Widget 7-->
    </div>
  
</div>
<!--end::Row-->

<!--begin::Card-->
<div id="employee_card_wizard" class="card card-custom card-transparent" data-card="true">
    <div class="card-body p-0">
        <!--begin::Wizard-->
        <div class="wizard wizard-4" id="kt_wizard" data-wizard-state="step-first" data-wizard-clickable="true">

            @include('system::special-pages.login.first.navigation')
            
            <!--begin::Card-->
            <div class="card card-custom card-shadowless rounded-top-0">
                <!--begin::Body-->
                <div class="card-body p-0">
                    <div class="row justify-content-center py-8 px-8 py-lg-15 px-lg-10">
                        <div class="col-xl-12 col-xxl-10">
                            <!--begin::Wizard Form-->
                            <form method="POST" class="form" id="kt_form" action="{{ route('sp.login.first.post', auth()->user()->employee->id) }}" 
                            x-data="{ formData: {
                                firstName: '{{ auth()->user()->employee->name['fname'] }}',
                                lastName: '{{ auth()->user()->employee->name['lname'] }}',
                                address: '{{ auth()->user()->employee->info['address'] }}',
                                sex: '{{ auth()->user()->employee->info['gender'] }}',
                                civil: '{{ auth()->user()->employee->info['civilStatus'] }}',
                                phone: '{{ auth()->user()->employee->info['phoneNumber'] }}',
                                username: '{{ auth()->user()->username }}'
                            }}" enctype="multipart/form-data"
                            >
                                @csrf
                                <div class="row justify-content-center">
                                    <div class="col-xl-9">

                                        @include('system::special-pages.login.first.information')
                                        @include('system::special-pages.login.first.employment')
                                        @include('system::special-pages.login.first.account')
                                        @include('system::special-pages.login.first.review')

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
<script src="{{ asset('js/Modules/System/pages/account/first-login.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
@endsection


