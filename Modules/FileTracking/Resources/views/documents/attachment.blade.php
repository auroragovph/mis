@extends('filetracking::layouts.app')

@section('page-title')
    Document Attachments
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

    <x-fts-qr size="sm-3" :document="$document['info']" :datas="$document['datas']" />

    <div class="col-sm-9">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-body">
                        <form method="POST" action="{{ route('fts.documents.attach.attach', $document['info']['id']) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="">Attachments</label>
                                <select class="form-control select2" multiple name="tags[]">


                                    <?php 
                                        $al = collect($document['attachments'])->pluck('description')->toArray();
                                    ?>

                                    @foreach($attachments->pluck('description') as $attachment)
                                        <option @if(in_array($attachment, $al)) selected @endif>{{ $attachment }}</option>
                                    @endforeach
                                </select>
                            </div>
            
                            <button class="btn btn-primary">Attach</button>
            
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card card-default">
                   <div class="card-body p-0">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($document['attachments'] as $attachment)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $attachment['description'] }}</td>
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
@else
<div class="row">
    <div class="col-12">
        <div id="attachment-card" class="card">
            <div class="card-body">
                <form action="{{ route('fts.documents.attach.check') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="">Series Number:</label>
                        <input name="series" type="text" class="form-control" autocomplete="off" required>
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
@endisset

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