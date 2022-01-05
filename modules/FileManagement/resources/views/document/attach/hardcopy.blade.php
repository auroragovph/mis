@extends('fms::layouts.master')


@section('pretitle', 'Document')
@section('title', 'Attachments')

@section('content')
    <div class="row row-cards">

        <div class="col-md-3">
            <x-fms-qr :series="$document" />

        </div>

        <div class="col-xl-9">

            <div class="row row-cards">
                <div class="col-md-7">
                    <x-ui.card title="Attachment Form">
                        <form method="POST" action="{{ route('fms.document.attach.attach') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="document_id" value="{{ $document->id }}">

                            <x-ui.form.input label="Name" type="text" name="name" value="{{ old('name') }}" required />
                            <x-ui.form.input label="File" type="file" name="file" />

                            <div class="row">
                                <div class="col-md-6">
                                    <x-ui.form.input label="Number / Control Number" type="text" name="number" />
                                </div>
                                <div class="col-md-6">
                                    <x-ui.form.input label="Date" type="date" name="date" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <x-ui.form.input label="Amount" type="number" step="0.01" name="amount" />
                                </div>
                                <div class="col-md-6">
                                    <x-ui.form.input label="Number of Page" type="number" name="page" />
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <x-ui.icon icon="paperclip" />
                                Attach
                            </button>

                        </form>
                    </x-ui.card>
                </div>
                <div class="col-md-5">
                    <x-ui.card title="Instructions" />
                </div>
                <div class="col-12">
                    <x-fms-attachments :attachments="$document->attachments" :forms="$document->forms" />
                </div>
            </div>

        </div>
    </div>
@endsection
