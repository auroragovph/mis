/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!************************************************************!*\
  !*** ./Modules/System/Resources/assets/js/select2-init.js ***!
  \************************************************************/
 // Class definition

var Select2 = function () {
  var _s2 = function _s2() {
    var select2 = $('.select2').select2({
      placeholder: 'Select from the list'
    });
  };

  return {
    // public functions
    init: function init() {
      _s2();
    }
  };
}();

jQuery(document).ready(function () {
  Select2.init();
});
/******/ })()
;