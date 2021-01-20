<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/Modules/FileManagement/paper.css') }}">


    <style>

    img{
        width: 2.6cm;
        height: 2.6cm;
        margin: 3px;
    }

    .container{
        margin: auto;
    }

    @page { size: A4 landscape ; }
    </style>

    <script src="{{ asset('plugins/custom/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/custom/jquery-qrcode/jquery-qrcode.min.js') }}"></script>

    



</head>

<body class="A4 landscape">

@foreach($pages as $page)
<section class="sheet padding-5mm">

    <div class="container">
    
        @foreach($page as $qr)
            <span id="canvas-parent-{{ $qr }}"></span>
    
            <script>
    
                $("#canvas-parent-{{ $qr }}").qrcode({
                        'render' : 'image',
                        size: 130,
                        fill: '#333',
                        text: '{{ $qr }}',
                        mode: 2,
                        label: '{{ fts_series($qr, "encode") }}',
                        fontcolor: '#e41b17',
                        minVersion: 1,
                        maxVersion: 10,
                        ecLevel: 'H',
                      });
            </script>
    
        @endforeach
    
    
    </div>
    
    </section>
@endforeach
</body>
</html>