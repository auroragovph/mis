@extends('layouts.master')


@section('page-title')
Travel Order
@endsection

@section('toolbar')
 <!--begin::Button-->
 <a href="{{ route('fms.travel.order.index') }}" class="btn btn-primary font-weight-bold btn-sm px-3 font-size-base">
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
            <h3 class="card-label font-weight-bolder text-dark">Travel Order Form</h3>
            <span class="text-muted font-weight-bold font-size-sm mt-1">Please fill up the form</span>
        </div>
    </div>
    <!--end::Header-->

    <!--begin::Body-->
    <div class="card-body">
        <form class="form" id="kt_form" method="POST" action="{{ route('fms.travel.order.update', $to->id) }}">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <!--begin::Group-->
                    <div class="form-group">
                        <label>Employees</label>
                        <select name="employees[]" multiple class="form-control select2">
                            @php($emp = $to->lists->pluck('employee_id')->toArray())

                            @foreach($employees as $employee)
                                <option @if(in_array($employee->id, $emp)) selected @endif  value="{{ $employee->id }}">{{ name_helper($employee->name) }}</option>
                            @endforeach
                           
                        </select>
                    </div>
                </div>
                <!--end::Group-->
            </div>

            <div class="form-group">
                <label>Number</label>
                <input type="text" class="form-control" name="number" value="{{ $to->number }}" />

            </div>

            <div class="row">
                <div class="col-md-6">
                    <!--begin::Group-->
                    <div class="form-group">
                        <label>Departure</label>
                        <input type="date" class="form-control" name="departure" value="{{ $to->departure }}" required />
                    </div>
                </div>
                <!--end::Group-->
                <!--begin::Group-->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Arrival</label>
                        <input type="date" class="form-control" name="arrival" value="{{ $to->arrival }}" required/>
                    </div>
                </div>
                <!--end::Group-->
            </div>

            <div class="row">
                <div class="col-md-6">
                    <!--begin::Group-->
                    <div class="form-group">
                        <label>Destination</label>
                        <input type="text" class="form-control" name="destination" value="{{ $to->destination }}" required/>
                    </div>
                </div>
                <!--end::Group-->

                <!--begin::Group-->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Charging Office</label>
                        <select name="charging" class="form-control select2">
                            @foreach($divisions as $division)
                                <option {{ sh($division->id, $to->charging_id) }} value="{{ $division->id }}">{{ office_helper($division) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!--end::Group-->
            </div>

            <div class="row">
                <div class="col-md-6">
                    <!--begin::Group-->
                    <div class="form-group">
                        <label>Purpose</label>
                        <textarea name="purpose" cols="10" rows="3" class="form-control">{{ $to->purpose }}</textarea>
                    </div>
                </div>
                <!--end::Group-->
                <!--begin::Group-->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Special Instruction</label>
                        <textarea name="instruction" id="" cols="10" rows="3" class="form-control">{{ $to->instruction }}</textarea>
                    </div>
                </div>
                <!--end::Group-->
            </div>

            <div class="row">
                <div class="col-md-12">
                    <!--begin::Group-->
                    <div class="form-group">
                        <label>Requesting Officer</label>
                        <select name="requesting" class="form-control select2">
                            @foreach($employees as $employee)
                                <option {{ sh($employee->id, $to->requesting_id) }} value="{{ $employee->id }}">{{ name_helper($employee->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!--end::Group-->
            </div>

            <div class="row">
                <div class="col-md-12">
                    <!--begin::Group-->
                    <div class="form-group">
                        <label>Liaison Officer</label>
                        <select name="liaison" class="form-control select2">
                            @foreach($employees->where('liaison', 1) as $liaison)
                                <option {{ sh($liaison->id, $to->document->liaison_id) }} value="{{ $liaison->id }}">{{ name_helper($liaison->name) }}</option>
                            @endforeach
                        </select>

                    </div>
                </div>
                <!--end::Group-->
            </div>

          

           
            <div class="separator separator-dashed"></div>

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
<script src="{{ asset('js/Modules/FileManagement/pages/forms/travel-order/create.js') }}"></script>
@endsection


