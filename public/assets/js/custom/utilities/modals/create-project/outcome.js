"use strict";

// Class definition
var KTModalCreateProjectOutcome = function () {
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
					'executive_planning_file': {
						validators: {
							notEmpty: {
								message: 'يجب رفع ملف الخطه التنفيذيه'
							}
						}
					},
					'titleOutcome[]': {
						validators: {
							notEmpty: {
								message: 'يجب ادخال عنوان او اسم المخرج'
							}
						}
					},
					'descOutcome[]': {
						validators: {
							notEmpty: {
								message: 'يجب ادخال وصف للمخرج'
							}
						}
					},

					'fileOutcome[]': {
						validators: {
							notEmpty: {
								message: 'يجب ادخال قالب  للمخرج'
							}
						}
					},

					////////////////////////According to Project Type ///////////////////////////


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
							text: "عذراً ، يبدو أنه تم اكتشاف بعض الأخطاء في أستكمال المخرجات ، يرجى المحاولة مرة أخرى.",
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
			nextButton = KTModalCreateProject.getStepper().querySelector('[data-kt-element="outcome-next"]');
			previousButton = KTModalCreateProject.getStepper().querySelector('[data-kt-element="outcome-previous"]');

			initValidation();
			handleForm();
		}
	};
}();

// Webpack support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
	window.KTModalCreateProjectOutcome = module.exports = KTModalCreateProjectOutcome;
}
