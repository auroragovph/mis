@extends('layouts.master')


@section('page-title')

    @isset($document)
        {{ ($track->action == 0) ? 'Receiving Page' : 'Releasing Page' }}
    @else 
        Receive / Release
    @endisset

@endsection

@section('toolbar')
@endsection

@section('content')

@isset($document)
<div class="row">
    <div class="col-xl-4">
        <x-fms-qr :document="$document" :datas="$datas" />

    </div>
    <div class="col-xl-8">
        @php($title_form = ($track->action == 0) ? 'Receive Form' : 'Release Form')
        <x-ui.card :title="$title_form">
            <form method="POST" action="{{ route('fms.documents.rr.submit') }}">
                @csrf
                @method('PUT')

                <x-ui.form.input label="Purpose" type="text" name="purpose" value="{{ old('purpose') }}" required autocomplete="off"/>

                <x-ui.form.select2 label="Status" name="status" required>
                    @foreach(collect(config('static-lists.status'))->pluck('name') as $key => $status)
                        <option value="{{ $key }}">{{ $status }}</option>
                    @endforeach
                </x-ui.form.select2>
    
                <hr>
    
                <div class="mt-10">
                    <button type="submit" class="btn btn-primary"> 
                        @if($track->action == 0)
                            <i class="fas fa-file-download"></i> RECEIVE
                        @else 
                            <i class="fas fa-file-upload"></i> RELEASE
                        @endif
                    </button>
                </div>
                
            </form>
        </x-ui.card>
        
    </div>
</div>
@else 
<div class="row">
    <div class="col-xl-12">
        <x-ui.card>
            <form action="{{ route('fms.documents.rr.form') }}" method="POST">
                @csrf

                <x-ui.form.input label="Document ID" type="text" name="document" value="{{ old('document') }}" required autofocus/>
                <x-ui.form.input label="Liaison QR" type="password" name="liaison" required />

                <hr>
                <button class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
            </form>
        </x-ui.card>
    </div>
</div>
@endisset

@endsection


@section('css-vendor')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
@endsection

@section('css-custom')
@endsection


@section('js-vendor')
<!-- Select2 -->
<script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
@endsection

@section('js-custom')
<script>
    $(function () {
        //Initialize Select2 Elements
		$(".select2").select2({
			placeholder: "Select in the list",
		});
    })
</script>
@endsection