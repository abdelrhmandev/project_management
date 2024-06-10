<div class="modal fade" id="ClientmodalWrapRedFlag" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-1000px">
        <div class="modal-content">
            <div class="modal-header mb-4">
                <h3><i class="bi bi-plus-square mx-4" style="color:#fff;font-size:1.3rem;"></i> إضافة بلاغ جديد </h3>
            </div>
            <div class="modal-body scroll-y mx-xl-10 pb-15 mx-5">
                <form id="ClientRedflagForm">      
                    <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}" />                  
                    <input type="hidden" name="project_id" value="{{ $row->id }}"/>
                    <div class="form-floating">
                        <textarea class="form-control" name="redflag" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>
                        <label for="floatingTextarea2">عنوان البلاغ</label>
                    </div>                                       
                 </form>
                <div class="dropzone mt-5" id="add_red_flag_file">
                    <div class="dz-message needsclick">
                        <i class="bi bi-upload text-primary fs-2x"></i>
                        <div class="ms-4">
                            <h3 class="fs-5 fw-bold mb-1 text-gray-900"> مرفقات البلاغ </h3>
                        </div>
                    </div>
                </div>                        
                 <div class="mt-5" style="border-top:1px solid #2a2a3f;padding-top:20px;">
                    <input type="button" class="canc btn" style="float:left;background:#F60F37;color:#fff;margin:0 10px;" data-bs-dismiss="modal" value="إلغاء">
                    <input type="button" class="btn btn me-2" style="float:left;background: #004A61; color:white" id="saveRedFlagClientbtn" value="إضافة">
                 </div>
            </div>
        </div>
    </div>
</div> 