// Start FlagReply
$(".PMRedFlagReplyClientClass").on("click", function() {


    document.getElementById('redflag_title_pm_reply_client').innerHTML = $(this).attr('data-redflag-title');    
    document.getElementById('redflag_id_pm_reply_client').value = $(this).attr('data-redflag-id');
    document.getElementById('client_id_pm_reply_client').value = $(this).attr('data-client-id');  

    document.getElementById('redflag_client_attachments').innerHTML = $(this).attr('data-redflag-attachments');    


});
new Dropzone("#RedFlagAttachmentpm_reply_client", {
    url: redflag_reply_route,
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
        $("input#PMRedFlagReplyClient").click(function(e) {     
          e.preventDefault();                               
               if (RedFlagDropzone.getQueuedFiles().length > 0) {      
                  RedFlagDropzone.processQueue(); 
              } else {            
                  AjaxhandleWithOutFilesX();
              }             
        });        
        this.on("sending", function(file, xhr, formData) {
            
           var redflagReply  =  document.getElementById("PMRedFlagReplyClient").elements["redflagReply"].value;
           var redflag_id    =  document.getElementById("PMRedFlagReplyClient").elements["redflag_id"].value;
           var project_id    =  document.getElementById("PMRedFlagReplyClient").elements["project_id"].value;
           var token         =  document.getElementById("PMRedFlagReplyClient").elements["token"].value;

     

            formData.append("redflagReply", redflagReply);
            formData.append("redflag_id", redflag_id);
            formData.append("project_id", project_id);
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
 
function AjaxhandleWithOutFilesX(){
      var r = document.getElementById("PMRedFlagReplyClient").elements["redflagReply"].value;      
      if(r == null || r == '' || r.length === 0){                
      Swal.fire({
        text:  'برجاء كتابه الرد علي البلاغ واضافة ملف المرفقات', 
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
    $.post(redflag_reply_route, $("form#PMRedFlagReplyClient").serialize(), function(data) {  
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