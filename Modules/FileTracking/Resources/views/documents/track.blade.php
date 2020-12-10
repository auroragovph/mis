@extends('filetracking::layouts.app')

@section('page-title')
    Tracking Page
@endsection

@section('breadcrumbs')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('fts.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Tracking Page</li>
</ol>
@endsection

@section('content')


<div class="row">
    <div class="col-12">
        <div class="card card-custom" data-card="true" id="activate-card">
            <div class="card-body p-10">
                <form action="{{ route('fts.documents.track') }}" method="GET">
                    <div class="form-group">
                        <label for="">Series Number</label>
                        <input type="text" name="series" class="form-control" autofocus required autocomplete="off" value="{{ request()->get('series') }}">
                    </div>
                   
                    <hr>
                    <button type="submit" class="btn bg-gradient-primary"><i class="fal fa-search"></i> Track</button>
                </form>
            </div>
        </div>
    </div>
</div>


@isset($document)



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