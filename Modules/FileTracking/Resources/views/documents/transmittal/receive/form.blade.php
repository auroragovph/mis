@extends('filetracking::layouts.app')

@section('page-title')
    Transmittal Receive Form
@endsection

@section('breadcrumbs')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('root.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Starter Page</li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card p-1">
            <div class="card-header">
                <h3 class="card-title">Series Lists</h3>
            </div>
           <div class="card-body">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Series</th>
                        <th>Document Type</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transmittal->documentsInfo as $document)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            
                            <td>
                                <a href="{{ route('fts.documents.track', ['series' => $document->series]) }}">{{ $document->seriesFull }}</a>
                            </td>

                            <td>{{ doc_type_only($document->type) }}</td>
                           
                        </tr>
                    @endforeach
                </tbody>
            </table>
           </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card p-1">
            <div class="card-header">
                <h3 class="card-title">Documents</h3>
            </div>
           <div class="card-body">
                <form action="{{ route('fts.documents.transmittal.receive.submit') }}" method="POST" autocomplete="off">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="">Purpose</label>
                        <input name="purpose" type="text" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="">Status</label>
                        <select name="status" id="" class="form-control select2" required>
                            @foreach(config('static-lists.documentStatusFTS') as $key => $status)
                                <option value="{{ $key }}">{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>

                    <hr>

                    <button class="btn bg-gradient-primary">Transmit</button>
                </form>
           </div>
        </div>
    </div>
    
</div>

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
        $(".select2").select2({});
    });
    </script>
@endsection