@extends('layouts.master')


@section('page-title')
QR Codes
@endsection

@section('toolbar')
@endsection

@section('content')
<div class="row">

    <div class="col-md-8">

    </div>
    <div class="col-md-4">

        <!--begin::Card-->
        <div class="card card-custom gutter-b">
            <!--begin::Body-->
            <div class="card-body">
                <form action="{{ route('fts.qr.generate') }}" method="POST">

                    <h3 class="font-size-h5">Generate QR Codes</h3>
                    <div class="separator separator-dashed"></div>

                    @csrf
                    <div class="form-group mt-5">
                        <label for="">QR Counts</label>
                        <input class="form-control" type="number" name="counts" max="1500" min="1" required>
                    </div>

                    <button class="btn btn-primary btn-block">Generate</button>
                </form>
            </div>
            <!--end::Body-->
        </div>
        <!--end::Card-->

        <!--begin::Card-->
        <div class="card card-custom gutter-b">
            <!--begin::Body-->
            <div class="card-body">
                <form action="{{ route('fts.qr.generate') }}" method="POST">

                    <h3 class="font-size-h5">Generate QR Codes</h3>
                    <div class="separator separator-dashed"></div>

                    @csrf
                    <div class="form-group mt-5">
                        <label for="">QR Counts</label>
                        <input class="form-control" type="number" name="counts" max="1500" min="1" required>
                    </div>

                    <button class="btn btn-primary btn-block">Generate</button>
                </form>
            </div>
            <!--end::Body-->
        </div>
        <!--end::Card-->

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
@endsection


