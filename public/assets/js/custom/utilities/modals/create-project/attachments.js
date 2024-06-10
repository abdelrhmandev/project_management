"use strict";

// Class definition
var KTModalCreateProjectAttachments = function () {
	// Variables
	var nextButton;
	var previousButton;
	var validator;
	var form;
	var stepper;

	// Private functions
	var initValidation = function () {
		// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
		validator = FormValidation.formValidation(
			form,
			{
				fields: {
					'logo': {
						validators: {
							notEmpty: {
								message: 'يجب رفع شعار المشروع أو شعار الجهة.'
							}
						}
					},
					'rfp': {
						validators: {
							notEmpty: {
								message: 'يجب رفع ملف كراسة نطاق عمل المشروع RFP.'
							}
						}
					},
					'requirements_specifications': {
						validators: {
							notEmpty: {
								message: 'يجب رفع ملف كراسة الشروط والمواصفات.'
							}
						}
					},
					////////////////////////According to Project Type ///////////////////////////
					'google_map': {
						validators: {
							callback: {
								message: 'يجب رفع ملف خرائط جوجل.',
								callback: function (input) {
									if ($('#google_map').is(':visible')) {
										return input.value.length < 1 ? false : true;
									}
								},
							},
						},
					},
					'charity_list': {
						validators: {
							callback: {
								message: 'يجب رفع ملف قائمة الجمعيات.',
								callback: function (input) {
									if ($('#charity_list').is(':visible')) {
										return input.value.length < 1 ? false : true;
									}
								},
							},
						},
					},
					'training_agenda': {
						validators: {
							callback: {
								message: 'يجب رفع ملف الأجندة.',
								callback: function (input) {
									if ($('#training_files').is(':visible')) {
										return input.value.length < 1 ? false : true;
									}
								},
							},
						},
					},
					'trainee_list': {
						validators: {
							callback: {
								message: 'يجب رفع ملف قائمة المتدربين.',
								callback: function (input) {
									if ($('#training_files').is(':visible')) {
										return input.value.length < 1 ? false : true;
									}
								},
							},
						},
					},
					'research_survey': {
						validators: {
							callback: {
								message: 'يجب رفع إستمارة البحث.',
								callback: function (input) {
									if ($('#research_survey').is(':visible')) {
										return input.value.length < 1 ? false : true;
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
							text: "عذراً ، يبدو أنه تم اكتشاف بعض الأخطاء في أستكمال المرفقات ، يرجى المحاولة مرة أخرى.",
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
			stepper.goPrevious();
		});
	}

	return {
		// Public functions
		init: function () {
			form = KTModalCreateProject.getForm();
			stepper = KTModalCreateProject.getStepperObj();
			nextButton = KTModalCreateProject.getStepper().querySelector('[data-kt-element="attachment-next"]');
			previousButton = KTModalCreateProject.getStepper().querySelector('[data-kt-element="attachment-previous"]');

			initValidation();
			handleForm();
		}
	};
}();

// Webpack support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
	window.KTModalCreateProjectAttachments = module.exports = KTModalCreateProjectAttachments;
}
