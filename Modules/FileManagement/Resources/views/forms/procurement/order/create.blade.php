@extends('layouts.master')


@section('page-title')
Purchase Order Form
@endsection

@section('toolbar')

@endsection

@section('content')
<x-ui.card>
    <form class="form" id="kt_form" method="POST" action="{{ route('fms.procurement.order.store') }}">
        @csrf
        <h5>Supplier</h5>
        <hr>

        <div class="row">
            <div class="col-md-6">
                <x-ui.form.input label="Firm / Business Name" name="supplier_firm" required />
            </div>
            <!--end::Group-->
            <!--begin::Group-->
            <div class="col-md-6">
                <x-ui.form.input label="Name" name="supplier_name" required />
            </div>
            <!--end::Group-->
        </div>
    
        <div class="row">
            <div class="col-md-6">
                <x-ui.form.input label="Address" name="supplier_address" required />
            </div>
            <!--end::Group-->
            <!--begin::Group-->
            <div class="col-md-6">
                <x-ui.form.input label="TIN" name="supplier_tin" />
            </div>
            <!--end::Group-->
        </div>

        <h5>Order</h5>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <x-ui.form.input label="PO Number" name="number" />
            </div>
            <!--end::Group-->
            <!--begin::Group-->
            <div class="col-md-6">
                <x-ui.form.input label="Mode Of Procurement" name="mode_of_procurement" />
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

        <h5>Order</h5>
        <hr>
    
        <div class="row">
            <div class="col-md-6">
                <x-ui.form.input label="Place of Delivery" name="delivery_place" required />
            </div>
            <!--end::Group-->
            <!--begin::Group-->
            <div class="col-md-6">
                <x-ui.form.input label="Date of Delivery" type="date" name="delivery_date" required />
            </div>
            <!--end::Group-->
        </div>
    
        <div class="row">
            <div class="col-md-6">
                <x-ui.form.input label="Delivery Term" name="delivery_term" required />
            </div>
            <!--end::Group-->
            <!--begin::Group-->
            <div class="col-md-6">
                <x-ui.form.input label="Payment Term" name="delivery_payment" />
            </div>
            <!--end::Group-->
        </div>
       
        <hr>

        <div id="kt_repeater_1">
            <div class="form-group row">
                <div data-repeater-list="lists" class="col-lg-12">
                    @foreach($document->purchase_request->lists as $list)
                    <div data-repeater-item="" class="form-group row align-items-center">
    
                        <div class="col-md-3">
                            <x-ui.form.input label="Stock Number:" name="stock" />
                        </div>
    
                        <div class="col-md-3">
                            <x-ui.form.input label="Unit:" name="unit" :value="$list['unit'] ?? ''" />
                        </div>
    
                        <div class="col-md-3">
                            <x-ui.form.input label="Quantity:" type="number" name="quantity" :value="$list['quantity'] ?? ''" />
                        </div>
    
                        <div class="col-md-3">
                            <x-ui.form.input label="Item Cost:" type="number" name="amount" :value="$list['amount'] ?? ''" />
                        </div>
    
                        <div class="col-md-12">
                            <x-ui.form.text-area label="Item Description:" name="description" :value="$list['description'] ?? ''" />
                        </div>
                       
                        <div class="col-md-1">
                            <a href="javascript:;" data-repeater-delete="" class="btn btn-sm btn-danger">
                            <i class="fas fa-times"></i></a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-12">
                    <a href="javascript:;" data-repeater-create="" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i>Add New Row</a>
                </div>
            </div>
        </div>

        <hr>

        
        <div class="row">
            <div class="col-md-12">

                <x-ui.form.select2 label="Approving Officer" name="approving">
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}">{{ name_helper($employee->name) }}</option>
                    @endforeach
                </x-ui.form.select2>

            </div>
            <!--end::Group-->
        </div>

        <hr>

        <div class="row">
            <div class="col-md-12">
                <x-ui.form.text-area name="particulars" label="Particulars" :value="$document->purchase_request->particulars" />
            </div>
            <!--end::Group-->
        </div>
        <hr>
        <button type="submit" class="btn btn-primary" name="submitButton">Submit</button>
    </form>
</x-ui.card>
@endsection


@section('css-vendor')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
@endsection

@section('js-vendor')
<!-- Select2 -->
<script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>

{{-- Repeater --}}
<script src="{{ asset('adminlte/plugins/repeater/repeater.js') }}"></script>
@endsection

@section('js-custom')
<script src="{{ asset('js/Modules/FileManagement/pages/forms/procurement/order/create.js') }}"></script>
@endsection


