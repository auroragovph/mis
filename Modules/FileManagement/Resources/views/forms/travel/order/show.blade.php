@extends('layouts.master')


@section('page-title')
Travel Order
@endsection

@section('toolbar')
    @include('filemanagement::documents.general_action_button', [
        'qrcode' => $to->document->qr,
        'document_id' => $to->document->id
    ])
@endsection

@section('content')
<div class="row">
    <div class="col-xl-4">
        <x-fms-qr :document="$to->document" />

    </div>
    <div class="col-xl-8">

        <x-ui.card>
            <div class="table-responsive">
                <table class="table table-hover">
                    <tr>
                        <td><strong>TO No:</strong></td>
                        <td>{{ $to->number }}</td>
                        <td><strong>Destination: </strong></td>
                        <td>{{ $to->destination }}</td>
                    </tr>
    
                    <tr>
                        <td><strong>Departure:</strong></td>
                        <td>{{ Carbon\Carbon::parse($to->departure)->format('F d, Y') }}</td>
                        <td><strong>Arrival: </strong></td>
                        <td>{{ Carbon\Carbon::parse($to->departure)->format('F d, Y') }}</td>
                    </tr>
    
    
                    <tr>
                        <td><strong>Charging Office:</strong></td>
                        <td>{{ office_helper($to->charging) }}</td>
                        <td><strong>Approval Officer: </strong></td>
                        <td>{{ name_helper($to->approval->name ?? '') }}</td>
                    </tr>
    
                    <tr>
                        <td><strong>Purpose:</strong></td>
                        <td>{{ $to->purpose }}</td>
                        <td><strong>Special Instruction: </strong></td>
                        <td>{{ $to->instruction }}</td>
                    </tr>
    
                </table>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Employee</th>
                            <th>Position</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($to->lists as $list)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ name_helper($list->employee->name ?? []) }}</td>
                                <td>{{ $list->employee->position->position ?? '' }}</td>
                                <th></th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @include('filemanagement::forms.travel.order.buttons')



        </x-ui.card>

        <x-fms-attachments :attachments="$to->document->attachments" :forms="$to->document->forms" />


        
         
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
@endsection


