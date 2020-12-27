"use strict";

// Class definition
var KTUInitPlugins = function () {
	// Base elements
	var avatar;

	var initPlugins = function() {

		avatar = new KTImageInput('kt_user_edit_avatar');

		//datepickers
		$('.kt_datepicker').datepicker({
            rtl: KTUtil.isRTL(),
            todayBtn: "linked",
            clearBtn: true,
            todayHighlight: true
		});
		
		// bootstrap select
		$('.kt-selectpicker').selectpicker();

		// init select 2 position
		$("#kt_select2_division").select2({
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

		// init select 2 role
		$("#kt_select2_position").select2({
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

		// init select 2 position
		$("#kt_select2_role").select2({
			placeholder: "Search for role",
			allowClear: true,
			ajax: {
				url: $("#kt_select2_role").data('api'),
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

		// init select 2 position
		$("#kt_select2_permissions").select2({
			placeholder: "Search for permissions (Use CTRL key to select multiple)",
			allowClear: true,
			ajax: {
				url: $("#kt_select2_permissions").data('api'),
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

	}

	return {
		// public functions
		init: function() {
			initPlugins();
		}
	};
}();

var KTFormValidation = function() {

	var _formInfo = function () {
		FormValidation.formValidation(
			document.getElementById('kt_form_information'),
			{
				fields: {
					firstname: {
						validators: {
							notEmpty: {
								message: 'First name is required'
							}
						}
					},
					lastname: {
						validators: {
							notEmpty: {
								message: 'Last name is required'
							}
						}
					},
					birthday: {
						validators: {
							notEmpty: {
								message: 'Birthday is required'
							}
						}
					},
					address: {
						validators: {
							notEmpty: {
								message: 'Address is required'
							}
						}
					},
					civil: {
						validators: {
							notEmpty: {
								message: 'Select from the list'
							}
						}
					},
					sex: {
						validators: {
							notEmpty: {
								message: 'Select from the list'
							}
						}
					},
					profile_avatar: {
						validators: {
							file: {
								extension: 'png,jpg,jpeg',
								type: 'image/jpeg,image/png',
								message: 'Please choose a JPEG or PNG file.'
							}
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					// Validate fields when clicking the Submit button
					submitButton: new FormValidation.plugins.SubmitButton(),
            		// Submit the form when all fields are valid
            		// defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
					// Bootstrap Framework Integration
					bootstrap: new FormValidation.plugins.Bootstrap({
						eleInvalidClass: '',
						eleValidClass: '',
					})
				}
			}
		).on('core.form.valid', function(){
            KTFormInformation.submit();
        });
	}

	var _formEmployment = function() {
		FormValidation.formValidation(
			document.getElementById('kt_form_employment'),
			{
				fields: {
					division: {
						validators: {
							notEmpty: {
								message: 'Division is required'
							}
						}
					},
					position: {
						validators: {
							notEmpty: {
								message: 'Position is required'
							}
						}
					},
					appointment: {
						validators: {
							notEmpty: {
								message: 'Appointment is required'
							}
						}
					},
					card: {
						validators: {
							notEmpty: {
								message: 'ID Card is required'
							}
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					// Validate fields when clicking the Submit button
					submitButton: new FormValidation.plugins.SubmitButton(),
            		// Submit the form when all fields are valid
            		// defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
					// Bootstrap Framework Integration
					bootstrap: new FormValidation.plugins.Bootstrap({
						eleInvalidClass: '',
						eleValidClass: '',
					})
				}
			}
		).on('core.form.valid', function(){
            KTFormEmployment.submit();
        });
	}

	var _formCredentials = function() {
		FormValidation.formValidation(
			document.getElementById('kt_form_credentials'),
			{
				fields: {
					password_old: {
						validators: {
							notEmpty: {
								message: 'Old password is required'
							}
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					// Validate fields when clicking the Submit button
					submitButton: new FormValidation.plugins.SubmitButton(),
            		// Submit the form when all fields are valid
            		// defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
					// Bootstrap Framework Integration
					bootstrap: new FormValidation.plugins.Bootstrap({
						eleInvalidClass: '',
						eleValidClass: '',
					})
				}
			}
		).on('core.form.valid', function(){
            KTFormCredentials.submit();
        });
	}

	var _formACL = function() {
		FormValidation.formValidation(
			document.getElementById('kt_form_acl'),
			{
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					// Validate fields when clicking the Submit button
					submitButton: new FormValidation.plugins.SubmitButton(),
            		// Submit the form when all fields are valid
            		// defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
					// Bootstrap Framework Integration
					bootstrap: new FormValidation.plugins.Bootstrap({
						eleInvalidClass: '',
						eleValidClass: '',
					})
				}
			}
		).on('core.form.valid', function(){
            FKTFormACL.submit();
        });
	}

	return {
		// public functions
		init: function() {
			_formInfo();
			_formEmployment();
			_formCredentials();
			_formACL();
		}
	};

}();

var KTFormInformation = function(){

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

		axios.post(_form.attr('action'), _data, {
			headers: {
				'X-Edit-Employee' : 'information'
			}
		}).then(res => {

			swal.fire({
				text: res.data.message,
				icon: "success",
				buttonsStyling: false,
				confirmButtonText: "Ok, got it!",
				customClass: {
					confirmButton: "btn font-weight-bold btn-light"
				}
			});

			if(res.data.reload == true){
				setTimeout(() => {
					window.location.reload();
				}, 5000);
			}

			


        }).catch(err => {

			let error = err.response;
			let res = error.data;
			var errTitle = '';
			var errMessage = '';

			console.log(error);


			switch(error.status){
				case 500: 
					errTitle = 'Internal Service Error';
					errMessage = res.message;
				break;
				case 422:
					let errors = res.errors;
					let firstErr = Object.keys(errors)[0];
					errTitle =  res.message;
					errMessage = errors[firstErr][0];
				break;
				default: 
					errTitle = 'Oooops.';
					errMessage = 'Something went wrong.';
				break;
			}

			swal.fire({
				title:	errTitle,
				text: errMessage,
				icon: "error",
				buttonsStyling: false,
				confirmButtonText: "Ok, got it!",
				customClass: {
					confirmButton: "btn font-weight-bold btn-light"
				}
			});

			

		}).finally(res => {
			// unblocking the card
			KTApp.unblock(_card.getSelf());
		});
		
	}

	return {
		submit: function() {
			_form = $('#kt_form_information');
			_data = new FormData(document.querySelector('#kt_form_information'));
			_card = new KTCard('informationTab');
			_submit();
		}
	}
}();

var KTFormEmployment = function(){

	var _form;
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

		axios.post(_form.attr('action'), _form.serialize(), {
			headers: {
				'X-Edit-Employee' : 'employment'
			}
		}).then(res => {

			swal.fire({
				text: res.data.message,
				icon: "success",
				buttonsStyling: false,
				confirmButtonText: "Ok, got it!",
				customClass: {
					confirmButton: "btn font-weight-bold btn-light"
				}
			});

        }).catch(err => {

			let error = err.response;
			let res = error.data;
			var errTitle = '';
			var errMessage = '';

			console.log(error);

			switch(error.status){
				case 500: 
					errTitle = 'Internal Service Error';
					errMessage = res.message;
				break;
				case 422:
					let errors = res.errors;
					let firstErr = Object.keys(errors)[0];
					errTitle =  res.message;
					errMessage = errors[firstErr][0];
				break;
				default: 
					errTitle = 'Oooops.';
					errMessage = 'Something went wrong.';
				break;
			}

			swal.fire({
				title:	errTitle,
				text: errMessage,
				icon: "error",
				buttonsStyling: false,
				confirmButtonText: "Ok, got it!",
				customClass: {
					confirmButton: "btn font-weight-bold btn-light"
				}
			});

			

		}).finally(res => {
			// unblocking the card
			KTApp.unblock(_card.getSelf());
		});
		
	}

	return {
		submit: function() {
			_form = $('#kt_form_employment');
			_card = new KTCard('employmentTab');
			_submit();
		}
	}
}();

var KTFormCredentials = function(){

	var _form;
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

		axios.post(_form.attr('action'), _form.serialize(), {
			headers: {
				'X-Edit-Employee' : 'credentials'
			}
		}).then(res => {

			swal.fire({
				text: res.data.message,
				icon: "success",
				buttonsStyling: false,
				confirmButtonText: "Ok, got it!",
				customClass: {
					confirmButton: "btn font-weight-bold btn-light"
				}
			});

        }).catch(err => {

			let error = err.response;
			let res = error.data;
			var errTitle = '';
			var errMessage = '';

			console.log(error);

			switch(error.status){
				case 500: 
					errTitle = 'Internal Service Error';
					errMessage = res.message;
				break;
				case 422:
					let errors = res.errors;
					let firstErr = Object.keys(errors)[0];
					errTitle =  res.message;
					errMessage = errors[firstErr][0];
				break;
				default: 
					errTitle = 'Oooops.';
					errMessage = 'Something went wrong.';
				break;
			}

			swal.fire({
				title:	errTitle,
				text: errMessage,
				icon: "error",
				buttonsStyling: false,
				confirmButtonText: "Ok, got it!",
				customClass: {
					confirmButton: "btn font-weight-bold btn-light"
				}
			});

			

		}).finally(res => {
			// unblocking the card
			KTApp.unblock(_card.getSelf());
		});
		
	}

	return {
		submit: function() {
			_form = $('#kt_form_credentials');
			_card = new KTCard('credentialsTab');
			_submit();
		}
	}
}();

var FKTFormACL = function(){

	var _form;
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

		axios.post(_form.attr('action'), _form.serialize(), {
			headers: {
				'X-Edit-Employee' : 'acl'
			}
		}).then(res => {

			swal.fire({
				text: res.data.message,
				icon: "success",
				buttonsStyling: false,
				confirmButtonText: "Ok, got it!",
				customClass: {
					confirmButton: "btn font-weight-bold btn-light"
				}
			});

        }).catch(err => {

			let error = err.response;
			let res = error.data;
			var errTitle = '';
			var errMessage = '';

			console.log(error);

			switch(error.status){
				case 500: 
					errTitle = 'Internal Service Error';
					errMessage = res.message;
				break;
				case 422:
					let errors = res.errors;
					let firstErr = Object.keys(errors)[0];
					errTitle =  res.message;
					errMessage = errors[firstErr][0];
				break;
				default: 
					errTitle = 'Oooops.';
					errMessage = 'Something went wrong.';
				break;
			}

			swal.fire({
				title:	errTitle,
				text: errMessage,
				icon: "error",
				buttonsStyling: false,
				confirmButtonText: "Ok, got it!",
				customClass: {
					confirmButton: "btn font-weight-bold btn-light"
				}
			});

			

		}).finally(res => {
			// unblocking the card
			KTApp.unblock(_card.getSelf());
		});
		
	}

	return {
		submit: function() {
			_form = $('#kt_form_acl');
			_card = new KTCard('aclTab');
			_submit();
		}
	}
}();

jQuery(document).ready(function() {
	KTUInitPlugins.init();
	KTFormValidation.init();
});