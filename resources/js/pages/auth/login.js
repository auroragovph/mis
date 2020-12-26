"use strict";


// Class Definition
var KTLogin = function() {
	var _buttonSpinnerClasses = 'spinner spinner-right spinner-white pr-15';

	var _handleFormSignin = function() {
		var form = KTUtil.getById('kt_login_singin_form');
		var formSubmitUrl = KTUtil.attr(form, 'action');
		var formSubmitButton = KTUtil.getById('kt_login_singin_form_submit_button');

		if (!form) {
			return;
		}

		FormValidation
		    .formValidation(
		        form,
		        {
		            fields: {
						username: {
							validators: {
								notEmpty: {
									message: 'Username is required'
								}
							}
						},
						password: {
							validators: {
								notEmpty: {
									message: 'Password is required'
								}
							}
						}
		            },
		            plugins: {
						trigger: new FormValidation.plugins.Trigger(),
						submitButton: new FormValidation.plugins.SubmitButton(),
	            		//defaultSubmit: new FormValidation.plugins.DefaultSubmit(), // Uncomment this line to enable normal button submit after form validation
						bootstrap: new FormValidation.plugins.Bootstrap({
						//	eleInvalidClass: '', // Repace with uncomment to hide bootstrap validation icons
						//	eleValidClass: '',   // Repace with uncomment to hide bootstrap validation icons
						})
		            }
		        }
		    )
		    .on('core.form.valid', function() {
				// Show loading state on button
				KTUtil.btnWait(formSubmitButton, _buttonSpinnerClasses, "Please wait");

				// Simulate Ajax request
				setTimeout(function() {
				}, 2000);


				// sending data via axios
				axios.post(KTUtil.attr(form, 'action'), $('#kt_login_singin_form').serialize())
				.then(res => {

					swal.fire({
						title: "Authentication success.",
						text: "Redirecting to dashboard.",
						onOpen: function() {
							swal.showLoading()
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
				}).finally(res => {
					// unblocking the button
					KTUtil.btnRelease(formSubmitButton);


				});
		    })
			.on('core.form.invalid', function() {
				swal.fire({
					text: "Sorry, looks like there are some errors detected, please try again.",
					icon: "error",
					buttonsStyling: false,
					confirmButtonText: "Ok, got it!",
					customClass: {
						confirmButton: "btn font-weight-bold btn-light-primary"
					}
				}).then(function() {
					KTUtil.scrollTop();
				});
		    });
    }

	

    // Public Functions
    return {
        init: function() {
            _handleFormSignin();
        }
    };
}();

// Class Initialization
jQuery(document).ready(function() {
	
	KTLogin.init();
	
});
