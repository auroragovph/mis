@extends('filemanagement::layouts.master')



@section('page-title')
    {{ $track->action == 0 ? 'Receiving Page' : 'Releasing Page' }}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-3">
        <x-fms-qr :document="$document" :datas="$datas" />

        </div>
        <div class="col-md-5">
            <x-ui.card>
                <form method="POST" action="{{ route('fms.documents.rr.submit') }}">
                    @csrf
                    @method('PUT')

                    <x-ui.form.input label="Purpose" type="text" name="purpose" value="{{ old('purpose') }}" required
                        autocomplete="off" />

                    <x-ui.form.choices label="Status" name="status" required>
                        @foreach (collect(config('static-lists.status'))->pluck('name') as $key => $status)
                            <option value="{{ $key }}">{{ $status }}</option>
                        @endforeach
                    </x-ui.form.choices>

                    <div class="mt-10">
                        <button type="submit" class="btn btn-primary">
                            @if ($track->action == 0)
                                <i class="fas fa-file-download"></i> RECEIVE
                            @else
                                <i class="fas fa-file-upload"></i> RELEASE
                            @endif
                        </button>
                    </div>

                </form>
            </x-ui.card>
        </div>
        <div class="col-md-4">
            <x-ui.card title="Instructions" />
        </div>
    </div>
@endsection
