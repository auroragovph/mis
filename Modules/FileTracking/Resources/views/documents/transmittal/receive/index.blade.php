@extends('filetracking::layouts.app')

@section('page-title')
    Transmittal Receive
@endsection

@section('breadcrumbs')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('fts.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Starter Page</li>
</ol>
@endsection

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card p-3">
            <form id="form-number" method="POST" action="{{ route('fts.documents.transmittal.receive.form') }}" autocomplete="off">
                @csrf
                <div class="form-group">
                    <label for="">Transmittal QR</label>
                    <input type="text" class="form-control" name="transmittal" autofocus>
                </div>
                <hr>
                <div class="form-group">
                    <button class="btn bg-gradient-primary">
                        <i class="fal fa-search"></i> Search
                    </button>
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
    
@endsection