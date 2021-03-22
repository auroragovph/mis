@extends('layouts.master')


@section('page-title')
CAFOA
@endsection

@section('toolbar')
 <!--begin::Button-->
 <a href="{{ route('fms.cafoa.index') }}" class="btn btn-primary font-weight-bold btn-sm px-3 font-size-base">
    <i class="fal fa-arrow-left"></i> Return back
</a>
<!--end::Button-->
@endsection

@section('content')

<!--begin::Advance Table: Widget 7-->
<div class="card card-custom gutter-b" id="card-box" data-card="true" >
    <!--begin::Header-->
   <div class="card-header py-3">
        <div class="card-title align-items-start flex-column">
            <h3 class="card-label font-weight-bolder text-dark">CAFOA Form</h3>
            <span class="text-muted font-weight-bold font-size-sm mt-1">Please fill up the form</span>
        </div>
    </div>
    <!--end::Header-->

    <!--begin::Body-->
    <div class="card-body">
        <form class="form" id="kt_form" method="POST" action="{{ route('fms.cafoa.store') }}">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <!--begin::Group-->
                    <div class="form-group">
                        <label>Payee</label>
                        <input type="text" class="form-control" name="payee" required/>
                    </div>
                </div>
                <!--end::Group-->
                <!--begin::Group-->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Requesting Officer</label>
                        <select name="requesting" class="form-control select2" required>
                            @foreach($employees->where('division_id', auth()->user()->employee->division_id) as $employee)
                                <option value=""></option>
                                <option value="{{ $employee->id }}">{{ name_helper($employee->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!--end::Group-->
            </div>
           
            <div class="separator separator-dashed mb-3"></div>

            <div id="kt_repeater_1">
                <div class="form-group row">
                    <div data-repeater-list="lists" class="col-lg-12">
                        <div data-repeater-item="" class="form-group row align-items-center">
                            <div class="col-md-2">
                                <label>Function:</label>
                                <input type="text" name="function" class="form-control" />
                                <div class="d-md-none mb-2"></div>
                            </div>
                            <div class="col-md-3">
                                <label>Allotment Class:</label>
                                <input type="text" name="allotment" class="form-control"/>
                                <div class="d-md-none mb-2"></div>
                            </div>

                            <div class="col-md-3">
                                <label>Expense Code:</label>
                                <input type="text" class="form-control" name="code"/>
                                <div class="d-md-none mb-2"></div>
                            </div>

                            <div class="col-md-3">
                                <label>Amount:</label>
                                <input type="number" step="0.01" name="amount" class="form-control"/>
                                <div class="d-md-none mb-2"></div>
                            </div>
                           
                            <div class="col-md-1">
                                <a href="javascript:;" data-repeater-delete="" class="btn btn-sm font-weight-bolder btn-light-danger mt-5">
                                <i class="fal fa-times"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <a href="javascript:;" data-repeater-create="" class="btn btn-sm font-weight-bolder btn-light-primary">
                        <i class="fal fa-plus"></i>Add</a>
                    </div>
                </div>
            </div>

            <div class="separator separator-dashed mb-5"></div>


            <h4>Signatories</h4>


            <div class="row">
                <div class="col-md-4">
                    <!--begin::Group-->
                    <div class="form-group">
                        <label>Budget</label>
                        <select name="budget" class="form-control select2" required>
                            @foreach($employees->where('division_id', config('constants.office.BUDGET')) as $employee)
                                <option value=""></option>
                                <option value="{{ $employee->id }}">{{ name_helper($employee->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!--end::Group-->
                <!--begin::Group-->
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Treasury</label>
                        <select name="treasury" class="form-control select2" required>
                            @foreach($employees->where('division_id', config('constants.office.PTO')) as $employee)
                                <option value=""></option>
                                <option value="{{ $employee->id }}">{{ name_helper($employee->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!--end::Group-->
                <!--begin::Group-->
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Accountant</label>
                        <select name="accountant" class="form-control select2" required>
                            @foreach($employees->where('division_id', config('constants.office.ACCOUNTING')) as $employee)
                                <option value=""></option>
                                <option value="{{ $employee->id }}">{{ name_helper($employee->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!--end::Group-->
            </div>



            <div class="separator separator-dashed mb-5"></div>

            <div class="form-group">
                <label>Liaison Officer</label>
                <select name="liaison" class="form-control select2" required>
                    @foreach($employees->where('division_id', auth()->user()->employee->division_id)->where('liaison', true) as $employee)
                        <option value=""></option>
                        <option value="{{ $employee->id }}">{{ name_helper($employee->name) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="separator separator-dashed mb-5"></div>


            <button type="submit" class="btn btn-primary mt-5" name="submitButton">Submit</button>

        </form>
    </div>

    <!--end::Body-->
</div>
<!--end::Advance Table Widget 7-->

@endsection


@section('css-vendor')
@endsection

@section('css-custom')
@endsection


@section('js-vendor')
@endsection

@section('js-custom')
<script src="{{ asset('js/Modules/FileManagement/pages/forms/cafoa/create.js') }}"></script>
@endsection


