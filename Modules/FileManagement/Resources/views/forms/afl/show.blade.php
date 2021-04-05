@extends('layouts.master')


@section('page-title')
Application For Leave
@endsection

@section('toolbar')

@include('filemanagement::forms.afl.action')

@endsection

@section('content')
<div class="row">
    <div class="col-xl-4">
        <x-fms-qr :document="$afl->document" />
    </div>
    <div class="col-xl-8">

        <x-ui.card title="AFL Details">

            <div class="table-responsive">
                <table class="table table-hover">
                    <tr>
                        <td><strong>Employe:</strong></td>
                        <td colspan="3">{{ name_helper($afl->employee->name) }}</td>
                    </tr>
                    @switch($afl->properties['type'])
    
                        @case('Vacation')
                        
                                <tr>
                                    <td><strong>Leave Type:</strong></td>
                                    <td>Vacation</td>
                                    <td><strong>Reason:</strong></td>
                                    <td>
                                        @if($afl->properties['details']['reason'] == 'tse')
                                            To seek employment
                                        @else 
                                            {{ $afl->properties['details']['reason'] }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Where leave will be spent:</strong></td>
                                    <td colspan="3">
                                        @if($afl->properties['details']['place'] == 'ph')
                                            Within the Philippines
                                        @else 
                                            {{ $afl->properties['details']['place'] }}
                                        @endif
                                    </td>
                                </tr>
                        
                        @break 
    
                        @case('Sick')
                        
                                <tr>
                                    <td><strong>Leave Type:</strong></td>
                                    <td>Sick</td>
                                    <td><strong>Hospital:</strong></td>
                                    <td>{{ $afl->properties['details'] }}</td>
                                </tr>
                                
                        
                        @break
    
    
                        @default 
                            <tr>
                                <td><strong>Leave Type:</strong></td>
                                <td colspan="3">
                                    @if($afl->properties['details'] == null)
                                        {{ $afl->properties['type'] }}
                                    @else 
                                        {{ $afl->properties['details'] }}
                                    @endif
                                </td>
                           
                            </tr>
                        @break
    
                        
    
                    @endswitch
                    
                    <tr>
                        <td><strong>Inclusive Dates:</strong></td>
                        <td colspan="3">
                            @foreach($afl->inclusives as $date)
                                {{ Carbon\Carbon::parse($date)->format('F d, Y') }} <br>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Commutation:</strong></td>
                        <td colspan="3">
                            @if($afl->properties['commutation'])
                                Requested
                            @else 
                                Not Requested
                            @endif
                        </td>
                    </tr>
    
                </table>
            </div>

            <h5 class="mt-3">Application Details of Action</h5>
            <hr>

            <div class="row">
                <div class="col-md-6">
                    <p><strong>Certification of Leave Credits as of:</strong> <br> {{ Carbon\Carbon::parse($afl->credits['as-of'])->format('F d, Y') }}</p>
                    <table class="table table-sm table-bordered text-center">
                        <thead>
                            <tr>
                                <th>Vacation</th>
                                <th>Sick</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $afl->credits['vacation'][0] }}</td>
                                <td>{{ $afl->credits['sick'][0] }}</td>
                                <td>{{ $afl->credits['vacation'][0] + $afl->credits['sick'][0]}}</td>
                            </tr>
                            <tr>
                                <td>{{ $afl->credits['vacation'][1] }}</td>
                                <td>{{ $afl->credits['sick'][1] }}</td>
                                <td>{{ $afl->credits['vacation'][1] + $afl->credits['sick'][1]}}</td>
                            </tr>
                            <tr>
                                <td>{{ $afl->credits['vacation'][0] - $afl->credits['vacation'][1] }}</td>
                                <td>{{ $afl->credits['sick'][0] - $afl->credits['sick'][1] }}</td>
                                <td>{{ ($afl->credits['vacation'][0] - $afl->credits['vacation'][1] ) +  ($afl->credits['sick'][0] - $afl->credits['sick'][1])}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5>Signatories</h5>
                    <hr>

                    <p class="text-center"><strong>{{ name_helper($afl->approval->name) }}</strong> <br> <small>Approving Officer</small> </p>
                    <p class="text-center"><strong>{{ name_helper($afl->hr->name) }}</strong> <br> <small>HRMO Officer</small> </p>


                </div>
            </div>
        </x-ui.card>
        
        <x-fms-attachments :attachments="$afl->document->attachments" />
        
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


