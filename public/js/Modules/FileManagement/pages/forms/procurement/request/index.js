/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!*********************************************************************************************!*\
  !*** ./Modules/FileManagement/Resources/assets/js/pages/forms/procurement/request/index.js ***!
  \*********************************************************************************************/
 // Class definition

var KTDTList = function () {
  var _dt = function _dt() {
    var _token = $('meta[name=csrf-token]').attr('content');

    var _api = $("#fms_proc_pr_dt").data('api');

    var datatable = $('#fms_proc_pr_dt').DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "ajax": _api,
      "columns": [{
        "data": "name"
      }, {
        "data": "position"
      }, {
        "data": "office"
      }, {
        "data": "extn"
      }, {
        "data": "start_date"
      }, {
        "data": "salary"
      }]
    });
  };

  return {
    // public functions
    init: function init() {
      _dt();
    }
  };
}();

jQuery(document).ready(function () {
  KTDTList.init();
});
/******/ })()
;