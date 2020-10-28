@extends('filetracking::layouts.app')

@section('page-title')
    Edit Travel Order
@endsection

@section('breadcrumbs')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('fts.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('fts.documents.index') }}">Document</a></li>
    <li class="breadcrumb-item"><a href="{{ route('fts.travel.order.index') }}">Travel Order</a></li>
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
                <form id="form-create" action="{{ route('fts.travel.order.update', $document->id) }}" method="POST">
                    @csrf
                    <div class="row">
          
                      <div class="col-md-6">
          
                        <div class="form-group">
                          <label for="">Select Series #:</label>
                          <input type="text" value="{{ $document->seriesFull }}" readonly class="form-control">
                        </div>
                      </div>
          
                      <div class="col-md-6">
          
                        <div class="form-group">
                          <label for="">Requesting Office:</label> <br>
                          <select name="division" class="form-control select2" required style="width: 100%">
                              <option value="" hidden disabled selected></option>
                              @foreach($divisions as $division)
                                <option {{ sh($document->division_id, $division->id) }} value="{{ $division->id }}">{{ office_helper($division) }}</option>
                              @endforeach
                          </select>
                        </div>
          
                      </div>
          
                    </div>
                  
          
                    <div class="row">
          
                      <div class="col-md-6">
                          <div class="form-group">
                            <label for="">Number:</label>
                            <input value="{{ $document->travel_order->number }}" type="text" name="number" class="form-control">
                          </div>
                      </div>
          
                      <div class="col-md-6">
                          <div class="form-group">
                            <label for="">Date:</label>
                            <input value="{{ $document->travel_order->date }}" name="date" type="date" class="form-control" required>
                          </div>
            
                        </div>
                      
                    </div>
          
                    <div class="row">
          
                      <div class="col-md-6">
                          <div class="form-group">
                            <label for="">Employees:</label>
                            <select required name="employees[]" class="form-control people-select2" multiple name="tags[]" style="width: 100%">
                                @foreach($document->travel_order->employees as $employee)
                                    <option selected>{{ $employee }}</option>
                                @endforeach
                            </select>
                           
                          </div>
                      </div>
          
                      <div class="col-md-6">
                          <div class="form-group">
                            <label for="">Destination:</label>
                            <input value="{{ $document->travel_order->destination }}" name="destination" type="text" class="form-control" required>
                          </div>
            
                        </div>
                      
                    </div>
          
                    <div class="row">
          
                      <div class="col-md-6">
                          <div class="form-group">
                            <label for="">Departure:</label>
                            <input value="{{ $document->travel_order->departure }}" type="date" name="departure" class="form-control" required>
                          </div>
                      </div>
          
                      <div class="col-md-6">
                          <div class="form-group">
                            <label for="">Arrival:</label>
                            <input value="{{ $document->travel_order->arrival }}" type="date" name="arrival" class="form-control" required>
                          </div>
            
                        </div>
                      
                    </div>
          
                    <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label for="">Purpose</label>
                              <textarea name="purpose" cols="30" rows="2" class="form-control" required>{{ $document->travel_order->purpose }}</textarea>
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

    $(".people-select2").select2({tags: true});

}); 
</script>
@endsection