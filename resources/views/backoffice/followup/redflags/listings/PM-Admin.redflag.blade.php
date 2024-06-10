              <!-- Project Manager Reply To Admin -->
              <div class="modal fade" id="modalWrapPMRedFlagReplyAdmin" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered mw-1000px">
                    <div class="modal-content">
                        <div class="modal-header mb-4">
                            <h3><i class="bi bi-plus-square mx-4" style="color:#fff;font-size:1.3rem;"></i>الرد علي البqqqqqqلاغ</h3>
                        </div>
                        <div class="modal-body scroll-y mx-xl-10 pb-15 mx-5">
                            <form id="addPMRedflagReplyAdmin" enctype="multipart/form-data">
                                @csrf
                                <input type="text" name="project" value="{{ $row->id }}">
                                <input type="text" name="redflag_id" id="redflag_id">
                                <input type="text" name="client_id" id="client_id">
                                <div id="inputWrap" class="mb-12">
                                    <div class="input">
                                        
                                        الرد
                                       
                                        <textarea class="form-control" name="_redflag_reply[]" placeholder="الرد"></textarea>
                                        <div class="fv-row mb-8 mt-5">
                                            <label class="fs-6 fw-semibold mb-2">ملف الرد علي البلاغ ان وجد</label>
                                            <input type="file" accept=".pdf" class="form-control form-control-solid" placeholder=" الملف .." name="replyFile" />
                                        </div>                
                                    </div>
                                </div>
                                <input type="button" id="saveRedflagReply" class="btn btn-primary mx-4" value="إضافة">
                                <input type="button" id="cancelRedflagReply" class="btn btn-secondary" data-bs-dismiss="modal" value="إلغاء">
                            </form>
                        </div>
                    </div>
                </div>
            </div>

          
 