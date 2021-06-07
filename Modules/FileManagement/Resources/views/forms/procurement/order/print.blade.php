<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Purchase Order  |  {{ $po->document->qr }} </title>

    <link rel="stylesheet" href="{{ asset('css/Modules/FileManagement/paper.css') }}">


    <style>

        body{
            font-family: 'Times New Roman', Times, serif !important;
            font-size: 12px;
        }

        @page { size: A4; }
        
        table{
            border-left: 1px solid black;
            border-right: 1px solid black;
            width: 90%;
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

        h3{
            font-size: 16px;
        }

    
    </style>  
    


</head>
<body class="A4">
        <section class="sheet padding-5mm">

            <p class="text-right"><em>Appendix 49</em></p>
            <h3 class="text-center">PURCHASE ORDER</h3>
            <p class="text-center" style="text-transform: uppercase; "><u>{{ config('constants.lgu') }}</u></p>
            <h3 class="text-center" style="margin-top:-10px;">LGU</h3>


            <table class="btm brm blm">
                <tr>
                    <td colspan="3" class="brm">
                        <strong>Supplier:</strong> <u>{{ $po->supplier['firm'] ?? '' }}</u>
                    </td>
                    <td colspan="3">
                        <strong>P.O No.:</strong> <u>{{ $po->number }}</u>
                    </td>
                </tr>

                <tr>
                    <td colspan="3" rowspan="2" class="brm">
                        <strong>Address:</strong> <u>{{ $po->supplier['address'] ?? '' }}</u>
                    </td>
                    <td colspan="3">
                        <strong>Date:</strong> <u>{{ $po->created_at }}</u>
                    </td>
                </tr>

                <tr>
                    <td colspan="3">
                        <strong>Mode of Procurement:</strong>  <u>{{ $po->mode_of_procurement }}</u>
                    </td>
                </tr>

                <tr class="bbm">
                    <td colspan="3" class="brm">
                        <strong>TIN:</strong> <u>{{ $po->supplier['tin'] ?? '' }}</u>
                    </td>
                    <td colspan="3">
                        <strong>PR No./s:</strong> 
                    </td>
                </tr>

                <tr>
                    <td colspan="6" class="bbm"> Gentelmen: <br>
                        <span style="margin-left: 15px;">Please </span> furnish this Office the following articles subject to the terms and conditions contained herein:
                    </td>
                </tr>

                <tr>
                    <td colspan="3" class="brm">
                        <strong>Place of Delivery:</strong> <u>{{ $po->delivery['place'] ?? '' }}</u>
                    </td>
                    <td colspan="3">
                        <strong>Delivery Term:</strong> <u>{{ $po->delivery['term'] ?? '' }}</u>
                    </td>
                </tr>

                <tr class="bbm">
                    <td colspan="3" class="brm">
                        <strong>Date of Delivery:</strong> <u>{{ $po->delivery['date'] ?? '' }}</u>
                    </td>
                    <td colspan="3">
                        <strong>Payment Term:</strong> <u>{{ $po->delivery['payment'] ?? '' }}</u>
                    </td>
                </tr>


                <tr class="bbm">
                    <td width="10%" class="text-center br"><strong>Stock/ <br>Property No.</strong></td>
                    <td width="10%" class="text-center br"><strong>Unit</strong></td>
                    <td width="35%" class="text-center br"><strong>Description</strong></td>
                    <td width="10%" class="text-center br"><strong>Quantity</strong></td>
                    <td width="10%" class="text-center br"><strong>Unit Cost</strong></td>
                    <td width="15%" class="text-center"><strong>Amount</strong></td>
                </tr>

                @php($lists = collect($po->lists))

                @foreach($lists as $list) 

                    <tr>
                    <td class="br text-center">{{ $list['stock'] }}</td>
                    <td class="br text-center">{{ $list['unit'] }}</td>
                    <td class="br">{{ $list['description'] }}</td>
                    <td class="br text-center">{{ $list['quantity'] }}</td>
                    <td class="br text-center">{{ $list['amount'] }}</td>
                    <td class="text-center">{{ pretty_number($list['quantity'] * $list['amount']) }}</td>
                    </tr>

                @endforeach

                <tr class="bt bbm">
                    <td colspan="2">
                        <strong>(Total Amount in Words)</strong>
                    </td>
                    <td class="text-right" colspan="4">
                        {{ numwords($lists->sum(fn ($list) => $list['quantity'] * $list['amount'])) }}
                    </td>
                </tr>

                <tr>
                    <td colspan="6">
                        <span style="margin-left: 30px;">In</span> case of failure to make the full delivery within the time specified above, a penalty of one-tenth (1/10) of one percent for every day of delay shall be imposed on the undelivered item/s.
                        <br><br>
                    </td>
                </tr>

                <tr class="bbm">
                    <td colspan="3">
                        <span style="margin-left: 30px;">Conforme:</span>

                        <p class="text-center"><strong><u>_____{{ $po->supplier['name'] ?? '' }}</u>_____</strong></p>
                        <p class="text-center" style="margin-top: -10px;">Signature over Printed Name of Supplier</p>


                        <p class="text-center">_____________________</p>
                        <p class="text-center" style="margin-top: -10px;">Date</p>

                    </td>

                    <td colspan="3">
                        <span style="margin-left: 30px;">Very truly yours,</span>

                        <p class="text-center"><strong>_____<u>{{ name_helper($po->approving->name) }}</u>_____</strong></p>
                        <p class="text-center" style="margin-top: -10px;">Signature over Printed Name of Authorized Official</p>

                        <p class="text-center"><u>{{ $po->approving->position->position ?? '' }}</u></p>
                        <p class="text-center" style="margin-top: -10px;">Designation</p>

                    </td>
                </tr>

                <tr>
                    <td colspan="6">
                        <p class="text-center">(In case of Negotiated Purchase pursuant to Section 369 (a) of RA 7160, this portion must be accomplished. )</p>
                        <p>Approved per Sanggunian Resolution No.: ___________________________________________________________</p>
                    </td>
                </tr>

                <tr class="bbm">
                    <td colspan="3">
                        <p style="margin-left: 20px;">Certified Correct:</p>
                        <p class="text-center">________________________________</p>
                        <p class="text-center" style="margin-top: -10px;">Secretary to the Sanggunian</p>
                    </td>
                    <td colspan="3">
                        <br>
                        <p class="text-center">________________________________</p>
                        <p class="text-center" style="margin-top: -10px;">Date</p>
                    </td>
                </tr>




            </table>
            



       
           
        </section>
</body>
</html>