<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Travel Order  |  {{ $document->qr }} </title>

    <link rel="stylesheet" href="{{ asset('css/filemanagement/paper.css') }}">
    <link rel="stylesheet" href="{{ asset('css/filemanagement/paperstyle.css') }}">

    <style>
        @page { size: A4; }
        
        
        table{
            border: none;
        }

        .office-title{
            font-size: 32px;
            font-family: 'Monotype Corsiva', sans-serif;
        }

        .namedes{
            line-height: 0.5em;
        }
        .pt-2{
            padding-top: 20px;
        }

    
    </style>    


    
    


</head>
<body class="A4">
    <section class="sheet padding-5mm">

        <table class="bbm">
            <tr>
                <td width="20%" class="center">
                    <img src="{{ asset('images/logo-sm.png') }}" alt="" width="100px" height="100px">
                </td>
    
                <td width="60%" class="center">
                    <p class="rep">Republic of the Philippines</p>
                    <p class="pro">PROVINCIAL GOVERNMENT OF AURORA</p>
                    <h3>TRAVEL ORDER</h3>
                </td>
    
                <td width="20%" class="center qr-div" id="qr-div">
                    <img width="75" height="75" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(500)->generate($document->qr)) !!}" alt="" class="symbol-label">
                    <span style="display: block; font-size: 10px">{{ $document->qr }}</span>
                    
                </td>
            </tr>
        </table>
    
        <!--<table>
            <tr>
                <td class="text-center bb office-title" style="padding-bottom:10px;">
                   Office of the Provincial Administrator
                </td>
            </tr>
        </table> -->
    
        <br>
    
        <table>
            <tr>
                <td width="75%" class="text-right">NO :</td>
                <td width="25%" class="bb text-center"> {{ $document->travel_order->number }}  </td>
            </tr>
            <tr>
                <td width="75%" class="text-right">Date :</td>
                <td width="25%" class="bb text-center"> {{ \Carbon\Carbon::parse($document->created_at)->format('F d, Y') }}  </td>
            </tr>
        </table>
    
        <br><br>
    
        <table>
            <tr>
                <td width="40%" style="padding-left: 30px">
                    <i>Name/s:</i>
                </td>
                <td width="60%">
                    @foreach($document->travel_order->employees as $employee)
                    <p class="namedes"><strong>{{ name_helper($employee->employee->name) }}</strong> - {{ $employee->employee->position->position }} </p>
                    @endforeach
                </td>
            </tr>
    
            <tr>
                <td class="pt-2" width="40%" style="padding-left: 30px">
                    <i>Destination:</i>
                </td>
                <td width="60%">
                    <strong> {{ $document->travel_order->destination }} </strong>
                </td>
            </tr>
    
            <tr>
                <td class="pt-2" width="40%" style="padding-left: 30px">
                    <i>Date of Departure:</i>
                </td>
                <td width="60%">
                    <strong> {{ \Carbon\Carbon::parse($document->travel_order->departure)->format('F d, Y') }} </strong>
                </td>
            </tr>
    
            <tr>
                <td class="pt-2" width="40%" style="padding-left: 30px">
                    <i>Date of Arrival:</i>
                </td>
                <td width="60%">
                    <strong>{{ \Carbon\Carbon::parse($document->travel_order->arrival)->format('F d, Y') }}</strong>
                </td>
            </tr>
            <tr>
                <td class="pt-2" width="40%" style="padding-left: 30px">
                    <i>Purpose of Travel:</i>
                </td>
                <td width="60%">
                    <strong>
                        {{ $document->travel_order->purpose }}
                    </strong>
                </td>
            </tr>
    
            <tr>
                <td class="pt-2" width="40%" style="padding-left: 30px">
                    <i>Charging Office:</i>
                </td>
                <td width="60%">
                    <strong>
                        {{ office_helper($document->travel_order->charging) }}
                    </strong>
                </td>
            </tr>
            <tr>
                <td class="pt-2" width="40%" style="padding-left: 30px">
                    <i>Special Instruction:</i>
                </td>
                <td width="60%">
                    <strong>
                        {{ $document->travel_order->instruction }}
                    </strong>
                </td>
            </tr>
    
        </table>
    
        <br><br><br>
    
        <table>
            <tr>
                <td width="40%">Recommending Approval:</td>
                <td width="60%">&nbsp;</td>
            </tr>
        </table>
        <br><br>
        <table>
            <tr>
                <td class="text-center" width="40%"><strong>{{strtoupper(name_helper($document->travel_order->approval->name))}}</strong></td>
                <td class="text-center" width="60%">&nbsp;</td>
            </tr>
            <tr>
                <td class="text-center"><em> {{ $document->travel_order->approval->position->position }}  </em></td>
                <td>&nbsp;</td>
            </tr>
        </table>
    
        <table>
            <tr>
                <td width="60%">&nbsp;</td>
                <td width="40%">Approved:</td>
            </tr>
        </table>
    
        <br><br>
        <table>
            <tr>
                <td width="60%">&nbsp;</td>
                <td class="text-center" width="40%"><strong>GERARDO A. NOVERAS</strong></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td class="text-center"><em>Governor</em></td>
            </tr>
        </table>
    
    </section>
</body>
</html>