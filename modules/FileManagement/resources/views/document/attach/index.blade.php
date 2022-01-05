@extends('fms::layouts.master')

@section('pretitle', 'Document')
@section('title', 'Attachments')

@section('content')
<div class="row">
    <div class="col-md-7">
        <x-ui.card title="Attachment Form">
            <form action="{{ route('fms.document.attach.check') }}" method="POST"
                x-data="{attachmentType: 'hardcopy'}">
                @csrf

                <x-ui.form.input label="Document ID" name="document" autofocus autocomplete="off" required />

                <x-ui.form.select name="attachtype" label="Attachment Type" x-model="attachmentType">
                    <option value="hardcopy">Hardcopy Documents</option>
                    <option value="dynamic">Existing Form (Already encoded form)</option>
                    <option value="newform">Dynamic Attach Form (Encode New Document)</option>
                </x-ui.form.select>

                <div x-show="attachmentType == 'dynamic'">
                    <x-ui.form.tag label="Document ID/s " name="dynamic_ids" />
                </div>

                <template x-if="attachmentType == 'newform' ">
                    <x-ui.form.select name="document_type_new_form" label="Document Type">
                        <option value="leave">Application For Leave</option>
                        <option value="cafoa">CAFOA / OBR</option>
                        <option value="purchase_request">Purchase Request</option>
                        <option value="purchase_order">Purchase Order</option>
                        <option value="travel_itinerary">Travel Itinerary</option>
                        <option value="travel_order">Travel Order</option>
                    </x-ui.form.select>
                </template>

                <button type="submit" class="btn btn-primary">
                   <x-ui.icon icon="search" /> Search
                </button>
            </form>
        </x-ui.card>
    </div>
    <div class="col-md-5">
        <x-ui.card title="Instructions" />
    </div>
</div>
@endsection

@push('js-lib')
    <script defer src="/libs/alpine/alpine.min.js"></script>
@endpush
