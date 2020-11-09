@extends('filetracking::layouts.app')

@section('page-title')
    Receive / Release
@endsection

@section('breadcrumbs')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('fts.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">RR Page</li>
</ol>
@endsection

@section('content')
@isset($document)
<div class="row">

        
    <x-fts-qr size="sm-4" :document="$document['info']" :datas="$document['datas']" />

    <div class="col-sm-8">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-body">
                        <form method="POST" action="{{ route('fts.documents.rr.submit') }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="">Purpose</label>
                                <input name="purpose" type="text" class="form-control" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label for="">Status</label>
                                <select name="status" id="" class="form-control select2" required>
                                    <option value="" selected hidden></option>
                                    <option value="0">Cancel</option>
                                    <option value="2">On Process</option>
                                    <option value="3">Approved</option>
                                    <option value="4">Disapproved</option>
                                    <option value="5">Pending</option>
                                </select>
                            </div>
    
                            <hr>
        
                            <div class="mt-10">
                                @if($document['tracks'][0]['action'] == 0)
                                    <button type="submit" class="btn bg-gradient-primary"> <i class="fal fa-file-download"></i> RECEIVE</button>
                                @else 
                                    <button type="submit" class="btn bg-gradient-primary"> <i class="fal fa-file-upload"></i> RELEASE</button>
                                @endif
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
    
            <x-fts-tracking-latest size="md-12" :track="$document['tracks'][0]" />
            
        </div>
    </div>
</div>
@else 
    <div class="row">
        <div class="col-12">
            <div class="card card-custom" data-card="true" id="activate-card">
                <div class="card-body p-10">
                    <form action="{{ route('fts.documents.rr.form') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="">Series Number</label>
                            <input type="text" name="series" class="form-control" autofocus required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="">Liaison QR</label>
                            <input type="password" name="liaison" id="liaison" class="form-control" required autocomplete="off">
                        </div>
                        <hr>
                        <button type="submit" class="btn bg-gradient-primary"><i class="fal fa-search"></i> Search</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endisset
@endsection



@section('css-vendor')
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    
@endsection

@section('css-custom')
    
@endsection


@section('js-vendor')
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

@endsection

@section('js-custom')
<script>
$(function () {
    //Initialize Select2 Elements
    $(".select2").select2({
        placeholder: "Select from list"
    });
});
</script>
@endsection