@extends('layouts.master')


@section('page-title')
Document Attach
@endsection

@section('toolbar')
@endsection

@section('content')

@isset($document)
<div class="row">

    <div class="col-xl-4">
        <x-fms-qr :document="$document" />
    </div>

    <div class="col-xl-8">

        <x-ui.card title="Attachment Form">
            <form id="kt_form" action="{{ route('fms.documents.attach.attach', $document->id) }}">

                <x-ui.form.input label="Name" type="text" name="name" value="{{ old('name') }}" required />
                <x-ui.form.input label="File" type="file" name="file" />


          
                <div class="row">
                    <div class="col-md-6">
                        <x-ui.form.input label="Number / Control Number" type="text" name="number" required/>
                    </div>
                    <div class="col-md-6">
                        <x-ui.form.input label="Date" type="date" name="date" required/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-ui.form.input label="Amount" type="text" name="amount"/>
                    </div>
                    <div class="col-md-6">
                        <x-ui.form.input label="Number of Page" type="number" name="page"/>
                    </div>
                </div>
            
                <hr>
            
                <button href="#" class="btn btn-primary btn-shadow font-weight-bold mr-2">Attach</button>

            </form>
        </x-ui.card>

        <x-fms-attachments :attachments="$document->attachments" />
    </div>
</div>
@else 
<div class="row">
    <div class="col-xl-12">
        <x-ui.card>
            <form action="{{ route('fms.documents.attach.check') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="">Document ID</label>
                    <input type="text" name="document" class="form-control" autofocus autocomplete="off">
                </div>
                <hr>
                <button class="btn btn-primary"><i class="flaticon2-magnifier-tool"></i> Search</button>
            </form>
        </x-ui.card>
    </div>
</div>
@endisset

@endsection


@section('css-vendor')
@endsection

@section('css-custom')
@endsection


@section('js-vendor')
@endsection

@section('js-custom')
<script src="{{ asset('js/Modules/FileTracking/pages/documents/attachment.js') }}"></script>
@endsection


