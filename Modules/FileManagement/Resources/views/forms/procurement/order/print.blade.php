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
                        <strong>Supplier:</strong>
                    </td>
                    <td colspan="3">
                        <strong>P.O No.:</strong>
                    </td>
                </tr>

                <tr>
                    <td colspan="3" rowspan="2" class="brm">
                        <strong>Address:</strong>
                    </td>
                    <td colspan="3">
                        <strong>Date:</strong>
                    </td>
                </tr>

                <tr>
                    <td colspan="3">
                        <strong>Mode of Procurement:</strong>
                    </td>
                </tr>

                <tr class="bbm">
                    <td colspan="3" class="brm">
                        <strong>TIN:</strong>
                    </td>
                    <td colspan="3">
                        <strong>PR No./s:</strong>
                    </td>
                </tr>

                <tr>
                    <td colspan="6" class="bbm"> Gentelmen: <br>
                        <span>Please furnish this Office the following articles subject to the terms and conditions contained herein:</span> 
                    </td>
                </tr>

                <tr>
                    <td colspan="3" class="brm">
                        <strong>Place of Delivery:</strong>
                    </td>
                    <td colspan="3">
                        <strong>Delivery Term:</strong>
                    </td>
                </tr>

                <tr class="bbm">
                    <td colspan="3" class="brm">
                        <strong>Date of Delivery:</strong>
                    </td>
                    <td colspan="3">
                        <strong>Payment Term:</strong>
                    </td>
                </tr>


                <tr class="bbm">
                    <td class="text-center br"><strong>Stock/ <br>Property No.</strong></td>
                    <td class="text-center br"><strong>Unit</strong></td>
                    <td class="text-center br"><strong>Description</strong></td>
                    <td class="text-center br"><strong>Quantity</strong></td>
                    <td class="text-center br"><strong>Unit Cost</strong></td>
                    <td class="text-center"><strong>Amount</strong></td>
                </tr>

            </table>
            



       
           
        </section>
</body>
</html>