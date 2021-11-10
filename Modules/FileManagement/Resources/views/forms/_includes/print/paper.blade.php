<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> {{ $html_title ?? 'Aurora Management Information System' }} </title>

    @include('filemanagement::forms._includes.print.styles')
    
</head>
<body class="{{ $paper_size ?? 'A4' }}">

    <section class="sheet padding-{{ $paper_padding ?? '5mm' }}">

        @include('filemanagement::forms._includes.print.header')

        <div class="content" style="height: 85%;">

            @section('content')
                
            @show
            
        </div>



        @include('filemanagement::forms._includes.print.footer')
       
    </section>
   
</body>
</html>