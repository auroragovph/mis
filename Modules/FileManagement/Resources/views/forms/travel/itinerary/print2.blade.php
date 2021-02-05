<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Itinerary of Travel |  {{ $iot->document->qr }} </title>

    {{-- <link rel="stylesheet" href="{{ asset('css/Modules/FileManagement/paper.css') }}"> --}}


    <style>

        body{
            font-family: 'Times New Roman', Times, serif !important;
            font-size: 12px;
        }

        /* @page { size: A4; } */
        
        table{
            border-collapse: collapse;
            width: 100%;
            margin: 0 auto;
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

        .align-left{
            float: left;
        }

        .align-right{
            float: right;
        }

        .m-auto{
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        

        hr{
            border: 0.5px solid gray;
        }

        td,th {
            vertical-align: baseline;
        }

        .pl-3{
            padding-left: 10px;
        }

        .ml-3{
            margin-left: 10px;
        }

        .text-right{
            text-align: right;
        }

        .text-center{
            text-align: center;
        }

        .center{
            text-align: center;
            vertical-align: middle;
        }

        .br0{
            border-right: 0px !important;

        }

        .btm{
            border-top: 2px solid black;
        }

        .bbm{
            border-bottom: 2px solid black;
        }

        .blm{
            border-left: 2px solid black;
        }

        .brm{
            border-right: 2px solid black;
        }

        .bt{
            border-top: 1px solid black;
        }

        .bb{
            border-bottom: 1px solid black;
        }

        .bl{
            border-left: 1px solid black;
        }

        .br{
            border-right: 1px solid black;
        }

        .rep{
            font-size: 12px;
        }

        .pro{
            font-size: 12px;
            margin-top: -5px;
        }

        h3{
            font-size: 20px;
        }

        .footer-page p{
            font-size: 10px;
        }

    
    </style>  
    


</head>
<body class="A4">
    <table>

        <thead>

            <tr>
                <td colspan="9">
                    <p class="text-right"><em>Appendix 46</em></p>
                </td>
            </tr>

            <tr>
                <td colspan="9" style="padding: 0px;" class="blm brm btm">
                    <h4 class="text-center" style="font-size:18px; margin-top: 5px; margin-bottom: 10px; margin-top:10px; text-transform:uppercase;">Itinerary Of Travel</h4>
                </td>
            </tr>
    
            <tr class="brm blm">
                <td colspan="9">
                    <span><strong>LGU:</strong> Provincial Government of Aurora</span>
                </td>
            </tr>
            <tr class="bbm blm brm">
                <td colspan="6">
                    <span><strong>Fund:</strong> {{ $iot->fund }}</span>
                </td>
                <td colspan="3">
                    <span><strong>No:</strong> {{ $iot->number }}</span>
                </td>
            </tr> 
    
    
            <tr class="brm blm">
                <td colspan="4" class="brm">
                    <span><strong>Name:</strong> </span>
                </td>
                <td colspan="5">
                    <span><strong>Date of Travel:</strong> </span>
                </td>
            </tr>
    
            <tr class="brm blm">
                <td colspan="4" class="brm">
                    <span><strong>Position:</strong> </span>
                </td>
                <td colspan="5" rowspan="2" class="bbm">
                    <span><strong>Purpose of Travel:</strong> </span>
                </td>
            </tr>
    
            <tr class="bbm blm">
                <td colspan="4" class="brm">
                    <span><strong>Official Station:</strong> </span>
                </td>
            </tr>
        </thead>

        <tbody>

        <tr class="bbm blm">
            <td class="text-center brm" rowspan="2" width="10%">
                Date
            </td>
            <td class="text-center brm" rowspan="2" width="27%">
                Place to be Visted <br> (Destination)
            </td>
            <td class="text-center brm" colspan="2" width="18%">
               Time
            </td>
            <td class="text-center brm" rowspan="2" width="12%">
                Means of <br> Transportation
            </td>
            <td class="text-center brm" rowspan="2" width="8%">
                Transpor- <br> tation
            </td>
            <td class="text-center brm" rowspan="2" width="6%">
                Per <br> Diem
            </td>
            <td class="text-center brm" rowspan="2" width="7%">
                Others
            </td>
            <td class="text-center brm" rowspan="2" width="12%">
                Total Amount
            </td>
        </tr>

        <tr class="bbm">
            <td class="text-center brm">Departure</td>
            <td class="text-center brm">Arrival</td>
        </tr>

        {{-- @foreach($iot->lists as $list)
            <tr class="blm"> 
                <td class="brm">{{ $list['date'] }}</td>
                <td class="brm">{{ $list['destination'] }}</td>
                <td class="brm">{{ $list['departure'] }}</td>
                <td class="brm">{{ $list['arrival'] }}</td>
                <td class="brm">{{ $list['means'] }}</td>
                <td class="brm">{{ $list['trans'] }}</td>
                <td class="brm">{{ $list['diem'] }}</td>
                <td class="brm">{{ $list['other'] }}</td>
                <td class="brm text-right">{{ pretty_number($list['amount']) }}</td>
            </tr>
        @endforeach --}}


            @for($remaining_rows = count($iot->lists); $remaining_rows <= 30; $remaining_rows++)
                <tr class="blm"> 
                    <td class="brm">&nbsp;</td>
                    <td class="brm">&nbsp;</td>
                    <td class="brm">&nbsp;</td>
                    <td class="brm">&nbsp;</td>
                    <td class="brm">&nbsp;</td>
                    <td class="brm">&nbsp;</td>
                    <td class="brm">&nbsp;</td>
                    <td class="brm">&nbsp;</td>
                    <td class="brm">&nbsp;</td>
                </tr>
            @endfor

            <tr class="btm bbm blm brm">
                <td colspan="3" ></td>
                <td><strong>TOTAL</strong></td>
                <td colspan="5" class="text-right">
                    {{-- <strong>{{ pretty_number(collect($iot->lists)->sum('amount')) }}</strong> --}}
                </td>
            </tr>

        </tbody>

       <tfoot>
        <tr class="bbm blm brm">

            <td colspan="3" class="brm bbm" rowspan="2">

                <br>

                <p style="margin-left: 10px; font-size:14px;">
                    <span style="margin-left: 30px;">I</span> certify that : (1) I have reviewed the foregoing itinerary, (2) the travel is necessary to the service, (3) the period covered is reasonable and (4) the expenses claimed are proper.
                </p>

                <br>

                <p class="text-center" style="font-size: 12px; font-weight:bolder; text-transform: uppercase;">{{ name_helper($iot->supervisor->name) }}</p>
                <p class="text-center" style="margin-top: -20px;">____________________________________________</p>
                <p class="text-center" style="margin-top: -10px;">Signature Over Printed Name</p>
                <p class="text-center" style="margin-top: -10px">Immediate Supervisor</p>


            </td>
            <td colspan="6">
                <p><strong>Prepared by :</strong></p>
                <br>
                <p class="text-center" style="font-size: 12px; font-weight:bolder; text-transform: uppercase;">{{ name_helper($iot->document->encoder->name) }}</p>
                <p class="text-center" style="margin-top: -20px;">____________________________________________</p>
                <p class="text-center" style="margin-top: -10px;">Signature Over Printed Name</p>



            </td>
        </tr>

        <tr class="brm">
            <td colspan="6" class="bbm">
                <p><strong>Approved by :</strong></p>
                <br>
                <p class="text-center" style="font-size: 12px; font-weight:bolder; text-transform: uppercase;">{{ name_helper($iot->head->name) }}</p>
                <p class="text-center" style="margin-top: -20px;">____________________________________________</p>
                <p class="text-center" style="margin-top: -10px;">Signature Over Printed Name</p>
                <p class="text-center" style="margin-top: -10px">Agency Head/Authorized Representative</p>

            </td>
        </tr>

       


       </tfoot>




    </table>
</body>
</html>