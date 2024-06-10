"use strict";

KTUtil.onDOMContentLoaded(function () {
    $("#inspector_visit_date").flatpickr({
        minDate: "today",
        dateFormat: "Y-m-d",
        locale: 'ar',
        time_24hr: false
    });
});
