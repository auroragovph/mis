@extends('layouts.master')


@section('page-title')
QR Codes
@endsection

@section('toolbar')
@endsection

@section('content')
<div class="row">

    <div class="col-md-8">

        <!--begin::Card-->
        <div class="card card-custom">
            <div class="card-body">
                <!--begin: Search Form-->
                <!--begin::Search Form-->
                <div class="mb-7">
                    <div class="row align-items-center">
                        <div class="col-lg-9 col-xl-8">
                            <div class="row align-items-center">
                                <div class="col-md-4 my-2 my-md-0">
                                    <div class="input-icon">
                                        <input type="text" class="form-control" placeholder="Search..." id="kt_datatable_search_query" />
                                        <span>
                                            <i class="flaticon2-search-1 text-muted"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <!--end::Search Form-->
                <!--end: Search Form-->
                <!--begin: Datatable-->
                <div class="datatable datatable-bordered datatable-head-custom" id="ktdt_qr"></div>
                <!--end: Datatable-->
            </div>
        </div>
        <!--end::Card-->




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
                    <h3 class="font-size-h5">Print QR (Auto)</h3>
                    <div class="separator separator-dashed"></div>
                    <form action="{{ route('fts.qr.print') }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="auto">

                        <div class="form-group">
                            <label for="">Type</label>
                            <select name="driver" class="form-control">
                                <option value="last">Last QR Print</option>
                                <option value="lost">Lost QR</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Number</label>
                            <input class="form-control" type="number" name="counts" required>
                        </div>

                        <button class="btn btn-primary btn-block">Print</button>
                    </form>
            </div>
            <!--end::Body-->
        </div>
        <!--end::Card-->

        <!--begin::Card-->
        <div class="card card-custom gutter-b">
            <!--begin::Body-->
            <div class="card-body">
                    <h3 class="font-size-h5">Print Range</h3>
                    <div class="separator separator-dashed"></div>
                    <form action="{{ route('fts.qr.print') }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="range">

                        <div class="form-group">
                            <label for="">Start</label>
                            <input class="form-control" type="number" name="start"  required>
                        </div>

                        <div class="form-group">
                            <label for="">End</label>
                            <input class="form-control" type="number" name="end" required>
                        </div>

                        <button class="btn btn-primary btn-block">Print</button>
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
<script src="{{ asset('js/Modules/FileTracking/pages/qr.js') }}"></script>
@endsection


