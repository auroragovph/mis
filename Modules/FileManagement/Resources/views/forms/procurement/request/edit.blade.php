@extends('layouts.master')


@section('page-title')
Purchase Request
@endsection

@section('toolbar')

@endsection

@section('content')

<!--begin::Advance Table: Widget 7-->
<div class="card card-custom gutter-b" id="card-box" data-card="true" >
  
    <x-ui.card.title title="Purchase Request Update Form" />

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
           
            <hr>

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
                                <input type="number" min="0" class="form-control" value="{{ $list['quantity'] }}" name="quantity"/>
                                <div class="d-md-none mb-2"></div>
                            </div>

                            <div class="col-md-3">
                                <label>Item Cost:</label>
                                <input type="number" step="0.01" name="amount" value="{{ $list['amount'] }}" class="form-control"/>
                                <div class="d-md-none mb-2"></div>
                            </div>

                            <div class="col-md-12 mt-5">
                                <label>Item Description:</label>
                                <textarea name="description" cols="30" rows="3" class="form-control">{{ $list['description'] }}</textarea>
                                <div class="d-md-none mb-2"></div>
                            </div>
                           
                            <div class="col-md-1">
                                <a href="javascript:;" data-repeater-delete="" class="btn btn-sm font-weight-bolder btn-danger mt-5">
                                <i class="fas fa-times"></i></a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <a href="javascript:;" data-repeater-create="" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus mr-1"></i>Add New Row</a>
                    </div>
                </div>
            </div>

            <hr>

            <h4>Signatories</h4>


            <div class="row">
                <div class="col-md-4">
                    <!--begin::Group-->
                    <div class="form-group">
                        <label>Requesting Officer</label>
                        <select name="requesting" class="form-control select2" required>
                            <option value=""></option>
                            @foreach($employees->where('division_id', auth_division()) as $employee)
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
                            <option value=""></option>
                            @foreach($employees->where('division_id', config('constants.office.PTO')) as $employee)
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
                            <option value=""></option>
                            @foreach($employees->where('division_id', auth_division()) as $employee)
                                <option {{ sh($employee->id, $pr->approving_id) }} value="{{ $employee->id }}">{{ name_helper($employee->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!--end::Group-->
            </div>



            <hr>

            <div class="form-group">
                <label>Liaison Officer</label>
                <select name="liaison" class="form-control select2" required>
                    <option value=""></option>
                    @foreach($employees->where('division_id', auth()->user()->employee->division_id)->where('liaison', true) as $employee)
                        <option {{ sh($employee->id, $pr->document->liaison_id) }} value="{{ $employee->id }}">{{ name_helper($employee->name) }}</option>
                    @endforeach
                </select>
            </div>

            <hr>
            <button type="submit" class="btn btn-primary" name="submitButton">Submit</button>
        </form>
    </div>

    <!--end::Body-->
</div>
<!--end::Advance Table Widget 7-->

@endsection


@section('css-vendor')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
@endsection

@section('css-custom')
@endsection


@section('js-vendor')
<!-- Select2 -->
<script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
<!-- Repeater -->
<script src="{{ asset('adminlte/plugins/repeater/repeater.js') }}"></script>
@endsection

@section('js-custom')
<script src="{{ asset('js/Modules/FileManagement/pages/forms/procurement/request/create.js') }}"></script>
@endsection


