@extends('system::layouts.master')


@section('page-title', 'Dashboard')

@section('content')
<div class="row gx-lg-4">

    @include('system::profile.toolbar')
    
    <div class="col-lg-9">
        @includeIf('system::profile.tabs.'.$tab)
    </div>
    
  </div>
@endsection

