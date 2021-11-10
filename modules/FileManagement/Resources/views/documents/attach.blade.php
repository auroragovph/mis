@extends('layouts.master')


@section('page-title')
    Attach Document
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
                    <form method="POST" action="{{ route('fms.documents.attach.attach', $document->id) }}">
                        @csrf
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
    @else
        <div class="row">
            <div class="col-xl-12">
                <x-ui.card>
                    <form action="{{ route('fms.documents.attach.check') }}" method="POST"
                        x-data="{attachmentType: 'hardcopy'}">
                        @csrf

                        <x-ui.form.input label="Document ID" name="document" autofocus autocomplete="off" required />

                        <x-ui.form.select name="attachtype" label="Attachment Type" x-model="attachmentType">
                            <option value="hardcopy">Hardcopy Documents</option>
                            <option value="dynamic">Existing Form (Already encoded form)</option>
                            <option value="newform">Dynamic Attach Form (Encode New Document)</option>
                        </x-ui.form.select>

                        <div x-show="attachmentType == 'dynamic'">
                            <x-ui.form.select2 label="Document ID/s " class="select2-tags" multiple name="dynamic_ids" width=  />
                        </div>

                        <template x-if="attachmentType == 'newform' ">
                            <x-ui.form.select name="document_type_new_form" label="Document Type">
                                <option value="leave">Application For Leave</option>
                                <option value="cafoa">CAFOA</option>
                                <option value="purchase_request">Purchase Request</option>
                                <option value="purchase_order">Purchase Order</option>
                                <option value="travel_itinerary">Travel Itinerary</option>
                                <option value="travel_order">Travel Order</option>
                            </x-ui.form.select>
                        </template>


                        <hr>
                        <button class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
                    </form>
                </x-ui.card>
            </div>
        </div>
    @endisset

@endsection


@section('css-vendor')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
@endsection

@section('css-custom')
@endsection


@section('js-vendor')
    <!-- AlpineJS -->
    <script src="{{ asset('adminlte/plugins/alpine/alpine.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
@endsection

@section('js-custom')
    {{-- <script src="{{ asset('js/Modules/FileTracking/pages/documents/attachment.js') }}"></script> --}}
    <script>
        $(document).ready(function() {
            $('.select2-tags').select2({
                placeholder: "Select from the list",
                tags: true
            });
        });
    </script>
@endsection
