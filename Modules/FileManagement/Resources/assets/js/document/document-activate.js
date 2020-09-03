$('#form-activate').submit(function(e){

    e.preventDefault();

    var form = $('#form-activate').serialize();
    var checker = $('#form-activate').serializeArray();
    var url = $('#form-activate').attr('action');


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

        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: data.message
        });

        $('#form-activate').trigger('reset');


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