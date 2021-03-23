<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Purchase Request  |  {{ $pr->document->qr }} </title>

    <link rel="stylesheet" href="{{ asset('css/Modules/FileManagement/paper.css') }}">


    <style>

        body{
            font-family: 'Times New Roman', Times, serif !important;
            font-size: 14px;
        }

        @page { size: A4; }
        
        table{
            border-left: 1px solid black;
            border-right: 1px solid black;
            width: 80%;
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

    
    </style>  
    


</head>
<body class="A4">
    @foreach($pages as $pager => $page)
        <section class="sheet padding-5mm">
            <p class="text-right"><em>Appendix 47</em></p>

            <table class="btm blm brm">

                <tr class="bb">
                    <td colspan="6" style="padding: 0px;">
                        <h4 class="text-center" style="margin-top: 5px; margin-bottom: 5px; ">PURCHASE REQUEST</h4>
                    </td>
                </tr>

                <tr class="bb">
                    <td colspan="6">
                        &nbsp;
                    </td>
                </tr>

                <tr class="bb">
                    <td colspan="3">
                        <span><strong>LGU:</strong> Provincial Government of Aurora</span>
                    </td>

                    <td colspan="3">
                        <span><strong>Fund:</strong> {{ $pr->fund }} </span>
                    </td>
                </tr>

                <tr>
                    <td class="br" colspan="2">
                        <span><strong>Department:</strong> </span>
                    </td>
                    <td colspan="2">
                        <span><strong>PR No.:</strong>{{ $pr->number }}</span>
                    </td>
                    <td colspan="2">
                        <span><strong>Date:</strong> {{ Carbon\Carbon::parse($pr->created_at)->format('F d, Y') }}</span>
                    </td>
                </tr>

                <tr class="bbm">
                    <td class="br" colspan="2">
                        <span><strong>Section:</strong></span>
                    </td>
                    <td colspan="4">
                        <span><strong>FPP:</strong> {{ $pr->fpp }}</span>
                    </td>
                </tr>



                <tr class="bbm">
                    <td width="12%" class="text-center br">Item No.</td>
                    <td width="10%" class="text-center br">Unit</td>
                    <td width="30%" class="text-center br">Item Description</td>
                    <td width="8%" class="text-center br">Quantity</td>
                    <td width="10%" class="text-center br">Unit <br> Cost</td>
                    <td width="10%" class="text-center">Total Cost</td>
                </tr>

                <?php $subtotal = 0; ?>

                @foreach($page as $list)
                    <?php $list_amount = $list['quantity'] * $list['amount']; ?>
                    <tr class="bb">
                        <td class="br">{{ $list['stock']  }}</td>
                        <td class="br">{{ $list['unit']  }}</td>
                        <td class="br">{!! nl2br($list['description'])  !!}</td>
                        <td class="br text-center">@if($list['quantity'] == null) &nbsp; @else {{ $list['quantity'] }} @endif</td>
                        <td class="br text-right">@if($list['amount'] == null) &nbsp; @else{{  pretty_number($list['amount']) }}@endif</td>
                        <td class="text-right">@if($list['amount'] == null) &nbsp; @else {{ pretty_number($list_amount) }}@endif</td>
                    </tr>
                    <?php $subtotal += $list_amount; ?>
                @endforeach

                @if(count($pages) == 1)
                    <tr>
                        <td class="br" colspan="3" align="right"><strong>TOTAL: </strong></td>
                        <td colspan="3" class="brm" align="right"><strong>{{ pretty_number($total_amount) }}</strong></td>
                    </tr>
                @else 

                    <tr>
                        <td class="br" colspan="3" align="right"><strong>SUB-TOTAL: </strong></td>
                        <td colspan="3" class="brm" align="right"><strong>{{ pretty_number($subtotal) }}</strong></td>
                    </tr>

                    @if(count($pages) == $pager + 1)
                        <tr class="bt">
                            <td class="br" colspan="3" align="right"><strong>GRAND TOTAL: </strong></td>
                            <td colspan="3" class="brm" align="right"><strong>{{ pretty_number($total_amount) }}</strong></td>
                        </tr>
                    @endif

                @endif

                <tr class="bbm btm">
                <td colspan="6">
                        <span><strong>Purpose:</strong></span>

                    <div style="max-height: 100px; min-height=100px; margin-top: 10px; margin-left:10px;">
                            {{ $pr->purpose }}
                    </div>
                </td>
                </tr>
            </table>
            
            <table class="btm blm brm bbm">

                <tr>
                    <tr>
                        <td width="15%" class="br">&nbsp;</td>
                        <td class="text-center br">
                            <span>Requested By:</span>
                        </td>
                        <td class="text-center br">
                            <span>Cash Availability:</span>
                        </td>
                        <td class="text-center">
                            <span>Approved By:</span>
                        </td>
                    </tr>
                </tr>

                <tr>
                    <td class="br bb bt">
                        <span>Signature</span>
                    </td>
                    <td class="br bb bt">
                        <span>&nbsp;</span>
                    </td>
                    <td class="br bb bt">
                        <span>&nbsp;</span>
                    </td>
                    <td class="br bb bt">
                        <span>&nbsp;</span>
                    </td>
                </tr>

                <tr>
                    <td class="br bb bt">
                        <span>Printed Name</span>
                    </td>
                    <td class="br bb bt text-center">
                        <span>{{ name_helper($pr->requesting->name) }}</span>
                    </td>
                    <td class="br bb bt text-center">
                        <span>{{ name_helper($pr->treasury->name) }}</span>
                    </td>
                    <td class="br bb bt text-center">
                        <span>{{ name_helper($pr->approval->name) }}</span>

                    </td>
                </tr>

                <tr>
                    <td class="br bb bt">
                        <span>Designation</span>
                    </td>
                    <td class="br bb bt text-center">
                        <span>&nbsp;</span>
                    </td>
                    <td class="br bb bt text-center">
                        <span>&nbsp;</span>
                    </td>
                    <td class="br bb bt text-center">
                        <span>&nbsp;</span>
                    </td>
                </tr>

            </table>
            
            <br>


            <img class="align-right" style="display: block; margin-right:50px" height="30" width="30" src="data:image/png;base64, {{ qr_to_base64($pr->document->qr) }} ">
        <br><br>
            <p class="text-right" style="display: block; font-size:11px; margin-top:-1px; margin-right:40px;">

                {{ $pr->document->qr }}
            </p>

            @if(count($pages) != 1)
            <br><br>
            <p class="text-center" style="position: absolute; left:150px; right:150px;">Page {{ $pager + 1 }} of {{ count($pages) }} </p>
            @endif

        </section>
    @endforeach
</body>
</html>