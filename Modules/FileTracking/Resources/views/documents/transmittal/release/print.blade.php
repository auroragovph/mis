<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('constants.title') }} || File Tracking Module</title>
    <link rel="stylesheet" href="{{ asset('plugins/paper/paper.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/paper/style.css') }}">

    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/x-icon">


    <style>
        table{
            border-right: 0px;
            border-left: 0px;
            font-size: 13px;
        }

        .table-bordered{
            border: 1px solid black;
        }

        .bordered{
            border: 1px solid black;
        }

        .rep{
            font-size: 14px;
        }
        .pro{
            font-size:18px;
            margin-top: -5px;
        }
        .obr-heading{
            font-size: 26px;
            letter-spacing: 3px;
            font-weight: bold;
        }
        .p-3{
            padding: 3px;
        }
        .p-5{
            padding: 5px;
        }
        .receipt-type{
            margin: 5px;
            font-size: 24px;
        }
        .receipt-table{
            width: 90%;
            margin: 0 auto;
            padding: 10px;
        }
        .receipt-table td{
            padding: 5px;
        }
        .wash-t{
            border-top-color: darkgrey;
        }
        @page { size: A4; }
    </style>
   
    


</head>
<body class="A4">

    <section class="sheet padding-5mm">
        <table>
            <tr class="bb">
                <td width="20%" class="center">
                    <img src="{{ asset('images/logo-md.png') }}" alt="" width="80px" height="80px">
                </td>
                <td width="60%" class="center">
                    <p class="rep">Republic of the Philippines</p>
                    <p class="pro">{{ strtoupper(config('constants.lgu')) }}</p>
                    <p class="pro">{{ office_helper($transmittal->releasingOffice) }}</p>
                </td>
                <td width="20%" class="center">
                    <img width="70" height="70" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->errorCorrection('H')->generate($transmittal->id)) !!} ">
                </td>
            </tr>
            <tr>
                <td colspan="3" class="bb">
                    <h4 class="receipt-type text-center"> TRANSMITTAL REPORT </h4>
                </td>
            </tr>
        </table>
        <br>

        <table class="table-bordered">
            <thead>
                <tr class="bb">
                    <th class="br">Series Number</th>
                    <th class="br">Type</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody style="max-height:700px; height:700px;">
                @foreach($transmittal->documentsInfo->sortBy('id') as $document)
                <tr class="bt">
                    <td>{{ $document->seriesFull }}</td>
                    <td class="bl">{!! doc_type_only($document->type) !!}</td>
                    <td class="bl">{!! show_status($document->status) !!}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <p>Receiving Office: {{ office_helper($transmittal->receivingOffice) }}</p>


        <table>
            <tr>
                <td>
                    <p>Printed By:</p>
                    <br><br>
                    {{ name_helper(Auth::user()->employee->name) }} <br>
                    <small>{{ office_helper(Auth::user()->employee->division) }}</small>
                    <br><br>
                    Printed Date: {{ date('F d, Y h:i A') }}
                    <br>

                    <p class="text-center">Page 1 of 1</p>
                    
                </td>
            </tr>
            <tr>
                <td class="text-center bt wash-t">
                    <strong>FILE TRACKING SYSTEM</strong><br>
                    PROVINCIAL MANAGEMENT INFORMATION SYSTEM
                </td>
            </tr>
        </table>
    </section>


<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>


</body>
</html>