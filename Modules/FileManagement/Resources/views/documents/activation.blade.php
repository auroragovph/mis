@extends('layouts.master')


@section('page-title')
Document Activation
@endsection

@section('toolbar')
@endsection

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card card-custom gutter-b" id="card-box">
           
            <!--begin::Body-->
            <div class="card-body">
                <form id="kt_form" action="{{ route('fms.documents.activation.submit') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="">Document ID</label>
                        <input type="text" name="document" class="form-control" autofocus required>
                    </div>
                    <div class="form-group">
                        <label for="">Liaison QR</label>
                        <input type="password" name="liaison" class="form-control" required>
                    </div>
                    <hr>
                    <button class="btn btn-primary"><i class="flaticon2-magnifier-tool"></i> Search</button>
                </form>
            </div>
            <!--end::Body-->
        </div>
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
<script src="{{ asset('js/Modules/FileManagement/pages/documents/activation.js') }}"></script>
@endsection


