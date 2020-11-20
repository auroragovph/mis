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
/******/ 	return __webpack_require__(__webpack_require__.s = 2);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./Modules/FileManagement/Resources/assets/js/document/document-number.js":
/*!********************************************************************************!*\
  !*** ./Modules/FileManagement/Resources/assets/js/document/document-number.js ***!
  \********************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$('#form-number').submit(function (e) {
  e.preventDefault();
  var form = $('#form-number').serialize();
  var checker = $('#form-number').serializeArray();
  var url = $('#form-number').attr('action'); // sending AJAX

  var send = $.ajax({
    type: "POST",
    url: url,
    data: form,
    dataType: 'json',
    beforeSend: function beforeSend() {
      // add whirl traditional
      $("#whirl").addClass("whirl traditional");
    }
  }).done(function (data) {
    $('#modal-num').text(data.data.last);
    $('#modal-last').text(data.data.type);
    $('input[name="document"]').val(data.data.meta.id);
    $('input[name="type"]').val(data.data.meta.type);
    $('#numberModal').modal('show');
  }).fail(function (data) {
    if (data.status == 500) {
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
  }).always(function () {
    // remove whirl traditional
    $("#whirl").removeClass("whirl");
    $("#whirl").removeClass("traditional");
  }); // console.log(checker);
});
$('#form-num').submit(function (e) {
  e.preventDefault();
  var form = $('#form-num').serialize();
  var checker = $('#form-num').serializeArray();
  var url = $('#form-num').attr('action'); // sending AJAX

  var send = $.ajax({
    type: "POST",
    url: url,
    data: form,
    dataType: 'json',
    beforeSend: function beforeSend() {
      // add whirl traditional
      $("#whirl-2").addClass("whirl traditional");
    }
  }).done(function (data) {
    $('#numberModal').modal('hide');
    $('#form-number').trigger('reset');
    $('#form-num').trigger('reset');
    Swal.fire({
      icon: 'success',
      title: 'Success',
      text: data.message
    });
  }).fail(function (data) {
    if (data.status == 500) {
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
  }).always(function () {
    // remove whirl traditional
    $("#whirl-2").removeClass("whirl");
    $("#whirl-2").removeClass("traditional");
  }); // console.log(checker);
});

/***/ }),

/***/ 2:
/*!**************************************************************************************!*\
  !*** multi ./Modules/FileManagement/Resources/assets/js/document/document-number.js ***!
  \**************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /home/xijeixhan/Desktop/mis_dev/Modules/FileManagement/Resources/assets/js/document/document-number.js */"./Modules/FileManagement/Resources/assets/js/document/document-number.js");


/***/ })

/******/ });