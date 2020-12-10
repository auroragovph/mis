@extends('filetracking::layouts.app')

@section('page-title')
    Transmittal Release
@endsection


@section('content')
<div class="row">
    <div class="col-12">
        <div class="card p-3">
            <form id="form-number" method="POST" action="{{ route('fts.documents.transmittal.release.form') }}">
                @csrf
                <div class="form-group">
                    <label for="">Document QR</label>
                    <select name="qrs[]" class="form-control select2-tags" multiple style="width: 100%">
                    </select>
                </div>
                <hr>
                <div class="form-group">
                    <button class="btn bg-gradient-primary">
                        <i class="fal fa-search"></i> Search
                    </button>
                </div>
            </form>
            
        </div>
    </div>
</div>

@include('filetracking::documents.transmittal.list', [
    'transmittals' => $transmittals
])
@endsection


@section('css-vendor')
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    
@endsection

@section('css-custom')
    
@endsection


@section('js-vendor')
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    
@endsection

@section('js-custom')

@if(session('fts.transmittal.uuid'))
<script>
    window.open('{{ session("fts.transmittal.uuid") }}', '_blank');
</script>
@endif

<script>
$(function () {
    $(".select2-tags").select2({tags: true});
});
</script>
    
@endsection