<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Aurora MIS  | {{ convert_to_series($document) }}  </title>

    <link rel="stylesheet" href="{{ asset('css/filemanagement/paper.css') }}">
    <link rel="stylesheet" href="{{ asset('css/filemanagement/paperstyle.css') }}">

    <style>@page { size: A4; }</style>    
    


</head>
<body class="A4">

    @foreach($pages as $i => $page)

    <section class="sheet padding-5mm">
    
        <table class="btm bbm">
            <tr>
                <td width="20%" class="center">
                    <img src="{{ asset('images/logo-sm.png') }}" alt="" width="80px" height="80px">

                </td>
    
                <td width="60%" class="center">
                    <p class="rep">Republic of the Philippines</p>
                    <p class="pro">PROVINCIAL GOVERNMENT OF AURORA</p>
                </td>
    
                <td width="20%" class="center">
                    <img width="75" height="75" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(500)->generate($document->id)) !!}" alt="" class="symbol-label">
                    <span style="display: block; font-size: 10px">{{ convert_to_series($document) }}</span>
                </td>
    
            </tr>
        </table>
    
        <table>
            <tr class="bb">
                <td class="br center obr-heading" width="70%">
                    OBLIGATION REQUEST
                </td>
                <td width="30%">No.  <span style="font-size:20px;"><b>{{ $document->obligation_request->number }}</b> </span></td>
            </tr>
        </table>
    
        <table>
            <tr class="bb">
                <td width="17%" class="br p-3"><strong>Payee</strong></td>
                <td> {{ $document->obligation_request->payee }} </td>
            </tr>
            <tr class="bb">
                <td class="br p-3"><strong>Office</strong></td>
                <td> {{ office_helper($document->division) }} </td>
            </tr>
            <tr class="bb">
                <td class="br p-3"><strong>Address</strong></td>
                <td> {{ $document->obligation_request->address }} </td>
            </tr>
        </table>
    
        <table>
            <tr class="bbm">
                <td width="17%" class="center br">Responsibility Center</td>
                <td width="45%" class="center br">Particulars</td>
                <td width="10%" class="center br">F.P.P</td>
                <td width="13%" class="center br">Account Code</td>
                <td width="15%" class="center">Amount</td>
            </tr>
    
            <?php $subtotal = 0; ?>
            @foreach($page as $list)
            
            <tr class="">
                <td width="17%" class="br">{{$list['responsibility_center']}}</td>
                <td width="45%" class="br">{{nl2br($list['particulars'])}}</td>
                <td width="10%" class="text-center br">{{$list['fpp']}}</td>
                <td width="13%" class="text-center br">{{$list['account_code']}}</td>
                <td width="15%" class="text-right">
                    @if($list['amount'] != '')
                    {{ nice_amount($list['amount']) }}
                    <?php $subtotal += $list['amount']?>
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
                        <td class="text-right"><strong><?= nice_amount($total_cost) ?></strong></td>
                    </tr>
                @else
                    <tr class="bb bt">
                        <td colspan="4" class="text-right br">SUB-TOTAL</td>
                        <td class="text-right"><strong><?= nice_amount($subtotal) ?></strong></td>
                    </tr>
                    <tr class="bb bt">
                        <td colspan="4" class="text-right br">GRAND TOTAL</td>
                        <td class="text-right"><strong><?= nice_amount($total_cost) ?></strong></td>
                    </tr>
                @endif
                   
            @else <!-- THIS IS NOT THE LAST PAGE -->
                <tr class="bb bt">
                    <td colspan="4" class="text-right br">SUB-TOTAL</td>
                    <td class="text-right"><strong><?= nice_amount($subtotal) ?></strong></td>
                </tr>
            @endif
    
        </table>
    
        <table>
            <tr class="bb">
                <td width="50%" class="br">
                    <p class="obr-a"><strong>A. Certified</strong></p>
                    <p class="obr-a"><input type="checkbox" name="" id="">Charges to appropriate/allotment necessary, lawful and under my direct supervision</p>
                    <p class="obr-a"><input type="checkbox" name="" id="">Supporting documents valid, proper and legal</p>
                </td>
                <td>
                    <p class="obr-a"><strong>A. Certified</strong></p>
                    <p class="center obr-a">Existense of available appropriation</p>
                </td>
            </tr>
        </table>
    
        <table>
            <tr class="bb">
                <td width="15%" class="p-5 br"><b>Signature</b></td>
                <td width="35%" class="p-5 br"></td>
                <td width="15%" class="p-5 br"><b>Signature</b></td>
                <td width="35%" class="p-5"></td>
            </tr>
            <tr class="bb">
                <td width="15%" class="p-5 br" style="font-size: 14px;"><b>Printed Name</b></td>
                <td width="35%" class="p-5 text-center br"> <strong>{{ name_helper($document->obligation_request->dh, 'FMIL') }}</strong> </td>
                <td width="15%" class="p-5 br" style="font-size: 14px;"><b>Printed Name</b></td>
                <td width="35%" class="p-5 text-center"><strong>{{ name_helper($document->obligation_request->bo, 'FMIL') }}</strong></td>
            </tr>
    
            <tr>
                <td rowspan="2" width="15%" class="p-5 br bb" style="vertical-align:middle;"><b>Position</b></td>
                <td width="35%" class="p-5 br text-center" style="font-size: 10px;"> {{ $document->obligation_request->dh->position }} </td>
                <td rowspan="2" width="15%" class="p-5 br bb" style="vertical-align:middle;"><b>Position</b></td>
                <td width="35%" class="p-5 br text-center" style="font-size: 10px;">Provincial Budget Officer</td>
            </tr>
    
            <tr class="bb">
                <td width="35%" class="br bt p-5 text-center" style="font-size:10px;">Head,Requesting Office/Authorized Representative</td>
                <td width="35%" class="br bt p-5 text-center" style="font-size:10px;">Head,Budget Unit/Authorized Representative</td>
            </tr>
    
            <tr class="bbm">
                <td width="15%" class="p-5 br"><b>Date</b></td>
                <td width="35%" class="p-5 br"></td>
                <td width="15%" class="p-5 br"><b>Date</b></td>
                <td width="35%" class="p-5"></td>
            </tr>
        </table>
    
        <div class="footer-page">
            <p class="text-center">Page {{ $i + 1 }} of {{ $page_count }} </p>
        </div>
    
    
    </section>
    @endforeach

</body>
</html>