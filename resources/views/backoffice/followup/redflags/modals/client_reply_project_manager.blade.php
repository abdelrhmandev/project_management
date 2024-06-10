<div class="modal fade" id="modalWrapClientFlagReplyPM" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-1000px">
        <div class="modal-content">
            <div class="modal-header mb-4">
                <h3><i class="bi bi-plus-square mx-4" style="color:#fff;font-size:1.3rem;"></i>رد مدير المشروع علي المدير العام بخصوص البلاغ المقدم </h3>
            </div>
            <div class="modal-body scroll-y mx-xl-10 pb-15 mx-5">
                <form class="form" id="addPMRedflagReplyAdmin">
                    @csrf
                    <input type="text" name="project" value="{{ $row->id }}">
                    <input type="text" name="redflag_id" id="pm_redflag_id">
                    
                    <div id="inputWrap" class="mb-12">
                        <div class="input">
                            <div class="alert alert-dismissible bg-light-danger d-flex flex-column flex-sm-row mb-10 p-5">
                                <i class="ki-duotone ki-notification-bing fs-2hx text-danger mb-sm-0 mb-5 me-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                <div class="d-flex flex-column pe-sm-10 pe-0">
                                    <h4 class="fw-semibold">عنوان البلاغ</h4>
                                    <div id="admin_redFtitle"></div>
                                </div>
                            </div>
                            <div class="alert alert-dismissible bg-light-success d-flex flex-column flex-sm-row mb-10 p-5">
                                <i class="ki-duotone ki-notification-bing fs-2hx text-success mb-sm-0 mb-5 me-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                <div class="d-flex flex-column pe-sm-10 pe-0">
                                    <h4 class="fw-semibold">رد مدير المشروع</h4>
                                    <div id="project_manager_redFReply"></div>
                                </div>
                            </div>
                            <span id="sp_0"></span>
                             
                            <div id="rejectRedFlagDiv" class="form-floating mt-5">
                                <textarea class="form-control" name="AdminRejectionReply" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>
                                <label for="floatingTextarea2">سبب رفض البلاغ</label>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="dropzone mt-10" id="pm_add_red_flag_file">
                    <div class="dz-message needsclick">
                        <i class="bi bi-upload text-primary fs-2x"></i>
                        <div class="ms-4">
                            <h3 class="fs-5 fw-bold mb-1 text-gray-900"> مرفقات يرفعها مدير المشروع </h3>
                        </div>
                    </div>
                </div>  
                
                <div class="mt-5">
                    <input type="button" id="saveAdminRedflagReply" class="btn btn-primary mx-4" value="إضافة">
                    <input type="button" id="cancelAdminRedflagReply" class="btn btn-secondary" data-bs-dismiss="modal" value="إلغاء">
                </div>
            </div>
        </div>
    </div>
</div>