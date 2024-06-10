"use strict";

// Class definition
var KTModalEditProjectMainData = function () {
	// Variables
	var nextButton;
	var previousButton;
	var validator;
	var form;
	var stepper;

	// Private functions
	var initForm = function () {
		// Due date. For more info, please visit the official plugin site: https://flatpickr.js.org/
		var startDate = $(form.querySelector('[name="start_date"]'));
		startDate.flatpickr({
			minDate: "today",
			dateFormat: "Y-m-d",
			locale: 'ar',
			time_24hr: false
		});

		var endDate = $(form.querySelector('[name="end_date"]'));
		endDate.flatpickr({
			minDate: "today",
			dateFormat: "Y-m-d",
			locale: 'ar',
			time_24hr: false
		});

		var trainingDate = $(form.querySelector('[name="training_date"]'));
		trainingDate.flatpickr({
			minDate: "today",
			dateFormat: "Y-m-d",
			locale: 'ar',
			time_24hr: false
		});

		// Expiry year. For more info, plase visit the official plugin site: https://select2.org/
		$(form.querySelector('[name="customer_id"]')).on('change', function () {
			// Revalidate the field when an option is chosen
			validator.revalidateField('customer_id');
		});

		$(form.querySelector('[name="region_ids[]"]')).on('change', function () {
			// Revalidate the field when an option is chosen
			validator.revalidateField('region_ids[]');
		});

		$(form.querySelector('[name="training_type"]')).on('change', function () {
			// Revalidate the field when an option is chosen
			validator.revalidateField('training_type');
		});

		$(form.querySelector('[name="participant_type"]')).on('change', function () {
			// Revalidate the field when an option is chosen
			validator.revalidateField('participant_type');
		});

	}

	 var initValidation = function () {




		// Init form validation rules. For more info check the FormValidation plugin's official
		documentation: https: //formvalidation.io/
		validator = FormValidation.formValidation(
			form, {
			fields: {
				'title': {
					validators: {
						notEmpty: {
							message: 'إسم المشروع حقل مطلوب.'
						}
					}
				},
				'customer_id': {
					validators: {
						notEmpty: {
							message: 'الجهة المسؤولة حقل مطلوب.'
						}
					}
				},

				'region_ids[]': {
					validators: {
						notEmpty: {
							message: 'عذرا يرجي علي الأقل تحديد منطقه واحده.'
						}
					}
				},

				'start_date': {
					validators: {
						notEmpty: {
							message: 'تاريخ بدء المشروع حقل مطلوب.'
						}
					}
				},

				'end_date': {
					validators: {
						notEmpty: {
							message: 'تاريخ انتهاء المشروع حقل مطلوب.'
						}
					}
				},
				////////////////////////According to Project Type ///////////////////////////
				'mine_title': {
					validators: {
						callback: {
							message: 'اسم المنجم/المحجر حقل مطلوب .',
							callback: function (input) {
								if( $('#edit_inspection_visit').is(':visible')){
									return input.value == '' ? false : true;
								}
							},
						},
					},
				},

				'cases_count': {
					validators: {
						callback: {
							message: 'عدد الحالات حقل مطلوب.',
							callback: function (input) {
								if( $('#edit_cases').is(':visible')){
									return input.value == '' ? false : true;
								}
							},
						},
					},
				},

				'building_count': {
					validators: {
						callback: {
							message: 'عدد المباني/المرافق التقديرية في الحصر حقل مطلوب.',
							callback: function (input) {
								if( $('#edit_building').is(':visible')){
									return input.value == '' ? false : true;
								}
							},
						},
					},
				},

				'charity_count': {
					validators: {
						callback: {
							message: 'عدد الجمعيات حقل مطلوب.',
							callback: function (input) {
								if( $('#edit_charity').is(':visible')){
									return input.value == '' ? false : true;
								}
							},
						},
					},
				},



				'training_count': {
					validators: {
						callback: {
							message: 'عدد المتدربين حقل مطلوب.',
							callback: function (input) {
								if( $('#edit_training').is(':visible')){
									return input.value == '' ? false : true;
								}
							},
						},
					},
				},


				'training_on': {
					validators: {
						callback: {
							message: 'التدريب على حقل مطلوب.',
							callback: function (input) {
								if( $('#edit_training').is(':visible')){
									return input.value == '' ? false : true;
								}
							},
						},
					},
				},


				'training_type': {
					validators: {
						callback: {
							message: 'نوع التدريب حقل مطلوب.',
							callback: function (input) {
								if( $('#edit_training').is(':visible')){
									return input.value == '' ? false : true;
								}
							},
						},
					},
				},

				'participant_type': {
					validators: {
						callback: {
							message: 'طبيعة الحضور حقل مطلوب.',
							callback: function (input) {
								if( $('#edit_training').is(':visible')){
									return input.value == '' ? false : true;
								}
							},
						},
					},
				},

				'training_date': {
					validators: {
						callback: {
							message: 'موعد التدريب حقل مطلوب.',
							callback: function (input) {
								if( $('#edit_training').is(':visible')){
									return input.value == '' ? false : true;
								}
							},
						},
					},
				},

				'duration': {
					validators: {
						callback: {
							message: 'مدة التدريب حقل مطلوب.',
							callback: function (input) {
								if( $('#edit_training').is(':visible')){
									return input.value == '' ? false : true;
								}
							},
						},
					},
				},












			},

			plugins: {
				trigger: new FormValidation.plugins.Trigger(),
				bootstrap: new FormValidation.plugins.Bootstrap5({
					rowSelector: '.fv-row',
					eleInvalidClass: '',
					eleValidClass: ''
				})
			}
		}
		);
	}

	var handleForm = function () {
		nextButton.addEventListener('click', function (e) {
			// Prevent default button action
			e.preventDefault();

			var projectTypeId = document.querySelector('input[name="type_idEdit"]').value;
			if ((projectTypeId >= 2 && projectTypeId <= 5) || projectTypeId == 12) {
				document.getElementById('training_filesEdit').classList.add("d-none");
				document.getElementById('charity_listEdit').classList.add("d-none");

				document.getElementById('research_surveyEdit').classList.remove("d-none");
				document.getElementById('google_mapEdit').classList.remove("d-none");
			} else if (projectTypeId == 9) {
				document.getElementById('charity_listEdit').classList.remove("d-none");
				document.getElementById('training_filesEdit').classList.add("d-none");
				document.getElementById('google_mapEdit').classList.add("d-none");

				document.getElementById('research_survey').classList.add("d-none");
			} else if (projectTypeId == 14) {
				document.getElementById('training_filesEdit').classList.remove("d-none");
				document.getElementById('charity_listEdit').classList.add("d-none");
				document.getElementById('research_surveyEdit').classList.add("d-none");
				document.getElementById('google_mapEdit').classList.add("d-none");
			} else {
				document.getElementById('training_filesEdit').classList.add("d-none");
				document.getElementById('charity_listEdit').classList.add("d-none");
				document.getElementById('research_surveyEdit').classList.add("d-none");
				document.getElementById('google_mapEdit').classList.remove("d-none");
			}

			// Disable button to avoid multiple click
			nextButton.disabled = true;

			// Validate form before submit
			if (validator) {
				validator.validate().then(function (status) {
					console.log('validated!');

					if (status == 'Valid') {
						// Show loading indication
						nextButton.setAttribute('data-kt-indicator', 'on');

						// Simulate form submission
						setTimeout(function () {
							// Simulate form submission
							nextButton.removeAttribute('data-kt-indicator');

							// Enable button
							nextButton.disabled = false;

							// Go to next step
							stepper.goNext();
						}, 1500);
					} else {
						// Enable button
						nextButton.disabled = false;

						// Show popup warning. For more info check the plugin's official documentation: https://sweetalert2.github.io/
						Swal.fire({
							text: "عذراً ، يبدو أنه تم اكتشاف بعض الأخطاء في أستكمال البيانات الأساسيه ، يرجى المحاولة مرة أخرى.",
							icon: "error",
							buttonsStyling: false,
							confirmButtonText: "حسنا موافق",
							customClass: {
								confirmButton: "btn btn-primary"
							}
						});
					}
				});
			}
		});

		previousButton.addEventListener('click', function () {
			// Go to previous step
			stepper.goPrevious();
		});
	}

	return {
		// Public functions
		init: function () {
			form = KTModalEditProject.getForm();
			stepper = KTModalEditProject.getStepperObj();
			nextButton = KTModalEditProject.getStepper().querySelector('[data-kt-element="main-next"]');
			previousButton = KTModalEditProject.getStepper().querySelector('[data-kt-element="main-previous"]');

			initForm();
			initValidation();
			handleForm();
		}
	};
}();

// Webpack support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
	window.KTModalEditProjectMainData = module.exports = KTModalEditProjectMainData;
}