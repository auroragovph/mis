@extends('layouts.master')


@section('page-title')
Itinerary of Travel
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
            <h3 class="card-label font-weight-bolder text-dark">Itinerary of Travel Form</h3>
            <span class="text-muted font-weight-bold font-size-sm mt-1">Please fill up the form</span>
        </div>
    </div>
    <!--end::Header-->

    <!--begin::Body-->
    <div class="card-body">
        <form class="form" id="kt_form" method="POST" action="{{ route('fms.travel.itinerary.store') }}">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <!--begin::Group-->
                    <div class="form-group">
                        <label>Employee</label>
                        <select name="employee" class="form-control select2" required>
                            @foreach($employees->where('division_id', auth_division()) as $employee)
                                <option value=""></option>
                                <option value="{{ $employee->id }}">{{ name_helper($employee->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!--end::Group-->
                <!--begin::Group-->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Fund</label>
                        <input type="text" class="form-control" name="fund" />
                    </div>
                </div>
                <!--end::Group-->
                <!--begin::Group-->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Date of Travel</label>
                        <input type="date" class="form-control" name="travel-date" required/>
                    </div>
                </div>
                <!--end::Group-->
                <!--begin::Group-->
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Purpose</label>
                        <textarea name="purpose" cols="30" rows="3" class="form-control"></textarea>
                    </div>
                </div>
                <!--end::Group-->
            </div>
           
            <div class="separator separator-dashed mb-3"></div>
            

            <h3 class="font-weight-bold">Lists</h3>


            <div id="kt_repeater">
                <div class="form-group row">
                    <div data-repeater-list="lists" class="col-lg-12">
                        <div data-repeater-item="" class="form-group row align-items-center">

                            <div class="col-12">
                                <div class="row">
        
                                    <div class="col-md-6">
                                    <div class="form-group">
                                            <label for="">Date</label>
                                            <input type="date" name="date" class="form-control">
                                    </div>
                                    </div>
            
                                    <div class="col-md-6">
                                    <div class="form-group">
                                            <label for="">Destination</label>
                                            <input type="text" name="destination" class="form-control">
                                    </div>
                                    </div>
            
                                </div>
            
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Departure</label>
                                            <input type="date" name="departure" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Arrival</label>
                                            <input type="date" name="arrival" class="form-control">
                                        </div>
                                    </div>
                                </div>
            
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Means of Transportation</label>
                                            <input type="text" name="means" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Transportation</label>
                                            <input type="number" step="0.01" name="trans" class="form-control">
                                        </div>
                                    </div>
                                </div>
            
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Per diem</label>
                                            <input type="number" step="0.01" name="diem" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Others</label>
                                            <input type="number" step="0.01" name="other" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <a href="javascript:;" data-repeater-delete="" class="btn btn-sm font-weight-bolder btn-light-danger mt-5">
                                    <i class="fal fa-times"></i>
                                </a>

                                
                            </div>
                        </div>
                    </div>
                </div>
                <a href="javascript:;" data-repeater-create="" class="btn btn-sm font-weight-bolder btn-light-primary">
                    <i class="fal fa-plus"></i>Add New Row</a>
                
            </div>

            <div class="separator separator-dashed mb-5"></div>


            <h4>Signatories</h4>


            <div class="row">
               
                <!--begin::Group-->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Supervisor Officer</label>
                        <select name="supervisor" class="form-control select2" required>
                            @foreach($employees->where('division_id', auth_division()) as $employee)
                                <option value=""></option>
                                <option value="{{ $employee->id }}">{{ name_helper($employee->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!--end::Group-->
                <!--begin::Group-->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Approving Officer</label>
                        <select name="approving" class="form-control select2" required>
                            @foreach($employees->where('division_id', auth_division()) as $employee)
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
                    @foreach($employees->where('division_id', auth_division())->where('liaison', true) as $employee)
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
<script src="{{ asset('js/Modules/FileManagement/pages/forms/travel-itinerary/create.js') }}"></script>

@endsection


