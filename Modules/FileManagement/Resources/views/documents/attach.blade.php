@extends('layouts.master')


@section('page-title')
Document Attach
@endsection

@section('toolbar')
@endsection

@section('content')

@isset($document)
<div class="row">

    <div class="col-xl-4">
        <x-fms-qr :document="$document" />

    </div>
    <div class="col-xl-8">
        <div class="card card-custom  gutter-b">
            <!--begin::Header-->
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label font-weight-bolder text-dark">Attachment Form</span>
                </h3>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body">
               <form action="{{ route('fms.documents.attach.attach', $document->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="form-group">
                        <label for="">Attach documents without image/pdf:</label>
                        <select class="form-control select2" multiple name="tags[]">
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Attach documents with image/pdf:</label>
                        <input type="file" name="files[]" class="form-control" accept="image/*, .pdf" multiple>
                    </div>

                    <hr>

                    <button class="btn btn-primary">Attach</button>
               </form>
            </div>
            <!--end::Body-->
        </div>

        <x-fms-attachments :attachments="$document->attachments" />
    </div>
</div>
@else 
<div class="row">
    <div class="col-xl-12">
        <div class="card card-custom  gutter-b">
           
            <!--begin::Body-->
            <div class="card-body">
                <form action="{{ route('fms.documents.attach.check') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="">Document ID</label>
                        <input type="text" name="document" class="form-control" autofocus autocomplete="off">
                    </div>
                    <hr>
                    <button class="btn btn-primary"><i class="flaticon2-magnifier-tool"></i> Search</button>
                </form>
            </div>
            <!--end::Body-->
        </div>
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
<script>
    $(function () {
        //Initialize Select2 Elements
        $(".select2").select2({
            tags: true
        });
    });
</script>
@endsection


