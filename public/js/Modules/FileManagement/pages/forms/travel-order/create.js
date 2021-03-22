/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!***************************************************************************************!*\
  !*** ./Modules/FileManagement/Resources/assets/js/pages/forms/travel-order/create.js ***!
  \***************************************************************************************/
 // Class definition

var KTUInitPlugins = function () {
  // Base elements
  var avatar;

  var initPlugins = function initPlugins() {
    // init select 2 employees
    $(".select2").select2({
      placeholder: "Select in the list"
    }); // init select 2 employees

    $("#kt_select2_employees").select2({
      placeholder: "Search for employees",
      allowClear: true,
      ajax: {
        url: $("#kt_select2_employees").data('api'),
        dataType: 'json',
        delay: 250,
        headers: {
          "X-Select2": true
        },
        data: function data(params) {
          return {
            search: params.term
          };
        },
        processResults: function processResults(data, page) {
          return {
            results: $.map(data, function (obj, index) {
              return {
                id: obj.id,
                text: obj.name + ' - ' + obj.position
              };
            })
          };
        },
        cache: true
      },
      escapeMarkup: function escapeMarkup(markup) {
        return markup;
      },
      // let our custom formatter work
      minimumInputLength: 2
    }); // init select 2 employees

    $("#kt_select2_requesting").select2({
      placeholder: "Search for employees",
      allowClear: true,
      ajax: {
        url: $("#kt_select2_requesting").data('api'),
        dataType: 'json',
        delay: 250,
        headers: {
          "X-Select2": "true2"
        },
        data: function data(params) {
          return {
            search: params.term
          };
        },
        processResults: function processResults(data, page) {
          return {
            results: $.map(data, function (obj, index) {
              return {
                id: obj.id,
                text: obj.name + ' - ' + obj.position
              };
            })
          };
        },
        cache: true
      },
      escapeMarkup: function escapeMarkup(markup) {
        return markup;
      },
      // let our custom formatter work
      minimumInputLength: 2
    }); // init select 2 division

    $("#kt_select2_charging").select2({
      placeholder: "Search for office / division",
      allowClear: true,
      ajax: {
        url: $("#kt_select2_charging").data('api'),
        dataType: 'json',
        delay: 250,
        headers: {
          "X-Select2": true
        },
        data: function data(params) {
          return {
            search: params.term
          };
        },
        processResults: function processResults(data, page) {
          return {
            results: data.data
          };
        },
        cache: true
      },
      escapeMarkup: function escapeMarkup(markup) {
        return markup;
      },
      // let our custom formatter work
      minimumInputLength: 2
    }); // init select 2 liaison

    $("#kt_select2_liaison").select2({
      placeholder: "Search for liaison officer",
      allowClear: true,
      ajax: {
        url: $("#kt_select2_liaison").data('api'),
        dataType: 'json',
        delay: 250,
        headers: {
          "X-Select2": "true2"
        },
        data: function data(params) {
          return {
            search: params.term,
            liaison: true
          };
        },
        processResults: function processResults(data, page) {
          return {
            results: $.map(data, function (obj, index) {
              return {
                id: obj.id,
                text: obj.name + ' - ' + obj.position
              };
            })
          };
        },
        cache: true
      },
      escapeMarkup: function escapeMarkup(markup) {
        return markup;
      }
    });
  };

  return {
    // public functions
    init: function init() {
      initPlugins();
    }
  };
}();

var KTFormValidation = function () {
  var _form = function _form() {
    FormValidation.formValidation(document.getElementById('kt_form'), {
      fields: {
        'employees[]': {
          validators: {
            notEmpty: {
              message: 'Employee is required'
            }
          }
        },
        departure: {
          validators: {
            notEmpty: {
              message: 'Departure date is required'
            }
          }
        },
        arrival: {
          validators: {
            notEmpty: {
              message: 'Arrival date is required'
            }
          }
        },
        destination: {
          validators: {
            notEmpty: {
              message: 'Destination is required'
            }
          }
        },
        charging: {
          validators: {
            notEmpty: {
              message: 'Charging office is required'
            }
          }
        },
        purpose: {
          validators: {
            notEmpty: {
              message: 'Purpose is required'
            }
          }
        },
        liaison: {
          validators: {
            notEmpty: {
              message: 'Liaison officer is required'
            }
          }
        },
        requesting: {
          validators: {
            notEmpty: {
              message: 'Requesting officer is required'
            }
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        // Validate fields when clicking the Submit button
        submitButton: new FormValidation.plugins.SubmitButton(),
        // Submit the form when all fields are valid
        // defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
        // Bootstrap Framework Integration
        bootstrap: new FormValidation.plugins.Bootstrap({
          eleInvalidClass: '',
          eleValidClass: ''
        })
      }
    }).on('core.form.valid', function () {
      KTForm.submit();
    });
  };

  return {
    // public functions
    init: function init() {
      _form();
    }
  };
}();

var KTForm = function () {
  var _form;

  var _card;

  var _submit = function _submit() {
    // BLOCKING THE CARD
    KTApp.block(_card.getSelf(), {
      overlayColor: '#ffffff',
      type: 'loader',
      state: 'primary',
      opacity: 0.3,
      message: 'Submitting...',
      size: 'lg'
    });
    axios.post(_form.attr('action'), _form.serialize()).then(function (res) {
      swal.fire({
        text: res.data.message,
        icon: "success",
        buttonsStyling: false,
        confirmButtonText: "Ok, got it!",
        customClass: {
          confirmButton: "btn font-weight-bold btn-light"
        }
      });
      window.location.href = res.data.route;
    })["catch"](function (err) {
      var error = err.response;
      var res = error.data;
      var errTitle = '';
      var errMessage = '';
      console.log(error);

      switch (error.status) {
        case 500:
          errTitle = 'Internal Service Error';
          errMessage = res.message;
          break;

        case 422:
          var errors = res.errors;
          var firstErr = Object.keys(errors)[0];
          errTitle = res.message;
          errMessage = errors[firstErr][0];
          break;

        default:
          errTitle = 'Oooops.';
          errMessage = 'Something went wrong.';
          break;
      }

      swal.fire({
        title: errTitle,
        text: errMessage,
        icon: "error",
        buttonsStyling: false,
        confirmButtonText: "Ok, got it!",
        customClass: {
          confirmButton: "btn font-weight-bold btn-light"
        }
      });
    })["finally"](function (res) {
      // unblocking the card
      KTApp.unblock(_card.getSelf());
    });
  };

  return {
    submit: function submit() {
      _form = $('#kt_form');
      _card = new KTCard('card-box');

      _submit();
    }
  };
}();

jQuery(document).ready(function () {
  KTUInitPlugins.init();
  KTFormValidation.init();
});
/******/ })()
;