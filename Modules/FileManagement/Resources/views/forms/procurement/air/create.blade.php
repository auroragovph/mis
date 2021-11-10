@extends('layouts.master')


@section('page-title', 'Create Inspection and Acceptance')

@section('action')
@endsection

@section('content')
<x-ui.card>
    <form action="{{ route('fms.procurement.air.store') }}" method="POST">
        
        @csrf

        <input type="hidden" value="{{ $po->document_id }}" name="document_id" />
        <input type="hidden" value="{{ $po->id }}" name="po_id" />
        
       <div class="row">
           <div class="col-md-6" style="border-right: 1px solid #e1e5ea;">
                <x-ui.form.input label="Supplier" value="{{ $po->supplier['firm'] ?? '' }}" readonly />
                <x-ui.form.input label="PO Number" value="{{ $po->number }}" readonly />
           </div>

           <div class="col-md-6">
                <x-ui.form.input label="AIR Number" name="number" required />

                <div class="row">
                    <div class="col-md-6">
                        <x-ui.form.input label="Invoice Number" name="invoice_number" required />
                    </div>
                    <div class="col-md-6">
                        <x-ui.form.input label="Date" type="date" name="invoice_date" required />
                    </div>
                </div>
            </div>
       </div>

       

        <hr>
        <h6>Receivable Items</h6>

        @foreach($po->lists as $list)
            <div class="row">
                <div class="col-md-2">
                    <x-ui.form.input label="Stock No." readonly value="{{ $list['stock'] }}" />
                </div>
                <div class="col-md-4">
                    <x-ui.form.input label="Description" readonly value="{{ $list['description'] }}" />
                </div>
                <div class="col-md-2">
                    <x-ui.form.input label="Unit" value="{{ $list['unit'] }}" readonly />
                </div>
                <div class="col-md-2">
                    <x-ui.form.input label="Quantity" value="{{ $list['quantity'] }}" readonly />
                </div>
                <div class="col-md-2">
                    <x-ui.form.input label="Receive Quantity" type="number" name="lists[]" max="{{ $list['quantity'] }}" required />
                </div>
            </div>
        @endforeach

        <hr>

        <button class="btn bg-gradient-primary">Submit</button>


    </form>
</x-ui.card>
@endsection


@section('css-vendor')
@endsection

@section('css-custom')
@endsection


@section('js-vendor')
@endsection

@section('js-custom')
@endsection