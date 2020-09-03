$(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });

    $(".select2").select2({
      placeholder: "Select from list"
  });
});





$( "#user-create-form" ).submit(function(e) {

    e.preventDefault();

    var form = $('#user-create-form').serialize();
    var url = $('#user-create-form').attr('action');
    var checker = $('#user-create-form').serializeArray();

    if(checker[3].value !== checker[4].value){

        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "Password mismatch"
        });


    }

    
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

        location.reload();

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
         $("#whirl").removeClass("whirl traditional");
    });

    


});