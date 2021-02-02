@extends('layouts.master')


@section('page-title')
@endsection

@section('toolbar')
@endsection

@section('content')
<div id="canvas"></div>
@endsection


@section('css-vendor')
@endsection

@section('css-custom')
@endsection


@section('js-vendor')
<script type="text/javascript" src="{{ asset('plugins/cdn/qrcode/qrcode.js') }}"></script>
@endsection

@section('js-custom')

<script type="text/javascript">
    $('#canvas').qrcode({
    // render method: 'canvas', 'image' or 'div'
    render: 'canvas',

    // version range somewhere in 1 .. 40
    minVersion: 1,
    maxVersion: 40,

    // error correction level: 'L', 'M', 'Q' or 'H'
    ecLevel: 'H',

    // offset in pixel if drawn onto existing canvas
    left: 0,
    top: 0,

    // size in pixel
    size: 200,

    // code color or image element
    fill: '#000',

    // background color or image element, null for transparent background
    background: null,

    // content
    text: 'LASDJKLSFLKF',

    // corner radius relative to module width: 0.0 .. 0.5
    radius: 0,

    // quiet zone in modules
    quiet: 1,

    // modes
    // 0: normal
    // 1: label strip
    // 2: label box
    // 3: image strip
    // 4: image box

    mode: 4,

    mSize: 0.1,
    mPosX: 0.5,
    mPosY: 0.5,

    label: 'SR-00000000001',
    fontname: 'sans-serif',
    fontcolor: '#000',

    image: "{{ asset('media/logos/logo-md.png') }}"
});
</script>
@endsection


