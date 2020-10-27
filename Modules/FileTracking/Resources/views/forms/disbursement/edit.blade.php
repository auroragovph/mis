@extends('filetracking::layouts.app')

@section('page-title')
    Edit Disbursement Voucher
@endsection

@section('breadcrumbs')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('fts.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Starter Page</li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-default">

            <div class="card-header">
                <h3 class="card-title">Edit</h3>
            </div>

            <div class="card-body">
                <form action="{{ route('fts.dv.update', $document->id) }}" method="POST">
                    @csrf
                    <div class="row">
          
                      <div class="col-md-6">
          
                        <div class="form-group">
                          <label for="">Select Series #:</label> <br>
                          <input value="{{ $document->seriesFull }}" type="text" class="form-control" readonly>
                        </div>
                      </div>
          
                      <div class="col-md-6">
          
                        <div class="form-group">
                          <label for="">Requesting Office:</label> <br>
                          <select name="division" class="form-control select2" required style="width: 100%">
                              <option value="" hidden disabled selected></option>
                              @foreach($divisions as $division)
                                <option {{ sh($division->id, $document->division_id ) }} value="{{ $division->id }}">{{ office_helper($division) }}</option>
                              @endforeach
                          </select>
                        </div>
          
                      </div>
          
                    </div>
                  
          
                    <div class="row">
          
                      <div class="col-md-6">
                          <div class="form-group">
                            <label for="">Payee:</label>
                            <input value="{{ $document->dv->payee }}" type="text" name="payee" class="form-control" required>
                          </div>
                      </div>
          
                      <div class="col-md-6">
                          <div class="form-group">
                            <label for="">Amount:</label>
                            <input value="{{ $document->dv->amount }}" name="amount" type="number" step="0.01" class="form-control" required>
                          </div>
            
                        </div>
                      
                    </div>
          
                    <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label for="">Particulars</label>
                              <textarea name="particulars" cols="30" rows="2" class="form-control" required>{{ $document->dv->particulars }}</textarea>
                          </div>
                      </div>
                    </div>
          
                    <div class="row">
          
                      <div class="col-md-6">
                          <div class="form-group">
                            <label for="">Code:</label>
                            <input value="{{ $document->dv->code }}" type="text" name="code" class="form-control">
                          </div>
                      </div>
          
                      <div class="col-md-6">
                          <div class="form-group">
                            <label for="">Accountable Person:</label>
                            <input value="{{ $document->dv->accountable }}" name="accountable" type="text" class="form-control">
                          </div>
            
                        </div>
                      
                    </div>
          
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="">Liaison QR:</label>
                          <input name="liaison" type="password" class="form-control" autocomplete="off">
                        </div>
                      </div>
                    </div>
                    
                    <hr>
          
                    <button class="btn bg-gradient-primary">Save</button>
                  </form>
            </div>
        </div>
    </div>
</div>
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
    $(".select2").select2({
        placeholder: "Select from list"
    });
}); 
</script>
@endsection