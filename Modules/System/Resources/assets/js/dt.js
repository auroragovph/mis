"use strict";
// Class definition

var KTDTList = function() {

	
	var _dt = function() {

		var datatable = $('#dt_table').DataTable();

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