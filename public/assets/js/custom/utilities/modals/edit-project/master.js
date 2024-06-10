"use strict";

var KTModalEditProject = function () {
	var stepper;
	var stepperObj;
	var form;	

	var initStepper = function () {
		stepperObj = new KTStepper(stepper);
	}

	return {
		init: function () {
			stepper = document.querySelector('#kt_modal_edit_project_stepper');
			form = document.querySelector('#kt_modal_edit_project_form');

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
	if (!document.querySelector('#kt_modal_edit_project')) {
		return;
	}

	KTModalEditProject.init();
	KTModalEditProjectType.init();
	KTModalEditProjectMainData.init();
	KTModalEditProjectAttachments.init();
	KTModalEditProjectOpening.init();
	KTModalEditProjectClosing.init();
	KTModalEditProjectComplete.init();
});

if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
	window.KTModalEditProject = module.exports = KTModalEditProject;
}
