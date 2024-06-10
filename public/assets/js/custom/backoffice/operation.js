"use strict";

// $("#date_range").daterangepicker({ format: 'yyyy-mm-dd' });


KTUtil.onDOMContentLoaded(function () {
    $("#start_date").flatpickr({
        minDate: "today",
        dateFormat: "Y-m-d",
        locale: 'ar',
        time_24hr: false
    });
    //begin Handle Modal Close
    $("#kt_edit_project_cancel").click(function () {
        window.location = projectBaseUrl + '/operation/projects';
    });
    //end Handle Modal Close

    $("#kt_edit_quote_cancel").click(function () {
        window.location = projectBaseUrl + '/operation/estimate-quote';
    });

    var projectId = $("#project_id").val();
    var table = $("#kt_datatable_general_equipment").DataTable({
        pageLength: 10,
        paging: false,
        columnDefs: [{
            orderable: false,
            targets: [1, 2]
        }]
    });

    $("#kt_datatable_general_equipment_submit").click(function () {
        var disabled = table.$(':input:disabled').removeAttr('disabled');
        var data = table.$("input").serialize();
        disabled.attr('disabled', 'disabled');

        $.ajax({
            type: 'POST',
            url: projectBaseUrl + '/operation/create/' + projectId,
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                window.location = '/operation/' + projectId + '/edit';
            }
        });
        return false;
    });

    var tableTraining = $("#kt_datatable_training_equipment").DataTable({
        pageLength: 10,
        paging: false,
        columnDefs: [{
            orderable: false,
            targets: [1, 2]
        }]
    });

    $("#kt_datatable_training_equipment_submit").click(function () {
        var disabled = tableTraining.$(':input:disabled').removeAttr('disabled');
        var data = tableTraining.$("input").serialize();
        disabled.attr('disabled', 'disabled');

        $.ajax({
            type: 'POST',
            url: projectBaseUrl + '/operation/create/' + projectId,
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                window.location = projectBaseUrl + '/operation/' + projectId + '/edit';
            }
        });
        return false;
    });

    var tableOpening = $("#kt_datatable_opening_equipment").DataTable({
        pageLength: 10,
        paging: false,
        columnDefs: [{
            orderable: false,
            targets: [1, 2]
        }]
    });

    $("#kt_datatable_opening_equipment_submit").click(function () {
        var disabled = tableOpening.$(':input:disabled').removeAttr('disabled');
        var data = tableOpening.$("input").serialize();
        disabled.attr('disabled', 'disabled');

        $.ajax({
            type: 'POST',
            url: projectBaseUrl + '/operation/create/' + projectId,
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                window.location = projectBaseUrl + '/operation/' + projectId + '/edit';
            }
        });
        return false;
    });

    var tableAuditing = $("#kt_datatable_auditing_equipment").DataTable({
        pageLength: 10,
        paging: false,
        columnDefs: [{
            orderable: false,
            targets: [1, 2]
        }]
    });

    $("#kt_datatable_auditing_equipment_submit").click(function () {
        var disabled = tableAuditing.$(':input:disabled').removeAttr('disabled');
        var data = tableAuditing.$("input").serialize();
        disabled.attr('disabled', 'disabled');

        $.ajax({
            type: 'POST',
            url: projectBaseUrl + '/operation/create/' + projectId,
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                window.location = projectBaseUrl + '/operation/' + projectId + '/edit';
            }
        });
        return false;
    });

    $("#kt_datatable_team_rank_item").DataTable({
        pageLength: 10,
        paging: false,
        columnDefs: [{
            orderable: false,
            targets: [1, 2, 3]
        }]
    });

    $('#contract_term_repeater').repeater({
        initEmpty: false,
        defaultValues: {
            'text-input': 'foo'
        },

        show: function () {
            $(this).slideDown();
        },

        hide: function (deleteElement) {
            $(this).slideUp(deleteElement);
        }
    });


    $('#realestate_term_repeater').repeater({
        initEmpty: false,
        defaultValues: {
            'text-input': 'foo'
        },

        show: function () {
            $(this).slideDown();
            $(this).find('[data-kt-repeater="select2"]').select2();
        },

        hide: function (deleteElement) {
            $(this).slideUp(deleteElement);
        },

        ready: function () {
            // Init select2
            $('[data-kt-repeater="select2"]').select2();
        }
    });

    $(document).on("click", "#modal_team_rank_1", function () {
        var typeId = 1;
        var $request = $.get(projectBaseUrl + '/operation/team-item-list/' + projectId + '/' + typeId); // make request
        var $projectList = $('#teamItemList');
        $request.done(function (data) { // success
            $projectList.html(data.views);
        });
        $request.always(function () {
            $projectList.removeClass('loading');
        });

        $('#rank').html('المراقب');
        $('#type_id').val(typeId)
    });

    $(document).on("click", "#modal_team_rank_2", function () {
        var typeId = 2;
        var $request = $.get(projectBaseUrl + '/operation/team-item-list/' + projectId + '/' + typeId); // make request
        var $projectList = $('#teamItemList');
        $request.done(function (data) { // success
            $projectList.html(data.views);
        });
        $request.always(function () {
            $projectList.removeClass('loading');
        });

        $('#rank').html('مراقب التدقيق');
        $('#type_id').val(typeId);
    });

    $(document).on("click", "#modal_team_rank_3", function () {
        var typeId = 3;
        var $request = $.get(projectBaseUrl + '/operation/team-item-list/' + projectId + '/' + typeId); // make request
        var $projectList = $('#teamItemList');
        $request.done(function (data) { // success
            $projectList.html(data.views);
        });
        $request.always(function () {
            $projectList.removeClass('loading');
        });

        $('#rank').html('المدقق');
        $('#type_id').val(typeId);
    });

    $(document).on("click", "#modal_team_rank_4", function () {
        var typeId = 4;
        var $request = $.get(projectBaseUrl + '/operation/team-item-list/' + projectId + '/' + typeId); // make request
        var $projectList = $('#teamItemList');
        $request.done(function (data) { // success
            $projectList.html(data.views);
        });
        $request.always(function () {
            $projectList.removeClass('loading');
        });

        $('#rank').html('المشرف');
        $('#type_id').val(typeId);
    });

    $(document).on("click", "#modal_team_rank_5", function () {
        var typeId = 5;
        var $request = $.get(projectBaseUrl + '/operation/team-item-list/' + projectId + '/' + typeId); // make request
        var $projectList = $('#teamItemList');
        $request.done(function (data) { // success
            $projectList.html(data.views);
        });
        $request.always(function () {
            $projectList.removeClass('loading');
        });

        $('#rank').html('الباحث');
        $('#type_id').val(typeId);
    });

    $(document).on("click", "#modal_team_rank_6", function () {
        var typeId = 6;
        var $request = $.get(projectBaseUrl + '/operation/team-item-list/' + projectId + '/' + typeId); // make request
        var $projectList = $('#teamItemList');
        $request.done(function (data) { // success
            $projectList.html(data.views);
        });
        $request.always(function () {
            $projectList.removeClass('loading');
        });

        $('#rank').html('فاحص');
        $('#type_id').val(typeId);
    });

    $(document).on("click", "#modal_team_rank_7", function () {
        var typeId = 7;
        var $request = $.get(projectBaseUrl + '/operation/team-item-list/' + projectId + '/' + typeId); // make request
        var $projectList = $('#teamItemList');
        $request.done(function (data) { // success
            $projectList.html(data.views);
        });
        $request.always(function () {
            $projectList.removeClass('loading');
        });

        $('#rank').html('المدرب');
        $('#type_id').val(typeId);
    });
});

