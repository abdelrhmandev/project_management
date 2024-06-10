"use strict";

const form = document.getElementById("ClientNoApproveFORM");

// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
var validator = FormValidation.formValidation(form, {
    fields: {
        rejection_note: {
            validators: {
                notEmpty: {
                    message: "برجاء كتابه سبب رفض أعتماد المشروع .",
                },
            },
        },
         

    },
    plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap: new FormValidation.plugins.Bootstrap5({
            rowSelector: ".fv-row",
            eleInvalidClass: "",
            eleValidClass: "",
        }),
    },
});

// Submit button handler
const submitButton = document.getElementById("not-approve-btn");
submitButton.addEventListener("click", function (e) {
    // Prevent default button action
    e.preventDefault();

    // Validate form before submit
    if (validator) {
        validator.validate().then(function (status) {
            console.log("validated!");

            if (status == "Valid") {
                // Show loading indication
                submitButton.setAttribute("data-kt-indicator", "on");

                // Disable button to avoid multiple click
                
                submitButton.disabled = true;
               
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "post",
                    enctype: "multipart/form-data",
                    url: $("#ClientNoApproveFORM").data("route-url"),
                    data: new FormData($("#ClientNoApproveFORM")[0]),
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (response, textStatus, xhr) {
            

                        Swal.fire({
                            text: response["msg"],
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "حسنأ موافق",
                            customClass: {
                                confirmButton: "btn btn-primary",
                            },
                        });
                        window.location.href = response["url"];

                    },
                });
            } else {
                Swal.fire({
                    text: "عذراً ، يبدو أنه تم اكتشاف بعض الأخطاء في رفض مشروع الخطه التنفيذيه ، يرجى المحاولة مرة أخرى.",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "حسنأ موافق",
                    customClass: {
                        confirmButton: "btn btn-primary",
                    },
                });
            }
        });
    }
});
