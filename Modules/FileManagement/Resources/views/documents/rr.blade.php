@extends('filemanagement::layouts.app')


@section('page-title')
    Receive / Release
@endsection

@section('breadcrumbs')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('fms.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('fms.documents.index') }}">Documents</a></li>
    <li class="breadcrumb-item active">Receive | Release</li>
</ol>
@endsection

@section('content')


@if(!isset($document))

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-custom" data-card="true" id="activate-card">
                <div class="card-body p-10">
                    <form action="{{ route('fms.documents.rr.form') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="">Document QR</label>
                            <input type="text" name="document" class="form-control" autofocus required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="">Liaison QR</label>
                            <input type="password" name="liaison" id="liaison" class="form-control" required autocomplete="off" onkeypress="geeks(event)">
                            {{-- <textarea class="form-control" name="liaison" id="" cols="30" rows="10"></textarea> --}}
                            {{-- <input type="password" name="liaison" id="liaison" class="form-control" required autocomplete="off"> --}}
                        </div>
                        <hr>
                        <button type="submit" class="btn bg-gradient-primary"><i class="fal fa-search"></i> Search</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@else 


<div class="container-fluid">
    <div class="row">

        
        <x-fms-qr size="sm-4" :document="$document" :datas="$datas" />

        <div class="col-sm-8">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-body">
                            <form method="POST" action="{{ route('fms.documents.rr.submit') }}">
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
                                    @if($track->action == 0)
                                        <button type="submit" class="btn bg-gradient-primary"> <i class="fal fa-file-download"></i> RECEIVE</button>
                                    @else 
                                        <button type="submit" class="btn bg-gradient-primary"> <i class="fal fa-file-upload"></i> RELEASE</button>
                                    @endif
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
        
                <x-fms-tracking-latest size="md-12" :track="$track" />
                
            </div>
        </div>
    </div>
</div>
@endif

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
<script> 
    function geeks(event) {
        let textar = document.querySelector('#liaison');
        let textb = textar.value;
        if(event.keyCode == 10)
        {
            // console.log(textb);
            textar.value = textb+"||";
        }
        // console.log(event.key);
        // console.log(event.keyCode + "  " + event.key);
    } 
</script> 
@endsection