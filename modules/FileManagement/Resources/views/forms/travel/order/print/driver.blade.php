<html>
    <head>
        <link rel="stylesheet" href="css/modules/FileManagement/forms/travel_order/print.css">
        <link rel="stylesheet" href="css/modules/FileManagement/forms/table_helper.css">
    <body>
        @include('filemanagement::forms.travel.order.print.header')
        @include('filemanagement::forms.travel.order.print.footer', [
            'qrcode' => $to->document->qrcode
        ])

        <script type="text/php">
            if ( isset($pdf) ) {
                $pdf->page_text(250, 815, "Page {PAGE_NUM} of {PAGE_COUNT}", "Arial", 10, array(0,0,0));
            }
        </script>
       

        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
            <p class="number" style="margin-right: 100px;">No.: 
                @if($to->number == null)
                ___________
                @else
                <span><u>{{ $to->number }}</u></span>
                @endif
            </p>

            <br><br>

            <table>
    
                @php($employee_count = count($to->employees))
    
                <tr>
                    <td class="top-left" width="30%" rowspan="{{ $employee_count + 1 }}">Name and Designation</td>
                </tr>
    
                @foreach($to->employees as $employee)
                <tr>
                    <td class="bb">
                        {{ $employee['name'] }} - {{ $employee['position'] }}
                    </td>
                </tr>
                @endforeach
    
              
    
                @if($employee_count < 10)
                    @for($i = $employee_count; $i < 9; $i++)
                        <tr>
                            <td class="bb">
                                &nbsp;
                            </td>
                        </tr>
                    @endfor
                @endif
    
                <tr>
                    <td>Destination</td>
                    <td class="bb">
                        <p>{{ $to->destination }}</p>
                    </td>
                </tr>
    
                <tr>
                    <td>Date of Departure</td>
                    <td class="bb">{{ $to->departure->format('F d, Y') }}</td>
                </tr>
    
                <tr>
                    <td>Date of Arrival</td>
                    <td class="bb">{{ $to->arrival->format('F d, Y') }}</td>
                </tr>
    
                <tr>
                    <td class="top-left" >Purpose</td>
                    <td class="bb">
                        <p>{{ $to->purpose }}</p>
                    </td>
                </tr>
    
                <tr>
                    <td class="top-left" >Special Instruction</td>
                    <td class="bb">
                        <p>{{ $to->instruction }}</p>
                    </td>
                </tr>
    
                <tr>
                    <td>Charging Office</td>
                    <td class="bb">
                        {{ office($to->charging) }}
                    </td>
                </tr>
    
            </table>
    
            <br><br>
    
            <table>
                <tr>
                    <td width="40%">
                        <p>Recommending Approval</p>
    
                        <br> <br>
    
                    </td>
                    <td width="20%"></td>
                    <td width="40%">
                        <p>Approved By</p>
                        <br> <br>
                    </td>
                </tr>
    
                <tr>
                    <td class="bb">
                        <p class="text-center"><strong>{{ strtoupper($to->signatories['requester']['name']) }}</strong></p>
                    </td>
                    <td></td>
                    <td class="bb">
                        <p class="text-center"><strong>{{ strtoupper($to->signatories['approval']['name']) }}</strong></p>
                    </td>
                </tr>
    
                <tr>
                    <td>
                        <p class="text-center"><em>{{ $to->signatories['requester']['position'] }}</em></p>
    
                    </td>
                    <td></td>
                    <td>
                        <p class="text-center"><em>{{ $to->signatories['approval']['position'] }}</em></p>
                    </td>
                </tr>
    
              
    
            </table>
        </main>
    </body>
</html>
