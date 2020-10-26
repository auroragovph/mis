<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> FTS</title>
    <link rel="stylesheet" href="{{ asset('plugins/paper/paper.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/paper/style.css') }}">

    <style>
        table{
            border-right: 0px;
            border-left: 0px;
            font-size: 13px;
        }
        .rep{
            font-size: 18px;
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
        @page { size: A5; }
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
                    <p class="pro">PROVINCIAL GOVERNMENT OF AURORA</p>
                </td>
                <td width="20%" class="center">
                    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(70)->merge('/public/images/logo-sm.png', .3)->errorCorrection('H')->generate(1)) !!} ">
                    <span style="display: block">SR-00000000001</span>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="bb">
                    <h4 class="receipt-type text-center"> {{ strtoupper(doc_type_only($document->type)) }} </h4>
                </td>
            </tr>
        </table>
        <br>
        <table>
            <tr style="max-height:700px; height:700px;">
                <td width="50%">
                    <table class="receipt-table">
                        <tr><td colspan="2" class="text-center bb">DOCUMENT INFORMATION</td></tr>
                        <tr>
                            <td>Series:</td>
                            <td>{{ $document->seriesFull }}</td>
                        </tr>
                        <tr class="bt">
                            <td>Encoded By:</td>
                            <td>{{ name_helper($document->encoder->name) }}</td>
                        </tr>
                        <tr class="bt">
                            <td>Encoded Date:</td>
                            <td>{{ $document->encoded }}</td>
                        </tr>
                        <tr class="bt">
                            <td>Liaison Officer:</td>
                            <td>{{ name_helper($document->liaison->name) }}</td>
                        </tr>
                        <tr class="bt">
                            <td>Requesting Office:</td>
                            <td>{{ office_helper($document->division) }}</td>
                        </tr>

                        @foreach($datas as $key => $data)
                        <tr class="bt">
                            <td>{{ $key }}:</td>
                            <td>{{ $data }}</td>
                        </tr>
                        @endforeach
    
                    </table>
                </td>
                <td width="50%">
                    <table class="receipt-table">
                        <tr>
                            <td colspan="2" class="text-center bb">DOCUMENT ATTACHED</td>
                        </tr>
                        
    
                        <tr class="bt">
                            <td colspan="2">
                               AA
                            </td>
                        </tr>
                    </table>
                </td>
    
            </tr>
        </table>
        <table>
            <tr>
                <td>
                    <p>Printed By:</p>
                    <br><br>
                    {{ name_helper(Auth::user()->employee->name) }} <br>
                    <small>{{ office_helper(Auth::user()->employee->division) }}</small>
                    <br><br>
                    Printed Date: {{ date('F d, Y h:i A') }}
                    <br><br><br>
                    <br><br><br>
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