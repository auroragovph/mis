<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> Travel Order  |  {{ $to->document->qr }} </title>

    @include('filemanagement::forms._includes.print.styles')

    <link rel="stylesheet" href="{{ asset('css/Modules/FileManagement/forms/travel/order/print.css') }}">

</head>
<body class="A4">

    <section class="sheet padding-5mm">

        @include('filemanagement::forms._includes.print.header')

        <div class="content">

            <h1 class="text-center">TRAVEL ORDER</h1>

                <table>
                    <tr>
                        <td width="75%" class="text-right">NO :</td>
                        <td width="25%" class="bb text-center"> {{ $to->number }}  </td>
                    </tr>
                    <tr>
                        <td width="75%" class="text-right">Date :</td>
                        <td width="25%" class="bb text-center"> {{ Carbon\Carbon::parse($to->document->created_at)->format('m/d/Y') }}  </td>
                    </tr>
                </table>

                <table>
                    <tr>
                        <td width="40%" style="padding-left: 30px">
                            <i>Name/s:</i>
                        </td>
                        <td width="60%">
                            @foreach($to->lists as $employee)
                            <p class="namedes"><strong>{{ name_helper($employee->employee->name) }}</strong> - {{ $employee->employee->position->position ?? '' }} </p>
                            @endforeach
                        </td>
                    </tr>
            
                    <tr>
                        <td class="pt-2" width="40%" style="padding-left: 30px">
                            <i>Destination:</i>
                        </td>
                        <td width="60%">
                            <strong> {{ $to->destination }} </strong>
                        </td>
                    </tr>
            
                    <tr>
                        <td class="pt-2" width="40%" style="padding-left: 30px">
                            <i>Date of Departure:</i>
                        </td>
                        <td width="60%">
                            <strong> {{ \Carbon\Carbon::parse($to->departure)->format('F d, Y') }} </strong>
                        </td>
                    </tr>
            
                    <tr>
                        <td class="pt-2" width="40%" style="padding-left: 30px">
                            <i>Date of Arrival:</i>
                        </td>
                        <td width="60%">
                            <strong>{{ \Carbon\Carbon::parse($to->arrival)->format('F d, Y') }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="pt-2" width="40%" style="padding-left: 30px">
                            <i>Purpose of Travel:</i>
                        </td>
                        <td width="60%">
                            <strong>
                                {{ $to->purpose }}
                            </strong>
                        </td>
                    </tr>
            
                    <tr>
                        <td class="pt-2" width="40%" style="padding-left: 30px">
                            <i>Charging Office:</i>
                        </td>
                        <td width="60%">
                            <strong>
                                {{ office_helper($to->charging) }}
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="pt-2" width="40%" style="padding-left: 30px">
                            <i>Special Instruction:</i>
                        </td>
                        <td width="60%">
                            <strong>
                                {{ $to->document->instruction }}
                            </strong>
                        </td>
                    </tr>
            
                </table>

                <br><br>
                <br><br>

                <table>
                    <tr>
                        <td width="40%">Recommending Approval:</td>
                        <td width="60%">&nbsp;</td>
                    </tr>
                </table>
                <br><br>
                <table>
                    <tr>
                        <td class="text-center" width="40%"><strong>{{strtoupper(name_helper($to->approval->name ?? ''))}}</strong></td>
                        <td class="text-center" width="60%">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="text-center"><em> {{ $to->approval->position->position ?? '' }}  </em></td>
                        <td>&nbsp;</td>
                    </tr>
                </table>
            
                <table>
                    <tr>
                        <td width="60%">&nbsp;</td>
                        <td width="40%">Approved:</td>
                    </tr>
                </table>
            
                <br><br>
                <table>
                    <tr>
                        <td width="60%">&nbsp;</td>
                        <td class="text-center" width="40%"><strong>GERARDO A. NOVERAS</strong></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td class="text-center"><em>Governor</em></td>
                    </tr>
                </table>

            
        </div>

        @include('filemanagement::forms._includes.print.footer', [
            'qrcode' => $to->document->qr
        ])
    </section>
   
</body>
</html>