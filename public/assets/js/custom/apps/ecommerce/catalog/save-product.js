"use strict";

// Class definition
var KTAppEcommerceSaveProduct = function () {

    // Init quill editor
    const initQuill = () => {
        // Define all elements for quill editor
        const elements = [
            '#kt_rejection_reason',
            '#kt_ecommerce_add_product_meta_description'
        ];

        // Loop all elements
        elements.forEach(element => {
            // Get quill element
            let quill = document.querySelector(element);

            // Break if element not found
            if (!quill) {
                return;
            }

            // Init quill --- more info: https://quilljs.com/docs/quickstart/
            quill = new Quill(element, {
                modules: {
                    toolbar: [
                        [{ 'align': [] }],
                        [{ 'font': [] }],
                        ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
                      
                        [{ 'header': 1 }, { 'header': 2 }, { 'header': [1, 2, 3, 4, 5, 6] }],               // custom button values
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
                        [{ 'direction': 'rtl' }],                         // text direction
                      
                        [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
                        [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
                        ['blockquote', 'code-block'],
                    ]
                },
                theme: 'snow' // or 'bubble'
            });
            quill.format('align', 'right');
        });
    }

    // Category status handler
    const handleStatus = () => {
        const target = document.getElementById('kt_project_status');
        const select = document.getElementById('kt_project_status_select');
        const statusClasses = ['bg-success', 'bg-warning', 'bg-danger'];

        $(select).on('change', function (e) {
            const value = e.target.value;

            switch (value) {
                case "approved": {
                    target.classList.remove(...statusClasses);
                    target.classList.add('bg-success');
                    hideCancelation();
                    showApproval();
                    hideDatepicker();
                    break;
                }
                case "pending": {
                    target.classList.remove(...statusClasses);
                    target.classList.add('bg-warning');
                    hideCancelation();
                    hideApproval();
                    showDatepicker();
                    break;
                }
                case "reject": {
                    target.classList.remove(...statusClasses);
                    target.classList.add('bg-danger');
                    showCancelation();
                    hideApproval();
                    hideDatepicker();
                    break;
                }
                default:
                    break;
            }
        });

        // Handle datepicker
        const datepicker = document.getElementById('kt_pending_date');

        // Init flatpickr --- more info: https://flatpickr.js.org/
        $('#kt_pending_date').flatpickr({
            minDate: "today",
            locale: 'ar',
            dateFormat: "Y-m-d",
        });

        const showDatepicker = () => {
            datepicker.parentNode.classList.remove('d-none');
        }

        const hideDatepicker = () => {
            datepicker.parentNode.classList.add('d-none');
        }

        // Handle approval
        const approve = document.getElementById('kt_project_approved');
        const showApproval = () => {
            approve.parentNode.classList.remove('d-none');
        }

        const hideApproval = () => {
            approve.parentNode.classList.add('d-none');
        }

        // Handle Cancelation
        const cancel = document.getElementById('kt_rejection_reason');
        const showCancelation = () => {
            cancel.parentNode.classList.remove('d-none');
        }

        const hideCancelation = () => {
            cancel.parentNode.classList.add('d-none');
        }
    }

    // Public methods
    return {
        init: function () {
            initQuill();
            handleStatus();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTAppEcommerceSaveProduct.init();
});
