$( "#login-form" ).submit(function(e) {

    e.preventDefault();

    var form = $('#login-form').serialize();


    var checker = $('#login-form').serializeArray();


    // sending AJAX
    var send = $.ajax({
        type: "POST",
        url: "/auth/signin",
        data: form,
        dataType: 'json',
        beforeSend: function(){

            // add whirl traditional
            $("#login-whirl").addClass("whirl traditional");
            
        }
    }).done((data) => {

        window.location = data.route;

    }).fail((data) => {

       
        if(data.status == 500){

            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "Internal Service Error. Please try again later."
            });

            return;
        }

        if(data.status == 429){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "Too many login attempts. Please try again later."
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
         $("#login-whirl").removeClass("whirl traditional");
    });

    


});