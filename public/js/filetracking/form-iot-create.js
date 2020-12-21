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
/******/ 	return __webpack_require__(__webpack_require__.s = 14);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./Modules/FileTracking/Resources/assets/js/form-iot-create.js":
/*!*********************************************************************!*\
  !*** ./Modules/FileTracking/Resources/assets/js/form-iot-create.js ***!
  \*********************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  $(".select2").select2({
    placeholder: "Select from list"
  });
  $(".select2-tags").select2({
    tags: true
  });
  var dt = $("#dataTables").DataTable({
    "processing": true,
    "serverSide": true,
    sDom: 'lrtip',
    ajax: window.location.href,
    columns: [{
      data: 'encoded'
    }, {
      data: 'series'
    }, {
      data: 'office'
    }, {
      data: 'name'
    }, {
      data: 'position'
    }, {
      data: 'destination'
    }, {
      data: 'amount'
    }, {
      data: 'purpose'
    }, {
      data: 'status'
    }, {
      data: 'action',
      searchable: false,
      orderable: false
    }],
    "responsive": true,
    "autoWidth": false
  });
  $("#form-create").submit(function (e) {
    e.preventDefault(); // avoid to execute the actual submit of the form.

    var form = $(this);
    var url = form.attr('action'); // add whirl traditional

    $(".modal-content").addClass("whirl traditional");
    $.post(url, form.serialize(), function (data) {
      dt.ajax.reload();
      $('#modal-create').modal('hide');
      form.trigger('reset');
      $(".select2").select2({
        placeholder: "Select from list"
      });
      $(".select2-tags").select2({
        tags: true
      });
      window.open(data.receipt, '_blank');
      Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: data.message
      });
    }).fail(function (data) {
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: data.responseJSON.message
      });
    }).always(function () {
      $(".modal-content").removeClass("whirl");
      $(".modal-content").removeClass("traditional");
    });
  });
  $("#form-search").submit(function (e) {
    e.preventDefault(); // avoid to execute the actual submit of the form.

    dt.search('MODAL_SEARCH');
    dt.columns(0).search($('input[name="search-encoded"]').val());
    dt.columns(1).search($('input[name="search-series"]').val());
    dt.columns(2).search($('select[name="search-division"]').val());
    dt.columns(8).search($('select[name="search-status"]').val());
    dt.columns(3).search($('input[name="search-name"]').val());
    dt.columns(4).search($('input[name="search-position"]').val());
    dt.columns(5).search($('input[name="search-destination"]').val());
    dt.columns(6).search($('input[name="search-amount"]').val());
    dt.columns(7).search($('input[name="search-purpose"]').val());
    dt.draw();
    $('#modal-search').modal('hide');
  });
  $("#form-reset").on("click", function (e) {
    $("#form-search").trigger('reset');
    $(".select2").select2({
      placeholder: "Select from list",
      allowClear: true
    });
    dt.search('');
    dt.draw();
  });
});

/***/ }),

/***/ 14:
/*!***************************************************************************!*\
  !*** multi ./Modules/FileTracking/Resources/assets/js/form-iot-create.js ***!
  \***************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /home/xijeixhan/Desktop/mis_dev/Modules/FileTracking/Resources/assets/js/form-iot-create.js */"./Modules/FileTracking/Resources/assets/js/form-iot-create.js");


/***/ })

/******/ });