<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> CAFOA  |  {{ $cafoa->document->qr }} </title>

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
        


        table.fulltable > tr, td{
            border: 1px solid black !important;
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

    
    </style>  
    


</head>
<body class="A4">
    <section class="sheet padding-5mm">

        <p class="text-right"><em>Appendix 28</em></p>
        <h3 class="text-center">Provincial Government of Aurora</h3>
        <h1 class="text-center">CERTIFICATION ON APPROPRIATIONS, <br> FUNDS AND OBLIGATION OF ALLOTMENT</h1>

        <table>
            <tr class="bt">
                <td class="br" width="50%" rowspan="5">
                    <p class="ml-3"><strong>Request</strong></p>
                    <p class="ml-3">Payee <span class="ml-3"><u>JIMWELL P. PARINAS</u></span></p>


                    <table class="fulltable" style="margin:auto; width:90%">

                        <tr>
                            <td class="text-center">Function</td>
                            <td class="text-center">Allotment <br> Class</td>
                            <td class="text-center">Expense <br> Code</td>
                            <td class="text-center">Amount</td>
                        </tr>

                        @php($sum = 0)
                        @php($rows = 0)

                        @foreach($cafoa->lists as $list)
                            <tr>
                                <td>{{ $list['function'] }}</td>
                                <td>{{ $list['allotment'] }}</td>
                                <td>{{ $list['code'] }}</td>
                                <td>{{ $list['amount'] }}</td>
                            </tr>
                            <?php
                                $sum += $list['amount'];
                                $rows++;
                            ?>
                        @endforeach

                        @for($rows; $rows <= 5; $rows++)
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                        @endfor

                    </table>

                    <p class="ml-3">Total amount requested <span class="ml-3"><u>{{ pretty_number($sum) }}</u></span></p>
                    <p class="ml-3">Amount in Words
                        <span class="ml-3"><u>{{ numwords($sum) }} only</u></span>
                    </p>

                    <br>

                    <div>
                        <p class="ml-3 align-left"><strong>RICARDO Q. BAUTISATA</strong></p>
                        <p class="align-right">___________</p>

                        <p class="ml-3 align-left" style="margin-top: -10px;">Provincial General Service Officer</p>
                        <p class="align-right" style="margin-top: -10px;">Date &nbsp;&nbsp;&nbsp;</p>
                    </div>







                </td>
                <td>
                    Obligation No: 
                </td>
            </tr>
            <tr>
                <td>
                    Approved Amount: <strong>{{ pretty_number($sum) }}</strong>
                </td>
            </tr>
             {{-- BUDGET OFFICE --}}
            <tr>
                <td>
                    <p><strong>Certification:</strong></p>
                    I hereby certify as to the existence of appropriations for the expenditures in the amount specified herein:

                    <br><br>
                    <div>
                        <p class="align-left"><strong>ATTY. PAZ L. TORREGOSA</strong></p>
                        <p class="align-right">___________</p>

                        <p class="align-left" style="margin-top: -10px;">Budget Officer</p>
                        <p class="align-right" style="margin-top: -10px;">Date &nbsp;&nbsp;&nbsp;</p>
                    </div>

                </td>
            </tr>

            {{-- TREASURER OFFICE --}}
            <tr>
                <td>
                    <p><strong>Certification:</strong></p>
                    I hereby certify as to the availability of funds for the expenditures in the amount specified herein:

                    <br><br>
                    <div>
                        <p class="align-left"><strong>MARY ZENCLAIRE N. ONG</strong></p>
                        <p class="align-right">___________</p>
                        <br><br><br>

                        <p class="align-left" style="margin-top: -10px;">Treasurer</p>
                        <p class="align-right" style="margin-top: -10px;">Date &nbsp;&nbsp;&nbsp;</p>
                    </div>
                    
                </td>
            </tr>
           
            <tr>
                <td>
                    <p><strong>Certification:</strong></p>
                    I hereby certify that the allotments are available for obligation in the amount specified herein:

                    <br><br>
                    <div>
                        <p class="align-left"><strong>WILFREDO C. SATURNO</strong></p>
                        <p class="align-right">___________</p>
                        <br><br><br>
                        <p class="align-left" style="margin-top: -10px;">Accountant</p>
                        <p class="align-right" style="margin-top: -10px;">Date &nbsp;&nbsp;&nbsp;</p>
                    </div>
                    
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <p class="text-center"><strong>Subsidiary Ledger</strong></p>
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <br>
                    <table class="fulltable" style="margin:auto; width:95%">

                        <tr>
                            <td class="text-center">Date</td>
                            <td class="text-center">Particulars / Reference</td>
                            <td class="text-center">Liquidations</td>
                            <td class="text-center">Obligation Increase <br> (Decrease)</td>
                            <td class="text-center">Balance</td>
                            
                        </tr>

                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>

                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>


                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>


                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>


                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>


                       
                    </table>
                    <br>
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    &nbsp;
                </td>
            </tr>


        </table>



    </section>
</body>
</html>