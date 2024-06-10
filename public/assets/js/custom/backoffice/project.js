KTUtil.onDOMContentLoaded(function () {
    $("#opening_date").flatpickr({
        minDate: "today",
        dateFormat: "Y-m-d",
        locale: 'ar',
        time_24hr: false
    });

    $("#closing_date").flatpickr({
        minDate: "today",
        dateFormat: "Y-m-d",
        locale: 'ar',
        time_24hr: false
    });

    var projectId = $("#project_id").val();
    Inputmask("decimal", {
        "rightAlignNumerics": false
    }).mask("#kt_inputnumber");

    Inputmask({
        "mask": "999-999-9999"
    }).mask("#kt_inputphone");

    Inputmask({
        mask: "*{1,20}[.*{1,20}][.*{1,20}][.*{1,20}]@*{1,20}[.*{2,6}][.*{1,2}]",
        greedy: false,
        onBeforePaste: function (pastedValue, opts) {
            pastedValue = pastedValue.toLowerCase();
            return pastedValue.replace("mailto:", "");
        },
        definitions: {
            "*": {
                validator: '[0-9A-Za-z!#$%&"*+/=?^_`{|}~\-]',
                cardinality: 1,
                casing: "lower"
            }
        }
    }).mask("#kt_inputemail");

    $(document).on("click", "#modal_team_rank_1", function () {
        var typeId = 1;
        var $request = $.get(projectBaseUrl+'/project/team-item-list/'+projectId+'/'+typeId); // make request
        var $projectList = $('#teamItemList');
        $request.done(function (data) { // success
            $projectList.html(data.views);
        });
        $request.always(function () {
            $projectList.removeClass('loading');
        });

        $('#rank').html('المراقب');
    });

    $(document).on("click", "#modal_team_rank_2", function () {
        var typeId = 2;
        var $request = $.get(projectBaseUrl+'/project/team-item-list/'+projectId+'/'+typeId); // make request
        var $projectList = $('#teamItemList');
        $request.done(function (data) { // success
            $projectList.html(data.views);
        });
        $request.always(function () {
            $projectList.removeClass('loading');
        });

        $('#rank').html('مراقب التدقيق');
    });

    $(document).on("click", "#modal_team_rank_3", function () {
        var typeId = 3;
        var $request = $.get(projectBaseUrl+'/project/team-item-list/'+projectId+'/'+typeId); // make request
        var $projectList = $('#teamItemList');
        $request.done(function (data) { // success
            $projectList.html(data.views);
        });
        $request.always(function () {
            $projectList.removeClass('loading');
        });

        $('#rank').html('المدقق');
    });

    $(document).on("click", "#modal_team_rank_4", function () {
        var typeId = 4;
        var $request = $.get(projectBaseUrl+'/project/team-item-list/'+projectId+'/'+typeId); // make request
        var $projectList = $('#teamItemList');
        $request.done(function (data) { // success
            $projectList.html(data.views);
        });
        $request.always(function () {
            $projectList.removeClass('loading');
        });

        $('#rank').html('المشرف');
    });

    $(document).on("click", "#modal_team_rank_5", function () {
        var typeId = 5;
        var $request = $.get(projectBaseUrl+'/project/team-item-list/'+projectId+'/'+typeId); // make request
        var $projectList = $('#teamItemList');
        $request.done(function (data) { // success
            $projectList.html(data.views);
        });
        $request.always(function () {
            $projectList.removeClass('loading');
        });

        $('#rank').html('الباحث');
    });

    $(document).on("click", "#modal_team_rank_6", function () {
        var typeId = 6;
        var $request = $.get(projectBaseUrl+'/operation/team-item-list/' + projectId + '/' + typeId); // make request
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
        var $request = $.get(projectBaseUrl+'/operation/team-item-list/' + projectId + '/' + typeId); // make request
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

    $("button#projectDetailCancel").on("click", function() {
        window.location.reload(true);
    });
});

const form = document.getElementById('kt_modal_create_project_form');
const submitButton = document.getElementById('save-project');
submitButton.addEventListener('click', function (e) {
    // Prevent default button action
    e.preventDefault();

    submitButton.setAttribute('data-kt-indicator', 'on');

    // Disable button to avoid multiple click
    submitButton.disabled = true;

    // Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
    setTimeout(function () {
        // Remove loading indication
        submitButton.removeAttribute('data-kt-indicator');
        // Enable button
        submitButton.disabled = false;
        form.submit(); // Submit form
    }, 2000);

});

function manageOpening(checkboxItem) {
    if (checkboxItem.checked) {
        document.getElementById('opening_div').classList.remove("d-none");
    } else {
        document.getElementById('opening_div').classList.add("d-none");
    }
}

function manageClosing(checkboxItem) {
    if (checkboxItem.checked) {
        document.getElementById('closing_div').classList.remove("d-none");
    } else {
        document.getElementById('closing_div').classList.add("d-none");
    }
}
