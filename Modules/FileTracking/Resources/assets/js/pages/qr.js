"use strict";
// Class definition

var KTDTList = function() {
	// Private functions

	// basic demo
	var _demo = function() {

        var _token = $('meta[name=csrf-token]').attr('content');

		var datatable = $('#ktdt_qr').KTDatatable({
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
					field: 'id',
					title: '#'
				},{
					field: 'series',
					title: 'Series'
				},{
					field: 'Actions',
					title: 'Actions',
					sortable: false,
					width: 130,
					overflow: 'visible',
					autoHide: false,
					template: function(row) {
                        return `
                           
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