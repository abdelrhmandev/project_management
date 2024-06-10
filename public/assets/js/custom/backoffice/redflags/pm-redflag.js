const redflagReplyText = $("[name=redflagReply]").val();
// Start FlagReply
$(".AddRedFlagReplyClass").on("click", function() {
    document.getElementById('redflag_title').innerHTML = $(this).attr('data-red-title');
    document.getElementById('redflag_id').value = $(this).attr('data-red-id');
    document.getElementById('client_id').value = $(this).attr('data-client-id');  
});

new Dropzone("#RedFlagAttachment", {
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
        $("input#saveRedFlagReply").click(function(e) {          
          e.preventDefault();                               
               if (RedFlagDropzone.getQueuedFiles().length > 0) {      
                  RedFlagDropzone.processQueue(); 
              } else {            
                  AjaxhandleWithOutFiles(redflagReplyText);
              }             
        });        
        this.on("sending", function(file, xhr, formData) {
            formData.append("redflagReply", $("[name=redflagReply]").val());
            formData.append("redflag_id", $("[name=redflag_id]").val());
            formData.append("project_id", $("[name=project_id]").val());
            formData.append("_token", $("#token").val());
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
 
function AjaxhandleWithOutFiles(){
      var r = $("[name=redflagReply]").val();
      if(r == null || r == '' || r.length === 0){                
      Swal.fire({
        text:  'برجاء كتابه الرد علي البلاغ', 
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

 
    $.post(redflag_reply_route, $("form#RedflagReply").serialize(), function(data) {  
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