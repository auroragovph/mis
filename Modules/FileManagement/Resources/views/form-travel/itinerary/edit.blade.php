@extends('filemanagement::layouts.app')

@section('page-title')
    
@endsection

@section('breadcrumbs')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('fms.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('fms.documents.index') }}">Documents</a></li>
    <li class="breadcrumb-item"><a href="{{ route('fms.travel.itinerary.index') }}">Itinerary</a></li>
    <li class="breadcrumb-item active">Create</li>
</ol>
@endsection

@section('content')
<div class="row" id="itinerary-div-create">
    <div class="col-12"><div class="card card-default">
        <div class="card-body px-5 py-3">
            <form method="POST" action="{{ route('fms.travel.itinerary.update', $document->id) }}">
                @csrf
                <h4>Itinerary of Travel Details</h4>
                <hr>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Employee</label>
                            <select name="employee" id="" class="form-control select2">
                                <option value="" hidden disabled selected></option>
                                @foreach($employees as $employee)
                                    <option {{ sh($employee->id, $itinerary->employee_id) }} value="{{ $employee->id }}">{{ name_helper($employee->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Fund</label>
                            <input type="text" name="fund" value="{{ $itinerary->fund }}" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Date of Travel</label>
                            <input type="date" name="date" value="{{ $itinerary->properties['date'] }}" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                       <div class="form-group">
                            <label for="">Purpose of Travel</label>
                            <input type="text" name="purpose" value="{{ $itinerary->properties['purpose'] }}" class="form-control">
                       </div>
                    </div>
                </div>

                <h4 class="mt-3">Lists</h4>
                <hr>

                <div id="itinerary-create">

                    @foreach($itinerary->lists as $list)
                    <div class="itinerary-list">
                        <div class="row">

                            <div class="col-md-6">
                            <div class="form-group">
                                    <label for="">Date</label>
                                    <input type="date" value="{{ $list['date'] }}" name="list-date[]" class="form-control">
                            </div>
                            </div>
    
                            <div class="col-md-6">
                            <div class="form-group">
                                    <label for="">Destination</label>
                                    <input type="text" value="{{ $list['destination'] }}" name="list-destination[]" class="form-control">
                            </div>
                            </div>
    
                        </div>
    
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Departure</label>
                                    <input type="text" value="{{ $list['departure'] }}" name="list-departure[]" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Arrival</label>
                                    <input type="text" value="{{ $list['arrival'] }}" name="list-arrival[]" class="form-control">
                                </div>
                            </div>
                        </div>
    
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Means of Transportation</label>
                                    <input type="text" value="{{ $list['means'] }}" name="list-means[]" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Transportation</label>
                                    <input type="text" value="{{ $list['trans'] }}" name="list-trans[]" class="form-control">
                                </div>
                            </div>
                        </div>
    
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Per diem</label>
                                    <input type="text" value="{{ $list['diem'] }}" name="list-diem[]" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Others</label>
                                    <input type="text" value="{{ $list['other'] }}" name="list-other[]" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Total Amount</label>
                                    <input type="text" value="{{ $list['amount'] }}" name="list-amount[]" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>

                <button @click="addNewRow" type="button" class="btn btn-primary btn-sm mr-3"><i class="flaticon-add-circular-button"></i> Add New Row</button>
                <button @click="deleteLastRow" type="button" v-show="itemCount > 1" class="btn btn-warning btn-sm mr-3"><i class="flaticon-close"></i> Remove Last Row</button>

                <h4 class="mt-3">Signatories</h4>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Supervisor</label>
                            <select name="supervisor" id="" class="form-control select2">
                                <option value="" hidden disabled selected></option>
                                @foreach($employees as $employee)
                                    <option {{ sh($employee->id, $itinerary->signatories['supervisor']) }} value="{{ $employee->id }}">{{ name_helper($employee->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Approval</label>
                            <select name="aprroval" id="" class="form-control select2">
                                <option value="" hidden disabled selected></option>
                                @foreach($employees as $employee)
                                    <option {{ sh($employee->id, $itinerary->signatories['approval']) }} value="{{ $employee->id }}">{{ name_helper($employee->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
    
             
    
                <h4 class="mt-3">Liaison Officer</h4>
                <hr>
                <div class="form-group">
                    <label for="">Select Employee:</label>
                    <select name="liaison" id="" class="form-control select2" required>
                        <option value="" hidden disabled selected></option>
                        @foreach($liaisons as $liaison)
                           <option {{ sh($liaison->id, $document->liaison_id) }} value="{{ $liaison->id }}">{{ name_helper($liaison->name) }}</option>
                        @endforeach
                    </select>
                </div>

                <hr>
    
                <button type="submit" class="btn bg-gradient-success">Submit</button>
    
            </form>
        </div>
        <!--end::Wizard-->
    </div></div>
</div>
@endsection




@section('css-vendor')
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<script src="{{ asset('plugins/vue/vue.js') }}"></script>
    
@endsection

@section('css-custom')
    
@endsection


@section('js-vendor')
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

    
@endsection

@section('js-custom')
<script src="{{ asset('js/filemanagement/itinerary-create.js') }}"></script>
@endsection