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
        <x-ui.card>
            <form action="{{ route('fms.documents.cancel.submit', $document->id) }}" method="POST">
                @csrf
                <x-ui.form.text-area label="Reason for document cancellation" name="reason"></x-ui.form.text-area>
                <hr>
                <button type="submit" class="btn btn-danger">Cancel this document</button>
            </form>
        </x-ui.card>
    </div>
</div>
@else 
<div class="row">
    <div class="col-xl-12">
        <div class="card card-custom  gutter-b">
           
            <!--begin::Body-->
            <div class="card-body">
                <form action="{{ route('fms.documents.cancel.form') }}" method="POST">
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


