@extends('filetracking::layouts.app')

@section('page-title')
    Transmittal Release Form
@endsection


@section('content')
<div class="row">
    <div class="col-md-7">
        <div class="card p-1">
            <div class="card-header">
                <h3 class="card-title">Documents</h3>
            </div>
           <div class="card-body">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Series</th>
                        <th>Document Type</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transmits as $transmit)
                        <tr @if($transmit['error'] == true) class="bg-red" @endif>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $transmit['document']['series'] }}</td>
                            <td>{{ doc_type_only($transmit['document']['type']) }}</td>
                            <td>
                                @if($transmit['document']['status'] == '0')
                                    Cannot include in the transmittal. Document has been cancelled.
                                @endif

                                {{ $transmit['message'] }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
           </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card p-1">
            <div class="card-header">
                <h3 class="card-title">Documents</h3>
            </div>
           <div class="card-body">
                <form action="{{ route('fts.documents.transmittal.release.submit') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="">Receiving Office</label>
                        <select name="division" class="form-control select2">
                            @foreach(divisions() as $division)
                                <option value="{{ $division->id }}}">{{ office_helper($division) }}</option>
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
    $(".select2-tags").select2({tags: true});
    $(".select2").select2({});
});
</script>
    
@endsection