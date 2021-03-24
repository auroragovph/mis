"use strict";
// Class definition

var KTDTList = function() {

	
	var _dt = function() {

        var _token = $('meta[name=csrf-token]').attr('content');
		var _api = $("#fms_proc_dt").data('api');

		var datatable = $('#fms_proc_dt').DataTable({
			"responsive": true, 
			"lengthChange": false, 
			"autoWidth": false,
			"stateSave": true,
			"ajax": _api,
			"columns": [
				{ data: "id" },
				{ data: "qr" },
				{ data: "number" },
				{ data: "type" },
				{ data: "office" },
				{ data: "particulars" },
				{ data: "amount" },
				{ 
					data: null,
					orderable: false,
					className: 'text-center',
					render: function(data, type, row){
						return `
							<a target="_blank" href="${data.show}" class="text-primary" title="Show Document">
								<i class="fas fa-eye"></i>
							</a>
						`;
					}
				}
			],
			createdRow: function (row, data, dataIndex) {
				if(data.status == "0"){
					$(row).addClass('bg-red');
				}

				if(data.status == "1"){
					$(row).addClass('bg-warning');
				}
			},
		});

	};

	return {
		// public functions
		init: function() {
			_dt();
		},
	};
}();

jQuery(document).ready(function() {
	KTDTList.init();
});