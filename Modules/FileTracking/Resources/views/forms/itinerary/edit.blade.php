@extends('layouts.master')


@section('page-title')
Itinerary Of Travel
@endsection

@section('toolbar')
@endsection

@section('content')

<!--begin::Advance Table: Widget 7-->
<div class="card card-custom gutter-b" id="card-box" data-card="true" >
    <!--begin::Header-->
   <div class="card-header py-3">
        <div class="card-title align-items-start flex-column">
            <h3 class="card-label font-weight-bolder text-dark">Itinerary Update Form</h3>
            <span class="text-muted font-weight-bold font-size-sm mt-1">Please fill up the form</span>
        </div>
    </div>
    <!--end::Header-->

    <!--begin::Body-->
    <div class="card-body">
        <form id="kt_form" action="{{ route('fts.travel.itinerary.update', $iot->id) }}" method="POST">

            @csrf
            <div class="row">
  
              <div class="col-md-6">
  
                <div class="form-group">
                  <label for="">* Select Series #:</label> <br>
                  <input type="text" class="form-control" disabled value="{{ $iot->document->seriesFull }}">
                </div>
              </div>
  
              <div class="col-md-6">
  
                <div class="form-group">
                  <label for="">* Requesting Office:</label> <br>
                  <select name="division" class="form-control select2" required style="width: 100%">
                      <option value="" hidden disabled selected></option>
                      @foreach($divisions as $division)
                        <option {{ sh($division->id, $iot->document->division_id) }} value="{{ $division->id }}">{{ office_helper($division) }}</option>
                      @endforeach
                  </select>
                </div>
  
              </div>
  
            </div>


            {{-- INSERT YOUR FORM HERE --}}
            <div class="row">
  
                <div class="col-md-6">
    
                  <div class="form-group">
                    <label for="">* Name:</label>
                    <input type="text" class="form-control" name="name" value="{{ $iot->name }}" required>
                  </div>
                </div>
    
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">* Position:</label>
                    <input type="text" class="form-control" name="position" value="{{ $iot->position }}" required>
                  </div>
                </div>
    
            </div>

            <div class="row">
  
                <div class="col-md-6">
    
                  <div class="form-group">
                    <label for="">* Destination:</label>
                    <input type="text" class="form-control" name="destination" value="{{ $iot->destination }}" required>
                  </div>
                </div>
    
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">* Amount:</label>
                    <input type="number" step="0.01" class="form-control" name="amount" value="{{ $iot->amount }}" required>
                  </div>
                </div>
    
            </div>
            {{-- END YOUR FORM HERE --}}

            <div class="row">
  
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">* Purpose</label>
                        <textarea name="particulars" cols="30" rows="3" class="form-control">{{ $iot->particulars }}</textarea>
                    </div>
                </div>
  
            </div>
          
  
            <div class="row">
  
              <div class="col-md-12">
                  <div class="form-group">
                      <label for="">Attached Documents:</label>
                      <select name="attachments[]" class="form-control select2-tags" multiple style="width: 100%">
                         
                      </select>
                  </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label for="">* Liaison Officer:</label> <br>
                  <select name="liaison" class="form-control select2" required style="width: 100%">
                      <option value="" hidden disabled selected></option>
                      @foreach($liaisons as $liaison)
                        <option {{ sh($liaison->id, $iot->document->liaison_id) }} value="{{ $liaison->id }}">{{ name_helper($liaison->name) }}</option>
                      @endforeach
                  </select>
                </div>
              </div>

            </div>


            <div class="separator separator-dashed mb-5"></div>
            <button type="submit" class="btn btn-primary mt-5" name="submitButton">Save Changes</button>
            
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