@extends('filemanagement::layouts.app')

@section('page-title')
    Create Purchase Request
@endsection

@section('breadcrumbs')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('fms.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Starter Page</li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div id="procurement-request-create" class="card card-default px-5 py-3">
            <div class="card-body ">
                <form method="POST" action="{{ route('fms.procurement.request.store') }}">
                    @csrf
                    <h4>Purchase Request Details</h4>
                    <hr>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label>Requesting Officer</label>
                                <select name="requesting" class="form-control select2" required data-size="5" data-live-search="true">
                                    <option value="" selected hidden></option>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ name_helper($employee) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label>Charging Office</label>
                                <select name="charging" class="form-control select2">
                                    <option value="" selected hidden></option>
                                    @foreach($divisions as $division)
                                        <option value="{{ $division->id }}">{{ office_helper($division) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Purpose</label>
                        <textarea name="purpose" rows="3" class="form-control" required></textarea>
                    </div>
                    <div class="separator separator-solid separator-border-2 separator-success"></div>
                    <h4 class="mt-10">Lists</h4>
                    <hr>
                    <div id="pr-create">
                    <div class="row">
                        <div class="col-xl-3">
                            <div class="form-group">
                                <label>Stock Number</label>
                                <input type="text" name="stock[]" class="form-control">
                            </div>
                        </div>
                        <div class="col-xl-3">
                            <div class="form-group">
                                <label>Unit</label>
                                <input type="text" name="unit[]" class="form-control">
                            </div>
                        </div>
                        <div class="col-xl-3">
                            <div class="form-group">
                                <label>Quantity</label>
                                <input type="number" name="qty[]" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-xl-3">
                            <div class="form-group">
                                <label>Item Cost</label>
                                <input type="number" name="cost[]" class="form-control" step="0.01" required>
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label for="">Item Description</label>
                                <textarea name="desc[]" rows="2" class="form-control" required></textarea>
                            </div>
                        </div>
                    </div>
                    </div>

                    <button @click="addNewRow" type="button" class="btn btn-primary btn-sm mr-3"><i class="flaticon-add-circular-button"></i> Add New Row</button>
                    <button @click="deleteLastRow" type="button" v-show="itemCount > 1" class="btn btn-warning btn-sm mr-3"><i class="flaticon-close"></i> Remove Last Row</button>

                    <hr>

                    @php($liaisons = $employee->where('liaison', 1))
                    <h4 class="mt-10">Liaison Officer</h4>
                    <hr>
                    <div class="form-group">
                        <label for="">Select Employee:</label>
                        <select name="liaison" class="form-control select2" required>
                            <option value="" hidden disabled selected></option>
                            <?php $liaisons = $employees->where('liaison', 1); ?>
                            @foreach($liaisons as $liaison)
                               <option value="{{ $liaison->id }}">{{ name_helper($liaison) }}</option>
                            @endforeach
                        </select>
                    </div>

                   <hr>

                   <button type="submit" class="btn bg-gradient-success">Submit</button>


                </form>
            </div>
            <!--end::Wizard-->
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
<script src="{{ asset('plugins/vue/vue.js') }}"></script>
@endsection

@section('js-custom')
<script src="{{ asset('js/filemanagement/pr-create.js') }}"></script>
    
@endsection