@extends('filemanagement::layouts.app')

@section('page-title')
    Dashboard
@endsection

@section('breadcrumbs')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item active">Dashboard</li>
</ol>
@endsection

@section('content')

<div class="row">
    <div class="col-md-3 col-sm-6 col-12">
      <div class="info-box">
        <span class="info-box-icon bg-info"><i class="fal  fa-envelope"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Documents</span>
          <span class="info-box-number">1,410</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-12">
      <div class="info-box">
        <span class="info-box-icon bg-success"><i class="fal  fa-flag"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Bookmarks</span>
          <span class="info-box-number">410</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-12">
      <div class="info-box">
        <span class="info-box-icon bg-warning"><i class="fal  fa-copy"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Uploads</span>
          <span class="info-box-number">13,648</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-12">
      <div class="info-box">
        <span class="info-box-icon bg-danger"><i class="fal  fa-star"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Likes</span>
          <span class="info-box-number">93,139</span>
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