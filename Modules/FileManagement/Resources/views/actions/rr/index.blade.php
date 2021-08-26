@extends('filemanagement::layouts.master')



@section('page-title')
Receive / Release
@endsection

@section('content')

<div class="row">
    <div class="col-md-6">
        <x-ui.card>
            <form action="{{ route('fms.documents.rr.form') }}" method="POST">
                @csrf

                <x-ui.form.input label="Document QR" type="text" name="document" value="{{ old('document') }}" required autofocus/>
                <x-ui.form.input label="Liaison QR" type="password" name="liaison" required />

                <button class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
            </form>
        </x-ui.card>
    </div>
    <div class="col-md-6">
      <x-ui.card title="Instructions" />
    </div>
</div>
@endsection
