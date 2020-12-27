"use strict";
// Class definition

var KTDTAccountList = function() {

	var _init = function() {

        var _token = $('meta[name=csrf-token]').attr('content');

		var datatable = $('#kt_datatable_account_list').KTDatatable({
			// datasource definition
			data: {
				type: 'remote',
				source: {
					read: {
                        url: window.location.href,
                        headers: {'X-CSRF-TOKEN': _token},
                        method: 'GET',
					},
				},
				pageSize: 10, // display 20 records per page
				serverPaging: false,
				serverFiltering: false,
				serverSorting: false,
			},

			// layout definition
			layout: {
				scroll: false, // enable/disable datatable scroll both horizontal and vertical when needed.
				footer: false, // display/hide footer
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
					width: 40,
					type: 'number',
					selector: false,
					textAlign: 'left',
					template: function(data) {
						return '<span class="font-weight-bolder">' + data.id + '</span>';
					}
				}, {
					field: 'name',
					title: 'Name',
					width: 300,
					template: function(data) {
						var number = KTUtil.getRandomInt(1, 14);
                        var user_img = data.image;
                        var fullName = data.name

                        var output = '';
                        
						if (user_img != null) {
							output = `<div class="d-flex align-items-center">\
								<div class="symbol symbol-40 symbol-sm flex-shrink-0">\
									<img class="" src="${user_img}" alt="photo">\
								</div>\
								<div class="ml-4">\
                                    <div class="text-dark-75 font-weight-bolder font-size-lg mb-0">${fullName}</div>\
									<span class="text-muted font-weight-bold text-hover-primary"> ${data.position} </span>\
                                    
								</div>\
							</div>`;
						}
						else {
							var stateNo = KTUtil.getRandomInt(0, 7);
							var states = [
								'success',
								'primary',
								'danger',
								'success',
								'warning',
								'dark',
								'primary',
								'info'];
							var state = states[stateNo];

							output = `<div class="d-flex align-items-center">\
								<div class="symbol symbol-40 symbol-light-'+state+' flex-shrink-0">\
									<span class="symbol-label font-size-h4 font-weight-bold">${fullName.charAt(0)}</span>\
								</div>\
								<div class="ml-4">\
                                    <div class="text-dark-75 font-weight-bolder font-size-lg mb-0">${fullName}</div>\
									<span class="text-muted font-weight-bold text-hover-primary"> ${data.position} </span>\
								</div>\
							</div>`;
						}

						return output;
					}
				}, {
					field: 'username',
					title: 'Username'
				}, {
					field: 'role',
					title: 'Role'
				},{
					field: 'status',
					title: 'Status',
					template: function(row) {
						var status = {
							'true': {'title': 'Active', 'class': ' label-light-success'},
							'false': {'title': 'Inactive', 'class': ' label-light-danger'}
						};
						return `
								<span class="label label-lg font-weight-bold ${status[row.status].class} label-inline">
									${status[row.status].title}
								</span>
							`;
					},
				}, {
					field: 'Actions',
					title: 'Actions',
					sortable: false,
					width: 130,
					overflow: 'visible',
					autoHide: false,
					template: function(row) {
						return `\
	                        <a href="${row.edit}" class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon mr-2" title="Edit details">\
	                            <span class="svg-icon svg-icon-md">\
									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
										<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
											<rect x="0" y="0" width="24" height="24"/>\
											<path d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953) "/>\
											<path d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>\
										</g>\
									</svg>\
	                            </span>\
	                        </a>\
	                    `;
					},
				}],
		});

	};

	return {
		// public functions
		init: function() {
			_init();
		},
	};
}();

jQuery(document).ready(function() {
	KTDTAccountList.init();
});