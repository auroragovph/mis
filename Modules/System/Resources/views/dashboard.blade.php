@extends('layouts.system')

@section('action')
@endsection

@section('content')
<div class="row">
    <div class="col-md-3">
        <x-ui.widget.info title="CPU Usage" desc="40%" color="bg-danger" icon="fas fa-server" />
    </div>
    <div class="col-md-3">
        <x-ui.widget.info title="RAM Usage" desc="40%" icon="fas fa-microchip" />
    </div>
    <div class="col-md-3">
        <x-ui.widget.info title="Disk Usage" desc="40%" icon="fas fa-hdd" />
    </div>
    <div class="col-md-3">
        <x-ui.widget.info title="GPU Usage" desc="40%" icon="fas fa-desktop" />
    </div>
</div>
@endsection


@section('css-vendor')
@endsection

@section('css-custom')
@endsection


@section('js-vendor')
@endsection

@section('js-custom')
@endsection