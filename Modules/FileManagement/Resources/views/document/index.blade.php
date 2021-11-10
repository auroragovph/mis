@extends('filemanagement::layouts.master')


@section('page-title', 'Document')


@section('content')
<div class="row row-deck row-cards">
    <div class="col-lg-5">
        <div class="row row-cards">
            <div class="col-md-6">
                @include('filemanagement::document.tile-form', [
                'tile_title' => "Leave",
                'tile_link' => route('fms.afl.index'),
                'tile_image' => "/assets/illustrations/undraw_windy_day_x63l.svg"
                ])
            </div>
            <div class="col-md-6">

                @include('filemanagement::document.tile-form', [
                'tile_title' => "Procurement",
                'tile_link' => route('fms.procurement.index'),
                'tile_image' => "/assets/illustrations/undraw_deliveries_131a.svg"
                ])

            </div>
            <div class="col-md-6">
                @include('filemanagement::document.tile-form', [
                'tile_title' => "Payroll",
                'tile_link' => '#',
                'tile_image' => "/assets/illustrations/undraw_wallet_aym5.svg"
                ])

            </div>
            <div class="col-md-6">
                @include('filemanagement::document.tile-form', [
                'tile_title' => "Travel",
                'tile_link' => route('fms.travel.order.index'),
                'tile_image' => "/assets/illustrations/undraw_Traveling_re_weve.svg"
                ])

            </div>

            <div class="col-12">
              @include('filemanagement::document.choices')
            </div>
        </div>
    </div>
</div>
@endsection
