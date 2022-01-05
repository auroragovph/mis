@extends('fms::layouts.master')

@section('pretitle', 'Document')
@section('title', 'Receive / Release')

@section('content')
<div class="row row-cards">
  <div class="col-md-5">
      <x-ui.card title="Receive / Release Form">
          <form action="{{ route('fms.document.rr.form') }}" method="POST">
              @csrf

              <x-ui.form.input label="Document ID / Series" type="text" name="document" value="{{ old('document') }}" required autofocus autocomplete="off" />
              <x-ui.form.input label="Liaison QR" type="password" name="liaison" autocomplete="new-password" required />

              <button type="submit" class="btn btn-primary mt-2"><x-ui.icon icon="search" /> Search</button>
          </form>
      </x-ui.card>
  </div>
  <div class="col-md-7">
    <x-ui.card title="Instructions" />
  </div>
</div>

@endsection

