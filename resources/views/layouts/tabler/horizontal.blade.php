<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta3
* @link https://tabler.io
* Copyright 2018-2021 The Tabler Authors
* Copyright 2018-2021 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">

<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Aurora Management Information System.</title>

    @include('layouts.tabler.includes.styles')
</head>

<body class="antialiased">
    <div class="wrapper">
        @include('layouts.tabler.includes.header')

        @isset($__navigation__)
            @include($__navigation__)
        @else
            @include('layouts.tabler.includes.navbar')
        @endisset


        <div class="page-wrapper">
            <div class="container-xl">
                <!-- Page title -->
                <!-- Page title -->
                <div class="page-header d-print-none">
                    <div class="row align-items-center">
                        <div class="col">
                            <!-- Page pre-title -->
                            <div class="page-pretitle">
                                @yield('page-pretitle')
                            </div>
                            <h2 class="page-title">
                                @yield('page-title')
                            </h2>
                        </div>
                        <!-- Page title actions -->
                        <div class="col-auto ms-auto d-print-none">
                            @yield('page-action')
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-body">
                <div class="container-xl">
                    @include('layouts.tabler.includes.alerts')
                    @section('content')
                    @show
                </div>
            </div>
            @include('layouts.tabler.includes.footer')


        </div>
    </div>


    @include('layouts.tabler.includes.scripts')
</body>

</html>
