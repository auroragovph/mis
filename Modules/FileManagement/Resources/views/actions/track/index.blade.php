@extends('filemanagement::layouts.master')



@section('page-title')
Document Tracker
@endsection


@section('content')
<div class="row row-cards">
    <div class="col-md-5">
        <x-ui.card title="Tracker Form">
            <form action="{{ route('fms.documents.track') }}" method="GET">
                <x-ui.form.input label="Document ID" type="text" name="qrcode" value="{{ old('qrcode') }}" required autofocus autocomplete="off" />
                <button class="btn btn-primary mt-3"><x-ui.widget.icon icon="search" /> Search</button>
            </form>
        </x-ui.card>
    </div>
    <div class="col-md-7">
      <x-ui.card title="Instructions"/>
  </div>
</div>
@endsection

