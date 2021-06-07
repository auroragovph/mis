
$("#ajax_form").submit(function (e) {
    e.preventDefault();

    _form = $("#ajax_form");

    $.ajax({
        url: _form.attr("action"),
        type: "POST",
        dataType: "json",
        data: _form.serialize(),
        success: function (Result) {
            
        },
        error: function (xhr) {
            switch (xhr.status) {
                case 422:
                    let firstKey = Object.keys(xhr.responseJSON.errors)[0];
                    let firstError = xhr.responseJSON.errors[firstKey][0];
                    var err = {title: "Invalid form submit", message: firstError}
                    break;

                default:
                    var err = {title: xhr.statusText, message: xhr.responseJSON.message}
                    break;
            }

            swal(err.title, err.message, "error");
        },
        beforeSend: function () {
            $(".card").append(`
                    <div class="overlay">
                        <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                    </div>
            `);
        },
        complete: function () {
            $(".card").children().last().remove();
            // _form.removeClass("whirl traditional");
        },
    });
});
