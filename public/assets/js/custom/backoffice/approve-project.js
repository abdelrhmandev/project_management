"use strict";

KTUtil.onDOMContentLoaded(function () {
    $("#start_date").flatpickr({
        minDate: "today",
        dateFormat: "Y-m-d",
        locale: "ar",
        time_24hr: false,
    });


    $("#end_date").flatpickr({
        minDate: "today",
        dateFormat: "Y-m-d",
        locale: "ar",
        time_24hr: false,
    });

    $("#opening_date").flatpickr({
        minDate: "today",
        dateFormat: "Y-m-d",
        locale: "ar",
        time_24hr: false,
    });

    $("#closing_date").flatpickr({
        minDate: "today",
        dateFormat: "Y-m-d",
        locale: "ar",
        time_24hr: false,
    });

    $(document).on("click", "#kt_approve_project_cancel", function () {
        window.location.href = projectBaseUrl + "/project/projects"; // make request
    });
});

// Define form element
const form = document.getElementById("kt_docs_form_validation_approve_project");
const select = document.getElementById("kt_project_status_select");
// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
var validator = FormValidation.formValidation(form, {
    fields: {
        confirm_letter: {
            validators: {
                notEmpty: {
                    message: "برجاء إختيار ملف خطاب الترسية ",
                },
            },
        },
        family_list: {
            validators: {
                notEmpty: {
                    message: "برجاء إختيار ملف قائمة الأسر ",
                },
            },
        },
        coordinate_file: {
            validators: {
                notEmpty: {
                    message: "برجاء إختيار ملف الإحداثيات ",
                },
            },
        },
        opening_date: {
            validators: {
                callback: {
                    message: "برجاء إختيار تاريخ الافتتاح ",
                    callback: function (input) {
                        if ($("input#opening").is(":checked")) {
                            return input.value == '' ? false : true;
                        }
                    },
                },
            },
        },
        closing_date: {
            validators: {
                callback: {
                    message: "برجاء إختيار تاريخ الإغلاق",
                    callback: function (input) {
                        if ($("input#closing").is(":checked")) {
                            return input.value == '' ? false : true;
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
const submitButton = document.getElementById(
    "kt_docs_approve_project_form_validation_text_submit"
);
submitButton.addEventListener("click", function (e) {
    // Prevent default button action
    e.preventDefault();
    // Validate form before submit
    if (validator) {
        validator.validate().then(function (status) {
            console.log("validated!");

            if (
                status == "Valid" ||
                select.options[select.selectedIndex].value !== "approved"
            ) {
                if (select.options[select.selectedIndex].value === "reject") {
                    $("#rejection_reason").val(
                        $("#kt_rejection_reason").html()
                    );
                }

                // Show loading indication
                submitButton.setAttribute("data-kt-indicator", "on");

                // Disable button to avoid multiple click
                submitButton.disabled = true;

                // Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                setTimeout(function () {
                    // Remove loading indication
                    submitButton.removeAttribute("data-kt-indicator");

                    // Enable button
                    submitButton.disabled = false;

                    // Show popup confirmation
                    form.submit(); // Submit form
                }, 2000);
            }
        });
    }
});

function manageOpening(checkboxItem) {
    if (checkboxItem.checked) {
        document.getElementById("opening_div").classList.remove("d-none");
    } else {
        document.getElementById("opening_div").classList.add("d-none");
    }
}

function manageClosing(checkboxItem) {
    if (checkboxItem.checked) {
        document.getElementById("closing_div").classList.remove("d-none");
    } else {
        document.getElementById("closing_div").classList.add("d-none");
    }
}
