"use strict";
// Class definition

var KTDTList = function() {
	// Private functions

	// basic demo
	var _demo = function() {

        var _token = $('meta[name=csrf-token]').attr('content');

		var datatable = $('#kt_datatable_fms_cafoa_list').KTDatatable({
			// datasource definition
			data: {
				type: 'remote',
				source: {
					read: {
                        url: window.location.href,
                        headers: {'X-CSRF-TOKEN': _token},
                        method: 'GET',
					},
				},
				pageSize: 10, // display 20 records per page
				serverPaging: false,
				serverFiltering: false,
				serverSorting: false,
			},

			// layout definition
			layout: {
				scroll: false, // enable/disable datatable scroll both horizontal and vertical when needed.
				footer: false, // display/hide footer
			},

			// column sorting
			sortable: true,

			pagination: true,

			search: {
                input: $('#kt_datatable_search_query'),
                key: 'generalSearch'
            },

			// columns definition
			columns: [
				{
					field: 'encoded',
					title: 'Encoded Date'
				},{
					field: 'qr',
					title: 'Document ID'
				},{
					field: 'number',
					title: 'Number'
				},{
					field: 'payee',
					title: 'Payee'
				},{
					field: 'amount',
					title: 'Amount'
				},{
					field: 'status',
					title: 'Status'
				}, {
					field: 'Actions',
					title: 'Actions',
					sortable: false,
					width: 130,
					overflow: 'visible',
					autoHide: false,
					template: function(row) {
                        return `
                            <a href="${row.show}" class="btn btn-icon btn-light-primary btn-sm mr-2" title="Show">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="${row.edit}" class="btn btn-icon btn-light-warning btn-sm mr-2">
                                <i class="fas fa-edit"></i>
                            </a>
	                    `;
					},
				}],
		});

	};

	return {
		// public functions
		init: function() {
			_demo();
		},
	};
}();

jQuery(document).ready(function() {
	KTDTList.init();
});