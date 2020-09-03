@extends('filemanagement::layouts.app')


@section('page-title')
    Cancellation
@endsection

@section('breadcrumbs')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('fms.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('fms.documents.index') }}">Documents</a></li>
    <li class="breadcrumb-item active">Cancellation</li>
</ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h3>Document Cancellation for: {{ convert_to_series($document) }}</h3>
                    <hr>
                    <form action="{{ route('fms.documents.cancel2', $document->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="">Cancellation Reason</label>
                            <textarea name="reason" id="" cols="30" rows="3" class="form-control"></textarea>
                        </div>
                        <hr>
                        <div class="form-group">
                            <button class="btn bg-gradient-danger"><i class="fas fa-ban"></i> Submit</button>
                        </div>
                    </form>
                </div>
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