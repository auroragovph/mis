@extends('layouts.master')


@section('page-title')
Receive / Release
@endsection

@section('toolbar')
@endsection

@section('content')
@isset($document)
<div class="row">

    <div class="col-xl-4">
        <x-fts-qr :document="$document" :datas="$datas" />
    </div>

    <div class="col-xl-8">
        <div class="card card-custom gutter-b" id="card-box" data-card="true">
          
            <!--begin::Body-->
            <div class="card-body">

                <h3 class="font-size-h4 font-weight-bolder">
                    @if($track->action == 0)
                        Receive Form
                    @else
                        Release Form 
                    @endif
                </h3>
                <div class="separator separator-dashed mb-5"></div>

                <form id="kt_form" method="POST" action="{{ route('fts.documents.rr.submit') }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="">Purpose</label>
                        <input name="purpose" type="text" class="form-control" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label for="">Status</label>
                        <select name="status" id="" class="form-control" required>
                            <option value="" selected hidden></option>
                            @foreach(config('static-lists.documentStatusFTS') as $key => $status)
                                <option {{ sh($key, $track->status ?? 0) }} value="{{ $key }}">{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>

                    <hr>

                    <div class="mt-10">
                        @if($track->action == 0)
                            <button type="submit" class="btn btn-primary"> <i class="fal fa-file-download"></i> RECEIVE</button>
                        @else 
                            <button type="submit" class="btn btn-warning"> <i class="fal fa-file-upload"></i> RELEASE</button>
                        @endif
                    </div>
                    
                </form>
            </div>
            <!--end::Body-->
        </div>
    </div>
</div>
@else 
<div class="row">
    <div class="col-xl-12">
        <div class="card card-custom gutter-b">
           
            <!--begin::Body-->
            <div class="card-body">
                <form action="{{ route('fts.documents.rr.form') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="">Document ID</label>
                        <input type="text" name="series" class="form-control" autofocus required>
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
@endisset

@endsection


@section('css-vendor')
@endsection

@section('css-custom')
@endsection


@section('js-vendor')
@endsection

@section('js-custom')
@isset($document)
<script src="{{ asset('js/Modules/FileTracking/pages/rr.js') }}"></script>
@endisset
@endsection