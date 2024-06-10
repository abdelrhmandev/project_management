"use strict";

var $superior_id = $('#superior_id');
KTUtil.onDOMContentLoaded(function () {
    $("#auditor_training_date").flatpickr({
        minDate: "today",
        dateFormat: "Y-m-d",
        locale: 'ar',
        time_24hr: false
    });

    $(document).on("click", "#kt_edit_project_cancel", function() {
        window.location.href = projectBaseUrl+'/auditor/projects'; // make request
    });
});
