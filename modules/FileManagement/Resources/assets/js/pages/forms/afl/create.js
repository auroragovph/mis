"use strict";

// Class definition
var KTUInitPlugins = function () {

	var initPlugins = function() {

		// init select 2 employees
		$(".select2").select2({
			placeholder: "Select in the list",
        });

        $('#afl_datepicker').datepicker({
            clearBtn: true,
            multidate: true
        });

	}

	return {
		// public functions
		init: function() {
			initPlugins();
		}
	};
}();

jQuery(document).ready(function() {
	KTUInitPlugins.init();
});