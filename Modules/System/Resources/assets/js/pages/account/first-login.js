"use strict";


// Class Definition
var KTAddUser = function () {
	// Private Variables
	var _wizardEl;
	var _formEl;
	var _wizard;
	var _avatar;
	var _validations = [];

	// Private Functions
	var _initWizard = function () {
		// Initialize form wizard
		_wizard = new KTWizard(_wizardEl, {
			startStep: 1, // initial active step number
			clickableSteps: true  // allow step clicking
		});

		// Validation before going to next page
		_wizard.on('beforeNext', function (wizard) {
			_validations[wizard.getStep() - 1].validate().then(function(status) {
		        if (status == 'Valid') {

                    // if(wizard.getStep() == 1){
                    //     _initSelect2();
					// }

					_wizard.goNext();
					KTUtil.scrollTop();
				} else {

					swal.fire({
						'title': 'Ooops',
		                text: "Sorry, looks like there are some errors detected, please try again.",
		                icon: "error",
		                buttonsStyling: false,
		                confirmButtonText: "Ok, got it!",
						customClass: {
							confirmButton: "btn font-weight-bold btn-light"
						}
		            }).then(function() {
						KTUtil.scrollTop();
					});
				}
		    });

			_wizard.stop();  // Don't go to the next step
		});

		// Change Event
		_wizard.on('change', function (wizard) {
			KTUtil.scrollTop();
		});
	}

	var _initValidations = function () {
		// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/

		// Validation Rules For Step 1
		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
					'profile_avatar': {
						validators: {
							file: {
								extension: 'png,jpg,jpeg',
								type: 'image/jpeg,image/png,image/jpg',
								message: 'Please choose a JPEG or PNG file.'
							}
						}
					},
					firstname: {
						validators: {
							notEmpty: {
								message: 'First name is required.'
							}
						}
					},
					lastname: {
						validators: {
							notEmpty: {
								message: 'Last name is required.'
							}
						}
					},
					address: {
						validators: {
							notEmpty: {
								message: 'Address is required.'
							}
						}
					},
					phone: {
						validators: {
							numeric: {
                                message: 'Invalid phone number.'
                            }
						}
                    },
                    civil: {
						validators: {
							notEmpty: {
                                message: 'Select civil status.'
                            }
						}
                    },
                    birthday: {
						validators: {
							notEmpty: {
                                message: 'Select birthday.'
                            }
						}
                    },
                    sex: {
						validators: {
							notEmpty: {
                                message: 'Select sex.'
                            }
						}
					},
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		));

		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
					// Step 2
					division: {
						validators: {
							notEmpty: {
								message: 'Please select a division.'
							}
						}
                    },
                    position: {
						validators: {
							notEmpty: {
								message: 'Please select a position.'
							}
						}
                    },
                    appointment: {
						validators: {
							notEmpty: {
								message: 'Please select an appointment.'
							}
						}
                    },
                    card: {
						validators: {
							notEmpty: {
								message: 'ID Card is required.'
							}
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		));

		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
					username: {
						validators: {
							notEmpty: {
								message: 'Username is required.'
							}
						}
					},
					password: {
						validators: {
							notEmpty: {
								message: 'Password is required.'
							}
						}
					},
					password_confirmation: {
						validators: {
							identical: {
								compare: function() {
									return document.querySelector('[name="password"]').value;
								},
								message: 'Password mismatch.'
							},
							notEmpty: 'Confirm the password.'
						}
					},
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		));


		// revalidating every keyup

	}

    var _initPlugins = function () {

        _avatar = new KTImageInput('kt_user_add_avatar');

        //datepickers
		$('.kt_datepicker').datepicker({
            rtl: KTUtil.isRTL(),
            todayBtn: "linked",
            clearBtn: true,
            todayHighlight: true
		});
		
		// bootstrap select
		$('.kt-selectpicker').selectpicker();
        

        // initializing select 2
        let office = $('#kt_select2_division').select2({
            placeholder: "Search for office / division",
			allowClear: true,
			ajax: {
				url: $("#kt_select2_division").data('api'),
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
					return { results: data.data };
				},
				cache: true
			},
			escapeMarkup: function(markup) {
				return markup;
			}, // let our custom formatter work
			minimumInputLength: 2
		});

		// watching the select
		$('#kt_select2_division').on('select2:select', function (e) {
			let data = e.params.data;
			$('#select2OfficeSpan').text(data.text)
		});
		
		// initializing select 2
		let position = $("#kt_select2_position").select2({
			placeholder: "Search for position",
			allowClear: true,
			ajax: {
				url: $("#kt_select2_position").data('api'),
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
					return { results: data.data };
				},
				cache: true
			},
			escapeMarkup: function(markup) {
				return markup;
			}, // let our custom formatter work
			minimumInputLength: 2
		});

		$('#kt_select2_position').on('select2:select', function (e) {
			let data = e.params.data;
			$('#select2PositionSpan').text(data.text)
		});


    }

	return {
		// public functions
		init: function () {
			_wizardEl = KTUtil.getById('kt_wizard');
			_formEl = KTUtil.getById('kt_form');
			_initWizard();
			_initValidations();
			_initPlugins();
		}
	};
}();

var KTSubmitForm = function(){

	var _form;
	var _data;
	var _card;

	var _submit = function() {

		// BLOCKING THE CARD
		KTApp.block(_card.getSelf(), {
				overlayColor: '#ffffff',
				type: 'loader',
				state: 'primary',
				opacity: 0.3,
				message: 'Submitting...',
				size: 'lg'
		});

		axios.post(_form.attr('action'), _data)

        .then(res => {

			swal.fire({
				text: res.data.message,
				icon: "success",
				buttonsStyling: false,
				confirmButtonText: "Ok, got it!",
				customClass: {
					confirmButton: "btn font-weight-bold btn-light"
				}
			});
			window.location.href = res.data.route;

        }).catch(err => {

			let errors = err.response.data.errors;
			let firstErr = Object.keys(errors)[0];

			swal.fire({
				text: errors[firstErr][0],
				icon: "error",
				buttonsStyling: false,
				confirmButtonText: "Ok, got it!",
				customClass: {
					confirmButton: "btn font-weight-bold btn-light"
				}
			});

			console.log(errors);


		}).finally(res => {

			// unblocking the card
			KTApp.unblock(_card.getSelf());
		});
		
	}

	return {
		submit: function() {
			_form = $('#kt_form');
			_data = new FormData(document.querySelector('#kt_form'));
			_card = new KTCard('employee_card_wizard');
			_submit();
		}
	}


}();

jQuery(document).ready(function () {

	KTAddUser.init();
	$('#kt_form').on('submit', function(e){
		e.preventDefault();
		KTSubmitForm.submit();
	});
});


