@extends('layouts.master')


@section('page-title')
Purchase Order
@endsection

@section('toolbar')

@endsection

@section('content')

<!--begin::Advance Table: Widget 7-->
<div class="card card-custom gutter-b" id="card-box" data-card="true" >
    <!--begin::Header-->
   <div class="card-header py-3">
        <div class="card-title align-items-start flex-column">
            <h3 class="card-label font-weight-bolder text-dark">PO Form</h3>
            <span class="text-muted font-weight-bold font-size-sm mt-1">Please fill up the form</span>
        </div>
    </div>
    <!--end::Header-->

    <!--begin::Body-->
    <div class="card-body">
        <form class="form" id="kt_form" method="POST" action="{{ route('fms.procurement.order.store') }}">
            @csrf

            <h4 class="font-size-h5">Supplier</h4>
            <div class="separator separator-dashed mb-5"></div>


            <div class="row">
                <div class="col-md-6">
                    <!--begin::Group-->
                    <div class="form-group">
                        <label>Firm / Business Name</label>
                        <input type="text" class="form-control" name="supplier_firm" required/>
                    </div>
                </div>
                <!--end::Group-->
                <!--begin::Group-->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="supplier_name" required/>
                    </div>
                </div>
                <!--end::Group-->
            </div>

            <div class="row">
                <div class="col-md-6">
                    <!--begin::Group-->
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" class="form-control" name="supplier_address" required/>
                    </div>
                </div>
                <!--end::Group-->
                <!--begin::Group-->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>TIN</label>
                        <input type="text" class="form-control" name="supplier_tin"/>
                    </div>
                </div>
                <!--end::Group-->
            </div>

            <h4 class="font-size-h5">Order</h4>
            <div class="separator separator-dashed mb-5"></div>
            <div class="row">
                <div class="col-md-6">
                    <!--begin::Group-->
                    <div class="form-group">
                        <label>PO Number</label>
                        <input type="text" class="form-control" name="number"/>
                    </div>
                </div>
                <!--end::Group-->
                <!--begin::Group-->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Mode Of Procurement</label>
                        <input type="text" class="form-control" name="mode_of_procurement"/>
                    </div>
                </div>
                <!--end::Group-->
            </div>

            <div class="row">
                <div class="col-md-12">
                    <!--begin::Group-->
                    <div class="form-group">
                        <label>PR Number/s</label>
                        <select name="pr_number[]" class="form-control select2-tags" multiple>
                            @if($document->purchase_request->number != '')
                                <option selected>{{ $document->purchase_request->number }}</option>
                            @endif
                        </select>
                    </div>
                </div>
                <!--end::Group-->
            </div>

            <h4 class="font-size-h5">Delivery</h4>
            <div class="separator separator-dashed mb-5"></div>

            <div class="row">
                <div class="col-md-6">
                    <!--begin::Group-->
                    <div class="form-group">
                        <label>Place of Delivery</label>
                        <input type="text" class="form-control" name="delivery_place" required/>
                    </div>
                </div>
                <!--end::Group-->
                <!--begin::Group-->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Date of Delivery</label>
                        <input type="text" class="form-control" name="delivery_date" required/>
                    </div>
                </div>
                <!--end::Group-->
            </div>

            <div class="row">
                <div class="col-md-6">
                    <!--begin::Group-->
                    <div class="form-group">
                        <label>Delivery Term</label>
                        <input type="text" class="form-control" name="delivery_term"/>
                    </div>
                </div>
                <!--end::Group-->
                <!--begin::Group-->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Payment Term</label>
                        <input type="text" class="form-control" name="delivery_payment"/>
                    </div>
                </div>
                <!--end::Group-->
            </div>
           
            <div class="separator separator-dashed mb-3"></div>

            <div id="kt_repeater_1">
                <div class="form-group row">
                    <div data-repeater-list="lists" class="col-lg-12">
                        <div data-repeater-item="" class="form-group row align-items-center">
                            <div class="col-md-3">
                                <label>Stock Number:</label>
                                <input type="text" name="stock" class="form-control" />
                                <div class="d-md-none mb-2"></div>
                            </div>
                            <div class="col-md-3">
                                <label>Unit:</label>
                                <input type="text" name="unit" class="form-control"/>
                                <div class="d-md-none mb-2"></div>
                            </div>

                            <div class="col-md-3">
                                <label>Quantity:</label>
                                <input type="number" min="0" class="form-control" name="quantity"/>
                                <div class="d-md-none mb-2"></div>
                            </div>

                            <div class="col-md-3">
                                <label>Item Cost:</label>
                                <input type="number" step="0.01" name="amount" class="form-control"/>
                                <div class="d-md-none mb-2"></div>
                            </div>

                            <div class="col-md-12 mt-5">
                                <label>Item Description:</label>
                                <textarea name="description"  cols="30" rows="3" class="form-control"></textarea>
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
                        <i class="fal fa-plus"></i>Add New Row</a>
                    </div>
                </div>
            </div>

            <div class="separator separator-dashed mb-5"></div>

            <div class="row">
                <div class="col-md-12">
                    <!--begin::Group-->
                    <div class="form-group">
                        <label>Approving Officer</label>
                        <select name="approving" class="form-control select2">
                           @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">{{ name_helper($employee->name) }}</option>
                           @endforeach
                        </select>
                    </div>
                </div>
                <!--end::Group-->
            </div>

            <div class="separator separator-dashed mb-5"></div>

            <div class="row">
                <div class="col-md-12">
                    <!--begin::Group-->
                    <div class="form-group">
                        <label>Particulars</label>
                        <textarea name="particulars" cols="30" rows="3" class="form-control">{{ $document->purchase_request->purpose ?? '' }}</textarea>
                    </div>
                </div>
                <!--end::Group-->
            </div>


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
<script src="{{ asset('js/Modules/FileManagement/pages/forms/procurement/order/create.js') }}"></script>
@endsection


