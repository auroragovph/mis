<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Application For Leave |  {{ $afl->document->qr }} </title>

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

        .afl-title{
            padding: 0;
            margin: 0;
            font-weight: bolder;
        }

    
    </style>  
    


</head>
<body class="A4">
        <section class="sheet padding-5mm">

            <p> CSC Form 6 <br> Revised 1998 </p>
            

            <table class="bt bb">

                <tr>
                    <td colspan="4" class="text-center bb">
                        <h3 class="afl-title">APPLICATION FOR LEAVE</h3>
                    </td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                </tr>


                <tr class="bb">
                    <td width="25%">
                        1.Office / Agency <br> &nbsp;
                    </td>

                    <td width="25%">
                        2.Name (Last)
                    </td>

                    <td width="25%">
                        (First)
                    </td>

                    <td width="25%">
                        (Middle)
                    </td>
                </tr>

                <tr class="bb">
                    <tr>
                        <td>3. Date of Filling  <br> &nbsp;</td>
                        <td colspan="2">4. Position</td>
                        <td>5. Salary</td>
                    </tr>
                </tr>

                <tr class="bt">
                    <td colspan="4" class="text-center bb">
                        <h3 class="afl-title">DETAILS OF APPLICATION</h3>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">

                        6.A) Type of Leave <br><br>

                        <span style="margin-left: 10px;">{!! checkbox_svg('20px', '20px', 'uncheck') !!}</span> <span style="display:inline; margin-left: 10px; margin-top: -100px;">Vacation</span>

                    </td>
                </tr>

            </table>
           
        </section>
</body>
</html>