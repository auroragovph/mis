@extends('layouts.master')


@section('page-title')
Receive / Release
@endsection

@section('toolbar')
@endsection

@section('content')
@isset($document)
<div class="row">
    <x-fms-qr size="xl-4" :document="$document" :datas="$datas" />

    <div class="col-xl-8">
        <div class="card card-custom gutter-b" id="card-box">
            <!--begin::Header-->
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label font-weight-bolder text-dark">
                        @if($track->action == 0)
                            Receive Form
                        @else
                            Release Form 
                        @endif
                    </span>
                </h3>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body">
                <form method="POST" action="{{ route('fms.documents.rr.submit') }}" id="kt_form">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="">Purpose</label>
                        <input name="purpose" type="text" class="form-control" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label for="">Status</label>
                        <select name="status" class="form-control" required>
                            <option value="">---SELECT---</option>
                            @foreach(config('static-lists.documentStatus') as $key => $status)
                                <option value="{{ $key }}">{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>

                    <hr>

                    <div class="mt-10">
                        @if($track->action == 0)
                            <button type="submit" class="btn btn-primary"> <i class="fal fa-file-download"></i> RECEIVE</button>
                        @else 
                            <button type="submit" class="btn btn-primary"> <i class="fal fa-file-upload"></i> RELEASE</button>
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
                <form action="{{ route('fms.documents.rr.form') }}" method="POST">
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
@endisset

@endsection


@section('css-vendor')
@endsection

@section('css-custom')
@endsection


@section('js-vendor')
@endsection

@section('js-custom')
<script src="{{ asset('js/Modules/FileManagement/pages/documents/rr.js') }}"></script>
@endsection