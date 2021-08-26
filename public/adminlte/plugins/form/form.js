/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!***************************************************************!*\
  !*** ./Modules/System/Resources/assets/js/pages/ajax_form.js ***!
  \***************************************************************/
$("#ajax_form").submit(function (e) {
  e.preventDefault();
  _form = $("#ajax_form");
  $.ajax({
    url: _form.attr("action"),
    type: _form.attr("method"),
    dataType: "json",
    data: _form.serialize(),
    success: function success(Result) {
      var _Result$message;

      Swal.fire({
        title: 'Success',
        text: (_Result$message = Result.message) !== null && _Result$message !== void 0 ? _Result$message : 'Success',
        icon: 'success',
        showCancelButton: false,
        confirmButtonText: 'Ok.',
        allowOutsideClick: false
      }).then(function (result) {
        if (result.isConfirmed) {
          if ("intended" in Result) {
            window.location = Result.intended;
          }
        }
      });
    },
    error: function error(xhr) {
      var _xhr$responseJSON$mes;

      switch (xhr.status) {
        case 422:
          var firstKey = Object.keys(xhr.responseJSON.errors)[0];
          var firstError = xhr.responseJSON.errors[firstKey][0];
          var err = {
            title: "Invalid form submit",
            message: firstError
          };
          break;

        default:
          var err = {
            title: xhr.statusText,
            message: (_xhr$responseJSON$mes = xhr.responseJSON.message) !== null && _xhr$responseJSON$mes !== void 0 ? _xhr$responseJSON$mes : 'Something went wrong'
          };
          break;
      }

      Swal.fire(err.title, err.message, "error"); // $(".card").children().last().remove();
    },
    beforeSend: function beforeSend() {
      $(".card").append("\n                    <div class=\"overlay\">\n                        <i class=\"fas fa-2x fa-sync-alt fa-spin\"></i>\n                    </div>\n            ");
    },
    complete: function complete() {
      $(".card").children().last().remove(); // _form.removeClass("whirl traditional");
    }
  });
});
/******/ })()
;