@extends('filemanagement::layouts.app')


@section('page-title')
    Activation
@endsection

@section('breadcrumbs')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('fms.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('fms.documents.index') }}">Documents</a></li>
    <li class="breadcrumb-item active">Activation</li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div id="whirl" class="card p-3">
            <form id="form-activate" method="POST" action="{{ route('fms.documents.activation') }}">
                @csrf
                <div class="form-group">
                    <label for="">Document QR</label>
                    <input type="text" name="document" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="">Liaison QR</label>
                    <input type="text" name="liaison" class="form-control" required>
                </div>
                <hr>
    
                <div class="form-group">
                    <button class="btn bg-gradient-primary"><i class="fal fa-search"></i> Search</button>
                </div>
            </form>
            
        </div>
    </div>
</div>


@endsection




@section('css-vendor')
<link rel="stylesheet" href="{{ asset('plugins/whirl/whirl.css') }}">
@endsection

@section('css-custom')
    
@endsection


@section('js-vendor')
<script src="{{ asset("plugins/sweetalert2/sweetalert2.all.min.js")}}"></script>
@endsection

@section('js-custom')
    <script src="{{ asset('js/filemanagement/document-activate.js') }}"></script>
@endsection