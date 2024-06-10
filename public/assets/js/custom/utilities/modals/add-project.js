"use strict";

const button = document.querySelector("#kt_modal_create_project_btn");
const loadingEl = document.createElement("div");
// Handle toggle click event
button.addEventListener("click", function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        method: "POST",
        url: $('#kt_modal_create_project_form').data("route-url"),
        data: $('#kt_modal_create_project_form').serialize(),
        dataType: "json",
        cache: false,
        contentType: false, //tell jquery to avoid some checks
        processData: false, 
 
        success: function (response, textStatus, xhr) {
         if (response['status'] == true) {
            Swal.fire({
               text: response['msg'], // respose from controller
               icon: 'success',
               buttonsStyling: false,
               confirmButtonText: "{{ __('site.confirmButtonTextGotit') }}",
               customClass: {
                  confirmButton: "btn fw-bold btn-primary",
               }
            })
         } else if (response['status'] == false) {
            let msgError = '';
            $.each(response['msg'], function (key, value) {
               msgError+= '<p>' + value + '</p>';
            });
          
            // manage response jquery 
            Swal.fire({
               html: msgError, // respose from controller
               icon: 'error',
               buttonsStyling: false,
               confirmButtonText: "{{ __('site.confirmButtonTextGotit') }}",
               customClass: {
                  confirmButton: "btn fw-bold btn-primary",
               }
            })
         }
      },
      error: function (response, textStatus, xhr) {
       
         errorMessages ='sdsadsa';
        Swal.fire({
            text: errorMessages, // respose from controller
            icon: 'error',
            buttonsStyling: false,
            confirmButtonText: "{{ __('site.confirmButtonTextGotit') }}",
            customClass: {
               confirmButton: "btn fw-bold btn-primary",
            }
         })
      },                        
       
                        


        
    });
});
