@extends('layouts.horizontal', [
    'module_title' => 'File Tracking - Kiosk Page'
])

@section('content')


<form action="{{ route('fts.documents.kiosk') }}">
    <div class="form-group">
        <label for="">Series Number:</label>
        <input type="text" class="form-control" name="series" required autofocus>
    </div>
    <button type="submit" class="btn bg-gradient-primary"> <i class="fal fa-search"></i> Track</button>
</form>


@isset($document)
<hr>
<div class="row">
    <x-fts-qr size="sm-3" :document="$document['info']" :datas="$document['datas']"/>
    <x-fts-tracking-table size="sm-9" :tracks="$document['tracks']"/>
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