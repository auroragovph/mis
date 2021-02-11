@extends('layouts.master')


@section('page-title')
Disbursement Voucher
@endsection

@section('toolbar')
@endsection

@section('content')

<!--begin::Advance Table: Widget 7-->
<div class="card card-custom gutter-b" id="card-box" data-card="true" >
    <!--begin::Header-->
   <div class="card-header py-3">
        <div class="card-title align-items-start flex-column">
            <h3 class="card-label font-weight-bolder text-dark">Disbursement Voucher Form</h3>
            <span class="text-muted font-weight-bold font-size-sm mt-1">Please fill up the form</span>
        </div>
    </div>
    <!--end::Header-->

    <!--begin::Body-->
    <div class="card-body">
        <form id="kt_form" action="{{ route('fts.dv.store') }}" method="POST">

            @csrf
            <div class="row">
  
              <div class="col-md-6">
  
                <div class="form-group">
                  <label for="">* Select Series #:</label> <br>
                  <select name="series" class="form-control select2" required style="width: 100%">
                      <option value="" hidden disabled selected></option>
                      @foreach($qrs as $qr)
                        <option value="{{ $qr->id }}">{{ $qr->series }}</option>
                      @endforeach
                  </select>
                </div>
              </div>
  
              <div class="col-md-6">
  
                <div class="form-group">
                  <label for="">* Requesting Office:</label> <br>
                  <select name="division" class="form-control select2" required style="width: 100%">
                      <option value="" hidden disabled selected></option>
                      @foreach($divisions as $division)
                        <option value="{{ $division->id }}">{{ office_helper($division) }}</option>
                      @endforeach
                  </select>
                </div>
  
              </div>
  
            </div>

            <div class="row">
  
                <div class="col-md-6">
    
                  <div class="form-group">
                    <label for="">Payee:</label>
                    <input type="text" name="payee" class="form-control" required>
                  </div>
                </div>
    
                <div class="col-md-6">
    
                  <div class="form-group">
                    <label for="">Amount :</label>
                    <input type="number" name="amount" step="0.01"  class="form-control" required>
                  </div>
    
                </div>
    
            </div>

            <div class="row">
  
                <div class="col-md-6">
    
                  <div class="form-group">
                    <label for="">Accountable Person:</label>
                    <input type="text" name="accountable" class="form-control" required>
                  </div>
                </div>
    
                <div class="col-md-6">
    
                  <div class="form-group">
                    <label for="">Code :</label>
                    <input type="text" name="code" class="form-control">
                  </div>
    
                </div>
    
            </div>

         
            
            <div class="row">
  
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">* Particulars</label>
                        <textarea name="particulars" cols="30" rows="3" class="form-control"></textarea>
                    </div>
                </div>
  
            </div>

            <div class="row">

              <div class="col-md-12">
                <div class="form-group">
                  <label for="">* Liaison Officer:</label> <br>
                  <select name="liaison" class="form-control select2" required style="width: 100%">
                      <option value="" hidden disabled selected></option>
                      @foreach($liaisons as $liaison)
                        <option value="{{ $liaison->id }}">{{ name_helper($liaison->name) }}</option>
                      @endforeach
                  </select>
                </div>
              </div>

            </div>

            <div class="separator separator-dashed mb-5"></div>
            <button type="submit" class="btn btn-primary mt-5" name="submitButton">Submit</button>
            
          </form>
    </div>

    <!--end::Body-->
</div>
<!--end::Advance Table Widget 7-->

@endsection


@section('css-vendor')
@endsection

@section('css-custom')
@endsection


@section('js-vendor')
@endsection

@section('js-custom')
<script src="{{ asset('js/Modules/FileTracking/pages/forms/create.js') }}"></script>
@endsection