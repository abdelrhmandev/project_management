"use strict";

// Class definition
var KTModalEditProjectComplete = function () {
   // Variables
	// var startButton;
   var form;
   var stepper;

   // Private functions
   var handleForm = function () {


      // Submit button handler
      const submitButtonSaveEdit = document.getElementById('kt_modal_new_target_submit_save_edit');
      submitButtonSaveEdit.addEventListener('click', function (e) {
         // Prevent default button action
         e.preventDefault();

         // Show loading indication
         submitButtonSaveEdit.setAttribute('data-kt-indicator', 'on');

         // Disable button to avoid multiple click
         submitButtonSaveEdit.disabled = true;

         // Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
         setTimeout(function () {
            // Remove loading indication
            submitButtonSaveEdit.removeAttribute('data-kt-indicator');

            // Enable button
            submitButtonSaveEdit.disabled = false;

            // Show popup confirmation


            form.submit(); // Submit form
         }, 2000);


      });
   
 	  
	
	
	}

   return {
      // Public functions
      init: function () {
         form = KTModalEditProject.getForm();
         stepper = KTModalEditProject.getStepperObj();
        //  startButton = KTModalEditProject.getStepper().querySelector('[data-kt-element="complete-start"]');

         handleForm();
      }
   };
}();

// Webpack support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
   window.KTModalEditProjectComplete = module.exports = KTModalEditProjectComplete;
}