
{{-- BIG --}}

@if(session('alert-success'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h5><i class="icon fas fa-check"></i> Success!</h5>
    {!! session('alert-success') !!}
  </div>
@endif

@if(session('alert-error'))
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h5><i class="icon fas fa-ban"></i> Error!</h5>
    {!! session('alert-error') !!}
  </div>
@endif

@if(session('alert-warning'))
<div class="alert alert-warning alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h5><i class="icon fas fa-exclamation-triangle"></i> Warning!</h5>
    {!! session('alert-warning') !!}
  </div>
@endif


{{-- SMALL --}}

@if(session('alert-success-sm'))
<div class="alert alert-success" role="alert">
    {!! session('alert-success-sm') !!}
</div>
@endif

@if(session('alert-error-sm'))
<div class="alert alert-danger" role="alert">
    {!! session('alert-error-sm') !!}
</div>
@endif

@if(session('alert-warning-sm'))
<div class="alert alert-warning" role="alert">
    {!! session('alert-warning-sm') !!}
</div>
@endif


@if($errors->any())
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger" role="alert">
            {{ $error }}
        </div>
    @endforeach
@endif


