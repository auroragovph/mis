@extends('layouts.master')


@section('page-title')
Document Cancellation
@endsection

@section('toolbar')
@endsection

@section('content')

@isset($document)
<div class="row">

    <div class="col-xl-4">
        <x-fms-qr :document="$document" />

    </div>

    <div class="col-xl-8">
        <div class="card card-custom  gutter-b">
            <!--begin::Header-->
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label font-weight-bolder text-dark">Document Cancellation Form</span>
                </h3>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body">
                <form action="{{ route('fms.documents.cancel.submit', $document->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="">Reason for document cancellation</label>
                        <textarea name="reason" cols="30" rows="3" class="form-control"></textarea>
                    </div>
                    <hr>
                    <button class="btn btn-danger">Cancel this document</button>
                </form>
            </div>
            <!--end::Body-->
        </div>
    </div>
</div>
@else 
<div class="row">
    <div class="col-xl-12">
        <div class="card card-custom  gutter-b">
           
            <!--begin::Body-->
            <div class="card-body">
                <form action="{{ route('fms.documents.cancel.check') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="">Document ID</label>
                        <input type="text" name="document" class="form-control" autofocus>
                    </div>
                    <hr>
                    <button class="btn btn-primary"><i class="flaticon2-magnifier-tool"></i> Search</button>
                </form>
            </div>
            <!--end::Body-->
        </div>
    </div>
</div>
@endisset

@endsection


@section('css-vendor')
@endsection

@section('css-custom')
@endsection


@section('js-vendor')
@endsection

@section('js-custom')
@endsection


