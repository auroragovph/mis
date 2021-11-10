<!doctype html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>@yield('html-title') Aurora Management Information System</title>

    @include('layouts.tabler.includes.styles')

</head>

<body class="antialiased d-flex flex-column">

    <slot />

    @section('content')
    @show

    @include('layouts.tabler.includes.scripts')

</body>

</html>
