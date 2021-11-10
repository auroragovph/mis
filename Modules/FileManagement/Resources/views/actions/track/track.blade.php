@extends('filemanagement::layouts.master')



@section('page-title')
    Document Tracker
@endsection


@section('page-actions')
    @include('filemanagement::actions.track.buttons', [
        'type' => $document->type,
        'rel' => $rel
    ])
@endsection

@section('content')

    <div class="row row-cards">

        <div class="col-md-3">
            <x-fms-qr :document="$document" :datas="$datas" />
        </div>

        <div class="col-xl-9">

            <div class="row row-cards">
                <div class="col-12">
                    <x-ui.table.table title="Tracking Logs">
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
                            @foreach ($tracks as $i => $track)
                                <tr>
                                    <td>{{ Carbon\Carbon::parse($track->created_at)->format('F d, Y h:i A') }}</td>
                                    <td>{{ office_helper($track->division, 'alias') }}</td>
                                    <td>
                                        @if ($track->action == 1)
                                            <span class="btn-primary">RECEIVED</span>
                                        @else
                                            <span class="btn-success">RELEASED</span>
                                        @endif
                                    </td>
                                    <td>{{ $track->purpose }}</td>
                                    <td>{!! tracking_table_status($track->status) !!}</td>
                                    <td>{{ name_helper($track->clerk->name) }}</td>
                                    <td>
                                        @if ($track->liaison_id != 0)
                                            {{ name_helper($track->liaison->name) }}
                                        @endif
                                    </td>
                                    <td>
                                        @if (!$loop->last)
                                            {{ get_date_diff($track->created_at, $tracks[$i + 1]['created_at']) }}
                                            {{-- @else --}}
                                            {{-- {{ get_date_diff($document->created_at, $tracks[$i]['created_at']) }} --}}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </x-ui.table.table>
                </div>
                <div class="col-12">
            <x-fms-attachments :attachments="$document->attachments" :forms="$document->forms" />

                </div>
            </div>


        </div>
    </div>

@endsection
