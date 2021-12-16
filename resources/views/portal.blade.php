@extends('layouts.horizontal.index', [
'__module_title__' => strtoupper('Provincial Government of Aurora')
])


@section('content')
    <div class="text-center mb-1">
        <img src="/logo/md.png" height="100" class="mb-4">
        <h1 class="mb-4">System Modules</h1>
    </div>

    <div class="row row-cards justify-content-center">

        @php
            $modules = include base_path('resources/views/modules.php');
        @endphp

        @foreach ($modules as $module)

            <div class="col-md-6 col-xl-3">
                <div class="card h-100">
                    <div class="card-body text-center">

                        <img src="{{ $module['image'] }}" alt="" width="50%" height="50%">

                        <div class="card-title mb-1 mt-3">{{ $module['name'] }}</div>
                        <div class="text-muted">{{ $module['description'] }}</div>
                    </div>

                    <a href="{{ $module['url'] }}" class="card-btn">Access</a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
