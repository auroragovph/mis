@extends('layouts.master')


@section('page-title')
Numbering
@endsection

@section('toolbar')
@endsection

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card card-custom gutter-b" id="card-box">
            <!--begin::Body-->
            <div class="card-body">
                <form id="kt_form" action="{{ route('fms.documents.number.search') }}" method="POST">
                    @csrf
                    @method('PUT')
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

<div class="modal fade" id="numberModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" data-card="true" id="modal-card">
        <div id="whirl-2" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Document Numbering</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="fal fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="card bg-danger p-5">
                    <h1 id="modal-num" class="font-weight-bolder text-center text-white">TO-123</h1>
                    <small id="modal-last" class="text-center text-white">LAST PR NUMBER</small>
                </div>

                <hr>

                <form id="form_num" method="POST" action="{{ route('fms.documents.number.number') }}">
                    @csrf
                <div class="form-group">
                    <label for="">Number</label>
                    <input type="hidden" name="document" value="">
                    <input type="hidden" name="type" value="">
                    <input type="text" name="number" class="form-control" required>
                </div>

            </div>
            <div class="modal-footer justify-content-center">
                <button id="form_num_btn" type="submit" class="btn btn-primary">Save</button>
            </div>

            </form>
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
<script src="{{ asset('js/Modules/FileManagement/pages/documents/numbering.js') }}"></script>
@endsection


