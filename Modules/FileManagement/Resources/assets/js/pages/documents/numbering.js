"use strict";
// Class definition

var KTNum = function() {
	var _buttonSpinnerClasses = 'spinner spinner-right spinner-white pr-15';

	var _handleForm = function() {
		var form = KTUtil.getById('form_num');
		var formSubmitUrl = KTUtil.attr(form, 'action');
		var formSubmitButton = KTUtil.getById('form_num_btn');

		if (!form) {
			return;
		}

		FormValidation
		    .formValidation(
		        form,
		        {
		            fields: {
						number: {
							validators: {
								notEmpty: {
									message: 'Number is required'
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
				axios.post(KTUtil.attr(form, 'action'), $('#form_num').serialize())
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
                            $('#form_num').trigger('reset');
                            $('#kt_form').trigger('reset');
                            $('#numberModal').modal('hide');
                        }
                    });


				}).catch(err => {

                    let error = err.response;
                    let res = error.data;
                    var errTitle = '';
                    var errMessage = '';

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
                        case 406:
                            errTitle =  'oops';
                            errMessage = res.message;
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
					// unblocking the button
					KTUtil.btnRelease(formSubmitButton);

				});
		    });
    }

	

    // Public Functions
    return {
        init: function() {
            _handleForm();
        }
    };
}();

var KTForm = function() {
	// Private functions

	var _form;
	var _card;

	// basic demo
	var submit = function() {
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
                'x-rr-numer': true
            }
        })
		.then(res => {

            let response = res.data;

            $('#modal-num').text(response.data.last);
            $('#modal-last').text(response.data.type);
            $('input[name="document"]').val(response.data.meta.id);
            $('input[name="type"]').val(response.data.meta.type);

            KTNum.init();

            $('#numberModal').modal('show');


		}).catch(err => {

            console.log(err);

			let error = err.response;
			let res = error.data;
			var errTitle = '';
			var errMessage = '';

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
				case 406:
					errTitle =  'oops';
					errMessage = res.message;
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
	};

	return {
		// public functions
		init: function() {
			_form = $('#kt_form');
			_card = new KTCard('card-box');
			submit();
		},
	};
}();

jQuery(document).ready(function() {



	$('#kt_form').on('submit', function(e){
		e.preventDefault();
		KTForm.init();
    });
    
});