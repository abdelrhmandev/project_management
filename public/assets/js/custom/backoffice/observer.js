"use strict";

$(document).on("change", "input.researcherBox", function () {
    let len = $("input.researcherBox:checked").length;
    $("div#reasercher-list span#nums").text(len);
});

$("span.excelFile").on("click", function () {
    $("input#imported_researchers").click();
});

$("input#imported_researchers").on("change", function () {
    $("span.excelFile").text($(this).val());
});

function fieldworks_disable_observer(id, observer) {
    var target_user = 'users-' + id;
    var target_city = 'city-' + id;
    if ($("#" + id).prop("checked")) {
        document.getElementById(target_user).disabled = false;
        document.getElementById(target_city).disabled = false;
    } else {
        document.getElementById(target_user).disabled = true;
        document.getElementById(target_city).disabled = true;
    }
}

$("input#observerFilterSuperVisor").on("input", function () {
    let $projectList = $('#supervisorlist');
    $.get($('#observerFilterUrl').val(), {
        "type": 'supervisor',
        "filter": $(this).val()
    }, function (data) {
        $projectList.html(data.views);
    });
});

$("input#observerFilterResearcher").on("input", function () {
    let $projectList = $('#researcherlist');
    $.get($('#observerFilterUrl').val(), {
        "superior_id": $('#filter_superior_id').val(),
        "type": 'researcher',
        "filter": $(this).val()
    }, function (data) {
        $projectList.html(data.views);
    });
});

$("#import_researcherDiv").addClass('d-none');
var $superior_id = $('#superior_id');
function reloadResearcher(id, project_id, is_correction) {
    document.getElementById('observerFilterResearcher').disabled = false;
    var $request = $.get(projectBaseUrl + '/observer/ajax/' + id + '/' + project_id + '/' + is_correction); // make request
    var $researcherlist = $('#researcherlist');
    $request.done(function (data) { // success
        $researcherlist.html(data.views);
        $superior_id.val(id);
        $("div#reasercher-list span#count").text(data.teamcount);
    });
    $request.always(function () {
        $researcherlist.removeClass('loading');
    });

    var $Importresearcherlist = $('#Importresearcherlist');
    $request.done(function (data) { // success
        $("#import_superior_id").val(id);
        $("#import_project_id").val(project_id);
        $("#import_researcherDiv").removeClass('d-none');
    });
    $request.always(function () {
        $Importresearcherlist.removeClass('loading');
    });
}

$("button#saveSupers").on("click", function (e) {
    e.preventDefault();
    Swal.fire({
        title: 'هل انت متاكد؟',
        icon: 'question',
        html: '',
        showCloseButton: true,
        showCancelButton: true,
        showConfirmButton: true,
        confirmButtonText: "نعم",
        cancelButtonText: "لا",
        confirmButtonColor: '#50cd89',
        cancelButtonColor: '#d33'
    }).then((result) => {
        if (result.isConfirmed) {
            $(this).parents().filter("form").trigger("submit");
        } else if (result.dismiss) {
            // nothing
        }
    });
});

$("button#updateKader").on("click", function (e) {
    e.preventDefault();
    var assignedSupervisors = parseInt($("input#numSupers").val()) - parseInt($("input#remainSupers").val());
    var assignedResearchers = parseInt($("input#numResearch").val()) - parseInt($("input#remainReasers").val());
    var a = parseInt($("input#totResearch").val());
    var b = parseInt($("input#numResearchers").val());

    Swal.fire({
        title: 'هل انت متاكد؟',
        icon: 'question',
        html: '',
        showCloseButton: true,
        showCancelButton: true,
        showConfirmButton: true,
        confirmButtonText: "نعم",
        cancelButtonText: "لا",
        confirmButtonColor: '#50cd89',
        cancelButtonColor: '#d33'
    }).then((result) => {
        if (result.isConfirmed) {
            if (parseInt($("input#totSupers").val()) < assignedSupervisors) {
                Swal.fire({
                    title: 'لايمكن تقليل عدد المشرفين عن ' + assignedSupervisors,
                    icon: 'error',
                    html: '',
                    showCloseButton: true,
                    showCancelButton: false,
                    showConfirmButton: true,
                    confirmButtonText: "موافق",
                    confirmButtonColor: '#50cd89'
                });
            } else if (parseInt($("input#totResearch").val()) < assignedResearchers) {
                Swal.fire({
                    title: 'لا يمكن تقليل عدد الباحثين عن ' + assignedResearchers,
                    icon: 'error',
                    html: '',
                    showCloseButton: true,
                    showCancelButton: false,
                    showConfirmButton: true,
                    confirmButtonText: "موافق",
                    confirmButtonColor: '#50cd89'
                });
            } else if (a < b) {
                Swal.fire({
                    title: 'لا يمكن تقليل عدد الباحثين عن ' + $("input#numResearchers").val(),
                    icon: 'error',
                    html: '',
                    showCloseButton: true,
                    showCancelButton: false,
                    showConfirmButton: true,
                    confirmButtonText: "موافق",
                    confirmButtonColor: '#50cd89'
                });
            } else {
                $(this).parents().filter("form").submit();
            }

        } else if (result.dismiss) {
            // nothing
        }
    });
});

