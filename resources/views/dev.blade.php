<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('plugins/paper/paper.css') }}">

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

    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-qrcode/jquery-qrcode.min.js') }}"></script>

    



</head>

<body class="A4 landscape">

<section class="sheet padding-5mm">

    <div class="container">
    
        <span id="canvas-parent-1"></span>
      
    
    </div>
    
    </section>


<script>
    
    $("#canvas-parent-1").qrcode({
            'render' : 'image',
            size: 130,
            fill: '#333',
            text: 'GSO-P-REMI',
            mode: 2,
            label: 'GSO-P-REMI',
            fontcolor: '#e41b17',
            minVersion: 10,
            maxVersion: 40,
            ecLevel: 'H',
        });
</script>


</body>
</html>