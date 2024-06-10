"use strict";

// Class definition
var KTModalEditProjectType = function () {
	// Variables
	var nextButton;
	var validator;
	var form;
	var stepper;

	// Private functions
	var initValidation = function() {
		// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
		validator = FormValidation.formValidation(
			form,
			{
				fields: {
					'edit_title': {
						validators: {
							notEmpty: {
								message: 'هذا الحقل مطلوب'
							}
						}
					}
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

	var handleForm = function() {
		nextButton.addEventListener('click', function (e) {
			// Prevent default button action
			e.preventDefault();

			// Disable button to avoid multiple click
			nextButton.disabled = true;

			// Validate form before submit
			if (validator) {
				validator.validate().then(function (status) {
					e.preventDefault();
					var projectTypeId = $('#edit_type_id').val();
					if(projectTypeId == 9) {
						document.getElementById('edit_cases').classList.add("d-none");
						document.getElementById('edit_building').classList.add("d-none");
						document.getElementById('edit_training').classList.add("d-none");
						document.getElementById('edit_inspection_visit').classList.add("d-none");

						document.getElementById('edit_charity').classList.remove("d-none");
					} else if(projectTypeId == 14) {
						document.getElementById('edit_cases').classList.add("d-none");
						document.getElementById('edit_building').classList.add("d-none");
						document.getElementById('edit_charity').classList.add("d-none");
						document.getElementById('edit_inspection_visit').classList.add("d-none");

						document.getElementById('edit_training').classList.remove("d-none");
					} else if(projectTypeId == 10) {
						document.getElementById('edit_cases').classList.add("d-none");
						document.getElementById('edit_building').classList.remove("d-none");
						document.getElementById('edit_charity').classList.add("d-none");
						document.getElementById('edit_training').classList.add("d-none");

						document.getElementById('edit_inspection_visit').classList.remove("d-none");
					} else {
						document.getElementById('edit_charity').classList.add("d-none");
						document.getElementById('edit_training').classList.add("d-none");
						document.getElementById('edit_inspection_visit').classList.add("d-none");

						document.getElementById('edit_cases').classList.remove("d-none");
						document.getElementById('edit_building').classList.remove("d-none");
					}

					if (status == 'Valid') {
						// Show loading indication
						nextButton.setAttribute('data-kt-indicator', 'on');

						// Simulate form submission
						setTimeout(function() {
							// Simulate form submission
							nextButton.removeAttribute('data-kt-indicator');

							// Enable button
							nextButton.disabled = false;

							// Go to next step
							stepper.goNext();
						}, 1000);
					} else {
						// Enable button
						nextButton.disabled = false;

						// Show popup warning. For more info check the plugin's official documentation: https://sweetalert2.github.io/
						Swal.fire({
							text: "Sorry, looks like there are some errors detected, please try again.",
							icon: "error",
							buttonsStyling: false,
							confirmButtonText: "Ok, got it!",
							customClass: {
								confirmButton: "btn btn-primary"
							}
						});
					}
				});
			}
		});
	}

	return {
		// Public functions
		init: function () {
			form = KTModalEditProject.getForm();
			stepper = KTModalEditProject.getStepperObj();
			nextButton = KTModalEditProject.getStepper().querySelector('[data-kt-element="type-next"]');
			initValidation();
			handleForm();
		}
	};
}();

// Webpack support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
	window.KTModalEditProjectType = module.exports = KTModalEditProjectType;
}
