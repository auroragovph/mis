@extends('layouts.master')


@section('page-title')
    Attach Document
@endsection

@section('toolbar')
@endsection

@section('content')
        <div class="row">

            <div class="col-xl-4">
                <x-fms-qr :document="$document" />
            </div>

            <div class="col-xl-8">

                <x-ui.card>
                    <form method="POST" action="{{ route('fms.documents.attach.attach') }}">
                        @csrf


                        <input type="hidden" name="document_id" value="{{ $document->id }}">

                        <x-ui.form.input label="Name" type="text" name="name" value="{{ old('name') }}" required />
                        <x-ui.form.input label="File" type="file" name="file" />

                        <div class="row">
                            <div class="col-md-6">
                                <x-ui.form.input label="Number / Control Number" type="text" name="number" required />
                            </div>
                            <div class="col-md-6">
                                <x-ui.form.input label="Date" type="date" name="date" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <x-ui.form.input label="Amount" type="text" name="amount" />
                            </div>
                            <div class="col-md-6">
                                <x-ui.form.input label="Number of Page" type="number" name="page" />
                            </div>
                        </div>

                        <hr>

                        <button type="submit" class="btn btn-primary btn-shadow font-weight-bold mr-2">Attach</button>

                    </form>
                </x-ui.card>

                <x-fms-attachments :attachments="$document->attachments" />
            </div>
        </div>
@endsection


@section('css-vendor')

@endsection

@section('css-custom')
@endsection


@section('js-vendor')

@endsection

@section('js-custom')

@endsection
