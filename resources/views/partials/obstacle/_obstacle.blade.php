<div class="modal fade" id="kt_modal_project_obstacles" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered mw-1000px">
                <div class="modal-content">
                    <form class="form" action="{{ url('saveObstacle/projects') }}" novalidate="novalidate" method="post">
                        @csrf
                        <input type="hidden" name="project_id" id="project_id" value="{{ $row->id }}" />
                        <div class="modal-header">
                            <h3 class="modal-title">نموذج رفع بلاغ</h3>
                            <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                <span class="svg-icon svg-icon-1">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                        <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                        <div class="modal-body scroll-y mx-xl-18 pb-15 mx-5">
                            <div data-kt-search-element="results">
                                <div class="mh-375px scroll-y me-n7 pe-7">
                                    <div class="row">
                                        <label class="col-lg col-form-label fw-semibold fs-6">عنوان البلاغ</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control w-540px mb-2" name="title" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-lg col-form-label fw-semibold fs-6">التصنيف</label>
                                        <div class="col-lg-8">
                                            <select name="type_id" aria-label="إختر التصنيف" data-control="select2" data-placeholder="التصنيف" class="form-select form-control form-control-lg form-control-solid">
                                                <option value="1">مشكلة</option>
                                                <option value="2">مقترح</option>
                                                <option value="3">إستفسار</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <label class="col-lg col-form-label fw-semibold fs-6">الرجاء تحديد من سيقوم
                                            بحلها</label>
                                        <div class="col-lg-8">
                                            <select name="user_id" aria-label="إختر العميل" data-control="select2" data-placeholder="العميل" class="form-select form-control form-control-lg form-control-solid">
                                                <option value="all">كل الإدارات</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->user->id }}">{{ $user->user->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column mt-5">
                                        <label class="fs-6 fw-semibold mb-2">الرجاء كتابة وصف عن سبب رفع الطلب</label>
                                        <textarea class="form-control form-control-solid" rows="4" name="message" placeholder="" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                            <button type="submit" class="btn btn-primary">إرسال الطلب</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--end::Modals-->