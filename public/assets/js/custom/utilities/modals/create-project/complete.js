"use strict";

 

// Class definition
var KTModalCreateProjectComplete = function () {
   // Variables
   // var startButton;
   var form = document.querySelector('#kt_modal_create_project_form');

   // Private functions
   var handleForm = function () {
      // Submit button handler
  
      const submitButtonOnlySave = document.getElementById('save-project');
      submitButtonOnlySave.addEventListener('click', function (e) {
         // Prevent default button action
         e.preventDefault();

         // Show loading indication
         submitButtonOnlySave.setAttribute('data-kt-indicator', 'on');

         // Disable button to avoid multiple click
         submitButtonOnlySave.disabled = true;

         // Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
         setTimeout(function () {
            // Remove loading indication
            submitButtonOnlySave.removeAttribute('data-kt-indicator');

            // Enable button
            submitButtonOnlySave.disabled = false;

            // Show popup confirmation
            form.submit(); // Submit form
         }, 2000);
      });
   }

   return {
      // Public functions
      init: function () {
         handleForm();
      }
   };
}();

// Webpack support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
   window.KTModalCreateProjectComplete = module.exports = KTModalCreateProjectComplete;
}