"use strict";

KTUtil.onDOMContentLoaded(function () {
    $("#start_date").flatpickr({ 
        enableTime: true, 
        noCalendar: true, 
        dateFormat: "h:i", 
        locale: "ar"
    });
    $("#end_date").flatpickr({ 
        enableTime: true, 
        noCalendar: true, 
        dateFormat: "h:i", 
        locale: "ar"
    });
});

function deleteTrainingUrl(val) {
    var $urlId = val.firstElementChild.value;
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    var $postrequest = $.post(projectBaseUrl + "/trainer/customTrainingDeletion/url/" + $urlId);
    $postrequest.done(function (data) {
        window.location.href = projectBaseUrl + "/trainers/" + $project_id.val() + "/edit"; // make request
    });
}

function deleteTrainer(val) {
    var $team_memeber_id = val.firstElementChild.value;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var $postrequest = $.post(projectBaseUrl + '/trainer/customTrainingDeletion/training/0/' + $project_id.val() + '/' + $team_memeber_id);
    $postrequest.done(function (data) { // success
        window.location.href = projectBaseUrl + '/trainers/' + $project_id.val() + '/edit'; // make request
    });
}

// Define form element
var form = document.getElementById("trainingForm");

// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
var validator = FormValidation.formValidation(form, {
    fields: {
        title: {
            validators: {
                notEmpty: {
                    message: "يرجي إدخال عنوان التدريب ",
                },
            },
        },
        start_date: {
            validators: {
                notEmpty: {
                    message: "يرجي إدخال تاريخ و وقت البدء .",
                },
            },
        },
        end_date: {
            validators: {
                notEmpty: {
                    message: "يرجي إدخال تاريخ و وقت النهاية .",
                },
            },
        },
        url: {
            validators: {
                notEmpty: {
                    message: "يرجي إدخال رابط التدريب .",
                },
            },
        },
        train_file_url: {
            validators: {
                callback: {
                    message: "يرجي ادخال رابط التدريب.",
                    callback: function (input) {
                        if ($("#TrainurlDiv").is(":visible")) {
                            return input.value == "" ? false : true;
                        }
                    },
                },
            },
        },
        train_kashef_url: {
            validators: {
                callback: {
                    message: "يرجي إدخال رابط تدريب برنامج كاشف.",
                    callback: function (input) {
                        if ($("#kashefDataDiv").is(":visible")) {
                            return input.value == "" ? false : true;
                        }
                    },
                },
            },
        },
        train_kashef_account_email: {
            validators: {
                callback: {
                    message: "يرجي إدخال البريد الألكتروني الخاص ببرنامج كاشف.",
                    callback: function (input) {
                        if ($("#kashefDataDiv").is(":visible")) {
                            return input.value == "" ? false : true;
                        }
                    },
                },
            },
        },
        train_kashef_account_password: {
            validators: {
                callback: {
                    message: "يرجي إدخال كلمه المرور الخاص ببرنامج كاشف.",
                    callback: function (input) {
                        if ($("#kashefDataDiv").is(":visible")) {
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
const submitButton = document.getElementById("kt_page_loading_overlay");
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
                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                });
                $.ajax({
                    type: "POST",
                    url: $("#trainingForm").data("route-url"),
                    data: $("#trainingForm").serialize(),
                    cache: true,
                    dataType: "json",

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

                        Swal.fire({
                            text: response["msg"],
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "حسنأ موافق",
                            customClass: {
                                confirmButton: "btn btn-primary",
                            },
                        });

                        window.location.href = $("#trainingForm").data("redirect-url");
                    },
                });
            } else {
                Swal.fire({
                    text: "عذراً ، يبدو أنه تم اكتشاف بعض الأخطاء في أستكمال إنشاء رابط تدريب جديد ، يرجى المحاولة مرة أخرى.",
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

$("#kt_edit_project_cancel").click(function () {
    window.location = projectBaseUrl + '/trainer/projects';
});