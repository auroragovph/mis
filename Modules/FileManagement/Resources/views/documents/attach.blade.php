@extends('filemanagement::layouts.app')


@section('page-title')
    Attachments
@endsection

@section('breadcrumbs')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('fms.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('fms.documents.index') }}">Documents</a></li>
    <li class="breadcrumb-item active">Attachments</li>
</ol>
@endsection

@section('content')
@if(!isset($document))
    <div class="row">
        <div class="col-12">
            <div id="attachment-card" class="card">
                <div class="card-body">
                    <form action="{{ route('fms.documents.attach.check') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="">Document QR</label>
                            <input name="document" type="text" class="form-control" autocomplete="off" required>
                        </div>
                        <hr>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"> <i class="fal fa-search"></i> Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@else 
<div class="row">

    <x-fms-qr size="sm-4" :document="$document" />


    <div class="col-sm-8">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-body">
                        <form method="POST" action="{{ route('fms.documents.attach.attach', $document->id) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="">Attach documents without image/pdf:</label>
                                <select class="form-control select2" multiple name="tags[]">
                                </select>
                            </div>
            
                            <div class="form-group">
                                <label for="">Attach documents with image/pdf:</label>
                                <input type="file" name="files[]" class="form-control" accept="image/*, .pdf" multiple>
                            </div>
            
                            <hr>
            
                            <button class="btn btn-primary">Attach</button>
            
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card card-default">
                   <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Description</th>
                                <th>Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($document->attachments as $attachment)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $attachment->description }}</td>
                                    <td>{{ $attachment->mime }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                   </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
@endif
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
<script>
        $(function () {
  //Initialize Select2 Elements
  $(".select2").select2({
  tags: true
});
});
    </script>
@endsection