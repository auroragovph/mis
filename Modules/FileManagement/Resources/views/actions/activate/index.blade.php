@extends('filemanagement::layouts.master')


@section('page-title', 'Activation')

@section('content')
<div class="row">
  <div class="col-md-6">
      <x-ui.card title="Form">
          <form action="{{ route('fms.documents.activation.submit') }}" method="POST">
              @csrf

              <x-ui.form.input label="Document ID" type="text" name="document" value="{{ old('document') }}" required autofocus />
              <x-ui.form.input label="Liaison QR" type="password" name="liaison" required />

              <button type="submit" class="btn btn-primary">
                <x-ui.widget.icon icon="search" />
                <i class="fas fa-search"></i> Search
              </button>
          </form>
      </x-ui.card>
  </div>

  <div class="col-md-6">
    <x-ui.card title="Instructions">
        
    </x-ui.card>
</div>
</div>
@endsection

