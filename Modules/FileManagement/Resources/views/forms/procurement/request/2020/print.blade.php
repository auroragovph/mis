<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> Purchase Request  |  {{ $pr->document->qr }} </title>

    @include('filemanagement::forms._includes.print.styles')
    
</head>
<body class="A4">

    <section class="sheet padding-5mm">

        @include('filemanagement::forms._includes.print.header')

        <div class="content">

        </div>

        @include('filemanagement::forms._includes.print.footer', [
            'qrcode' => $pr->document->qr
        ])
       
    </section>
   
</body>
</html>