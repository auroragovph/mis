<!doctype html>
<html lang="en">

<head>

    @include('layouts.includes.meta')

    
    <title>Aurora Management Information System.</title>

    @include('layouts.includes.styles')
</head>

<body class="antialiased">
    <div class="wrapper">
        @include('layouts.includes.header')

        @isset($__navigation__)
            @include($__navigation__)
        @else
            @include('layouts.includes.navbar')
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
                    @include('layouts.includes.alerts')
                    @section('content')
                    @show
                </div>
            </div>
            @include('layouts.includes.footer')


        </div>
    </div>


    @include('layouts.includes.scripts')
</body>

</html>
