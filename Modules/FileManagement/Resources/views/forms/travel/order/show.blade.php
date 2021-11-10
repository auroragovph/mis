@extends('filemanagement::layouts.master')



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
    <div class="row row-cards">
        <div class="col-md-3">
            <x-fms-qr :document="$to->document" />
        </div>
        <div class="col-md-9">
            <div class="row row-cards">
                <div class="col-12">
                    <x-ui.card title="Travel Details">
                        <x-slot name="actions">
                            @include('filemanagement::forms.travel.order.buttons')

                        </x-slot>
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
                    </x-ui.card>
                </div>
                <div class="col-12">
                    <x-ui.table.table title="Employees">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Position</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($to->employees as $employee)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $employee['name'] }}</td>
                                    <td>{{ $employee['position'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </x-ui.table.table>
                </div>
                <div class="col-12">
                    <x-fms-attachments :attachments="$to->document->attachments" :forms="$to->document->forms" />
                </div>
            </div>
        </div>
    </div>
@endsection
