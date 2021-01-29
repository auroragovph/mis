<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> CAFOA  |  {{ $pr->document->qr }} </title>

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

    
    </style>  
    


</head>
<body class="A4">
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
                    <span><strong>LGU:</strong></span>
                </td>

                <td colspan="3">
                    <span><strong>Fund:</strong></span>
                </td>
            </tr>

            <tr>
                <td class="br" colspan="2">
                    <span><strong>Department:</strong></span>
                </td>
                <td colspan="2">
                    <span><strong>PR No.:</strong></span>
                </td>
                <td colspan="2">
                    <span><strong>Date:</strong></span>
                </td>
            </tr>

            <tr class="bbm">
                <td class="br" colspan="2">
                    <span><strong>Section:</strong></span>
                </td>
                <td colspan="4">
                    <span><strong>FPP:</strong></span>
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

            @for($i = 1; $i <= 28; $i++)

                <tr class="bb">
                    <td class="br">&nbsp;</td>
                    <td class="br">&nbsp;</td>
                    <td class="br">&nbsp;</td>
                    <td class="br">&nbsp;</td>
                    <td class="br">&nbsp;</td>
                    <td class="">&nbsp;</td>
                </tr>

            @endfor

            <tr class="bbm btm">
               <td colspan="6">
                    <span><strong>Purpose:</strong></span> <br>
                    ______________________________________________________________________________________ <br>
                    ______________________________________________________________________________________ <br>
                    ______________________________________________________________________________________ <br><br>
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
                    <span>Designation</span>
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

        </table>

    </section>
</body>
</html>