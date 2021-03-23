@extends('layouts.master')


@section('page-title')
Receive / Release
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
                    @if($track->action == 0)
                        <button type="submit" class="btn btn-primary"> <i class="fas fa-file-download"></i> RECEIVE</button>
                    @else 
                        <button type="submit" class="btn btn-primary"> <i class="fas fa-file-upload"></i> RELEASE</button>
                    @endif
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
@endsection

@section('css-custom')
@endsection


@section('js-vendor')
@endsection

@section('js-custom')
{{-- <script src="{{ asset('js/Modules/FileManagement/pages/documents/rr.js') }}"></script> --}}
@endsection