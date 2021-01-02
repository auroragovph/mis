@extends('layouts.master')


@section('page-title')
Documents
@endsection

@section('toolbar')
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <!--begin::Base Table Widget 5-->
        <div class="card card-custom gutter-b card-stretch">
            <!--begin::Header-->
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label font-weight-bolder text-dark">Select Document Type</span>
                </h3>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body pt-2 pb-0">
                <div class="form-group">
                    <select class="form-control select2" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                        <option></option>
                        <option value="{{ route('fms.afl.index') }}">Application For Leave (AFL)</option>
                        <option value="{{ route('fms.cafoa.index') }}">Certification On Appropriations, Funds And Obligation Of Allotment (CAFOA)</option>
                        {{-- <option value="{{ route('fms.obr.index') }}">Obligation Request (OBR)</option> --}}
                        <option value="{{ route('fms.travel.itinerary.index') }}">Itinerary of Travel </option>
                        <option value="{{ route('fms.procurement.request.index') }}">Purchase Request (PR) </option>
                        {{-- <option value="{{ route('fms.procurement.order.index') }}">Purchase Order (PO)</option> --}}
                        <option value="{{ route('fms.travel.order.index') }}">Travel Order (TO)</option>
                    </select>
                </div>
            </div>
            <!--end::Body-->
        </div>
        <!--end::Base Table Widget 5-->
    </div>
</div>
@endsection


@section('css-vendor')
@endsection

@section('css-custom')
@endsection


@section('js-vendor')
@endsection

@section('js-custom')
<script>
$(document).ready(function () {
    $('.select2').select2({
        placeholder: "Select document type"
	});
});
</script>
@endsection


