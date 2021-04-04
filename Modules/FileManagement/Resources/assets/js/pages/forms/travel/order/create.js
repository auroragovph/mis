"use strict";

// Class definition
var KTUInitPlugins = function () {
	// Base elements
	var avatar;

	var initPlugins = function() {

		// init select 2 employees
		$(".select2").select2({
			placeholder: "Select in the list",
		});

        // init select 2 employees
		$("#kt_select2_employees").select2({
			placeholder: "Search for employees",
			allowClear: true,
			ajax: {
				url: $("#kt_select2_employees").data('api'),
				dataType: 'json',
				delay: 250,
				headers: {
					"X-Select2" : true
				},
				data: function(params) {
					return {
						search: params.term,
					};
				},
				processResults: function(data, page) {
                    return {
                        results: $.map(data, function(obj, index) {
                          return { id: obj.id, text: obj.name + ' - ' + obj.position };
                        })
                    };
				},
				cache: true
			},
			escapeMarkup: function(markup) {
				return markup;
			}, // let our custom formatter work
			minimumInputLength: 2
		});
		
		// init select 2 employees
		$("#kt_select2_requesting").select2({
			placeholder: "Search for employees",
			allowClear: true,
			ajax: {
				url: $("#kt_select2_requesting").data('api'),
				dataType: 'json',
				delay: 250,
				headers: {
					"X-Select2" : "true2"
				},
				data: function(params) {
					return {
						search: params.term,
					};
				},
				processResults: function(data, page) {
                    return {
                        results: $.map(data, function(obj, index) {
                          return { id: obj.id, text: obj.name + ' - ' + obj.position };
                        })
                    };
				},
				cache: true
			},
			escapeMarkup: function(markup) {
				return markup;
			}, // let our custom formatter work
			minimumInputLength: 2
        });

		// init select 2 division
		$("#kt_select2_charging").select2({
			placeholder: "Search for office / division",
			allowClear: true,
			ajax: {
				url: $("#kt_select2_charging").data('api'),
				dataType: 'json',
				delay: 250,
				headers: {
					"X-Select2" : true
				},
				data: function(params) {
					return {
						search: params.term,
					};
				},
				processResults: function(data, page) {
					return { results: data.data };
				},
				cache: true
			},
			escapeMarkup: function(markup) {
				return markup;
			}, // let our custom formatter work
			minimumInputLength: 2
        });

        // init select 2 liaison
		$("#kt_select2_liaison").select2({
			placeholder: "Search for liaison officer",
			allowClear: true,
			ajax: {
				url: $("#kt_select2_liaison").data('api'),
				dataType: 'json',
				delay: 250,
				headers: {
					"X-Select2" : "true2"
				},
				data: function(params) {
					return {
                        search: params.term,
                        liaison: true
					};
				},
				processResults: function(data, page) {
					return {
                        results: $.map(data, function(obj, index) {
                          return { id: obj.id, text: obj.name + ' - ' + obj.position };
                        })
                    };
				},
				cache: true
			},
			escapeMarkup: function(markup) {
				return markup;
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