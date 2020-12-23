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
/******/ 	return __webpack_require__(__webpack_require__.s = 152);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./Modules/System/Resources/assets/js/pages/office/index.js":
/*!******************************************************************!*\
  !*** ./Modules/System/Resources/assets/js/pages/office/index.js ***!
  \******************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
 // Class definition

var KTDatatableOfficeList = function () {
  // Private functions
  // basic demo
  var _init = function _init() {
    var _token = $('meta[name=csrf-token]').attr('content');

    var datatable = $('#kt_datatable').KTDatatable({
      data: {
        type: 'remote',
        source: {
          read: {
            url: window.location.href,
            headers: {
              'X-CSRF-TOKEN': _token
            },
            method: 'GET',
            map: function map(raw) {
              // sample data mapping
              var dataSet = raw;

              if (typeof raw.data !== 'undefined') {
                dataSet = raw.data;
              }

              return dataSet;
            }
          }
        },
        pageSize: 10,
        serverPaging: false,
        serverFiltering: false,
        serverSorting: false
      },
      // layout definition
      layout: {
        scroll: false,
        footer: false
      },
      // column sorting
      sortable: true,
      pagination: true,
      search: {
        input: $('#kt_datatable_search_query'),
        key: 'generalSearch'
      },
      // columns definition
      columns: [{
        field: 'id',
        title: '#',
        sortable: 'asc',
        width: 30,
        type: 'number',
        selector: false,
        textAlign: 'center'
      }, {
        field: 'name',
        title: 'Name'
      }, {
        field: 'alias',
        title: 'Alias'
      }, {
        field: 'division_count',
        title: 'Divisions'
      }, {
        field: 'employee_count',
        title: 'Employees'
      }, {
        field: 'Actions',
        title: 'Actions',
        sortable: false,
        width: 125,
        autoHide: false,
        overflow: 'visible',
        template: function template() {
          return "\n                                <button type=\"submit\" class=\"btn btn-icon btn-light btn-hover-primary btn-sm mx-3\">\n                                    <i class=\"flaticon-edit\"></i>\n                                </button>\n                        ";
        }
      }]
    });
  };

  return {
    // public functions
    init: function init() {
      _init();
    }
  };
}(); // Class definition


var KTFormControls = function () {
  // Private functions
  var _initForm = function _initForm() {
    FormValidation.formValidation(document.getElementById('form_create'), {
      fields: {
        name: {
          validators: {
            notEmpty: {
              message: 'Office name is required'
            }
          }
        }
      },
      plugins: {
        //Learn more: https://formvalidation.io/guide/plugins
        trigger: new FormValidation.plugins.Trigger(),
        // Bootstrap Framework Integration
        bootstrap: new FormValidation.plugins.Bootstrap(),
        // Validate fields when clicking the Submit button
        submitButton: new FormValidation.plugins.SubmitButton(),
        // Submit the form when all fields are valid
        defaultSubmit: new FormValidation.plugins.DefaultSubmit()
      }
    });
  };

  return {
    // public functions
    init: function init() {
      _initForm();
    }
  };
}();

jQuery(document).ready(function () {
  KTDatatableOfficeList.init();
  KTFormControls.init();
});

/***/ }),

/***/ 152:
/*!************************************************************************!*\
  !*** multi ./Modules/System/Resources/assets/js/pages/office/index.js ***!
  \************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /home/xijeixhan/Desktop/newmis/Modules/System/Resources/assets/js/pages/office/index.js */"./Modules/System/Resources/assets/js/pages/office/index.js");


/***/ })

/******/ });