// Define form element
const form_financial = document.getElementById('financial-bid-estimates');
// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
var bidValidator = FormValidation.formValidation(form_financial, {
    fields: {
        'writing_report_cost': {
            validators: {
                notEmpty: {
                    message: 'برجاء إدخال قيمه تكلفة كتابة التقارير '
                }
            }
        },
        'date_range': {
            validators: {
                notEmpty: {
                    message: 'برجاء إدخال تاريخ بدأ الموعد '
                }
            }
        },
        'beneficiary_preparation_pricing': {
            validators: {
                notEmpty: {
                    message: 'برجاء إدخال قيمه تسعيرة تهيئة المستفدين '
                }
            }
        },
    },

    plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap: new FormValidation.plugins.Bootstrap5({
            rowSelector: '.fv-row',
            eleInvalidClass: '',
            eleValidClass: ''
        })
    }
}
);

// Submit button handler
const submitBidButton = document.getElementById('kt_docs_form_validation_text_submit');
submitBidButton.addEventListener('click', function (e) {
    // Prevent default button action
    e.preventDefault();

    // Validate form before submit
    if (bidValidator) {
        bidValidator.validate().then(function (status) {
            console.log('validated!');

            if (status == 'Valid') {
                // Show loading indication
                submitBidButton.setAttribute('data-kt-indicator', 'on');

                // Disable button to avoid multiple click
                submitBidButton.disabled = true;

                // Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                setTimeout(function () {
                    // Remove loading indication
                    submitBidButton.removeAttribute('data-kt-indicator');

                    // Enable button
                    submitBidButton.disabled = false;

                    // Show popup confirmation
                    form_financial.submit();

                    //form_financial.submit(); // Submit form
                }, 2000);
            }
        });
    }
});

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

function disable_option(equipment_id, equipment_type, typecase) {
    var target_equipment_qty = typecase + '-equipment-qty-' + equipment_type + '-' + equipment_id;
    var target_equipment_price = typecase + '-equipment-price-' + equipment_type + '-' + equipment_id;
    if ($("#" + equipment_id).prop("checked")) {
        document.getElementById(target_equipment_qty).disabled = false;
        document.getElementById(target_equipment_price).disabled = false;
    } else {
        document.getElementById(target_equipment_qty).disabled = true;
        document.getElementById(target_equipment_price).disabled = true;
    }
}

function manageExplorVisit(checkboxItem) {
    if (checkboxItem.checked) {
        document.getElementById('explorVisit').classList.add("d-none");
        document.getElementById('explorVisit-btn').classList.remove("d-none");
    } else {
        document.getElementById('explorVisit').classList.remove("d-none");
        document.getElementById('explorVisit-btn').classList.add("d-none");
    }
}
