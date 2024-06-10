// Start Admin FlagReply
$(".AdminRedFlagReplyPMClass").on("click", function() {           
    document.getElementById('redflag_title').innerHTML = $(this).attr('data-redflag-title');
    document.getElementById('redflag_id').value = $(this).attr('data-redflag-id');
    document.getElementById('client_id').value = $(this).attr('data-client-id');
    document.getElementById('project_manager_redflag_reply').innerHTML = $(this).attr('data-project-manager-redflag-Reply');
});
function manageAdminRejectRedFlag(type) {
    if (type == true) {
        document.getElementById('ReplyRedFlagDiv').classList.remove("d-none");
        document.getElementById('add_red_flag_file').classList.remove("d-none");
    } else {
        document.getElementById('ReplyRedFlagDiv').classList.add("d-none");
        document.getElementById('add_red_flag_file').classList.add("d-none");
    }
}
//////////////////////Drop Zone For Admin //////////////////////
new Dropzone("#add_red_flag_file", {
    url: admin_redflag_reply_pm_route,
    method: "post",        
    paramName: "RedFlag_file",
    maxFiles: 10,
    maxFilesize: 10, // MB
    parallelUploads: 4,
    addRemoveLinks: true,
    uploadMultiple: true,
    autoProcessQueue: false,
    init: function() {
        var RedFlagDropzone = this;
        $("input#saveAdminRedflagReplyPM").click(function(e) {     
          e.preventDefault();                               
          if (RedFlagDropzone.getQueuedFiles().length > 0) {      
                  RedFlagDropzone.processQueue(); 
              } else {            
                  AjaxhandleWithOutFiles();
              }             
        });        
        this.on("sending", function(file, xhr, formData) {

            var redflagReply =  document.getElementById("AdminedFlagReplyPM").elements["redflagReply"].value;
            var redflag_id   =  document.getElementById("AdminedFlagReplyPM").elements["redflag_id"].value;
            var project_id   =  document.getElementById("AdminedFlagReplyPM").elements["project_id"].value;
            var token        =  document.getElementById("AdminedFlagReplyPM").elements["token"].value;
            var type         =  document.getElementById("AdminedFlagReplyPM").elements["type"].value;

            formData.append("redflagReply", redflagReply);
            formData.append("redflag_id", redflag_id);
            formData.append("project_id", project_id);            
            formData.append("_method", "POST"); 
            formData.append("type", type);
            formData.append("_token", token);

            
        });
    }, 
    success: function(file, response) {
        Swal.fire({
            text:  response.msg, // respose from controller
            icon: response.icon,
            buttonsStyling: false,
            confirmButtonText: "موافق",
            customClass: {
                confirmButton: "btn fw-bold btn-primary",
            }
        }).then(function() {          
              location.reload();           
        });
    }
});
 
function AjaxhandleWithOutFiles(){
      var r = $("[name=redflagReply]").val();      
      if($('#type').val() == 'rejected'){
            if(r == null || r == '' || r.length === 0){                
            Swal.fire({
                text:  'برجاء كتابه سبب رفض البلاغ', 
                icon: 'error',
                buttonsStyling: false,
                confirmButtonText: "موافق",
                customClass: {
                    confirmButton: "btn fw-bold btn-primary",
                }
            }).then(function() {          
                // location.reload();           
            });
        }
  }else{ 
    $.post(admin_redflag_reply_pm_route, $("form#AdminedFlagReplyPM").serialize(), function(data) {  
      $.ajax({
          success: function(response, textStatus, xhr) {       
              Swal.fire({                
                  text: 'تم إرسال الرد علي البلاغ بنجاح', // respose from controller
                  icon: 'success',
                  buttonsStyling: false,
                  confirmButtonText: "موافق",
                  customClass: {
                      confirmButton: "btn fw-bold btn-primary",
                  }
                }).then(function() {
                  // delete row data from server and re-draw datatable
                  dt.draw();
              });
              location.reload();          
          },
      });
  });  
  }
} 