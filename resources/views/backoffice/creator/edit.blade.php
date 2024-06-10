@extends('layouts.app')

@section('content')
    <div id="kt_content_container" class="container-xxl">
        <!--begin::Layout-->
        <div class="d-flex flex-column flex-xl-row">
            <!--begin::Sidebar-->
            @include('partials.backoffice.sidebar-project')
            <!--end::Sidebar-->

            <!--begin::Content-->
            <div class="flex-lg-row-fluid ms-lg-15">
                <div class="tab-content" id="myTabContent">
                    <form class="form" action="{{ url('creator/hand-offer-task') }}" enctype="multipart/form-data" novalidate="novalidate" method="post">
                        @csrf
                        <input type="hidden" name="project_id" id="project_id" value="{{ $row->id }}" />
                        <!--begin:::Tab pane-->
                        <div class="tab-pane fade show active">
                            <!--begin::Card-->
                            <div class="card mb-xl-9 mb-6 pt-4">
                                <!--begin::Card header-->
                                <div class="card-header border-0">
                                    <!--begin::Card title-->
                                    <div class="card-title">
                                        <h2 class="fw-bold mb-0">معلومات الإستمارة وحساب الدخول إلى البرنامج</h2>
                                    </div>
                                    <!--end::Card title-->
                                </div>
                                <!--end::Card header-->
                                <!--begin::Card body-->
                                <div id="kt_customer_view_payment_method" class="card-body pt-0">
                                    <!--begin::Option-->
                                    <div class="py-0" data-kt-customer-payment-method="row">
                                        <!--begin::Header-->
                                        <div class="d-flex flex-stack flex-wrap py-3">
                                            <!--begin::Toggle-->
                                            <div class="d-flex align-items-center collapsible rotate" data-bs-toggle="collapse" href="#kt_customer_view_payment_method_1" role="button" aria-expanded="false" aria-controls="kt_customer_view_payment_method_1">
                                                <!--begin::Arrow-->
                                                <div class="me-3 rotate-90">
                                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
                                                    <span class="svg-icon svg-icon-3">
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z" fill="currentColor" />
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                </div>
                                                <!--end::Arrow-->
                                                <!--begin::Logo-->
                                                <img src="assets/media/svg/card-logos/mastercard.svg" class="w-40px me-3" alt="" />
                                                <!--end::Logo-->
                                                <!--begin::Summary-->
                                                <div class="me-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="fw-bold text-gray-800">حساب الإدارة</div>
                                                        @if ($survey_accounts == '' || $survey_accounts->admin_email == '')
                                                            <div class="badge badge-light-danger ms-5">لم يتم إنشائه بعد</div>
                                                            <td class="text-gray-800">
                                                                <span class="svg-icon svg-icon-2 svg-icon-danger">
                                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                                                        <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                                                                    </svg>
                                                                </span>
                                                            </td>
                                                        @else
                                                            <div class="badge badge-light-success ms-5">تم إنشائه</div>
                                                            <td class="text-gray-800">
                                                                <span class="svg-icon svg-icon-2 svg-icon-success">
                                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor" />
                                                                        <path d="M10.4343 12.4343L8.75 10.75C8.33579 10.3358 7.66421 10.3358 7.25 10.75C6.83579 11.1642 6.83579 11.8358 7.25 12.25L10.2929 15.2929C10.6834 15.6834 11.3166 15.6834 11.7071 15.2929L17.25 9.75C17.6642 9.33579 17.6642 8.66421 17.25 8.25C16.8358 7.83579 16.1642 7.83579 15.75 8.25L11.5657 12.4343C11.2533 12.7467 10.7467 12.7467 10.4343 12.4343Z" fill="currentColor" />
                                                                    </svg>
                                                                </span>
                                                            </td>
                                                        @endif
                                                    </div>
                                                </div>
                                                <!--end::Summary-->
                                            </div>
                                            <!--end::Toggle-->
                                            <!--begin::Toolbar-->
                                            <div class="d-flex ms-9 my-3">
                                                <!--begin::Edit-->
                                                <a href="#" id="kt_modal_new_card_admin" class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_new_card">
                                                    <span data-bs-toggle="tooltip" data-bs-trigger="hover" title="Edit">
                                                        <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                                        <span class="svg-icon svg-icon-3">
                                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path opacity="0.3"
                                                                    d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z"
                                                                    fill="currentColor" />
                                                                <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor" />
                                                            </svg>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </a>
                                                <!--end::More-->
                                            </div>
                                            <!--end::Toolbar-->
                                        </div>
                                        <!--end::Header-->
                                        <!--begin::Body-->
                                        <div id="kt_customer_view_payment_method_1" class="show fs-6 ps-10 collapse" data-bs-parent="#kt_customer_view_payment_method">
                                            <!--begin::Details-->
                                            <div class="d-flex flex-wrap py-5">
                                                <!--begin::Col-->
                                                <div class="flex-equal me-5">
                                                    <table class="table-flush fw-semibold gy-1 table">
                                                        <tr>
                                                            <td class="text-muted min-w-125px w-125px">البريد الإلكتروني</td>
                                                            <td class="text-gray-800">{{ $survey_accounts->admin_email ?? '' }}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <!--end::Col-->
                                                <!--begin::Col-->
                                                <div class="flex-equal">
                                                    <table class="table-flush fw-semibold gy-1 table">
                                                        <tr>
                                                            <td class="text-muted min-w-125px w-125px">كلمةالمرور</td>
                                                            <td class="text-gray-800">
                                                                <a href="#" class="text-hover-primary text-gray-900">{{ $survey_accounts->admin_password ?? '' }}</a>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <!--end::Col-->
                                            </div>
                                            <!--end::Details-->
                                        </div>
                                        <!--end::Body-->
                                    </div>
                                    <!--end::Option-->
                                    <div class="separator separator-dashed"></div>
                                    <!--begin::Option-->
                                    <div class="py-0" data-kt-customer-payment-method="row">
                                        <!--begin::Header-->
                                        <div class="d-flex flex-stack flex-wrap py-3">
                                            <!--begin::Toggle-->
                                            <div class="d-flex align-items-center collapsible collapsed rotate" data-bs-toggle="collapse" href="#kt_customer_view_payment_method_4" role="button" aria-expanded="false" aria-controls="kt_customer_view_payment_method_4">
                                                <!--begin::Arrow-->
                                                <div class="me-3 rotate-90">
                                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
                                                    <span class="svg-icon svg-icon-3">
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z" fill="currentColor" />
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                </div>
                                                <!--end::Arrow-->
                                                <!--begin::Logo-->
                                                <img src="assets/media/svg/card-logos/american-express.svg" class="w-40px me-3" alt="" />
                                                <!--end::Logo-->
                                                <!--begin::Summary-->
                                                <div class="me-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="fw-bold text-gray-800">رابط البرنامج</div>
                                                        @if ($survey_accounts == '' || $survey_accounts->url == '')
                                                            <div class="badge badge-light-danger ms-5">لم يتم إنشائه بعد</div>
                                                            <td class="text-gray-800">
                                                                <span class="svg-icon svg-icon-2 svg-icon-danger">
                                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                                                        <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                                                                    </svg>
                                                                </span>
                                                            </td>
                                                        @else
                                                            <div class="badge badge-light-success ms-5">تم إنشائه</div>
                                                            <td class="text-gray-800">
                                                                <span class="svg-icon svg-icon-2 svg-icon-success">
                                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor" />
                                                                        <path d="M10.4343 12.4343L8.75 10.75C8.33579 10.3358 7.66421 10.3358 7.25 10.75C6.83579 11.1642 6.83579 11.8358 7.25 12.25L10.2929 15.2929C10.6834 15.6834 11.3166 15.6834 11.7071 15.2929L17.25 9.75C17.6642 9.33579 17.6642 8.66421 17.25 8.25C16.8358 7.83579 16.1642 7.83579 15.75 8.25L11.5657 12.4343C11.2533 12.7467 10.7467 12.7467 10.4343 12.4343Z" fill="currentColor" />
                                                                    </svg>
                                                                </span>
                                                            </td>
                                                        @endif
                                                    </div>
                                                </div>
                                                <!--end::Summary-->
                                            </div>
                                            <!--end::Toggle-->
                                            <!--begin::Toolbar-->
                                            <div class="d-flex ms-9 my-3">
                                                <!--begin::Edit-->
                                                <a href="#" id="kt_modal_url_card_url" class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_url_card">
                                                    <span data-bs-toggle="tooltip" data-bs-trigger="hover" title="Edit">
                                                        <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                                        <span class="svg-icon svg-icon-3">
                                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path opacity="0.3"
                                                                    d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z"
                                                                    fill="currentColor" />
                                                                <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor" />
                                                            </svg>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </a>
                                                <!--end::More-->
                                            </div>
                                            <!--end::Toolbar-->
                                        </div>
                                        <!--end::Header-->
                                        <!--begin::Body-->
                                        <div id="kt_customer_view_payment_method_4" class="fs-6 ps-10 collapse" data-bs-parent="#kt_customer_view_payment_method">
                                            <!--begin::Details-->
                                            <div class="d-flex flex-wrap py-5">
                                                <!--begin::Col-->
                                                <div class="flex-equal me-5">
                                                    <table class="table-flush fw-semibold gy-1 table">
                                                        <tr>
                                                            <td class="text-muted min-w-125px w-125px">الرابط الإلكتروني</td>
                                                            <td class="text-gray-800">{{ $survey_accounts->url ?? '' }}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <!--end::Col-->
                                            </div>
                                            <!--end::Details-->
                                        </div>
                                        <!--end::Body-->
                                    </div>
                                    <!--end::Option-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card-->
                        </div>
                        <!--end:::Tab pane-->
                        <!--end:::Tab content-->
                        <div class="text-center">
                            <button type="reset" id="kt_edit_project_cancel" class="btn btn-secondary me-3">إلغاء</button>
                            <button type="submit" id="kt_edit_project_submit" class="btn btn-primary">إنهاء وتسليم المهمة</button>
                        </div>
                    </form>
                </div>
            </div>
            <!--end::Content-->
        </div>
        <!--end::Layout-->

        <!--begin::MODALS-->
        <!--begin::Modal - New Card-->
        <div class="modal fade" id="kt_modal_new_card" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2 id="dept_id"></h2>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                            <span class="svg-icon svg-icon-1">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                    <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Modal header-->
                    <!--begin::Account Modal body-->
                    <div class="modal-body scroll-y mx-xl-15 mx-5 my-7">
                        <!--begin::Form-->
                        <form id="kt_modal_new_card_form" class="form" action="{{ url('creator/create-survey-account') }}" method="post">
                            @csrf
                            <input type="hidden" name="project_id" id="project_id" value="{{ $row->id }}" />
                            <input type="hidden" name="type_id" id="type_id" />

                            <!--begin::Input group-->
                            <div class="d-flex flex-column fv-row mb-7">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                                    <span class="required">البريد الإلكتروني</span>
                                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Specify a card holder's name"></i>
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid" placeholder="البريد الإلكتروني" name="email" id="email" />
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="d-flex flex-column fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-semibold form-label mb-2">كلمة المرور</label>
                                <!--end::Label-->
                                <!--begin::Input wrapper-->
                                <div class="position-relative">
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" placeholder="كلمة المرور" name="password" id="password" />
                                    <!--end::Input-->
                                </div>
                                <!--end::Input wrapper-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Actions-->
                            <div class="pt-15 text-center">
                                <button type="reset" id="kt_modal_new_card_cancel" class="btn btn-light me-3" data-bs-dismiss="modal">إلغاء</button>
                                <button type="submit" id="kt_modal_new_card_submit" class="btn btn-primary">
                                    <span class="indicator-label">حفظ</span>
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm ms-2 align-middle"></span></span>
                                </button>
                            </div>
                            <!--end::Actions-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Account Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
        <!--end::Modal - New Card-->

        <!--begin::Modal - URL-->
        <div class="modal fade" id="kt_modal_url_card" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2 id="dept_url"></h2>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                            <span class="svg-icon svg-icon-1">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                    <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Modal header-->
                    <!--begin::Account Modal body-->
                    <div class="modal-body scroll-y mx-xl-15 mx-5 my-7">
                        <!--begin::Form-->
                        <form id="kt_modal_new_card_form" class="form" action="{{ url('creator/create-survey-account') }}" method="post">
                            @csrf
                            <input type="hidden" name="project_id" id="project_id" value="{{ $row->id }}" />
                            <input type="hidden" name="type_url" id="type_url" />
                            <!--begin::Input group-->
                            <div class="d-flex flex-column fv-row mb-7">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                                    <span class="required">الرابط الإلكتروني للبرنامج</span>
                                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Specify a card holder's name"></i>
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid" placeholder="الرابط الإلكتروني" name="url" id="url" value="{{ $survey_accounts->url ?? '' }}" />
                            </div>
                            <!--end::Input group-->
                            <!--begin::Actions-->
                            <div class="pt-15 text-center">
                                <button type="reset" id="kt_modal_new_card_cancel" class="btn btn-light me-3" data-bs-dismiss="modal">إلغاء</button>
                                <button type="submit" id="kt_modal_new_card_submit" class="btn btn-primary">
                                    <span class="indicator-label">حفظ</span>
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm ms-2 align-middle"></span></span>
                                </button>
                            </div>
                            <!--end::Actions-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Account Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
        <!--end::Modal - URL-->
        <!--end::MODALS-->
        @include('partials.obstacle._obstacle')
    </div>
@stop

@section('scripts')
    <script src="{{ asset('assets/js/custom/backoffice/creator.js') }}"></script>
@stop
