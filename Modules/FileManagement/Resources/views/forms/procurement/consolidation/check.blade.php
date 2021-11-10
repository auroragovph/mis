@extends('layouts.master')


@section('page-title')
Purchase Request Consolidation
@endsection

@section('toolbar')
@endsection

@section('content')
<div class="row">
    <div class="col-xl-6">
        <div class="card card-custom gutter-b">
            <!--begin::Body-->
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Document ID</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($qrcodes as $qrcode)
                            <tr @if($qrcode['message'] !== null) class="bg-danger" @endif>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $qrcode['document'] }}</td>
                                <td>{{ $qrcode['message'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!--end::Body-->
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <h3 class="card-title">Consolidation Check Form</h3>
            </div>
            <!--begin::Body-->
            <div class="card-body">
                <form action="{{ route('fms.procurement.consolidate.form') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="">You cannot include highlighted purchase requests. Do you want to continue?</label>
                        <br>
                        <button type="submit" class="btn btn-primary mt-3">Continue</button>
                    </div>
                </form>
            </div>
            <!--end::Body-->
        </div>
    </div>
</div>
@endsection


@section('css-vendor')
@endsection

@section('css-custom')
@endsection


@section('js-vendor')
@endsection

@section('js-custom')
@endsection


