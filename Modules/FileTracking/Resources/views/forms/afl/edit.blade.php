@extends('layouts.master')


@section('page-title')
Application For Leave
@endsection

@section('toolbar')
@endsection

@section('content')

<!--begin::Advance Table: Widget 7-->
<div class="card card-custom gutter-b" id="card-box" data-card="true" >
    <!--begin::Header-->
   <div class="card-header py-3">
        <div class="card-title align-items-start flex-column">
            <h3 class="card-label font-weight-bolder text-dark">Application for Leave</h3>
            <span class="text-muted font-weight-bold font-size-sm mt-1">Please fill up the form</span>
        </div>
    </div>
    <!--end::Header-->

    <!--begin::Body-->
    <div class="card-body">
        <form id="kt_form" action="{{ route('fts.afl.update', $afl->id) }}" method="POST">
            @csrf
            @method('put')
            <div class="row">
  
                <div class="col-md-6">
    
                  <div class="form-group">
                    <label for="">* Select Series #:</label> <br>
                    <input type="text" class="form-control" disabled value="{{ $afl->document->seriesFull }}">
                  </div>
                </div>
    
                <div class="col-md-6">
    
                  <div class="form-group">
                    <label for="">* Requesting Office:</label> <br>
                    <select name="division" class="form-control select2" required style="width: 100%">
                        <option value="" hidden disabled selected></option>
                        @foreach($divisions as $division)
                          <option {{ sh($division->id, $afl->document->division_id) }} value="{{ $division->id }}">{{ office_helper($division) }}</option>
                        @endforeach
                    </select>
                  </div>
    
                </div>
    
            </div>

            {{-- INSERT YOUR FORM HERE --}}

            <div class="row">
  
                <div class="col-md-6">
    
                  <div class="form-group">
                    <label for="">Name:</label>
                    <input type="text" class="form-control" name="name" value="{{ $afl->name }}" required>
                  </div>
                </div>
    
                <div class="col-md-6">
    
                  <div class="form-group">
                    <label for="">Position:</label>
                    <input type="text" class="form-control" name="position" value="{{ $afl->position }}" required>
                  </div>
    
                </div>
    
            </div>

            <div class="row">
  
                <div class="col-md-6">
    
                  <div class="form-group">
                    <label for="" class="mb-3">Select inclusive dates: </label>
                    <div id="datepicker">
                        @php
                            $raw_dates = collect($afl->inclusives['dates']);
                            $dates = $raw_dates->map(function($item){
                                return Carbon\Carbon::parse($item)->format('m/d/Y');
                            })->implode(',');
                        @endphp
                        <input type="hidden" name="inclusive" value="{{ $dates }}" required>
                    </div>
                  </div>

                </div>
    
                <div class="col-md-6">
    
                  <div class="form-group">
                    <label for="">Leave Type:</label>
                    <select name="type" class="form-control select2-type" style="width: 100%;">
                        <option {{ sh($afl->type, 'Vacation Leave') }} >Vacation Leave</option>
                        <option {{ sh($afl->type, 'Sick Leave') }}>Sick Leave</option>
                        <option {{ sh($afl->type, 'Force Leave') }}>Force Leave</option>
                        <option {{ sh($afl->type, 'Mandatory Leave') }}>Mandatory Leave</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="">Credits as Of:</label>
                    <input type="date" name="credits" class="form-control" required value="{{ $afl->credits }}">

                  </div>
    
                </div>
    
            </div>

            <div class="row">
  
                <div class="col-md-6">
    
                    <div class="form-group">
                        <label for="">Vacation:</label>
                        <input type="number" name="v1" class="form-control" value="{{ $afl->leave['vacation'][0] }}" required>
                    </div>

                    <div class="form-group">
                        <label for="">Vacation:</label>
                        <input type="number" name="v2" class="form-control" value="{{ $afl->leave['vacation'][1] }}" required>
                    </div>

                </div>
    
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Sick:</label>
                        <input type="number" name="s1" class="form-control" value="{{ $afl->leave['sick'][0] }}" required>
                    </div>
                    <div class="form-group">
                        <label for="">Sick:</label>
                        <input type="number" name="s2" class="form-control" value="{{ $afl->leave['sick'][1] }}" required>
                    </div>
                </div>
    
            </div>

            {{-- END YOUR FORM HERE --}}
  
            <div class="row">

              <div class="col-md-12">
                <div class="form-group">
                  <label for="">* Liaison Officer:</label> <br>
                  <select name="liaison" class="form-control select2" required style="width: 100%">
                      <option value="" hidden disabled selected></option>
                      @foreach($liaisons as $liaison)
                        <option {{ sh($liaison->id, $afl->document->liaison_id) }} value="{{ $liaison->id }}">{{ name_helper($liaison->name) }}</option>
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
<script src="{{ asset('js/Modules/FileTracking/pages/forms/afl/create.js') }}"></script>
@endsection