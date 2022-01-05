@extends('fms::layouts.master')

@section('title')
  @if($track->action == \DocumentTrackEnum::RELEASE->value)
    Receiving Page
  @else
    Releasing Page
  @endif
@endsection

@section('pretitle', 'Document')

@section('content')

    <div class="row">
        <div class="col-md-3">
        <x-fms-qr :series="$document" :datas="$datas" />

        </div>
        <div class="col-md-5">
            <x-ui.card>
                <form method="POST" action="{{ route('fms.document.rr.submit') }}">
                    @csrf
                    @method('PUT')

                    <x-ui.form.input label="Purpose" type="text" name="purpose" value="{{ old('purpose') }}" required
                        autocomplete="off" />

                    <x-ui.form.choices label="Status" name="status" required>
                        @foreach (\DocumentStatusEnum::lists('formal') as $key => $status)
                            <option value="{{ $key }}">{{ $status }}</option>
                        @endforeach
                    </x-ui.form.choices>

                    <div class="mt-10">
                        <button type="submit" class="btn btn-primary">
                            @if ($track->action == \DocumentTrackEnum::RELEASE->value)
                                <x-ui.icon icon="download" /> RECEIVE
                            @else
                              <x-ui.icon icon="upload" /> RELEASE
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
