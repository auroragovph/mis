@extends('layouts.master')


@section('page-title')
Transmittal
@endsection

@section('toolbar')
@endsection

@section('content')


<div class="row">
    <div class="col-md-6">
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Release Transmittal</h3>
                </div>
            </div>
            <div class="card-body">
                <form id="form-number" method="POST" action="{{ route('fts.documents.transmittal.form') }}">
                    @csrf
                    <div class="form-group">
                        <label for="">Document QR</label>
                        <select name="qrs[]" class="form-control select2_tags" multiple style="width: 100%">
                        </select>
                    </div>
                    <hr>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-shadow font-weight-bold mr-2"><i class="fal fa-search"></i> Search</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Receive Transmittal</h3>
                </div>
            </div>
            <div class="card-body">
                <form id="form-number" method="POST" action="{{ route('fts.documents.transmittal.receive.form') }}">
                    @csrf
                    <div class="form-group">
                        <label for="">Transmittal QR</label>
                        <input type="text" class="form-control" name="transmittal" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="">Liaison ID</label>
                        <input type="password" class="form-control" name="liaison" autocomplete="new-password">
                    </div>
                    <hr>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-shadow font-weight-bold mr-2"><i class="fal fa-search"></i> Search</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@include('filetracking::documents.transmittal.list', [
    'transmits' => $transmits
])



@endsection


@section('css-vendor')
@endsection

@section('css-custom')
@endsection


@section('js-vendor')
@endsection

@section('js-custom')
<script src="{{ asset('js/Modules/FileTracking/pages/documents/transmittal.js') }}"></script>
@endsection


