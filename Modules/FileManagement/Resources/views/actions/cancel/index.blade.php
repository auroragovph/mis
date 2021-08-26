@extends('filemanagement::layouts.master')



@section('page-title')
    Document Cancellation
@endsection

@section('content')
    <div class="row">
        <div class="col-md-7">
            <x-ui.card>
                <form action="{{ route('fms.documents.cancel.form') }}" method="GET">
                    @csrf

                    <x-ui.form.input label="Document QR" name="qrcode" autofocus required />
                    <button class="btn btn-primary"><x-ui.icon icon="search" /> Search</button>
                </form>
            </x-ui.card>
        </div>
        <div class="col-md-5">
          <x-ui.card title="Instructions" />
        </div>
    </div>
@endsection
