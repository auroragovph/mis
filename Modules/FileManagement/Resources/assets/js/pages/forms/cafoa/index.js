"use strict";
// Class definition

var KTDTList = function() {

	
	var _dt = function() {

        var _token = $('meta[name=csrf-token]').attr('content');

		var datatable = $('#kt_datatable_fms_cafoa_list').DataTable({
			"responsive": true, 
			"lengthChange": false, 
			"autoWidth": false,
			"stateSave": true,
			"ajax": window.location.href,
			"columns": [
				{ data: "qr" },
				{ data: "number" },
				{ data: "office" },
				{ data: "payee" },
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
							|
							<a target="_blank" href="${data.edit}" class="text-warning" title="Edit Document">
								<i class="fas fa-edit"></i>
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