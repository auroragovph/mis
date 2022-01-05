@extends('filemanagement::layouts.master')



@section('page-pretitle', 'Travels')
@section('page-title', 'Order')


@section('content')
    <div class="row row-cards">
        <div class="col-md-3">
            <x-fms-qr :series="$to->series" />
        </div>
        <div class="col-md-9">
            <div class="row row-cards">
                <div class="col-12">
                    <x-ui.card title="Travel Details">
                        <x-slot name="actions">
                            <div class="dropdown">
                                <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Actions
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">

                                    <li>
                                        <a href="{{ route('fms.travel.order.edit', $to->id) }}" class="dropdown-item">
                                            <x-ui.icon class="dropdown-item-icon" icon="pencil" /> Edit
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="dropdown-item">
                                            <x-ui.icon class="dropdown-item-icon" icon="printer" /> Print
                                        </a>
                                    </li>

                                    <h6 class="dropdown-header">Document</h6>

                                    <li>
                                        <a href="#" class="dropdown-item">
                                            <x-ui.icon class="dropdown-item-icon" icon="search" /> Track
                                        </a>
                                    </li>




                                </ul>
                            </div>
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
                                    <td>{{ $to->departure->format('F d, Y') }}</td>
                                    <td><strong>Arrival: </strong></td>
                                    <td>{{ $to->departure->format('F d, Y') }}</td>
                                </tr>


                                <tr>
                                    <td><strong>Charging Office:</strong></td>
                                    <td>{{ office($to->charging) }}</td>
                                    <td><strong>Approval Officer: </strong></td>
                                    <td>{{ $to->signatories['approval']['name'] }}</td>
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
                    <x-ui.table.regular title="Employees">
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

                    <x-fms-attachments :attachments="$to->series->attachments" :forms="$to->series->forms" />
                </div>
            </div>
        </div>
    </div>
@endsection
