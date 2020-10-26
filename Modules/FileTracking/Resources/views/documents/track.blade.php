@extends('filetracking::layouts.app')

@section('page-title')
    Tracking Page
@endsection

@section('breadcrumbs')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('fts.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Starter Page</li>
</ol>
@endsection

@section('content')
@isset($document)

<div class="row">
    <x-fts-qr size="sm-3" :document="$document" :datas="$datas" />

    <x-fts-tracking-table size="sm-9" :tracks="$tracks"/>

</div>

@endisset
@endsection




@section('css-vendor')
    
@endsection

@section('css-custom')
    
@endsection


@section('js-vendor')
    
@endsection

@section('js-custom')
    
@endsection