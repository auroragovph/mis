"use strict";

// Class definition
var KTUInitPlugins = function () {
	// Base elements
	var avatar;

	var initPlugins = function() {

		// init select 2 employees
		$(".select2-tags").select2({
			tags: true
        });
        
        $('#kt_repeater_1').repeater({
            initEmpty: false,

            isFirstItemUndeletable: true,
           
            show: function () {
                $(this).slideDown(); 
            },

            hide: function (deleteElement) {                
                $(this).slideUp(deleteElement);                 
            }   
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