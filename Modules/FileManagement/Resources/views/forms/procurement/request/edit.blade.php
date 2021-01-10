@extends('layouts.master')


@section('page-title')
Purchase Request
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
            <h3 class="card-label font-weight-bolder text-dark">Purchase Request Update Form</h3>
            <span class="text-muted font-weight-bold font-size-sm mt-1">Please fill up the form</span>
        </div>
    </div>
    <!--end::Header-->

    <!--begin::Body-->
    <div class="card-body">
        <form class="form" id="kt_form" method="POST" action="{{ route('fms.procurement.request.update', $pr->id) }}">
            @method('PATCH')
            @csrf

            <div class="form-group">
                <label>Number</label>
                <input type="text" class="form-control" name="number" value="{{ $pr->number }}"/>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <!--begin::Group-->
                    <div class="form-group">
                        <label>Fund</label>
                        <input type="text" class="form-control" name="payee" value="{{ $pr->fund }}" required/>
                    </div>
                </div>
                <!--end::Group-->
                <!--begin::Group-->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>FPP</label>
                        <input type="text" class="form-control"  name="fpp" value="{{ $pr->fpp }}" required/>
                        
                    </div>
                </div>
                <!--end::Group-->
                <!--begin::Group-->
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Purpose</label>
                        <textarea name="purpose" cols="30" rows="3" class="form-control">{{ $pr->purpose }}</textarea>
                    </div>
                </div>
                <!--end::Group-->
            </div>
           
            <div class="separator separator-dashed mb-3"></div>

            <div id="kt_repeater_1">
                <div class="form-group row">
                    <div data-repeater-list="lists" class="col-lg-12">
                        @foreach($pr->lists as $list)
                        <div data-repeater-item="" class="form-group row align-items-center">
                            <div class="col-md-3">
                                <label>Stock Number:</label>
                                <input type="text" name="stock" value="{{ $list['stock'] }}" class="form-control" />
                                <div class="d-md-none mb-2"></div>
                            </div>
                            <div class="col-md-3">
                                <label>Unit:</label>
                                <input type="text" name="unit" value="{{ $list['unit'] }}" class="form-control"/>
                                <div class="d-md-none mb-2"></div>
                            </div>

                            <div class="col-md-3">
                                <label>Quantity:</label>
                                <input type="text" class="form-control" value="{{ $list['quantity'] }}" name="quantity"/>
                                <div class="d-md-none mb-2"></div>
                            </div>

                            <div class="col-md-3">
                                <label>Item Cost:</label>
                                <input type="text" name="amount" {{ $list['amount'] }} class="form-control"/>
                                <div class="d-md-none mb-2"></div>
                            </div>

                            <div class="col-md-12 mt-5">
                                <label>Item Description:</label>
                                <textarea name="description" cols="30" rows="3" class="form-control">{{ $list['description'] }}</textarea>
                                <div class="d-md-none mb-2"></div>
                            </div>
                           
                            <div class="col-md-1">
                                <a href="javascript:;" data-repeater-delete="" class="btn btn-sm font-weight-bolder btn-light-danger mt-5">
                                <i class="fal fa-times"></i></a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <a href="javascript:;" data-repeater-create="" class="btn btn-sm font-weight-bolder btn-light-primary">
                        <i class="fal fa-plus"></i>Add New Row</a>
                    </div>
                </div>
            </div>

            <div class="separator separator-dashed mb-5"></div>


            <h4>Signatories</h4>


            <div class="row">
                <div class="col-md-4">
                    <!--begin::Group-->
                    <div class="form-group">
                        <label>Requesting Officer</label>
                        <select name="requesting" class="form-control select2" required>
                            @foreach($employees->where('division_id', auth_division()) as $employee)
                                <option value=""></option>
                                <option {{ sh($employee->id, $pr->requesting_id) }} value="{{ $employee->id }}">{{ name_helper($employee->name) }}</option>
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
                                <option {{ sh($employee->id, $pr->treasury_id) }} value="{{ $employee->id }}">{{ name_helper($employee->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!--end::Group-->
                <!--begin::Group-->
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Approving Officer</label>
                        <select name="approving" class="form-control select2" required>
                            @foreach($employees->where('division_id', auth_division()) as $employee)
                                <option value=""></option>
                                <option {{ sh($employee->id, $pr->approving_id) }} value="{{ $employee->id }}">{{ name_helper($employee->name) }}</option>
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
                        <option {{ sh($employee->id, $pr->document->liaison_id) }} value="{{ $employee->id }}">{{ name_helper($employee->name) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="separator separator-dashed mb-5"></div>


            <button type="submit" class="btn btn-primary mt-5" name="submitButton">Save Changes</button>

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
<script src="{{ asset('js/Modules/FileManagement/pages/forms/procurement/request/create.js') }}"></script>
@endsection


