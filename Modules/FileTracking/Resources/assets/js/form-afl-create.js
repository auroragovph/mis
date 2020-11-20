$(function () {

    $(".select2").select2({
      placeholder: "Select from list",
    });
    $(".select2-type").select2({
      tags: true
    });

    $(".select2-tags").select2({tags: true});


    $('#datepicker').datepicker({
      multidate: true,
      clearBtn: true,
    });

    var dt = $("#dataTables").DataTable({
      processing: true,
      ajax: window.location.href,
      columns: [
        { data: 'encoded' },
        { data: 'series' },
        { data: 'office' },

        { data: 'name' },
        { data: 'position' },
        { data: 'type' },
        { data: 'inclusives' },

        { data: 'status' },
        { 
          data: 'action',
          searchable: false,
          orderable: false
        },
      ],
      "responsive": true,
      "autoWidth": false,
    });



    $("#form-create").submit(function(e) {

      e.preventDefault(); // avoid to execute the actual submit of the form.

      var form = $(this);
      var url = form.attr('action');


      // add whirl traditional
      $(".modal-content").addClass("whirl traditional");

      $.post(url, form.serialize(), function(data){

        dt.ajax.reload();

        $('#modal-create').modal('hide');
        form.trigger('reset');

        $(".select2").select2({
          placeholder: "Select from list"
        });

        $(".select2-type").select2({
          tags: true
        });

        $(".select2-tags").select2({tags: true});


        $('#datepicker').datepicker({
          multidate: true,
          clearBtn: true,
        });

        window.open(data.receipt, '_blank');


        Swal.fire({
          icon: 'success',
          title: 'Success!',
          text: data.message
        });



      }).fail(function(data){

        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: data.responseJSON.message
        });
        
      }).always(function(){

        $(".modal-content").removeClass("whirl");
        $(".modal-content").removeClass("traditional");

      });


    });
});