/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 154);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./Modules/HumanResource/Resources/assets/js/employee/create.js":
/*!**********************************************************************!*\
  !*** ./Modules/HumanResource/Resources/assets/js/employee/create.js ***!
  \**********************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
 // Class Definition

var KTAddUser = function () {
  // Private Variables
  var _wizardEl;

  var _formEl;

  var _wizard;

  var _avatar;

  var _validations = []; // Private Functions

  var _initWizard = function _initWizard() {
    // Initialize form wizard
    _wizard = new KTWizard(_wizardEl, {
      startStep: 1,
      // initial active step number
      clickableSteps: true // allow step clicking

    }); // Validation before going to next page

    _wizard.on('beforeNext', function (wizard) {
      _validations[wizard.getStep() - 1].validate().then(function (status) {
        if (status == 'Valid') {
          if (wizard.getStep() == 1) {
            _initSelect2();
          }

          _wizard.goNext();

          KTUtil.scrollTop();
        } else {
          swal.fire({
            'title': 'Ooops',
            text: "Sorry, looks like there are some errors detected, please try again.",
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Ok, got it!",
            customClass: {
              confirmButton: "btn font-weight-bold btn-light"
            }
          }).then(function () {
            KTUtil.scrollTop();
          });
        }
      });

      _wizard.stop(); // Don't go to the next step

    }); // Change Event


    _wizard.on('change', function (wizard) {
      KTUtil.scrollTop();
    });
  };

  var _initValidations = function _initValidations() {
    // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
    // Validation Rules For Step 1
    _validations.push(FormValidation.formValidation(_formEl, {
      fields: {
        'profile_avatar': {
          validators: {
            file: {
              extension: 'png, jpg',
              type: 'image/jpeg,image/png',
              message: 'Please choose a JPEG or PNG file.'
            }
          }
        },
        firstname: {
          validators: {
            notEmpty: {
              message: 'First name is required.'
            }
          }
        },
        lastname: {
          validators: {
            notEmpty: {
              message: 'Last name is required.'
            }
          }
        },
        address: {
          validators: {
            notEmpty: {
              message: 'Address is required.'
            }
          }
        },
        phone: {
          validators: {
            numeric: {
              message: 'Invalid phone number.'
            }
          }
        },
        civil: {
          validators: {
            notEmpty: {
              message: 'Select civil status.'
            }
          }
        },
        birthday: {
          validators: {
            notEmpty: {
              message: 'Select birthday.'
            }
          }
        },
        sex: {
          validators: {
            notEmpty: {
              message: 'Select sex.'
            }
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap: new FormValidation.plugins.Bootstrap()
      }
    }));

    _validations.push(FormValidation.formValidation(_formEl, {
      fields: {
        // Step 2
        division: {
          validators: {
            notEmpty: {
              message: 'Please select a division.'
            }
          }
        },
        position: {
          validators: {
            notEmpty: {
              message: 'Please select a position.'
            }
          }
        },
        appointment: {
          validators: {
            notEmpty: {
              message: 'Please select an appointment.'
            }
          }
        },
        card: {
          validators: {
            notEmpty: {
              message: 'ID Card is required.'
            }
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap: new FormValidation.plugins.Bootstrap()
      }
    }));

    _validations.push(FormValidation.formValidation(_formEl, {
      fields: {
        username: {
          validators: {
            notEmpty: {
              message: 'Username is required.'
            }
          }
        },
        password: {
          validators: {
            notEmpty: {
              message: 'Password is required.'
            }
          }
        },
        password_confirmation: {
          validators: {
            identical: {
              compare: function compare() {
                return document.querySelector('[name="password"]').value;
              },
              message: 'Password mismatch.'
            },
            notEmpty: 'Confirm the password.'
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap: new FormValidation.plugins.Bootstrap()
      }
    })); // revalidating every keyup

  };

  var _initAvatar = function _initAvatar() {
    _avatar = new KTImageInput('kt_user_add_avatar');
  };

  var _initSelect2 = function _initSelect2() {
    // initializing select 2
    var office = $('#kt_select2_1').select2({
      placeholder: "Select office/division"
    }); // watching the select

    $('#kt_select2_1').on('select2:select', function (e) {
      var data = e.params.data;
      $('#select2OfficeSpan').text(data.text);
    }); // initializing select 2

    var position = $("#kt_select2_2").select2({
      placeholder: "Search for position",
      allowClear: true,
      ajax: {
        url: $("#kt_select2_2").data('api'),
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
    });
    $('#kt_select2_2').on('select2:select', function (e) {
      var data = e.params.data;
      $('#select2PositionSpan').text(data.text);
    });
  };

  return {
    // public functions
    init: function init() {
      _wizardEl = KTUtil.getById('kt_wizard');
      _formEl = KTUtil.getById('kt_form');

      _initWizard();

      _initValidations();

      _initAvatar();
    }
  };
}();

var KTSubmitForm = function () {
  var _form;

  var _data;

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
    axios.post(_form.attr('action'), _data).then(function (res) {
      swal.fire({
        text: res.data.message,
        icon: "success",
        buttonsStyling: false,
        confirmButtonText: "Ok, got it!",
        customClass: {
          confirmButton: "btn font-weight-bold btn-light"
        }
      });

      _form.trigger('reset');

      var _wizard = new KTWizard(KTUtil.getById('kt_wizard'));

      _wizard.goTo(1);
    })["catch"](function (err) {
      var errors = err.response.data.errors;
      var firstErr = Object.keys(errors)[0];
      swal.fire({
        text: errors[firstErr][0],
        icon: "error",
        buttonsStyling: false,
        confirmButtonText: "Ok, got it!",
        customClass: {
          confirmButton: "btn font-weight-bold btn-light"
        }
      });
      console.log(errors);
    })["finally"](function (res) {
      // unblocking the card
      KTApp.unblock(_card.getSelf());
    });
  };

  return {
    submit: function submit() {
      _form = $('#kt_form');
      _data = new FormData(document.querySelector('#kt_form'));
      _card = new KTCard('employee_card_wizard');

      _submit();
    }
  };
}();

jQuery(document).ready(function () {
  KTAddUser.init();
  $('#kt_form').on('submit', function (e) {
    e.preventDefault();
    KTSubmitForm.submit();
  });
});

/***/ }),

/***/ 154:
/*!****************************************************************************!*\
  !*** multi ./Modules/HumanResource/Resources/assets/js/employee/create.js ***!
  \****************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\laragon\www\mis2\Modules\HumanResource\Resources\assets\js\employee\create.js */"./Modules/HumanResource/Resources/assets/js/employee/create.js");


/***/ })

/******/ });