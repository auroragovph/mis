<!doctype html>
<html lang="en">

<head>

    @include('layouts.partials.meta')

    <title>Empty page - Tabler - Premium and Open Source dashboard template with responsive and high quality UI.</title>

    @include('layouts.partials.styles')


</head>

<body>
    <div class="wrapper">

        @include('layouts.horizontal.header')

        @isset($__navigation__)
            @include($__navigation__)
        @endisset



        <div class="page-wrapper">
            <div class="container-xl">

                @hasSection('page-title')

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
                        </div>
                    </div>

                @endif



            </div>
            <div class="page-body">
                <div class="container-xl">
                    <!-- Content here -->
                    @section('content')
                    @show

                    {{ $slot ?? '' }}
                </div>
            </div>

            @include('layouts.horizontal.footer')

        </div>
    </div>
    @include('layouts.partials.scripts')
</body>

</html>
