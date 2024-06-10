"use strict";

// Drop Zoon
// On document ready
KTUtil.onDOMContentLoaded(function () {
  var $project_id = $('#project_id');
  $(document).on("click", "#kt_save_general_equipment", function (e) {
    e.preventDefault();
    var $researcherlist = $('#researcherlist');
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': '{{csrf_token()}}' } });
    var $postrequest = $.post(projectBaseUrl + '/equipment/save-ship-receipt', $(":input").serializeArray()); // make request
    $postrequest.done(function (data) { // success
      window.location.href = projectBaseUrl + '/equipments/' + $project_id.val() + '/edit'; // make request
    });
  });

  $(document).on("click", "#kt_save_general_equipment_handover", function (e) {
    e.preventDefault();
    var $researcherlist = $('#researcherlist');
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': '{{csrf_token()}}' } });
    var $postrequest = $.post(projectBaseUrl + '/equipment/save-ship-receipt/handover', $(":input").serializeArray()); // make request
    $postrequest.done(function (data) { // success
      window.location.href = projectBaseUrl + '/observer/handover/' + $project_id.val(); // make request
    });
  });

  $(document).on("click", "#kt_cancel_equipment", function () {
    window.location.href = projectBaseUrl + '/equipment/projects'; // make request
  });

  $(document).on("click", "#kt_cancel_equipment_handover", function () {
    window.location.href = projectBaseUrl + '/observer/handover/projects'; // make request
  });

  $("a.Div").on("click", function () {
    $("form#divForm input[name=eqType]").val($(this).data("type"));
    $("form#divForm input[name=eqID]").val($(this).data("item"));
    $("form#divForm h5[name=remain]").html($(this).data("remain"));
    $("form#divForm input[name=eqQty]").val($(this).data("qty"));
    $("form#divForm input[name=status]").val("");
    $("div#kt_div_eq_files div.wrapperdz").html("");
    $("form#divForm span").html("");
    $("form#divForm select[name=observer]").val('-1');
    $("form#divForm input[name=amount]").val("");
    $("form#divForm textarea[name=notes]").val("");
  });

  $("a.DivEdit").on("click", function () {
    $("form#divForm input[name=eqType]").val($(this).data("type"));
    $("form#divForm input[name=eqID]").val($(this).data("item"));
    $("form#divForm input[name=eqQty]").val($(this).data("qty"));
    $("form#divForm input[name=status]").val($(this).data("status"));
    $("form#divForm span").html("");
    $.get(LINK, { "P": $(this).data("project"), "O": $(this).data("observer"), "E": $(this).data("item") }, function (data) {
      $("div#kt_div_eq_files div.wrapperdz").html(data.out);
      $("form#divForm select[name=observer]").val(data.obs);
      $("form#divForm input[name=amount]").val(data.qty);
      $("form#divForm textarea[name=notes]").val(data.note);
    });
  });

  /*$("button#divSend").on("click",function(){
      $("form#divForm span").html("");
      $.post($("form#divForm").data("action"),$("form#divForm").serialize(),function(data){
        if(data.code == 400) {
          $("form#divForm span.observer").html(data.err.observer);
          $("form#divForm span.amount").html(data.err.amount);
          $("form#divForm span.notes").html(data.err.notes);
        }else{
          $("form#divForm span.success").html(data.MSG);
          setTimeout(()=>{
            window.location.reload();
          },1500);
        }
      });
  });*/
});
