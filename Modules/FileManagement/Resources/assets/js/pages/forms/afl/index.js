"use strict";
// Class definition

var KTDTList = function() {

	
	var _dt = function() {

        var _token = $('meta[name=csrf-token]').attr('content');

		var datatable = $('#fms_afl_dt').DataTable({
			"responsive": true, "lengthChange": false, "autoWidth": false
		}).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

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