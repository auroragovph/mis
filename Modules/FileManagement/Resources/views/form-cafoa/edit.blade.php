@extends('filemanagement::layouts.app', ['module_side_bar' => 'filemanagement::layouts.sidebar'])

@section('page-title')
    Create CAFOA
@endsection

@section('breadcrumbs')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('fms.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('fms.documents.index') }}">Documents</a></li>
    <li class="breadcrumb-item"><a href="{{ route('fms.cafoa.index') }}">CAFOA</a></li>
    <li class="breadcrumb-item active">Create</li>
</ol>
@endsection

@section('content')
<div class="row" id="app-root">
    <div class="col-md-12">
        <div class="card card-default px-5 py-3">
            <form action="{{ route('fms.cafoa.update', $document->id) }}" method="POST">
                @csrf
                <h4>CAFOA Details</h4>
                <hr>

                @if($document->cafoa->number != null)
                <div class="form-group">
                    <label for="">Obligation Number:</label>
                    <input name="number" type="text" class="form-control" required value="{{ $document->cafoa->number }}">
                </div>
                @endif
                
                <div class="form-group">
                    <label for="">Payee</label>
                    <input name="payee" type="text" class="form-control" required value="{{ $document->cafoa->payee }}">
                </div>
                <div class="form-group">
                    <label for="">Requesting Officer</label>
                    <select name="requesting" class="form-control select2">
                        <option value=""></option>
                        <?php $requestings = $employees->where('division_id', Auth::user()->employee->division_id); ?>
                        @foreach($requestings as $requesting)
                            <option value="{{ $requesting->id }}" {{ sh($requesting->id, $document->cafoa->requesting_id) }}>{{ name_helper($requesting->name) }}</option>
                        @endforeach
                    </select>
                </div>

                <hr>
                <h4 class="mt-10">Lists</h4>
                <hr>
                <div id="cafoa-row">
                    @foreach($document->cafoa->lists as $list)
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Function</label>
                                <input type="text" name="func[]" class="form-control" value="{{ $list['function'] }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Allotment Class</label>
                                <input type="text" name="ac[]" class="form-control" value="{{ $list['allotment'] }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Expense Code</label>
                                <input type="text" name="ec[]" class="form-control" value="{{ $list['expense'] }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Amount</label>
                                <input type="number" step="0.01" name="amount[]" class="form-control" value="{{ $list['amount'] }}">
                            </div>
                        </div>
                    </div>
                    <hr>
                    @endforeach
                </div>

                <button @click="addNewRow" type="button" class="btn btn-primary btn-sm mr-3"><i class="flaticon-add-circular-button"></i> Add New Row</button>
                <button @click="deleteLastRow" type="button" v-show="itemCount > 1" class="btn btn-warning btn-sm mr-3"><i class="flaticon-close"></i> Remove Last Row</button>
                

                
                <hr>
                <h4 class="mt-10">Signatories</h4>
                <hr>

                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Budget</label>
                            <select name="budget" class="form-control select2">
                                <option value=""></option>
                                <?php $budgets = $employees->where('division_id', 5); ?>
                                @foreach($budgets as $budget)
                                    <option value="{{ $budget->id }}" {{ sh($budget->id, $document->cafoa->signatories['budget']['id']) }}>{{ name_helper($budget->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Treasury</label>
                            <select name="treasury" class="form-control select2">
                                <option value=""></option>
                                <?php $treasuries =  $employees->where('division_id', 4); ?>
                                @foreach($treasuries as $treasury)
                                    <option value="{{ $treasury->id }}" {{ sh($treasury->id, $document->cafoa->signatories['treasury']['id']) }}>{{ name_helper($treasury->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Accountant</label>
                            <select name="accounting" class="form-control select2">
                                <option value=""></option>
                                <?php $accountants = $employees->where('division_id', 7); ?>
                                @foreach($accountants as $accountant)
                                    <option value="{{ $accountant->id }}" {{ sh($accountant->id, $document->cafoa->signatories['accounting']['id']) }}>{{ name_helper($accountant->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                </div>

                
                <hr>

                <h4 class="mt-10">Liaison Officer</h4>
                <hr>
                <div class="form-group">
                    <label for="">Select Employee:</label>
                    <select name="liaison" id="" class="form-control select2" required>
                        <option value="" hidden disabled selected></option>
                        <?php $liaisons = $employees->where('liaison', 1)->where('division_id', Auth::user()->employee->division_id); ?>
                        @foreach($liaisons as $liaison)
                           <option value="{{ $liaison->id }}" {{ sh($liaison->id, $document->liaison_id) }}>{{ name_helper($liaison->name) }}</option>
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

<script src="{{ asset('js/filemanagement/form-cafoa-create.js') }}"></script>
@endsection