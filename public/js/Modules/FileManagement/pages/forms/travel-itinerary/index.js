/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!******************************************************************************************!*\
  !*** ./Modules/FileManagement/Resources/assets/js/pages/forms/travel-itinerary/index.js ***!
  \******************************************************************************************/
 // Class definition

var KTDTList = function () {
  // Private functions
  // basic demo
  var _demo = function _demo() {
    var _token = $('meta[name=csrf-token]').attr('content');

    var datatable = $('#kt_datatable_fms_iot_list').KTDatatable({
      // datasource definition
      data: {
        type: 'remote',
        source: {
          read: {
            url: window.location.href,
            headers: {
              'X-CSRF-TOKEN': _token
            },
            method: 'GET'
          }
        },
        pageSize: 10,
        // display 20 records per page
        serverPaging: false,
        serverFiltering: false,
        serverSorting: false
      },
      // layout definition
      layout: {
        scroll: false,
        // enable/disable datatable scroll both horizontal and vertical when needed.
        footer: false // display/hide footer

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
        field: 'encoded',
        title: 'Encoded Date',
        type: 'date'
      }, {
        field: 'qr',
        title: 'Document ID'
      }, {
        field: 'number',
        title: 'Number'
      }, {
        field: 'employee',
        title: 'Employee'
      }, {
        field: 'date',
        title: 'Date'
      }, {
        field: 'purpose',
        title: 'Purpose'
      }, {
        field: 'amount',
        title: 'Amount'
      }, {
        field: 'Actions',
        title: 'Actions',
        sortable: false,
        width: 130,
        overflow: 'visible',
        autoHide: false,
        template: function template(row) {
          return "\n                            <a href=\"".concat(row.show, "\" class=\"btn btn-icon btn-light-primary btn-sm mr-2\" title=\"Show\">\n                                <i class=\"fas fa-eye\"></i>\n                            </a>\n                            <a href=\"").concat(row.edit, "\" class=\"btn btn-icon btn-light-warning btn-sm mr-2\">\n                                <i class=\"fas fa-edit\"></i>\n                            </a>\n\t                    ");
        }
      }]
    });
  };

  return {
    // public functions
    init: function init() {
      _demo();
    }
  };
}();

jQuery(document).ready(function () {
  KTDTList.init();
});
/******/ })()
;