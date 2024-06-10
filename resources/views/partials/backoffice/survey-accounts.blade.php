<!--begin::Survey Accounts-->
<div class="card mb-3 mb-xl-8">
    <form id="projectForm" data-action="{{route('project.form')}}">
        <input type="hidden" name="projectID" value="{{$row->id}}">
        <input type="hidden" name="accountType" value="survey">
        @csrf
        @method('PATCH')
        <!--begin::Card header-->
        <div class="card-header card-header-stretch pb-0">
            <!--begin::Title-->
            <div class="card-title">
                <h3 class="m-0">
                    تفاصيل الدخول إلى الإستمارة
                    @if(str_contains(URL::current(), '/followup/') == 1)
                    <label id="projectEditForm" class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-bs-toggle="tooltip" title="تعديل" style="display:inline-block;margin:5px 10px 0 0;" data-kt-initialized="1">
                        <i class="bi bi-pencil-fill fs-7"></i>
                    </label>
                    @endif
                </h3>
            </div>
            <!--end::Title-->
            <!--begin::Toolbar-->
            <div class="card-toolbar m-0">
                <!--begin::Tab nav-->
                <ul class="nav nav-stretch nav-line-tabs border-transparent" role="tablist">
                    <!--begin::Tab item-->
                    <li class="nav-item" role="presentation">
                        <a id="kt_admin_account_tab" class="nav-link fs-5 fw-bold me-5 active" data-bs-toggle="tab" role="tab" href="#kt_admin_account">حساب الإدارة</a>
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
            <div id="kt_admin_account" class="tab-pane fade show active" role="tabpanel">
                <!--begin::Row-->
                <div class="row gx-9 gy-6">
                    <div class="d-flex flex-wrap align-items-center">
                        <!--begin::Label-->
                        <div id="kt_signin_email">
                            <div class="fs-6 fw-bold mb-1">رابط البرنامج</div>
                            <input id="kt_admin_referral_link_input" type="text" class="form-control form-control-solid me-3 flex-grow-1 min-w-550px" name="URL" value="{{ $survey_accounts->url ?? ''}}" readonly />
                        </div>
                        <!--end::Label-->
                        <!--begin::Action-->
                        <div id="kt_signin_email_button" class="ms-auto">
                            <a href="#" id="kt_admin_link_copy_btn" class="btn btn-light btn-active-light-primary fw-bold flex-shrink-0" data-clipboard-target="#kt_admin_referral_link_input">نسخ رابط البرنامج</a>
                        </div>
                        <!--end::Action-->
                    </div>
                    <!--begin::Separator-->
                    <div class="separator separator-dashed my-4"></div>
                    <!--end::Separator-->
                    <!--begin::Email Address-->
                    <div class="d-flex flex-wrap align-items-center">
                        <!--begin::Label-->
                        <div id="kt_signin_email">
                            <div class="fs-6 fw-bold mb-1">البريد الإلكتروني</div>
                            <input id="kt_admin_referral_email_input" type="text" class="form-control form-control-solid me-3 flex-grow-1 min-w-550px" name="admin_email" value="{{ $survey_accounts->admin_email ?? ''}}" readonly />
                        </div>
                        <!--end::Label-->
                        <!--begin::Action-->
                        <div id="kt_signin_email_button" class="ms-auto">
                            <a href="#" id="kt_admin_email_copy_btn" class="btn btn-light btn-active-light-primary fw-bold flex-shrink-0" data-clipboard-target="#kt_admin_referral_email_input">نسخ البريد الإلكتروني</a>
                        </div>
                        <!--end::Action-->
                    </div>
                    <!--end::Email Address-->
                    <!--begin::Separator-->
                    <div class="separator separator-dashed my-4"></div>
                    <!--end::Separator-->
                    <!--begin::Password-->
                    <div class="d-flex flex-wrap align-items-center mb-10">
                        <!--begin::Label-->
                        <div id="kt_signin_password">
                            <div class="fs-6 fw-bold mb-1">كلمة المرور</div>
                            <input id="kt_admin_referral_password_input" type="text" class="form-control form-control-solid me-3 flex-grow-1 min-w-550px" name="admin_password" value="{{ $survey_accounts->admin_password ?? ''}}" readonly />
                        </div>
                        <!--end::Label-->
                        <!--begin::Action-->
                        <div id="kt_signin_password_button" class="ms-auto">
                            <a href="#" id="kt_admin_password_copy_btn" class="btn btn-light btn-active-light-primary fw-bold flex-shrink-0" data-clipboard-target="#kt_admin_referral_password_input">نسخ كلمة المرور</a>
                        </div>
                        <!--end::Action-->
                    </div>
                    <!--end::Password-->
                </div>
                <!--end::Row-->
            </div>
            <!--end::Tab panel-->
        </div>
        <!--end::Tab content-->
    </form>
    @if(str_contains(URL::current(), '/followup/') == 1)
    <button type="button" id="projectFormEdit" class="btn btn-primary me-2 hide" style="width:20%;">حفظ التغييرات</button>
    <button type="button" id="projectFormCancel" class="btn btn-light hide" style="width:20%;" onclick="window.location.reload(true);">إلغاء</button>
    @endif
</div>
<!--end::Survey Accounts-->