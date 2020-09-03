@extends('filemanagement::layouts.app')

@section('page-title')
    Edit Travel Order
@endsection

@section('breadcrumbs')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('fms.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('fms.documents.index') }}">Documents</a></li>
    <li class="breadcrumb-item"><a href="{{ route('fms.travel.order.index') }}">Orders</a></li>
    <li class="breadcrumb-item active">Edit</li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-12"><div class="card card-default">
        <div class="card-body px-5 py-3">
            <form method="POST" action="{{ route('fms.travel.order.update', $document->id) }}">
                @csrf
                <h4>Travel Order Details</h4>
                <hr>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="form-group">
                            <label for="">Employees</label>
                            <select class="form-control select2" name="employees[]" multiple="multiple" required>
                                @foreach($employees as $employee)
                                <option {{ in_array_helper($employee->id, $document->travel_order->employees->pluck('employee_id')->toArray()) }} value="{{ $employee->id }}">{{ name_helper($employee) }} - {{ $employee->position }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label>Departure</label>
                            <input type="date" value="{{ $document->travel_order->departure }}" name="departure" class="form-control datepickerform" placeholder="Select a date" required />
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label>Arrival</label>
                            <input type="date" value="{{ $document->travel_order->arrival }}" name="arrival" class="form-control datepickerform" placeholder="Select a date" required />
                        </div>
                    </div>
                </div>
    
                <div class="row">
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label>Destination</label>
                            <input type="text" value="{{ $document->travel_order->destination }}" name="destination" class="form-control" required />
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label>Charging Office</label>
                            <select class="form-control select2" name="charging" required>
                                <option value="" selected hidden></option>
                                @foreach($divisions as $division)
                                    <option {{ select_helper($division->id, $document->travel_order->charging_id) }} value="{{ $division->id }}">{{ office_helper($division) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
    
    
    
                <div class="row">
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label>Purpose</label>
                            <textarea name="purpose" id="" cols="5" rows="3" class="form-control" required>{{ $document->travel_order->purpose }}</textarea>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label>Special Instruction</label>
                            <textarea name="instruction" id="" cols="5" rows="3" class="form-control">{{ $document->travel_order->instruction }}</textarea>
                        </div>
                    </div>
                </div>
    
                <div class="row">
                    <div class="col-xl-12">
                        <div class="form-group">
                            <label>Recommending Approval</label>
                            <select class="form-control select2" name="approval" required>
                                <option value="" selected hidden></option>
                                @foreach($employees as $employee)
                                    <option {{ select_helper($employee->id, $document->travel_order->approval_id) }} value="{{ $employee->id }}">{{ name_helper($employee) }}</option>

                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                
               <div class="separator separator-solid separator-border-2 separator-success mt-6"></div>
    
                @php($liaisons = $employee->where('liaison', 1))
                <h4 class="mt-10">Liaison Officer</h4>
                <hr>
                <div class="form-group">
                    <label for="">Select Employee:</label>
                    <select name="liaison" id="" class="form-control select2" required>
                        <option value="" hidden disabled selected></option>
                        <?php $liaisons = $employees->where('liaison', 1); ?>
                        @foreach($liaisons as $liaison)
                        <option {{ select_helper($liaison->id, $document->liaison_id) }} value="{{ $liaison->id }}">{{ name_helper($liaison) }}</option>
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