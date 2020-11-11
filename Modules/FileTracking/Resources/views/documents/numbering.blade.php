@extends('filetracking::layouts.app')

@section('page-title')
    Numbering
@endsection

@section('breadcrumbs')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('fts.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Starter Page</li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div id="whirl" class="card p-3">
            <form id="form-number" method="POST" action="{{ route('fts.documents.number.search') }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="">Document QR</label>
                    <input type="text" name="series" class="form-control" required autofocus>
                </div>
                <hr>
                <div class="form-group">
                    <button class="btn bg-gradient-primary"><i class="fal fa-search"></i> Search</button>
                </div>
            </form>
            
        </div>
    </div>
</div>

<div class="modal fade" id="numberModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" data-card="true" id="modal-card">
        <div id="whirl-2" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Document Numbering</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="fal fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="card bg-danger p-5">
                    <h1 id="modal-num" class="font-weight-bolder text-center text-white">TO-123</h1>
                    <small id="modal-last" class="text-center text-white">LAST PR NUMBER</small>
                </div>

                <hr>

                <form id="form-num" method="POST" action="{{ route('fts.documents.number.number') }}">
                    @csrf
                <div class="form-group">
                    <label for="">Number</label>
                    <input type="hidden" name="document" value="">
                    <input type="hidden" name="type" value="">
                    <input type="text" name="number" class="form-control" required>
                </div>

            </div>
            <div class="modal-footer justify-content-center">
                <button type="submit" class="btn bg-gradient-primary">Save</button>
            </div>

            </form>
        </div>
    </div>
</div>
@endsection





@section('css-vendor')
<link rel="stylesheet" href="{{ asset('plugins/whirl/whirl.css') }}">
    
@endsection

@section('css-custom')
    
@endsection


@section('js-vendor')
<script src="{{ asset("plugins/sweetalert2/sweetalert2.all.min.js")}}"></script>
    
@endsection

@section('js-custom')
<script>
$('#form-number').submit(function(e){

e.preventDefault();

var form = $('#form-number').serialize();
var checker = $('#form-number').serializeArray();
var url = $('#form-number').attr('action');


// sending AJAX
var send = $.ajax({
    type: "POST",
    url: url,
    data: form,
    dataType: 'json',
    beforeSend: function(){

        // add whirl traditional
        $("#whirl").addClass("whirl traditional");
        
    }
}).done((data) => {

    $('#modal-num').text(data.data.last);
    $('#modal-last').text(data.data.type);
    $('input[name="document"]').val(data.data.meta.id);
    $('input[name="type"]').val(data.data.meta.type);


    $('#numberModal').modal('show');


}).fail((data) => {

   
    if(data.status == 500){

        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "Internal Service Error. Please try again later."
        });

        return;
    }

    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: data.responseJSON.message
    });

}).always(()=>{
     // remove whirl traditional
     $("#whirl").removeClass("whirl");
     $("#whirl").removeClass("traditional");
});




// console.log(checker);

});




$('#form-num').submit(function(e){

e.preventDefault();

var form = $('#form-num').serialize();
var checker = $('#form-num').serializeArray();
var url = $('#form-num').attr('action');


// sending AJAX
var send = $.ajax({
    type: "POST",
    url: url,
    data: form,
    dataType: 'json',
    beforeSend: function(){

        // add whirl traditional
        $("#whirl-2").addClass("whirl traditional");
        
    }
}).done((data) => {

    $('#numberModal').modal('hide');
    $('#form-number').trigger('reset');
    $('#form-num').trigger('reset');

    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: data.message
    });


}).fail((data) => {

   
    if(data.status == 500){

        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "Internal Service Error. Please try again later."
        });

        return;
    }

    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: data.message
    });

}).always(()=>{
     // remove whirl traditional
     $("#whirl-2").removeClass("whirl");
     $("#whirl-2").removeClass("traditional");
});




// console.log(checker);

});
</script>
@endsection