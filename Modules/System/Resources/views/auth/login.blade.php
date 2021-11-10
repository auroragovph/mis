@extends('layouts.clean')

@section('content')
    <div class="page page-center">
        <div class="container-tight py-4">
            <div class="text-center mb-1">
                <a href="#">
                    <img src="/assets/logo/banner.png" height="150">
                </a>
            </div>

            <form class="card card-md" action="/login" method="post">

                @csrf
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Login to your account</h2>



                    @if ($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    
                    <x-ui.form.input label="Username" name="username" placeholder="Enter username"
                        value="{{ old('username') }}" required />

                    <x-ui.form.input type="password" label="Password" name="password" placeholder="Enter password"
                        autocomplete="off" required />


                    <div class="mb-3">
                        <label class="form-check">
                            <input type="checkbox" class="form-check-input" name="remember" />
                            <span class="form-check-label">Remember me on this device</span>
                        </label>
                    </div>

                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">Sign in</button>
                    </div>

                </div>

            </form>

            <div class="text-center text-muted mt-3">
                Developed By: MIS-TEAM
            </div>
        </div>
    </div>

@endsection
