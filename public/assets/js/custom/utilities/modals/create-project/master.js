"use strict";

var KTModalCreateProject = function () {
	var stepper;
	var stepperObj;
	var form;	

	var initStepper = function () {
		stepperObj = new KTStepper(stepper);
	}

	return {
		init: function () {
			stepper = document.querySelector('#kt_modal_create_project_stepper');
			form = document.querySelector('#kt_modal_create_project_form');

			initStepper();
		},

		getStepperObj: function () {
			return stepperObj;
		},

		getStepper: function () {
			return stepper;
		},
		
		getForm: function () {
			return form;
		}
	};
}();

KTUtil.onDOMContentLoaded(function () {
	if (!document.querySelector('#kt_modal_create_project')) {
		return;
	}

	KTModalCreateProject.init();
	KTModalCreateProjectType.init();
	KTModalCreateProjectMainData.init();
	KTModalCreateProjectAttachments.init();
	KTModalCreateProjectOutcome.init();
	KTModalCreateProjectOpening.init();
	KTModalCreateProjectClosing.init();
	KTModalCreateProjectComplete.init();
});

if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
	window.KTModalCreateProject = module.exports = KTModalCreateProject;
}
