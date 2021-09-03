@extends('filemanagement::forms._includes.print.paper', [
'qrcode' => $pr->document->qrcode,
'html_title' => 'Purchase Request',
'appendix' => 'Appendix 47'
])


@section('content')
    <div class="border-t-2 border-l-2 border-r-2 border-black">

        <div>
            <h3 class="text-center uppercase text-2xl font-bold">
                Purchase Request
            </h3>
        </div>

        <div class="mt-3 flex justify-between">
            <p>LGU: <span></span></p>
            <p>FUND: ____</p>
        </div>

    </div>
@endsection
