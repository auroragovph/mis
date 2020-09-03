@extends('filemanagement::layouts.app')

@section('page-title')
    Edit Obligation Request
@endsection

@section('breadcrumbs')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('fms.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('fms.documents.index') }}">Documents</a></li>
    <li class="breadcrumb-item"><a href="{{ route('fms.obr.index') }}">Obligation Request</a></li>
    <li class="breadcrumb-item active">Create</li>
</ol>
@endsection

@section('content')

<div class="row" id="obr-div-create">
    <div class="col-md-12">
        <div class="card card-default px-5 py-3">

            <form method="POST" action="{{ route('fms.obr.update', $document->id) }}">
                @csrf
                <h4>Obligation Request Details</h4>
                <hr>
                <div class="row">
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label for="">Payee</label>
                            <input name="payee" type="text" class="form-control" value="{{ $document->obligation_request->payee }}" required>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label for="">Address</label>
                            <input name="address" type="text" class="form-control" value="{{ $document->obligation_request->address }}" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label>Department Head Officer</label>
                            <select required name="dh" class="form-control select2" required>
                                <option value="" selected hidden></option>
                                @foreach($employees as $employee)
                                    <option {{ select_helper($employee->id, $document->obligation_request->dh_id) }} value="{{ $employee->id }}">{{ name_helper($employee) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label>Budget Officer</label>
                            <select required name="bo" class="form-control select2">
                                <option value="" selected hidden></option>
                                @foreach($employees as $employee)
                                    <option {{ select_helper($employee->id, $document->obligation_request->bo_id) }} value="{{ $employee->id }}">{{ name_helper($employee) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <hr class="">
                
                <h4 class="mt-10">Lists</h4>
                <hr>
                <div id="obr-create">
                    @foreach($document->obligation_request->lists as $list)
                <div class="row">
                    <div class="col-xl-3">
                        <div class="form-group">
                            <label>Responsibility Center</label>
                            <input type="text" name="rc[]" class="form-control" value="{{ $list->responsibility_center }}">

                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="form-group">
                            <label>FPP</label>
                            <input type="text" name="fpp[]" class="form-control" value="{{ $list->fpp }}">

                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="form-group">
                            <label>Acount Code</label>
                            <input type="text" name="ac[]" class="form-control" value="{{ $list->account_code }}" required>

                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="form-group">
                            <label>Amount</label>
                            <input type="number" name="amount[]" class="form-control" value="{{ $list->amount }}" step="0.01" required>

                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="form-group">
                            <label for="">Particulars</label>
                            <textarea name="particulars[]" rows="2" class="form-control" required>{{ $list->particulars }}</textarea>

                        </div>
                    </div>
                </div>
                @if($loop->first)
                    <hr>
                    @endif
                @endforeach
                </div>

                <button @click="addNewRow" type="button" class="btn btn-primary btn-sm mr-3"><i class="flaticon-add-circular-button"></i> Add New Row</button>
                <button @click="deleteLastRow" type="button" v-show="itemCount > 1" class="btn btn-warning btn-sm mr-3"><i class="flaticon-close"></i> Remove Last Row</button>

                <hr>
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

                <hr class="mt-3">

                <button type="submit" class="btn bg-gradient-success">Submit</button>


            </form>

            
            
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

<script src="{{ asset('js/filemanagement/obr-create.js') }}"></script>
@endsection