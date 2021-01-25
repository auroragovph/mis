@extends('layouts.master')


@section('page-title')
Transmittal
@endsection

@section('toolbar')
@endsection

@section('content')


<div class="row">
    <div class="col-md-8">
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Release Transmittal</h3>
                </div>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Series</th>
                            <th>Document Type</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transmittal->documentsInfo as $document)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $document->seriesFull }}</td>
                                <td></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Receiving Office</h3>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('fts.documents.transmittal.receive.submit') }}">
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
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-shadow font-weight-bold mr-2"><i class="fal fa-upload"></i> Receive Transmittal</button>
                    </div>
                </form>
            </div>
        </div>
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
<script src="{{ asset('js/Modules/FileTracking/pages/documents/transmittal.js') }}"></script>
@endsection


