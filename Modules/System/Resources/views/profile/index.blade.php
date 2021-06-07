@extends('layouts.master')


@section('page-title', 'Profile')

@section('action')
@endsection

@section('content')
<div class="row">

    <div class="col-md-3">
        <x-ui.card>
            
            <div class="mb-10 text-center">

                <div class="mt-10">
                    @if(authenticated()->employee->info['image'] == null)
                        <img src="{{ asset('adminlte/dist/images/user.png') }}" class="elevation-2" width="130" height="130" alt="User Image">
                    @else 
                        <img src="{{asset('storage/employees/profile/'.authenticated()->employee->info['image'])  }}" class="elevation-2" width="130" height="130" alt="User Image">
                    @endif
                </div>

                <h4 class="my-2 mt-3">{{ name_helper(authenticated()->employee->name, 'FL') }}</h4>
                <div class="mb-2 text-muted">{{ authenticated()->employee->position->position ?? '' }}</div>
            </div>


            <!--begin::Contact-->
            <div class="mt-3 py-9">

                <p class="mr-2 font-weight-bold">
                    Office: <br>
                    <span class="text-muted font-weight-normal">{{ office_helper(authenticated()->employee->division) }}</span>
                </p>

                <p class="mr-2 font-weight-bold">
                    Status of Appointment: <br>
                    <span class="text-muted font-weight-normal">{{ authenticated()->employee->employment['type'] }}</span>
                </p>

            </div>
            <!--end::Contact-->

            <hr>

            

            @include('system::profile.toolbar')

        </x-ui.card>
    </div>



    <div class="col-md-9">
        <div class="tab-content" id="myTabContent5">
            @include('system::profile.tabs.information')
            @include('system::profile.tabs.employment')
            @include('system::profile.tabs.credentials')
            @include('system::profile.tabs.logs', ['logs' => []])
        </div>
    </div>
    
</div>
@endsection


@section('css-vendor')
@livewireStyles()
<!-- Toastr -->
<link rel="stylesheet" href="{{ asset('adminlte/plugins/toastr/toastr.min.css') }}">
@endsection

@section('css-custom')
@endsection


@section('js-vendor')
@livewireScripts()

<!-- AlpineJS -->
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

<!-- Toastr -->
<script src="{{ asset('adminlte/plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/toastr/toastr.event.js') }}"></script>
@endsection

@section('js-custom')
<script src="{{ asset('js/Modules/System/pages/profile.js') }}"></script>
@endsection