"use strict";
// Class definition

var KTDatatableOfficeList = function() {
    // Private functions

    // basic demo
    var _init = function() {


        var _token = $('meta[name=csrf-token]').attr('content');

        var datatable = $('#kt_datatable').KTDatatable({
           
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: window.location.href,
                        headers: {'X-CSRF-TOKEN': _token},
                        method: 'GET',
                        map: function(raw) {
                            // sample data mapping
                            var dataSet = raw;
                            if (typeof raw.data !== 'undefined') {
                                dataSet = raw.data;
                            }
                            return dataSet;
                        },
                    },
                },
                pageSize: 10,
                serverPaging: false,
                serverFiltering: false,
                serverSorting: false,
            },

            // layout definition
            layout: {
                scroll: false,
                footer: false,
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
                    title: '#',
                    sortable: 'asc',
                    width: 30,
                    type: 'number',
                    selector: false,
                    textAlign: 'center',
                }, {
                    field: 'name',
                    title: 'Name',
                }, {
                    field: 'alias',
                    title: 'Alias',
                }, {
                    field: 'division_count',
                    title: 'Divisions',
                }, {
                    field: 'employee_count',
                    title: 'Employees',
                },{
                    field: 'Actions',
                    title: 'Actions',
                    sortable: false,
                    width: 125,
                    autoHide: false,
                    overflow: 'visible',
                    template: function() {
                        return `
                                <button type="submit" class="btn btn-icon btn-light btn-hover-primary btn-sm mx-3">
                                    <i class="flaticon-edit"></i>
                                </button>
                        `;
                    },
                }
            ],

        });
    };

    return {
        // public functions
        init: function() {
            _init();
        },
    };
}();


// Class definition
var KTFormControls = function () {
	// Private functions
	var _initForm = function () {
		FormValidation.formValidation(
			document.getElementById('form_create'),
			{
				fields: {
					name: {
						validators: {
							notEmpty: {
								message: 'Office name is required'
							},
						}
					}
				},

				plugins: { //Learn more: https://formvalidation.io/guide/plugins
					trigger: new FormValidation.plugins.Trigger(),
					// Bootstrap Framework Integration
					bootstrap: new FormValidation.plugins.Bootstrap(),
					// Validate fields when clicking the Submit button
					submitButton: new FormValidation.plugins.SubmitButton(),
            		// Submit the form when all fields are valid
            		defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
				}
			}
		);
    }
    

	return {
		// public functions
		init: function() {
			_initForm();
		}
	};
}();



jQuery(document).ready(function() {
    KTDatatableOfficeList.init();
    KTFormControls.init();
});
