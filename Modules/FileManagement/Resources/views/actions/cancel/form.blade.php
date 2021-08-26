@extends('filemanagement::layouts.master')



@section('page-title')
Document Cancellation
@endsection

@section('content')
<div class="row">

  <div class="col-md-3">
      <x-fms-qr :document="$document" />
  </div>

  <div class="col-md-5">
      <x-ui.card>
          <form action="{{url()->full()}}" method="POST">
              @csrf
              <x-ui.form.text-area label="Reason for document cancellation" name="reason" required />
              <button type="submit" class="btn btn-danger">Cancel this document</button>
          </form>
      </x-ui.card>
  </div>

  <div class="col-md-4">
    <x-ui.card title="Instructions" />
  </div>
</div>
@endsection



