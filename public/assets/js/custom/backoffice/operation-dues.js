"use strict";

const form = document.getElementById("dept-timing-form");

// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
var validator = FormValidation.formValidation(form, {
    fields: {
        preparation_days: {
            validators: {
                notEmpty: {
                    message: "يرجي إدخال أيام إنهاء التهيئة .",
                },
            },
        },
        execution_days: {
            validators: {
                notEmpty: {
                    message: "يرجي إدخال أيام التنفيذ .",
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
const submitButton = document.getElementById("dept-timing-btn");
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

                ///////////////////////Ajax /////
                const loadingEl = document.createElement("div");
                document.body.prepend(loadingEl);
					loadingEl.classList.add("page-loader");
					loadingEl.classList.add("flex-column");
					loadingEl.classList.add("bg-dark");
					loadingEl.classList.add("bg-opacity-25");
					loadingEl.innerHTML = `
							<span class="spinner-border text-primary" role="status"></span>
							<span class="text-gray-800 fs-6 fw-semibold mt-5">الرجاء الإنتظار...</span>
						`;
						KTApp.showPageLoading()
                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                });
                $.ajax({
                    type: "POST",
                    url: $("#dept-timing-form").data("route-url"),
                    data: $("#dept-timing-form").serialize(),
                    cache: true,
                    dataType: "json",
                    success: function (response, textStatus, xhr) {
                        KTApp.hidePageLoading();
                        loadingEl.remove();

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
                    text: "عذراً ، يبدو أنه تم اكتشاف بعض الأخطاء في أستكمال إنشاء الأيام المسموحة لإنهاء المهام ، يرجى المحاولة مرة أخرى.",
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
