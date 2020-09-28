@extends('filemanagement::layouts.app')


@section('page-title')
    Documents
@endsection

@section('breadcrumbs')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('fms.dashboard') }}">Home</a></li>
    <li class="breadcrumb-item active">Documents</li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-default p-3">
            <div class="form-group">
                <label for="">Select Document Type</label>
                <select class="form-control select2" data-live-search="true" data-size="5" name="param" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                    <option value="" selected hidden></option>
                    <option value="{{ route('fms.afl.index') }}">Application For Leave (AFL)</option>
                    <option value="{{ route('fms.cafoa.index') }}">Certification On Appropriations, Funds And Obligation Of Allotment (CAFOA)</option>
                    {{-- <option value="{{ route('fms.obr.index') }}">Obligation Request (OBR)</option> --}}
                    <option value="{{ route('fms.procurement.request.index') }}">Purchase Request (PR) </option>
                    {{-- <option value="{{ route('fms.procurement.order.index') }}">Purchase Order (PO)</option> --}}
                    <option value="{{ route('fms.travel.order.index') }}">Travel Order (TO)</option>
                </select>
            </div>
        </div>
    </div>
</div>
@endsection




@section('css-vendor')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
@endsection

@section('css-custom')
    
@endsection


@section('js-vendor')
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
@endsection

@section('js-custom')
<script>
$(function () {
    //Initialize Select2 Elements
    $(".select2").select2({
        placeholder: "Select from list"
    });
});
</script>
@endsection