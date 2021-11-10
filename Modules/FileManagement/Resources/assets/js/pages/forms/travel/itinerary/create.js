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
        
        $('#kt_repeater').repeater({
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

var KTFormValidation = function() {

	var _form = function () {
		FormValidation.formValidation(
			document.getElementById('kt_form'),
			{
				fields: {
					'employee': {
						validators: {
							notEmpty: {
								message: 'Employee is required'
							}
						}
					},
					'travel-date': {
						validators: {
							notEmpty: {
								message: 'Date of travel is required'
							}
						}
					},
					purpose: {
						validators: {
							notEmpty: {
								message: 'Purpose is required'
							}
						}
					},
					supervisor: {
						validators: {
							notEmpty: {
								message: 'Supervisor officer is required'
							}
						}
                    },
                    approving: {
						validators: {
							notEmpty: {
								message: 'Approving officer is required'
							}
						}
					},
					liaison: {
						validators: {
							notEmpty: {
								message: 'Liaison officer is required'
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
            KTForm.submit();
        });
	}

	return {
		// public functions
		init: function() {
			_form();
		}
	};

}();

var KTForm = function(){

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

        axios.post(_form.attr('action'), _form.serialize())
        .then(res => {
			swal.fire({
				text: res.data.message,
				icon: "success",
				buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                allowOutsideClick: false,
				customClass: {
					confirmButton: "btn font-weight-bold btn-light"
				}
			}).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = res.data.route
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
			_form = $('#kt_form');
			_card = new KTCard('card-box');
			_submit();
		}
	}
}();

jQuery(document).ready(function() {
	KTUInitPlugins.init();
	KTFormValidation.init();
});