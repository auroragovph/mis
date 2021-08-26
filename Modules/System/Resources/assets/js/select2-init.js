"use strict";
// Class definition

var Select2 = function() {

	
	var _s2 = function() {
		var select2 = $('.select2').select2({
            placeholder: 'Select from the list'
        });
	};

	return {
		// public functions
		init: function() {
			_s2();
		},
	};
}();

jQuery(document).ready(function() {
	Select2.init();
});