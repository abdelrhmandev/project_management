"use strict";

const button = document.querySelector("#kt_page_loading_overlay");
const loadingEl = document.createElement("div");
// Handle toggle click event
button.addEventListener("click", function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'POST',
        url: $('#FormId').data("route-url"),
        data: $('#FormId').serialize(),
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
            if (response['status'] == true) {
                $('.toast').removeClass('d-none');
                $('.toast').toast('show');
                KTApp.hidePageLoading();
                loadingEl.remove();
                window.location.href = $('#redirectUrl').data("redirect-url");
            }
        },
    });
});
