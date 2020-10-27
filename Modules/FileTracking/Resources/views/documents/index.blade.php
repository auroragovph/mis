@extends('filetracking::layouts.app')

@section('page-title')
    Primary Documents
@endsection

@section('breadcrumbs')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('fts.dashboard') }}">Dashboard</a></li>
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
                    <option value="{{ route('fts.dv.index') }}">Disbursement Voucher (DV) </option>
                    <option value="{{ route('fts.procurement.request.index') }}">Purchase Request (PR) </option>
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