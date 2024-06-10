// Define form element
"use strict";
var v = true;
$("input#train_required").on("click",function(){
    if (v) {
       $("div#obsDate").show();
      v = false;
    }else{
        $("div#obsDate").attr({"style":"display:none !important;"}); 
        v = true;
    }
});
const form = document.getElementById("auditor-hand-offer-task-form");

// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
var validator = FormValidation.formValidation(form, {
    fields: {
        'auditor_training_date': {
            validators: {
                callback: {
                    message: "يرجي ادخال تاريخ التدريب.",
                    callback: function (input) {
                        if ($("#train_required").is(":checked")) {
                            return input.value == "" ? false : true;
                        }
                    },
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
const submitButton = document.getElementById("auditor-hand-offer-task-btn");
submitButton.addEventListener("click", function (e) {
    // Prevent default button action
    e.preventDefault();

    // Validate form before submit
    if (validator) {
        validator.validate().then(function (status) {
            console.log("validated!");

            if (status == "Valid") {               
                // Show loading indication
               form.submit(); // Submit form 
            } else {
                Swal.fire({
                    text: "عذراً ، يبدو أنه تم اكتشاف بعض الأخطاء في أستكمال إنهاء المهمه ، يرجى المحاولة مرة أخرى.",
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