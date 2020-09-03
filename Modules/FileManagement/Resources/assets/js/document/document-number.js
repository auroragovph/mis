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