"use strict";
function isNumberKey(evt, id) {
    try {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        if (charCode == 46) {
            var txt = document.getElementById(id).value;
            if (!(txt.indexOf(".") > -1)) {

                return true;
            }
        }
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    } catch (w) {
        alert(w);
    }
}
// On document ready
KTUtil.onDOMContentLoaded(function () {
    $(document).on("click", "#kt_cancel_equipment_type", function() {
        window.location.href = projectBaseUrl+'/admin/equipment-type'; // make request
    });

    $(document).on("click", "#kt_cancel_equipment", function() {
        window.location.href = projectBaseUrl+'/admin/equipments'; // make request
    });
    
    $(document).on("click", "#kt_cancel_customer", function() {
        window.location.href = projectBaseUrl+'/admin/customers'; // make request
    });

    $(document).on("click", "#kt_cancel_user", function() {
        window.location.href = projectBaseUrl+'/admin/users'; // make request
    });
});
