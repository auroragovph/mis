@extends('filetracking::layouts.app')

@section('page-title')
    Edit CAFOA
@endsection

@section('breadcrumbs')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('fts.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('fts.documents.index') }}">Document</a></li>
    <li class="breadcrumb-item"><a href="{{ route('fts.cafoa.index') }}">CAFOA</a></li>
    <li class="breadcrumb-item active">Edit</li>
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
                <form id="form-create" action="{{ route('fts.afl.update', $document->id) }}" method="POST">
                    @csrf
                    <div class="row">
          
                      <div class="col-md-6">
          
                        <div class="form-group">
                          <label for="">Select Series #:</label> <br>
                          <input type="text" class="form-control" value="{{ $document->seriesFull }}" readonly>
                        </div>
                      </div>
          
                      <div class="col-md-6">
          
                        <div class="form-group">
                          <label for="">Requesting Office:</label> <br>
                          <select name="division" class="form-control select2" required style="width: 100%">
                              <option value="" hidden disabled selected></option>
                              @foreach($divisions as $division)
                                <option {{ sh($division->id, $document->division_id) }} value="{{ $division->id }}">{{ office_helper($division) }}</option>
                              @endforeach
                          </select>
                        </div>
          
                      </div>
          
                    </div>
                  
          
                    <div class="row">
          
                      <div class="col-md-6">
                          <div class="form-group">
                            <label for="">Name:</label>
                            <input type="text" name="name" class="form-control" required value="{{ $document->afl->name }}">
                          </div>
                      </div>
          
                      <div class="col-md-6">
                          <div class="form-group">
                            <label for="">Position:</label>
                            <input name="position" type="text" class="form-control" required value="{{ $document->afl->position }}">
                          </div>
            
                        </div>
                      
                    </div>
          
          
          
                    <div class="row">
          
                      
                      <div class="col-md-6">
                        <label for="" class="mb-3">Select inclusive dates: </label>
                          <div id="datepicker">
                                @php
                                    $raw_dates = collect($document->afl->inclusives);

                                    $dates = $raw_dates->map(function($item){
                                        if(is_date($item) == false){
                                          return '01-01-2020';
                                        }
                                        return @Carbon\Carbon::parse($item)->format('m/d/Y');
                                    })->implode(',');
                                @endphp
                              <input type="hidden" name="inclusive" required value="{{ $dates }}">
                          </div>
                      </div>
          
          
                      <div class="col-md-6">
          
                        <div class="row">
          
                          <div class="col-md-12">
                            <div class="form-group">
                              <label for="">Leave Type:</label> <br>
                              <select name="type" class="form-control select2-type" style="width: 100%;">
                                <option {{ sh($document->afl->type, 'Vacation Leave') }} >Vacation Leave</option>
                                <option {{ sh($document->afl->type, 'Sick Leave') }}>Sick Leave</option>

                                @if($document->afl->type != 'Vacation Leave' || $document->afl->type != 'Sick Leave')
                                    <option selected>{{ $document->afl->type }}</option>
                                @endif
                              </select>
                            </div>
                          </div>
          
                          <div class="col-md-12">
                            <div class="form-group">
                              <label for="">Credits:</label>
                              <input type="date" name="credits" class="form-control" required value="{{ $document->afl->credits }}">
                            </div>
                          </div>
          
                        </div>
          
          
                          
                      </div>
          
                    </div>
          
                    <div class="row mt-3">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Vacation:</label>
                          <input type="number" name="v1" class="form-control" required value="{{ $document->afl->leave['vacation'][0] }}">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Sick:</label>
                          <input type="number" name="s1" class="form-control" required value="{{ $document->afl->leave['sick'][0] }}">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Vacation:</label>
                          <input type="number" name="v2" class="form-control" required value="{{ $document->afl->leave['vacation'][1] }}">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Sick:</label>
                          <input type="number" name="s2" class="form-control" required value="{{ $document->afl->leave['sick'][1] }}">
                        </div>
                      </div>
                    </div>
          
                   
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="">Liaison Officer:</label> <br>
                          <select name="liaison" class="form-control select2" required style="width: 100%">
                              <option value="" hidden disabled selected></option>
                              @foreach($liaisons as $liaison)
                                <option {{ sh($liaison->id, $document->liaison_id) }} value="{{ $liaison->id }}">{{ name_helper($liaison->name) }}</option>
                              @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                    
                    <hr>
          
                    <button class="btn bg-gradient-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection




@section('css-vendor')
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}">
    
@endsection

@section('css-custom')
    
@endsection


@section('js-vendor')
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    
@endsection

@section('js-custom')
<script>
$(function () {
    $(".select2").select2({
        placeholder: "Select from list"
    });

    $(".select2-type").select2({
        tags: true
      });

      $('#datepicker').datepicker({
        multidate: true,
        clearBtn: true,
      });
}); 
</script>
@endsection