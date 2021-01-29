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
                        @foreach($transmits as $transmit)
                        <tr @if($transmit['error'] == true) class="bg-danger" @endif>
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
    <div class="col-md-4">
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Receiving Office</h3>
                </div>
            </div>
            <div class="card-body">
                <?php $errCount = $transmits->where('error', false)->count(); ?>

                @if($errCount !== 0)

                    <form method="POST" action="{{ route('fts.documents.transmittal.form.release') }}">
                        @csrf
                        <div class="form-group">
                            <label for="">Office</label>
                            <select name="division" class="form-control select2" required>
                                <option value=""></option>
                                @foreach($divisions as $division)
                                    <option value="{{ $division->id }}">{{ office_helper($division) }}</option>
                                @endforeach
                            </select>                        
                        </div>
                        <hr>
                        <div class="form-group">
                            
                            <button type="submit" class="btn btn-primary btn-shadow font-weight-bold mr-2"><i class="fal fa-upload"></i> Release</button>
                        </div>
                    </form>

                @else 
                    
                    <h3 class="h3">You can only release document at least one.</h3>

                @endif
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


