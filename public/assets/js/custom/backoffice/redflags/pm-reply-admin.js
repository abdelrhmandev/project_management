// Start FlagReply
$(".PMRedFlagReplyAdminClass").on("click", function() {

    document.getElementById('redflag_title').innerHTML = $(this).attr('data-redflag-title');    
    document.getElementById('redflag_reply').innerHTML = $(this).attr('data-redflag-reply');      
    document.getElementById('redflag_id').value = $(this).attr('data-redflag-id');
    document.getElementById('client_id').value = $(this).attr('data-client-id');  
});
new Dropzone("#RedFlagAttachment", {
    url: pm_redflag_reply_admin_route,
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
        $("input#saveRedFlagReply").click(function(e) {          
          e.preventDefault();                               
               if (RedFlagDropzone.getQueuedFiles().length > 0) {      
                  RedFlagDropzone.processQueue(); 
              } else {            
                AjaxhandleWithOutFilesB();
              }             
        });        
        this.on("sending", function(file, xhr, formData) {

            var redflagReply =  document.getElementById("RedflagReplyPMTOADMIN").elements["redflagReply"].value;
            var redflag_id   =  document.getElementById("RedflagReplyPMTOADMIN").elements["redflag_id"].value;
            var project_id   =  document.getElementById("RedflagReplyPMTOADMIN").elements["project_id"].value;
            var token        =  document.getElementById("RedflagReplyPMTOADMIN").elements["token"].value;
            var type         =  document.getElementById("RedflagReplyPMTOADMIN").elements["type"].value;

            formData.append("redflagReply", redflagReply);
            formData.append("redflag_id", redflag_id);
            formData.append("project_id", project_id);
            formData.append("type", type);
            formData.append("_token", token);
            formData.append("_method", "POST");
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
 
function AjaxhandleWithOutFilesB(){
    var r = document.getElementById("RedflagReplyPMTOADMIN").elements["redflagReply"].value;  
      if(r == null || r == '' || r.length === 0){                
      Swal.fire({
        text:  'برجاء كتابة الرد على البلاغ واضافة ملف المرفقات', 
        icon: 'error',
        buttonsStyling: false,
        confirmButtonText: "موافق",
        customClass: {
            confirmButton: "btn fw-bold btn-primary",
        }
    }).then(function() {          
          // location.reload();           
    });

  }else{ 
    $.post(pm_redflag_reply_admin_route, $("form#RedflagReplyPMTOADMIN").serialize(), function(data) {  
      $.ajax({
          success: function(response, textStatus, xhr) {  
            if (response["status"] == true) {  
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
            }else{
                Swal.fire({                
                    text: data.msg, // respose from controller
                    icon: data.icon,
                    buttonsStyling: false,
                    confirmButtonText: "موافق",
                    customClass: {
                        confirmButton: "btn fw-bold btn-primary",
                    }
                  }).then(function() {
                    // delete row data from server and re-draw datatable
                   // dt.draw();
                });  
            }        
          },
      });
  });  
  }

}