function manageNeedTrainer(checkboxItem) {
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
    if (checkboxItem.checked) {
        document.getElementById('needTrainer').classList.remove("d-none");
        document.getElementById('trainindDate').classList.remove("d-none");
        $.post(projectBaseUrl + '/observer/is-trainers-needed/' + $('#project_id').val() + '/true'); // make request
    } else {
        document.getElementById('needTrainer').classList.add("d-none");
        document.getElementById('trainindDate').classList.add("d-none");
        $.post(projectBaseUrl + '/observer/is-trainers-needed/' + $('#project_id').val() + '/false'); // make request
    }
}

KTUtil.onDOMContentLoaded(function () {
    $("#observer_training_date").flatpickr({
        minDate: "today",
        dateFormat: "Y-m-d",
        locale: 'ar',
        time_24hr: false
    });

    var $project_id = $('#project_id');
    var loadingEl = document.createElement("div") ?? $("<div></div>");
    $(document).on("click", "#kt_save_researcher_list", function () {
        if ($("input[type=radio][name=team_user_id]").is(":checked")) {
            Swal.fire({
                title: 'هل انت متاكد؟',
                icon: 'question',
                html: '',
                showCloseButton: true,
                showCancelButton: true,
                showConfirmButton: true,
                confirmButtonText: "نعم",
                cancelButtonText: "لا",
                confirmButtonColor: '#50cd89',
                cancelButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
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
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var $postrequest = $.post(projectBaseUrl + '/observer/save-researcher-list', $(":input").serializeArray()); // make request
                    $postrequest.done(function (data) { // success
                        KTApp.hidePageLoading();
                        loadingEl.remove();
                        if (data.code == 401) {
                           // alert(data.MSG);
                           Swal.fire({
                            title: data.MSG ,
                            icon: 'error',
                            html: '',
                            showCloseButton: true,
                            showCancelButton: false,
                            showConfirmButton: true,
                            confirmButtonText: "إغلاق",
                            confirmButtonColor: '#f1416c'
                        });
                        } else {
                            window.location.href = projectBaseUrl + '/observer/get-researchers/' + $project_id.val(); // make request
                        }
                    });
                } else if (result.dismiss) {
                    // nothing
                }
            });
        } else {
           // alert("اختر احد المشرفين اولا");
            Swal.fire({
                title: 'اختر احد المشرفين اولا' ,
                icon: 'error',
                html: '',
                showCloseButton: true,
                showCancelButton: false,
                showConfirmButton: true,
                confirmButtonText: "إغلاق",
                confirmButtonColor: '#f1416c'
            });
        }
    });

    $(document).on("click", "#kt_save_correction_researcher_list", function () {
        if ($("input[type=radio][name=team_user_id]").is(":checked")) {
            Swal.fire({
                title: 'هل انت متاكد؟',
                icon: 'question',
                html: '',
                showCloseButton: true,
                showCancelButton: true,
                showConfirmButton: true,
                confirmButtonText: "نعم",
                cancelButtonText: "لا",
                confirmButtonColor: '#50cd89',
                cancelButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
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
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var $postrequest = $.post(projectBaseUrl + '/observer/save-researcher-list', $(":input").serializeArray()); // make request
                    $postrequest.done(function (data) { // success
                        KTApp.hidePageLoading();
                        loadingEl.remove();
                        if (data.code == 401) {
                           // alert(data.MSG);
                           Swal.fire({
                            title: data.MSG ,
                            icon: 'error',
                            html: '',
                            showCloseButton: true,
                            showCancelButton: false,
                            showConfirmButton: true,
                            confirmButtonText: "إغلاق",
                            confirmButtonColor: '#f1416c'
                        });
                        } else {
                            window.location.href = projectBaseUrl + '/observer/get-correction-researchers/' + $project_id.val(); // make request
                        }
                    });

                } else if (result.dismiss) {
                    // nothing
                }
            });

        } else {
           // alert("اختر احد المشرفين اولا");
           Swal.fire({
            title: 'اختر احد المشرفين اولا' ,
            icon: 'error',
            html: '',
            showCloseButton: true,
            showCancelButton: false,
            showConfirmButton: true,
            confirmButtonText: "إغلاق",
            confirmButtonColor: '#f1416c'
        });
        }
    });

    $(document).on("click", "#kt_cancel_researcher_list", function () {
        window.location.href = projectBaseUrl + '/observers/' + $project_id.val() + '/edit'; // make request
    });

    $(document).on("click", "#kt_cancel_approve_researcher", function () {
        window.location.href = projectBaseUrl + '/observer/projects'; // make request
    });

    $("#kt_edit_project_cancel").click(function () {
        window.location = projectBaseUrl + '/observer/projects';
    });

    $(document).on("click", "#kt_cancel_correction_researcher_list", function () {
        window.location.href = projectBaseUrl + '/observer/correction/' + $project_id.val(); // make request
    });
});
