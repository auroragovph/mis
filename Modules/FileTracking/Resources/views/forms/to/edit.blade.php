@extends('layouts.master')


@section('page-title')
Travel Order
@endsection

@section('toolbar')
@endsection

@section('content')

<!--begin::Advance Table: Widget 7-->
<div class="card card-custom gutter-b" id="card-box" data-card="true" >
    <!--begin::Header-->
   <div class="card-header py-3">
        <div class="card-title align-items-start flex-column">
            <h3 class="card-label font-weight-bolder text-dark">Travel Order Update Form</h3>
            <span class="text-muted font-weight-bold font-size-sm mt-1">Please fill up the form</span>
        </div>
    </div>
    <!--end::Header-->

    <!--begin::Body-->
    <div class="card-body">
        <form id="kt_form" action="{{ route('fts.travel.order.update', $to->id) }}" method="POST">

            @csrf
            <div class="row">
  
              <div class="col-md-6">
  
                <div class="form-group">
                  <label for="">* Select Series #:</label> <br>
                  <input type="text" class="form-control" disabled value="{{ $to->document->seriesFull }}">
                </div>
              </div>
  
              <div class="col-md-6">
  
                <div class="form-group">
                  <label for="">* Requesting Office:</label> <br>
                  <select name="division" class="form-control select2" required style="width: 100%">
                      <option value="" hidden disabled selected></option>
                      @foreach($divisions as $division)
                        <option {{ sh($division->id, $to->document->division_id) }} value="{{ $division->id }}">{{ office_helper($division) }}</option>
                      @endforeach
                  </select>
                </div>
  
              </div>
  
            </div>


            {{-- INSERT YOUR FORM HERE --}}

            <div class="row">
  
                <div class="col-md-6">
    
                  <div class="form-group">
                    <label for="">Number:</label>
                    <input type="text" name="number" class="form-control" value="{{ $to->number }}">
                  </div>
                </div>
    
                <div class="col-md-6">
    
                  <div class="form-group">
                    <label for="">Date:</label>
                    <input type="date" name="date" class="form-control" value="{{ $to->date }}">
                  </div>
    
                </div>
    
            </div>


            <div id="kt_repeater">
                <div class="form-group row">
                    <div data-repeater-list="employees" class="col-lg-12">
                        @foreach($to->employees as $employee)
                        <div data-repeater-item="" class="form-group row align-items-center">
                            <div class="col-md-6">
                                <label>Employee:</label>
                                <input type="text" name="employee" class="form-control" value="{{ $employee['employee'] }}" />
                                <div class="d-md-none mb-2"></div>
                            </div>
                            <div class="col-md-5">
                                <label>Position:</label>
                                <input type="text" name="position" class="form-control" value="{{ $employee['position'] }}" />
                                <div class="d-md-none mb-2"></div>
                            </div>
                            <div class="col-md-1">
                                <a href="javascript:;" data-repeater-delete="" class="btn btn-sm font-weight-bolder btn-light-danger mt-5">
                                <i class="fal fa-times"></i></a>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <a href="javascript:;" data-repeater-create="" class="btn btn-sm font-weight-bolder btn-light-primary">
                        <i class="fal fa-plus"></i>Add</a>
                    </div>
                </div>

            </div>



            <div class="row">

                <div class="col-md-12">
    
                    <div class="form-group">
                      <label for="">Destination:</label>
                      <input type="text" name="destination" class="form-control" value="{{ $to->destination }}" required>
                    </div>
                </div>
  
                <div class="col-md-6">
    
                  <div class="form-group">
                    <label for="">Departure:</label>
                    <input type="date" name="departure" class="form-control" value="{{ $to->departure }}">
                  </div>
                </div>
    
                <div class="col-md-6">
    
                  <div class="form-group">
                    <label for="">Arrival:</label>
                    <input type="date" name="arrival" class="form-control" value="{{ $to->arrival }}">
                  </div>
    
                </div>
    
            </div>

            {{-- END YOUR FORM HERE --}}

            <div class="row">
  
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">* Purpose</label>
                        <textarea name="particulars" cols="30" rows="3" class="form-control">{{ $to->particulars }}</textarea>
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
                          <option {{ sh($liaison->id, $to->document->liaison_id) }} value="{{ $liaison->id }}">{{ name_helper($liaison->name) }}</option>
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
<script src="{{ asset('js/Modules/FileTracking/pages/forms/to/create.js') }}"></script>

@endsection