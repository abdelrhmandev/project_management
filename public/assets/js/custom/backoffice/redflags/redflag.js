const redflagText = $("[name=redflag]").val();
new Dropzone("#add_red_flag_file", {
    url: redflagstoreRoute,
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
        $("input#saveRedFlagClientbtn").click(function(e) {       
          e.preventDefault();                               
          if (RedFlagDropzone.getQueuedFiles().length > 0) {      
                  RedFlagDropzone.processQueue(); 
              } else {            
                  AjaxhandleWithOutFilesC(redflagText);
              }
             
        });        
        this.on("sending", function(file, xhr, formData) {
            formData.append("redflag", $("[name=redflag]").val());
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
 
function AjaxhandleWithOutFilesC(){
      var r = $("[name=redflag]").val();
      if(r == null || r == '' || r.length === 0){                
      Swal.fire({
        text:  'برجاء كتابه عنوان البلاغ', 
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

 
    $.post(redflagstoreRoute, $("form#ClientRedflagForm").serialize(), function(data) {  
      $.ajax({
          success: function(response, textStatus, xhr) {       
              Swal.fire({                
                  text: 'تم إرسال البلاغ بنجاح', // respose from controller
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