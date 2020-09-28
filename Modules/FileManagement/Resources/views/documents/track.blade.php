@extends('filemanagement::layouts.app')


@section('page-title')
    Tracking Page
@endsection

@section('breadcrumbs')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('fms.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('fms.documents.index') }}">Documents</a></li>
    <li class="breadcrumb-item active">Tracking Page</li>
</ol>
@endsection

@section('content')



@isset($document)
<div class="row">

    <x-fms-qr size="sm-3" :document="$document" :datas="$datas" />

    <x-fms-tracking-table size="sm-9" :tracks="$tracks" :document="$document" />
    

    
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