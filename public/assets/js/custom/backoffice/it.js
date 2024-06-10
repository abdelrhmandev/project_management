"use strict";

// On document ready
KTUtil.onDOMContentLoaded(function () {
    //begin Handle Modal Close
    $("#kt_edit_project_cancel").click(function () {
        window.location = projectBaseUrl+'/it/projects';
    });
    //end Handle Modal Close

    $("#kt_datatable_opening_equipment_submit").click(function () {
        var disabled = tableOpening.$(':input:disabled').removeAttr('disabled');
        var data = tableOpening.$("input").serialize();
        disabled.attr('disabled', 'disabled');

        $.ajax({
            type: 'POST',
            url: projectBaseUrl+'/operation/create/' + projectId,
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                window.location = projectBaseUrl+'/operation/' + projectId + '/edit';
            }
        });
        return false;
    });

    $(document).on("click", "#kt_modal_new_card_admin", function () {
        $('#email').val($('#admin_email').val());
        $('#password').val($('#admin_password').val());
        $('#dept_id').text('حساب الإدارة في كاشف');
        $('#type_id').val('admin');
    });

    $(document).on("click", "#kt_modal_new_card_report", function () {
        $('#email').val($('#report_email').val());
        $('#password').val($('#report_password').val());
        $('#dept_id').text('حساب إستعراض التقارير في كاشف');
        $('#type_id').val('report');
    });

    $(document).on("click", "#kt_modal_new_card_studies", function () {
        $('#email').val($('#studies_email').val());
        $('#password').val($('#studies_password').val());
        $('#dept_id').text('حساب الدراسات في كاشف');
        $('#type_id').val('studies');
    });

    $(document).on("click", "#kt_modal_url_card_url", function () {
        $('#dept_url').text('رابط برنامج كاشف');
        $('#type_url').val('url');
    });
});
