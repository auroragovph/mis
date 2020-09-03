
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Aurora MIS | File Management System  </title>

    <link rel="stylesheet" href="{{ asset('css/filemanagement/paper.css') }}">
    <link rel="stylesheet" href="{{ asset('css/filemanagement/paperstyle.css') }}">

    <style>
    @page { size: A4; }
    /* body{
        font-family: 'Century Gothic', sans-serif;
        font-size: 0.9rem;
    } */
    </style>    
    


</head>
<body class="A4">


    @foreach($pages as $i => $page)
    <section class="sheet padding-5mm">
    
        <table class="btm">
            <tr>
                <td width="20%" class="bb center">
                    <img src="{{ asset('images/logo-sm.png') }}" alt="" width="80px" height="80px">
                </td>
    
                <td width="60%" class="bb center">
                    <p class="rep">Republic of the Philippines</p>
                    <p class="pro">PROVINCIAL GOVERNMENT OF AURORA</p>
                    <h3>PURCHASE REQUEST</h3>
                </td>
    
                <td width="20%" class="bb center qr-div" id="qr-div">
                    <img width="75" height="75" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(500)->generate($document->id)) !!}" alt="" class="symbol-label">
                    <span style="display: block; font-size: 10px">{{ convert_to_series($document) }}</span>
                </td>
    
            </tr>
        </table>
    
        <table>
            <tr class="bb">
                <td colspan="2" width="30%">Office: <strong>{{ office_alias_helper($document->division) }}</strong> </td>
                <td rowspan="2" class="bl br" width="40%">PR NO: <strong> {{ $document->purchase_request->number }} </strong> </td>
                <td rowspan="2" width="25%">Date: <strong>{{ Carbon\Carbon::parse($document->created_at)->format('F d, Y') }}</strong> </td>
            </tr>
            <tr class="bb">
                <td class="">Division:</td>
            </tr>
        </table>
    
        <table>
            <tr class="bbm">
                <td width="10%" class="center br">Stock <br> No.</td>
                <td width="10%" class="center br">Unit</td>
                <td width="45%" class="center br">Item Description</td>
                <td width="8%" class="center br">Qty.</td>
                <td width="12%" class="center br">Unit Cost</td>
                <td width="15%" class="center">Total Cost</td>
            </tr>
        </table>
    
        <table>
            <?php $subtotal = 0; ?>
            @foreach($page as $list)
            
            <tr class="">
                <td width="10%" class="br">{{$list['stock']}}</td>
                <td width="10%" class="text-center br">{{$list['unit']}}</td>
                <td width="45%" class="br">{!! nl2br($list['description']) !!}</td>
                <td width="8%" class="text-center br">{{$list['qty']}}</td>
                <td width="12%" class="text-right br">
                    @if($list['cost'] != '')
                    {{number_format($list['cost'], 2)}}
                    @endif
                </td>
                <td width="15%" class="text-right">
                    @if($list['cost'] != '')
                    {{ number_format($list['qty'] * $list['cost'], 2) }}
                    <?php $subtotal += $list['qty'] * $list['cost'];?>
                    @else  
                    -
                    @endif
                </td>
            </tr>
            @endforeach
    
            @if($i + 1 == $page_count) <!-- THIS IS THE LAST PAGE -->
    
            <!-- check if only one page -->
                @if($page_count == 1)
                    <tr class="bb bt">
                        <td colspan="4" class="text-right br">TOTAL</td>
                        <td colspan="2" class="text-right"><strong><?= number_format($total_cost, 2) ?></strong></td>
                    </tr>
                @else
                    <tr class="bb bt">
                        <td colspan="4" class="text-right br">SUB-TOTAL</td>
                        <td colspan="2" class="text-right"><strong><?= number_format($subtotal, 2) ?></strong></td>
                    </tr>
                    <tr class="bb bt">
                        <td colspan="4" class="text-right br">GRAND TOTAL</td>
                        <td colspan="2" class="text-right"><strong><?= number_format($total_cost, 2) ?></strong></td>
                    </tr>
                @endif
                   
            @else <!-- THIS IS NOT THE LAST PAGE -->
                <tr class="bb bt">
                    <td colspan="4" class="text-right br">SUB-TOTAL</td>
                    <td colspan="2" class="text-right"><strong><?= number_format($subtotal, 2) ?></strong></td>
                </tr>
            @endif
    
        </table>
    
        <table>
            <tr class="bb" height="80px">
                <td class="br" width="15%">Purpose</td>
                <td> {{ $document->purchase_request->purpose }} </td>
            </tr>
            <tr class="bb">
                <td class="br" width="15%">Charging</td>
                <td>{{ office_helper($document->purchase_request->charging) }}</td>
            </tr>
        </table>
    
        <table>
    
            <tr>
    
                <td colspan="2" width="50%" class="text-center br">Requested By:</td>
    
                <td width="50%" class="text-center">Approved By:</td>
            </tr>
    
            <tr class="bb">
                <td>Signature:</td>
                <td class="br"></td>
                <td class="br"></td>
            </tr>
    
            <tr class="bb">
                <td>Name:</td>
                <td class="br text-center"> {{ name_helper($document->purchase_request->requesting, 'FMIL') }}  </td>
                <td class="br center" width="50%"><b>{{ Constants::GOVERNOR }}</b></td>
            </tr>
    
            <tr class="bb">
                <td>Designation:</td>
                <td class="br text-center">{{ $document->purchase_request->requesting->position->position }}</td>
                <td class="br center"><i>Governor</i></td>
            </tr>
            <tr class="bbm">
                <td>Date:</td>
                <td class="br"></td>
                <td class="br center"></td>
            </tr>
        </table>
    
        <div class="footer-page">
            <p class="text-center">Page {{ $i + 1 }} of {{ $page_count }} </p>
        </div>
        
    </section>
@endforeach

</body>
</html>