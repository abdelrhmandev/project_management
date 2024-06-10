// Define form element
const form = document.getElementById("import-researchers-form");

// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
var validator = FormValidation.formValidation(form, {
    fields: {
        imported_researchers: {
            validators: {
                notEmpty: {
                    message: "برجاء أختر ملف الباحثين",
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
const submitButton = document.getElementById("kt_import_researcher_list");
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

                // Simulate form submission
                setTimeout(function () {
                    // Simulate form submission
                    submitButton.removeAttribute("data-kt-indicator");

                    // Enable button
                    submitButton.disabled = false;
                    $.ajaxSetup({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                    });

                    var formData = new FormData(
                        $("#import-researchers-form")[0]
                    );

                    $.ajax({
                        type: "post",
                        enctype: "multipart/form-data",
                        url: $("#import-researchers-form").data("route-url"),
                        data: formData,
                        processData: false,
                        contentType: false,
                        cache: false,

                        success: function (response, textStatus, xhr) {
                            if (response["status"] == true) {
                                Swal.fire({
                                    text: response["msg"], // respose from controller
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "حسنا موافق",
                                    customClass: {
                                    confirmButton:
                                            "btn fw-bold btn-primary",
                                    },
                                    }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = $("#url").val();                                    
                                    }                                    
                                });
                            }
                        },

                        success: function (response, textStatus, xhr) {
                            if (response["status"] == true) {
                                Swal.fire({
                                    text: response["msg"], // respose from controller
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "حسنا موافق",
                                    customClass: {
                                        confirmButton:
                                            "btn fw-bold btn-primary",
                                    },
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = $("#url").val();                                    
                                    } 
                                });
                            }
                            if (response["status"] == false) {
                                Swal.fire({
                                    text: response["msg"]["key"], // respose from controller
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "حسنا موافق",
                                    customClass: {
                                        confirmButton:
                                            "btn fw-bold btn-primary",
                                    },
                                });

                                $("#invalid_id_numbers").html(
                                    response["msg"]["values"]
                                );
                            }

                            if (response["status"] == "duplicate") {
                                Swal.fire({
                                    text: response["msg"], // respose from controller
                                    icon: "info",
                                    buttonsStyling: false,
                                    confirmButtonText: "حسنا موافق",
                                    customClass: {
                                        confirmButton:
                                            "btn fw-bold btn-primary",
                                    },
                                });

                                $("#invalid_id_numbers").html(
                                    response["msg"]["values"]
                                );
                            }

                            if (response["status"] == "info") {
                                Swal.fire({
                                    text: response["msg"]["key"],
                                    icon: "info",
                                    buttonsStyling: false,
                                    confirmButtonText: "حسنا موافق",
                                    customClass: {
                                        confirmButton:
                                            "btn fw-bold btn-primary",
                                    },
                                });
                                $("#invalid_id_numbers").html(
                                    response["msg"]["values"]
                                );
                            }
                        },
                    });

                    // Go to next step
                }, 1500);
            } else {
                // Enable button
                submitButton.disabled = false;

                // Show popup warning. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                Swal.fire({
                    text: "عذراً ، يبدو أنه تم اكتشاف بعض الأخطاء في أستكمال ملف الباحثين ، يرجى المحاولة مرة أخرى.",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "حسنا موافق",
                    customClass: {
                        confirmButton: "btn btn-primary",
                    },
                });
            }
        });
    }
});
