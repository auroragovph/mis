"use strict";
// Class definition

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

		axios.post(_form.attr('action'), _form.serialize())
		.then(res => {

			_form.trigger('reset');
			
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