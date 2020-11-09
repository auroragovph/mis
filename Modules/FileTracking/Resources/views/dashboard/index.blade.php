@extends('filetracking::layouts.app')

@section('page-title')
    
@endsection

@section('breadcrumbs')

@endsection

@section('content')
<div class="row">
    <div class="col-md-3 col-sm-6 col-12">
      <div class="info-box">
        <span class="info-box-icon bg-info"><i class="fal  fa-file"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Documents</span>
          <span class="info-box-number">{{ number_format($datas['documents']) }}</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-12">
      <div class="info-box">
        <span class="info-box-icon bg-success"><i class="fal fa-user"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Employees</span>
          <span class="info-box-number">{{ number_format($datas['employees']) }}</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-12">
      <div class="info-box">
        <span class="info-box-icon bg-warning"><i class="fal fa-clipboard-user"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Liaisons</span>
          <span class="info-box-number">{{ number_format($datas['liaisons']) }}</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-12">
      <div class="info-box">
        <span class="info-box-icon bg-danger"><i class="fal  fa-qrcode"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Available QR Code</span>
          <span class="info-box-number">{{ number_format($datas['qr']) }}</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->
@endsection




@section('css-vendor')
    
@endsection

@section('css-custom')
    
@endsection


@section('js-vendor')
    
@endsection

@section('js-custom')
    
@endsection