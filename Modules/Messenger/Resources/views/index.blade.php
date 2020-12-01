@extends('layouts.vertical')


@section('content')
<div class="row">
    @include('messenger::contacts')


    {{-- @include('messenger::chat')
    @include('messenger::profile') --}}

    @isset($convos)
        @include('messenger::chat')
        @include('messenger::profile')
    @else 
        @include('messenger::banner')
    @endisset
    

</div>
@endsection


@section('css-vendor')
@endsection

@section('css-custom')
    
@endsection


@section('js-vendor')
<script src="{{ asset("plugins/sweetalert2/sweetalert2.all.min.js")}}"></script>
    
@endsection

@section('js-custom')
<script>
    $(function () {
      
      $("#form-send").submit(function(e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.

        var form = $(this);
        var url = form.attr('action');



        $.post(url, form.serialize(), function(data){

          form.trigger('reset');


        //   attach to the dom

        let container = document.getElementById('message-box');

        container.insertAdjacentHTML('beforeEnd', `
            <div class="direct-chat-msg right">
              <div class="direct-chat-infos clearfix">
                <span class="direct-chat-timestamp float-left">${data.convo.time}</span>
              </div>
              <!-- /.direct-chat-infos -->
              <img class="direct-chat-img" src="${data.convo.image}" alt="Message User Image">
              <!-- /.direct-chat-img -->
              <div class="direct-chat-text">
                ${data.convo.text}
              </div>
              <!-- /.direct-chat-text -->
            </div>
        `);


        }).fail(function(data){

          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: data.responseJSON.message
          });
          
        }).always(function(){

    

        });


      });
    });
</script>
@endsection