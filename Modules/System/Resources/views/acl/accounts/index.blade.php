@extends('system::layouts.master')


@section('page-title', 'Accounts')

@section('content')
<div class="row row-cards">
  <div class="col-md-8">
    <x-ui.card title="Accounts" />
  </div>
  <div class="col-md-4">
    <x-ui.card title="Create New Account" />
  </div>
</div>
@endsection
