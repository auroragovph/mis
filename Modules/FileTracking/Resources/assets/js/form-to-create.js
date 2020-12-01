$(function () {
    $(".select2").select2({
        placeholder: "Select from list",
        allowClear: true
      });

    $(".people-select2").select2({tags: true});

    $(".select2-tags").select2({tags: true});


    var dt = $("#dataTables").DataTable({
        "processing": true,
        "serverSide": true,
        sDom: 'lrtip',
      ajax: window.location.href,
      columns: [

        { data: 'encoded' },
        { data: 'series' },
        { data: 'office' },

        { data: 'number' },
        { data: 'employees' },
        { data: 'destination' },
        { data: 'departure' },
        { data: 'arrival' },
        { data: 'purpose' },

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


        $('#modal-create').modal('hide');
        form.trigger('reset');

        $(".select2").select2({
          placeholder: "Select from list"
        });

        $(".people-select2").select2({tags: true});
        $(".select2-tags").select2({tags: true});


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

    $("#form-search").submit(function(e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.
        dt.search('MODAL_SEARCH');
        dt.columns(0).search($('input[name="search-encoded"]').val());
        dt.columns(1).search($('input[name="search-series"]').val());
        dt.columns(2).search($('select[name="search-division"]').val());
        dt.columns(9).search($('select[name="search-status"]').val());

        dt.columns(3).search($('input[name="search-number"]').val());
        dt.columns(4).search($('input[name="search-employee"]').val());
        dt.columns(5).search($('input[name="search-destination"]').val());
        dt.columns(6).search($('input[name="search-departure"]').val());
        dt.columns(7).search($('input[name="search-arrival"]').val());
        dt.columns(8).search($('input[name="search-purpose"]').val());
        dt.draw();
    
        $('#modal-search').modal('hide');
    
    
    
      });
    
      $("#form-reset").on("click",function(e) {
    
        $("#form-search").trigger('reset');
        
        $(".select2").select2({
          placeholder: "Select from list",
          allowClear: true
        });
    
        dt.search('');
        dt.draw();
    
    
      });
    
    
});