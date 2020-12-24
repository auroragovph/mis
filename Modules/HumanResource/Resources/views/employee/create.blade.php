@extends('layouts.master')


@section('page-title')
Register New Employee
@endsection

@section('toolbar')
<!--begin::Toolbar-->
<div class="d-flex align-items-center">
    <!--begin::Button-->
    <a href="{{ route('hrm.employee.index') }}" class="btn btn-primary font-weight-bold btn-sm px-3 font-size-base"><i class="la la-reply"></i> Return back</a>
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
            <!--begin::Wizard Nav-->
            <div class="wizard-nav">
                <div class="wizard-steps">
                    <div class="wizard-step" data-wizard-type="step" data-wizard-state="current">
                        <div class="wizard-wrapper">
                            <div class="wizard-number">1</div>
                            <div class="wizard-label">
                                <div class="wizard-title">Profile</div>
                                <div class="wizard-desc">Personal Information</div>
                            </div>
                        </div>
                    </div>
                    <div class="wizard-step" data-wizard-type="step">
                        <div class="wizard-wrapper">
                            <div class="wizard-number">2</div>
                            <div class="wizard-label">
                                <div class="wizard-title">Employment</div>
                                <div class="wizard-desc">Employment Details</div>
                            </div>
                        </div>
                    </div>
                    <div class="wizard-step" data-wizard-type="step">
                        <div class="wizard-wrapper">
                            <div class="wizard-number">3</div>
                            <div class="wizard-label">
                                <div class="wizard-title">Account</div>
                                <div class="wizard-desc">Account Credentials</div>
                            </div>
                        </div>
                    </div>
                    <div class="wizard-step" data-wizard-type="step">
                        <div class="wizard-wrapper">
                            <div class="wizard-number">4</div>
                            <div class="wizard-label">
                                <div class="wizard-title">Submission</div>
                                <div class="wizard-desc">Review and Submit</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Wizard Nav-->
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
                                        <!--begin::Wizard Step 1-->
                                        <div class="my-5 step" data-wizard-type="step-content" data-wizard-state="current">
                                            <h5 class="text-dark font-weight-bold mb-10">Employee Details:</h5>
                                            <!--begin::Group-->
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label text-left">Avatar</label>
                                                <div class="col-lg-9 col-xl-9">
                                                    <div class="image-input image-input-outline" id="kt_user_add_avatar">
                                                        <div class="image-input-wrapper" style="background-image: url({{ asset('media/users/blank.png') }})"></div>
                                                        <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
                                                            <i class="fa fa-pen icon-sm text-muted"></i>
                                                            <input type="file" name="profile_avatar" accept=".png, .jpg, .jpeg" />
                                                            <input type="hidden" name="profile_avatar_remove" />
                                                        </label>
                                                        <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
                                                            <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Group-->
                                            <!--begin::Group-->
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">First Name</label>
                                                <div class="col-lg-9 col-xl-9">
                                                    <input class="form-control form-control-solid form-control-lg" name="firstname" type="text"  x-model="formData.firstName" />
                                                </div>
                                            </div>
                                            <!--end::Group-->
                                            <!--begin::Group-->
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">Middle Name</label>
                                                <div class="col-lg-9 col-xl-9">
                                                    <input class="form-control form-control-solid form-control-lg" name="middlename" type="text" x-model="formData.middleName" />
                                                </div>
                                            </div>
                                            <!--end::Group-->
                                            <!--begin::Group-->
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">Last Name</label>
                                                <div class="col-lg-9 col-xl-9">
                                                    <input class="form-control form-control-solid form-control-lg" name="lastname" type="text" x-model="formData.lastName" />
                                                </div>
                                            </div>
                                            <!--end::Group-->
                                            <!--begin::Group-->
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">Contact Phone</label>
                                                <div class="col-lg-9 col-xl-9">
                                                    <div class="input-group input-group-solid input-group-lg">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">+639</span>
                                                        </div>
                                                        <input type="text" class="form-control form-control-solid form-control-lg" name="phone" placeholder="Phone" x-model="formData.phone"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Group-->
                                            <!--begin::Group-->
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">Address</label>
                                                <div class="col-lg-9 col-xl-9">
                                                    <input class="form-control form-control-solid form-control-lg" name="address" type="text" value="" x-model="formData.address"/>
                                                </div>
                                            </div>
                                            <!--end::Group-->
                                            <!--begin::Group-->
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">Civil Status</label>
                                                <div class="col-lg-9 col-xl-9">
                                                    <div class="input-group input-group-solid input-group-lg">
                                                        <select name="civil" class="form-control form-control-solid form-control-lg" @change="formData.civil = $event.target.value">
                                                            <option value="">---Select---</option>
                                                            <option>Single</option>
                                                            <option>Married</option>
                                                            <option>Widowed</option>
                                                            <option>Anulled</option>
                                                            <option>Separated</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Group-->

                                            <!--begin::Group-->
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">Birth Date</label>
                                                <div class="col-lg-4 col-xl-4">
                                                    <div class="input-group input-group-solid input-group-lg">
                                                        <input class="form-control form-control-solid form-control-lg" name="birthday" type="date" value="" x-model="formData.birthday"/>
                                                    
                                                    </div>
                                                </div>

                                                <label class="col-xl-1 col-lg-1 col-form-label">Sex</label>
                                                <div class="col-lg-4 col-xl-4">
                                                    <div class="input-group input-group-solid input-group-lg">
                                                        <select name="sex" class="form-control form-control-solid form-control-lg" @change="formData.sex = $event.target.value">
                                                            <option value="">---Select---</option>
                                                            <option>Male</option>
                                                            <option>Female</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Group-->

                                        </div>
                                        <!--end::Wizard Step 1-->

                                        <!--begin::Wizard Step 2-->
                                        <div class="my-5 step" data-wizard-type="step-content">
                                            <h5 class="text-dark font-weight-bold mb-10 mt-5">Employment Details</h5>
                                            <!--begin::Group-->
                                            <div class="form-group row">
                                                <label class="col-form-label col-xl-3 col-lg-3">Office / Division</label>
                                                <div class="col-xl-9 col-lg-9">


                                                    <select x-ref="selectDivision" id="kt_select2_1" class="form-control form-control-lg form-control-solid" name="division" style="width:100%;">
                                                        <option value=""></option>
                                                        @foreach($divisions as $division)
                                                            <option value="{{ $division->id }}">{{ office_helper($division) }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <!--end::Group-->
                                            <!--begin::Group-->
                                            <div class="form-group row">
                                                <label class="col-form-label col-xl-3 col-lg-3">Position</label>
                                                <div class="col-xl-9 col-lg-9">
                                                    <select id="kt_select2_2" class="form-control form-control-lg form-control-solid" name="position" data-api="{{ route('hrm.plantilla.position.lists') }}"  style="width:100%;" @change="formData.position = $event.target.innerText"></select>
                                                </div>
                                            </div>
                                            <!--end::Group-->
                                            <!--begin::Group-->
                                            <div class="form-group row">
                                                <label class="col-form-label col-xl-3 col-lg-3">Status of Appointment</label>
                                                <div class="col-xl-9 col-lg-9">
                                                    <select class="form-control form-control-lg form-control-solid" name="appointment" @change="formData.appointment = $event.target.value">
                                                        <option value="">---SELECT---</option>
                                                        <option>Job Order</option>
                                                        <option>Casual</option>
                                                        <option>Permanent</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!--end::Group-->
                                            <!--begin::Group-->
                                            <div class="form-group row">
                                                <label class="col-form-label col-xl-3 col-lg-3">ID Card</label>
                                                <div class="col-xl-9 col-lg-9">
                                                    <input class="form-control form-control-solid form-control-lg" name="card" type="text" value="" x-model="formData.card" />
                                                   
                                                </div>
                                            </div>
                                            <!--end::Group-->
                                            <!--begin::Group-->
                                            <div class="form-group row">
                                                <label class="col-form-label col-xl-3 col-lg-3"></label>
                                                <div class="col-xl-9 col-lg-9">
                                                    <div class="checkbox-inline">
                                                        <label class="checkbox">
                                                        <input name="liaison" type="checkbox" value="true" x-model="formData.liaison" /> Liaison Officer
                                                        <span></span></label>
                                                       
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Group-->
                                            
                                        </div>
                                        <!--end::Wizard Step 2-->

                                        <!--begin::Wizard Step 3-->
                                        <div class="my-5 step" data-wizard-type="step-content">
                                            <h5 class="mb-10 font-weight-bold text-dark">Setup Account</h5>

                                            <!--begin::Group-->
                                            <div class="form-group">
                                                <label>Creation:</label>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <label class="option option-plain">
                                                            <span class="option-control">
                                                                <span class="radio">
                                                                    <input x-model="formData.account" type="radio" name="account" value="default" checked/>
                                                                    <span></span>
                                                                </span>
                                                            </span>
                                                            <span class="option-label">
                                                                <span class="option-head">
                                                                    <span class="option-title">
                                                                        Default
                                                                    </span>
                                                                </span>
                                                                <span class="option-body">
                                                                    Username will based on name and password will be the ID Card. User can change it after they login in the first time
                                                                </span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="option option option-plain">
                                                            <span class="option-control">
                                                                <span class="radio">
                                                                    <input type="radio" name="account" value="manual" x-model="formData.account" />
                                                                    <span></span>
                                                                </span>
                                                            </span>
                                                            <span class="option-label">
                                                                <span class="option-head">
                                                                    <span class="option-title">
                                                                        Manual
                                                                    </span>
                                                                </span>
                                                                <span class="option-body">
                                                                    You can choose username and password for the account.
                                                                </span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Group-->

                                            <template x-if="formData.account == 'manual'">
                                                <div>
                                                    <!--begin::Group-->
                                                    <div class="form-group">
                                                        <label>Username</label>
                                                        <input x-model="formData.username" type="text" class="form-control form-control-solid form-control-lg" name="username" />
                                                    </div>
													<!--end::Group-->
                                                    <!--begin::Row-->
                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <!--begin::Group-->
                                                            <div class="form-group">
                                                                <label>Password</label>
                                                                <input type="password" class="form-control form-control-solid form-control-lg" name="password" />
                                                            </div>
                                                        </div>
                                                        <!--end::Group-->
                                                        <!--begin::Group-->
                                                        <div class="col-xl-6">
                                                            <div class="form-group">
                                                                <label>Confirm Password</label>
                                                                <input type="password" class="form-control form-control-solid form-control-lg" name="password_confirmation" />
                                                            </div>
                                                        </div>
                                                        <!--end::Group-->
                                                    </div>
                                                </div>
                                            </template>


                                            
                                        </div>
                                        <!--end::Wizard Step 3-->
                                        
                                        <!--begin::Wizard Step 4-->
                                        <div class="my-5 step" data-wizard-type="step-content">
                                            <h5 class="mb-10 font-weight-bold text-dark">Review Details and Submit</h5>
                                            <!--begin::Item-->
                                            <div class="border-bottom mb-5 pb-5">
                                                <div class="font-weight-bolder mb-3">Employee's personal details:</div>
                                                <div class="line-height-xl"><span x-text="formData.firstName"></span> <span x-text="formData.lastName"></span>
                                                <br />Phone: <span x-text="formData.phone"></span>
                                                <br />Address: <span x-text="formData.address"></span>
                                                <br />Civil Status: <span x-text="formData.civil"></span>
                                                <br />Birthday: <span x-text="formData.birthday"></span>
                                                <br />Sex: <span x-text="formData.sex"></span>
                                                </div>
                                            </div>
                                            <!--end::Item-->
                                            <!--begin::Item-->
                                            <div class="border-bottom mb-5 pb-5">
                                                <div class="font-weight-bolder mb-3">Employment Details:</div>
                                                <div class="line-height-xl">
                                                    Office: <span id="select2OfficeSpan"></span> <br>
                                                    Position: <span id="select2PositionSpan"></span> <br>
                                                    Status of Appointment: <span x-text="formData.appointment"></span> <br>
                                                    ID Card: <span x-text="formData.card"></span> <br>
                                                    Liaison: <span x-text="formData.liaison"></span>
                                                </div>
                                            </div>
                                            <!--end::Item-->
                                            <!--begin::Item-->
                                            <div>
                                                <div class="font-weight-bolder">Account Details:</div>
                                                <div class="line-height-xl">
                                                    Creation: <span x-text="formData.account"></span> 

                                                    <div x-show="formData.account == 'manual'">
                                                        Username: <span x-text="formData.username"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Item-->
                                        </div>
                                        <!--end::Wizard Step 4-->

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
<script src="{{ asset('js/humanresource/employee/create.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
@endsection


