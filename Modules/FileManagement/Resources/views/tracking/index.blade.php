@extends('layouts.master')


@section('page-title')
Document Tracker
@endsection

@section('toolbar')
@isset($document)

@include('filemanagement::tracking.action', [
    'type' => $document->type,
    'rel' => $rel
])

@endisset

@endsection

@section('content')

@isset($document)
<div class="row">
    <div class="col-xl-4">
        <x-fms-qr  :document="$document" :datas="$datas" />
    </div>

    <div class="col-xl-8">
        
        <x-ui.card title="Tracking Table">
            <table class="table table-hover table-sm table-bordered">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Office</th>
                        <th>Action</th>
                        <th>Remarks</th>
                        <th>Status</th>
                        <th>Clerk</th>
                        <th>Liaison</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tracks as $i => $track)
                        <tr>
                            <td>{{ Carbon\Carbon::parse($track->created_at)->format('F d, Y h:i A') }}</td>
                            <td>{{ office_helper($track->division, 'alias') }}</td>
                            <td>
                                @if($track->action == 1)
                                    <span class="btn-primary">RECEIVED</span>
                                @else 
                                    <span class="btn-success">RELEASED</span>
                                @endif
                            </td>
                            <td>{{ $track->purpose }}</td>
                            <td>{!! tracking_table_status($track->status) !!}</td>
                            <td>{{ name_helper($track->clerk->name) }}</td>
                            <td>
                                @if($track->liaison_id != 0)
                                {{ name_helper($track->liaison->name) }}
                                @endif
                            </td>
                            <td>
                                @if(!$loop->last)
                                    {{ get_date_diff($track->created_at, $tracks[$i+1]['created_at']) }}
                                @else 
                                    {{ get_date_diff($document->created_at, $tracks[$i]['created_at']) }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </x-ui.card>

        <x-fms-attachments :attachments="$document->attachments" />
    </div>
</div>
@else 
<div class="row">
    <div class="col-xl-12">
        <x-ui.card>
            <form action="{{ route('fms.documents.track') }}" method="GET">
                <x-ui.form.input label="Document ID" type="text" name="qr" value="{{ old('qr') }}" required autofocus autocomplete="off" />
                <hr>
                <button class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
            </form>
        </x-ui.card>
    </div>
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


