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

    var formData = new FormData($('#kt_modal_create_project_form')[0]);

    $.ajax({
        type: 'POST',
        url: $('#kt_modal_create_project_form').data("route-url"),
 
        data: formData,
        dataType: "json",
        cache: false,
        contentType: false, //tell jquery to avoid some checks
        processData: false, 

        beforeSend: function () {
            document.body.prepend(loadingEl);
            loadingEl.classList.add("page-loader");
            loadingEl.classList.add("flex-column");
            loadingEl.classList.add("bg-dark");
            loadingEl.classList.add("bg-opacity-25");
            loadingEl.innerHTML = `
                    <span class="spinner-border text-primary" role="status"></span>
                    <span class="text-gray-800 fs-6 fw-semibold mt-5">الرجاء الإنتظار...</span>
                `;

            KTApp.showPageLoading();
        },

        success: function (response, textStatus, xhr) {

            KTApp.hidePageLoading();
            loadingEl.remove();

            if (response['status'] == true) {
               Swal.fire({
                  text: response['msg'], // respose from controller
                  icon: 'success',
                  html:
                  response['msg'] +
                  '<br/><a href="/project/">المشروعات</a> ' +
                  '',                  
                  buttonsStyling: false,
                  confirmButtonText: "حسنا موافق",
                  customClass: {
                     confirmButton: "btn fw-bold btn-primary",
                  }
               })
            } else if (response['status'] == false) {
  
             
               // manage response jquery 
               Swal.fire({
                  html: response['msg'], // respose from controller
                  icon: 'error',
                  buttonsStyling: false,
                  confirmButtonText: "حسنا موافق",
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
               confirmButtonText: "حسنا موافق",
               customClass: {
                  confirmButton: "btn fw-bold btn-primary",
               }
            })
         },                        
        

        
    });
});
