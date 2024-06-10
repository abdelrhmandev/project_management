<!--begin::Modal - contact information-->
<div class="modal fade" id="kt_modal_contact_information" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-1000px">
        <div class="modal-content">
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header card-header-stretch pb-0">
                    <!--begin::Title-->
                    <div class="card-title">
                        <h3 class="m-0">معلومات التواصل</h3>
                    </div>
                    <!--end::Title-->
                    <!--begin::Toolbar-->
                    <div class="card-toolbar m-0">
                        <!--begin::Tab nav-->
                        <ul class="nav nav-stretch nav-line-tabs border-transparent" role="tablist">
                            <!--begin::Tab item-->
                            <li class="nav-item" role="presentation">
                                <a id="kt_contact_project_admin_tab" class="nav-link fs-5 fw-bold me-5 active" data-bs-toggle="tab" role="tab" href="#kt_contact_project_admin">معلومات مدير المشروع</a>
                            </li>
                            <!--end::Tab item-->
                            <!--begin::Tab item-->
                            <li class="nav-item" role="presentation">
                                <a id="kt_contact_customer_tab" class="nav-link fs-5 fw-bold" data-bs-toggle="tab" role="tab" href="#kt_contact_customer">معلومات مسؤول الجهة</a>
                            </li>
                            <!--end::Tab item-->
                        </ul>
                        <!--end::Tab nav-->
                    </div>
                    <!--end::Toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Tab content-->
                <div class="card-body tab-content">
                    <!--begin::Tab panel-->
                    <div id="kt_contact_project_admin" class="tab-pane fade show active" role="tabpanel">
                        <!--begin::Row-->
                        <div class="row gx-9 gy-6">
                            <!--begin::Basic info-->
                            <div class="card">
                                <!--begin::Content-->
                                <div id="kt_account_settings_profile_details" class="collapse show">
                                    <!--begin::Form-->
                                    <form id="kt_account_profile_details_form" class="form">
                                        <!--begin::Card body-->
                                        <div class="card-body p-9">
                                            <!--begin::Input group-->
                                            <div class="row mb-6">
                                                <!--begin::Label-->
                                                <label class="col-lg-4 col-form-label fw-semibold fs-6">الإسم الكامل للمسؤول</label>
                                                <!--end::Label-->
                                                <!--begin::Col-->
                                                <div class="col-lg-8">
                                                    <!--begin::Row-->
                                                    <div class="row">
                                                        <!--begin::Col-->
                                                        <div class="col-lg-12 fv-row">
                                                            <input type="text" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="First name" value="{{ $project_admin->name }}" />
                                                        </div>
                                                        <!--end::Col-->
                                                    </div>
                                                    <!--end::Row-->
                                                </div>
                                                <!--end::Col-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="row mb-6">
                                                <!--begin::Label-->
                                                <label class="col-lg-4 col-form-label fw-semibold fs-6">البريد الإلكتروني</label>
                                                <!--end::Label-->
                                                <!--begin::Col-->
                                                <div class="col-lg-8 fv-row">
                                                    <input type="email" name="website" class="form-control form-control-lg form-control-solid" placeholder="Company website" value="{{ $project_admin->email }}" />
                                                </div>
                                                <!--end::Col-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="row mb-6">
                                                <!--begin::Label-->
                                                <label class="col-lg-4 col-form-label fw-semibold fs-6">رقم الجوال</label>
                                                <!--end::Label-->
                                                <!--begin::Col-->
                                                <div class="col-lg-8 fv-row">
                                                    <input type="tel" name="phone" class="form-control form-control-lg form-control-solid" placeholder="Phone number" value="{{ $project_admin->mobile }}" />
                                                </div>
                                                <!--end::Col-->
                                            </div>
                                            <!--end::Input group-->
                                        </div>
                                        <!--end::Card body-->
                                        <!--begin::Actions-->
                                        <div class="card-footer d-flex justify-content-end px-9">
                                            <a href="{{ url('chats/'.$project_admin->id.'?Ref='.$project_admin->name) }}" class="btn btn me-2" style="background: #004A61; color:white">التواصل معه</a>
                                            <button type="reset" data-bs-dismiss="modal" class="btn btn me-2" style="background: #F60F37;color:white">إغلاق</button>
                                        </div>
                                        <!--end::Actions-->
                                    </form>
                                    <!--end::Form-->
                                </div>
                                <!--end::Content-->
                            </div>
                            <!--end::Basic info-->
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Tab panel-->
                    <!--begin::Tab panel-->
                    <div id="kt_contact_customer" class="tab-pane fade" role="tabpanel" aria-labelledby="kt_contact_customer_tab">
                        <!--begin::Row-->
                        <div class="row gx-9 gy-6">
                            <!--begin::Basic info-->
                            <div class="card">
                                <!--begin::Content-->
                                <div id="kt_account_settings_profile_details" class="collapse show">
                                    <!--begin::Form-->
                                    <form id="kt_account_profile_details_form" class="form">
                                        <!--begin::Card body-->
                                        <div class="card-body p-9">
                                            <!--begin::Input group-->
                                            <div class="row mb-6">
                                                <!--begin::Label-->
                                                <label class="col-lg-4 col-form-label fw-semibold fs-6">الإسم الكامل للمسؤول</label>
                                                <!--end::Label-->
                                                <!--begin::Col-->
                                                <div class="col-lg-8">
                                                    <!--begin::Row-->
                                                    <div class="row">
                                                        <!--begin::Col-->
                                                        <div class="col-lg-12 fv-row">
                                                            <input type="text" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="First name" value="{{ $row->customer->principal_name }}" />
                                                        </div>
                                                        <!--end::Col-->
                                                    </div>
                                                    <!--end::Row-->
                                                </div>
                                                <!--end::Col-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="row mb-6">
                                                <!--begin::Label-->
                                                <label class="col-lg-4 col-form-label fw-semibold fs-6">إسم الجهة التابع لها</label>
                                                <!--end::Label-->
                                                <!--begin::Col-->
                                                <div class="col-lg-8 fv-row">
                                                    <input type="text" name="company" class="form-control form-control-lg form-control-solid" placeholder="Company name" value="{{ $row->customer->title }}" />
                                                </div>
                                                <!--end::Col-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="row mb-6">
                                                <!--begin::Label-->
                                                <label class="col-lg-4 col-form-label fw-semibold fs-6">المنصب الذي يشغره</label>
                                                <!--end::Label-->
                                                <!--begin::Col-->
                                                <div class="col-lg-8 fv-row">
                                                    <input type="text" name="company" class="form-control form-control-lg form-control-solid" placeholder="Company name" value="{{ $row->customer->principal_position }}" />
                                                </div>
                                                <!--end::Col-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="row mb-6">
                                                <!--begin::Label-->
                                                <label class="col-lg-4 col-form-label fw-semibold fs-6">البريد الإلكتروني</label>
                                                <!--end::Label-->
                                                <!--begin::Col-->
                                                <div class="col-lg-8 fv-row">
                                                    <input type="email" name="website" class="form-control form-control-lg form-control-solid" placeholder="Company website" value="{{ $row->customer->principal_email }}" />
                                                </div>
                                                <!--end::Col-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="row mb-6">
                                                <!--begin::Label-->
                                                <label class="col-lg-4 col-form-label fw-semibold fs-6">رقم الجوال</label>
                                                <!--end::Label-->
                                                <!--begin::Col-->
                                                <div class="col-lg-8 fv-row">
                                                    <input type="tel" name="phone" class="form-control form-control-lg form-control-solid" placeholder="Phone number" value="{{ $row->customer->principal_mobile }}" />
                                                </div>
                                                <!--end::Col-->
                                            </div>
                                            <!--end::Input group-->
                                        </div>
                                        <!--end::Card body-->
                                        <!--begin::Actions-->
                                        <div class="card-footer d-flex justify-content-end px-9">
                                            <button type="reset" class="btn btn me-2" style="background: #004A61; color:white">التواصل معه</button>
                                            <button type="reset" data-bs-dismiss="modal" class="btn btn me-2" style="background: #F60F37;color:white">إغلاق</button>
                                        </div>
                                        <!--end::Actions-->
                                    </form>
                                    <!--end::Form-->
                                </div>
                                <!--end::Content-->
                            </div>
                            <!--end::Basic info-->
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Tab panel-->
                </div>
                <!--end::Tab content-->
            </div>
        </div>
    </div>
</div>
<!--end::Modals - contact information-->