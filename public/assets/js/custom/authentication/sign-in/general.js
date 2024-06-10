"use strict";
var KTSigninGeneral = (function () {
    var e, t, i;
    return {
        init: function () {
            (e = document.querySelector("#kt_sign_in_form")),
                (t = document.querySelector("#kt_sign_in_submit")),
                (i = FormValidation.formValidation(e, {
                    fields: {
                        email: { validators: { regexp: { regexp: /^[^\s@]+@[^\s@]+\.[^\s@]+$/, message: "البريد الألكتروني في صيغه غير صحيحه" }, notEmpty: { message: "البريد الألكتروني حقل مطلوب" } } },
                        password: { validators: { notEmpty: { message: "الرقم السري حقل مطلوب" } } },
                    },
                    plugins: { trigger: new FormValidation.plugins.Trigger(), bootstrap: new FormValidation.plugins.Bootstrap5({ rowSelector: ".fv-row", eleInvalidClass: "", eleValidClass: "" }) },
                })),
                t.addEventListener("click", function (n) {
                    n.preventDefault(),
                        i.validate().then(function (i) {
                            "Valid" == i ? (document.querySelector("#kt_sign_in_form").submit())                            
                            

                                  
                                : Swal.fire({
                                      text: "معذرة ، يبدو أنه تم اكتشاف بعض الأخطاء ، يرجى المحاولة مرة أخرى.",
                                      icon: "error",
                                      buttonsStyling: !1,
                                      confirmButtonText: "حسنا موافق",
                                      customClass: { confirmButton: "btn btn-primary" },
                                  });
                        });
                });
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTSigninGeneral.init();
});
