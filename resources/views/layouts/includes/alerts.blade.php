
{{-- BIG --}}

@if(session('alert-success'))
<div class="alert alert-custom alert-success fade show" role="alert">
    <div class="alert-icon"><i class="la la-check-double"></i></div>
    <div class="alert-text">{{ session('alert-success') }}</div>
    <div class="alert-close">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"><i class="ki ki-close"></i></span>
        </button>
    </div>
</div>
@endif

@if(session('alert-danger'))
<div class="alert alert-custom alert-danger fade show" role="alert">
    <div class="alert-icon"><i class="la la-times"></i></div>
    <div class="alert-text">{{ session('alert-danger') }}</div>
    <div class="alert-close">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"><i class="ki ki-close"></i></span>
        </button>
    </div>
</div>
@endif

@if(session('alert-warning'))
<div class="alert alert-custom alert-warning fade show" role="alert">
    <div class="alert-icon"><i class="la la-warning"></i></div>
    <div class="alert-text">{{ session('alert-warning') }}</div>
    <div class="alert-close">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"><i class="ki ki-close"></i></span>
        </button>
    </div>
</div>
@endif


{{-- SMALL --}}

@if(session('alert-success-sm'))
<div class="alert alert-success" role="alert">
    {{ session('alert-success-sm') }}
</div>
@endif

@if(session('alert-danger-sm'))
<div class="alert alert-danger" role="alert">
    {{ session('alert-danger-sm') }}
</div>
@endif

@if(session('alert-warning-sm'))
<div class="alert alert-warning" role="alert">
    {{ session('alert-warning-sm') }}
</div>
@endif


@if($errors->any())
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger" role="alert">
            {{ $error }}
        </div>
    @endforeach
@endif


