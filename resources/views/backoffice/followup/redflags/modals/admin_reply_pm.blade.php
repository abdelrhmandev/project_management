@if (auth()->user()->roles->first()->id == '1')
<div class="modal fade" id="modalWrapRedFlagReply" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-1000px">
        <div class="modal-content">
            <div class="modal-header mb-4">
                <h3><i class="bi bi-plus-square mx-4" style="color:#fff;font-size:1.3rem;"></i>رد المدير العام علي  البلاغ</h3>
            </div>
            <div class="modal-body scroll-y mx-xl-10 pb-15 mx-5">
                <form class="form" id="AdminedFlagReplyPM">                    
                    <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}" /> 
                    <input type="hidden" name="project_id" value="{{ $row->id }}">
                    <input type="hidden" name="redflag_id" id="redflag_id">
                    <input type="hidden" name="client_id" id="client_id">
                    
                    <div id="inputWrap" class="mb-12">
                        <div class="input">
                            <div class="alert alert-dismissible bg-light-success d-flex flex-column flex-sm-row mb-10 p-5">
                                <i class="ki-duotone ki-notification-bing fs-2hx text-success mb-sm-0 mb-5 me-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                <div class="d-flex flex-column pe-sm-10 pe-0">
                                    <h4 class="fw-semibold">عنوان البلاغ</h4>
                                    <div id="redflag_title"></div>
                                </div>
                            </div>
                            <div class="alert alert-dismissible bg-light-info d-flex flex-column flex-sm-row mb-10 p-5">
                                <i class="ki-duotone ki-notification-bing fs-2hx text-info mb-sm-0 mb-5 me-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                <div class="d-flex flex-column pe-sm-10 pe-0">
                                    <h4 class="fw-semibold">رد مدير المشروع</h4>
                                    <div id="project_manager_redflag_reply"></div>
                                </div>
                            </div>
                            <span id="sp_0"></span>
                            <div class="row mb-0">
                                <!--begin::Label-->
                                <div class="notice d-flex bg-light-warning border-warning mt-5 rounded border border-dashed p-6">
                                    <span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"></rect>
                                            <rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="currentColor"></rect>
                                            <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor"></rect>
                                        </svg>
                                    </span>
                                    <div class="d-flex flex-stack flex-grow-1">
                                        <h4 class="fw-semibold">برجاء تحديد هل سيتم قبول أو رفض البلاغ من قبل المدير العام</h4>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-7 mt-5 flex-wrap gap-5 text-gray-600">
                                    <!--begin::Radio-->
                                    <div class="form-check form-check-custom form-check-success form-check-solid">
                                        <input class="form-check-input" type="radio" name="type" value="accepted" id="type" checked="checked" onchange="manageAdminRejectRedFlag(false)" />
                                        <label class="form-check-label" for="all_conditions">مقبول</label>
                                    </div>
                                    <div class="form-check form-check-custom form-check-danger form-check-solid">
                                        <input class="form-check-input" type="radio" name="type" value="rejected" id="type" onchange="manageAdminRejectRedFlag(true)" />
                                        <label class="form-check-label" for="any_conditions">مرقوض</label>
                                    </div>
                                </div>
                            </div>
                            <div id="ReplyRedFlagDiv" class="d-none form-floating mt-5">
                                <textarea class="form-control" name="redflagReply" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>
                                <label for="floatingTextarea2">سبب رفض البلاغ</label>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="dropzone mt-10" id="add_red_flag_file">
                    <div class="dz-message needsclick">
                        <i class="bi bi-upload text-primary fs-2x"></i>
                        <div class="ms-4">
                            <h3 class="fs-5 fw-bold mb-1 text-gray-900"> مرفقات يرفعها المدير العام للرد علي البلاغ </h3>
                        </div>
                    </div>
                </div>  
                <div class="mt-5" style="border-top:1px solid #2a2a3f;padding-top:20px;">
                    <input type="button" id="cancelRedflagReply" class="canc btn" data-bs-dismiss="modal" style="float:left;background:#F60F37;color:#fff;margin:0 1px;" value="إلغاء">
                    <input type="button" id="saveAdminRedflagReplyPM" class="btn btn mx-4" value="إضافة" style="float:left;background: #004A61; color:white">
                </div>
            </div>
        </div>
    </div> 
</div>
@endif