<div class="modal fade" id="modalWrapPMRedFlagReplyAdmin" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-1000px">
        <div class="modal-content">
            <div class="modal-header mb-4">
                <h3><i class="bi bi-plus-square mx-4" style="color:#fff;font-size:1.3rem;"></i>رد مدير المشروع علي البلاغ المرفوض من المدير العام</h3>
            </div>
            <div class="modal-body scroll-y mx-xl-10 pb-15 mx-5">
                <div class="alert alert-dismissible bg-light-success d-flex flex-column flex-sm-row mb-10 p-5">
                    <i class="ki-duotone ki-notification-bing fs-2hx text-success mb-sm-0 mb-5 me-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                    <div class="d-flex flex-column pe-sm-10 pe-0">
                        <h4 class="fw-semibold">عنوان البلاغ</h4>
                        <div id="redflag_title"></div>
                    </div>
                </div>
                <div class="alert alert-dismissible bg-light-danger d-flex flex-column flex-sm-row mb-10 p-5">
                    <i class="ki-duotone ki-notification-bing fs-2hx text-danger mb-sm-0 mb-5 me-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                    <div class="d-flex flex-column pe-sm-10 pe-0">
                        <h4 class="fw-semibold">سبب رفض البلاغ</h4>
                        <div id="redflag_reply"></div>
                    </div>
                </div>
                <form id="RedflagReplyPMTOADMIN">      
                    <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}" />                  
                    <input type="hidden" name="project_id" value="{{ $row->id }}"/>
                    <input type="hidden" name="redflag_id" id="redflag_id"/>
                    <input type="hidden" name="client_id" id="client_id"/>
                    <input type="hidden" name="type" id="type" value="replied"/>
                    <div class="form-floating">
                        <textarea class="form-control" name="redflagReply"  placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>
                        <label for="floatingTextarea2">رد مدير المشروع</label>
                    </div>                                       
                 </form>                 
                <div class="dropzone mt-5" id="RedFlagAttachment">
                    <div class="dz-message needsclick">
                        <i class="bi bi-upload text-primary fs-2x"></i>
                        <div class="ms-4">
                            <h3 class="fs-5 fw-bold mb-1 text-gray-900"> مرفقات يرفعها مدير المشروع للرد علي البلاغ </h3>
                        </div>
                    </div>
                </div>                                        
                <div class="mt-5" style="border-top:1px solid #2a2a3f;padding-top:20px;">
                    <input type="button" class="canc btn" data-bs-dismiss="modal" style="float:left;background:#F60F37;color:#fff;margin:0 10px;" value="إلغاء">
                    <input type="button" class="btn btn" id="saveRedFlagReply" style="float:left;background: #004A61; color:white" value="إضافة">
                 </div>
            </div>
        </div>
    </div>
</div>