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
                    <!--begin::Content-->
                    <div class="tab-pane fade show active">
                        @include('partials.backoffice.research-details')
                        @if ($row->type_id != 10 && $row->type_id != 12)
                            @include('partials.backoffice.kashef-accounts')
                        @else
                            @include('partials.backoffice.survey-accounts')
                        @endif

                        <div class="col-lg-12">
                            <!--begin::Toolbar-->
                            <div class="d-flex flex-stack flex-wrap pb-7">
                                <!--begin::Title-->
                                <div class="d-flex align-items-center my-1 flex-wrap">
                                    <h3 class="fw-bold my-1 me-5">فريق العمل الرئيسي</h3>
                                </div>
                                <!--end::Title-->
                                <!--begin::Controls-->
                                <div class="d-flex my-1 flex-wrap">
                                    <!--begin::Tab nav-->
                                    <ul class="nav nav-pills mb-sm-0 mb-2 me-6">
                                        <li class="nav-item m-0">
                                            <a class="btn btn-sm btn-icon btn-light btn-color-muted btn-active-primary active me-3" data-bs-toggle="tab" href="#kt_project_users_card_pane">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen024.svg-->
                                                <span class="svg-icon svg-icon-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <rect x="5" y="5" width="5" height="5" rx="1" fill="currentColor" />
                                                            <rect x="14" y="5" width="5" height="5" rx="1" fill="currentColor" opacity="0.3" />
                                                            <rect x="5" y="14" width="5" height="5" rx="1" fill="currentColor" opacity="0.3" />
                                                            <rect x="14" y="14" width="5" height="5" rx="1" fill="currentColor" opacity="0.3" />
                                                        </g>
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </a>
                                        </li>
                                        <li class="nav-item m-0">
                                            <a class="btn btn-sm btn-icon btn-light btn-color-muted btn-active-primary" data-bs-toggle="tab" href="#kt_project_users_table_pane">
                                                <!--begin::Svg Icon | path: icons/duotune/abstract/abs015.svg-->
                                                <span class="svg-icon svg-icon-2">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z" fill="currentColor" />
                                                        <path opacity="0.3" d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z" fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </a>
                                        </li>
                                    </ul>
                                    <!--end::Tab nav-->
                                </div>
                                <!--end::Controls-->
                            </div>
                            <!--end::Toolbar-->
                            <!--begin::Tab Content-->
                            <div class="tab-content">
                                <!--begin::Tab pane-->
                                <div id="kt_project_users_card_pane" class="tab-pane fade show active">
                                    <!--begin::Row-->
                                    <div class="row g-6 g-xl-9">
                                        @forelse($project_fieldwork_teams as $project_fieldwork_team)
                                            <!--begin::Col-->
                                            <div class="col-md-12 col-xxl-6">
                                                <!--begin::Card-->
                                                <a href="{{ url('equipment/followup/field-team-details/' . $row->id . '/' . $project_fieldwork_team->user_id) }}" class="card border-hover-primary">
                                                    <div class="card">
                                                        <!--begin::Card body-->
                                                        <div class="card-body d-flex flex-center flex-column p-9 pt-12">
                                                            <!--begin::Avatar-->
                                                            <div class="symbol symbol-65px symbol-circle mb-5">
                                                                <span class="symbol-label fs-2x fw-semibold text-primary bg-light-primary">{{ substr($project_fieldwork_team->user[0]->username, 0, 1) }}</span>
                                                                <div class="bg-success position-absolute border-body h-15px w-15px rounded-circle translate-middle start-100 top-100 ms-n3 mt-n3 border border-4"></div>
                                                            </div>
                                                            <!--end::Avatar-->
                                                            <!--begin::Name-->
                                                            <a href="{{ url('chats/' . $project_fieldwork_team->user[0]->id . '?Ref=' . $project_fieldwork_team->user[0]->name) }}" class="fs-4 text-hover-primary fw-bold mb-0 text-gray-800">{{ $project_fieldwork_team->user[0]->name }}</a>
                                                            <!--end::Name-->
                                                            <!--begin::Position-->
                                                            <div class="fw-semibold mb-6 text-gray-400">{{ $project_fieldwork_team->user[0]->email }}</div>
                                                            <!--end::Position-->
                                                            <!--begin::Info-->
                                                            <div class="d-flex flex-center flex-wrap">
                                                                <!--begin::Stats-->
                                                                <div class="min-w-80px mx-2 mb-3 rounded border border-dashed border-gray-300 px-4 py-3">
                                                                    <div class="fs-6 fw-bold text-gray-700">{{ $project_fieldwork_team->type[0]->trans }}</div>
                                                                    <div class="fw-semibold text-gray-400">الدور العملي</div>
                                                                </div>
                                                                <!--end::Stats-->
                                                                @if ($project_fieldwork_team->supervisor_qty)
                                                                    <!--begin::Stats-->
                                                                    <div class="min-w-80px mx-2 mb-3 rounded border border-dashed border-gray-300 px-4 py-3">
                                                                        <div class="fs-6 fw-bold text-gray-700">{{ $project_fieldwork_team->supervisor_qty }}</div>
                                                                        <div class="fw-semibold text-gray-400">عدد المشرفين</div>
                                                                    </div>
                                                                    <!--end::Stats-->
                                                                    <!--begin::Stats-->
                                                                    <div class="min-w-80px mx-2 mb-3 rounded border border-dashed border-gray-300 px-4 py-3">
                                                                        <div class="fs-6 fw-bold text-gray-700">{{ $project_fieldwork_team->researcher_qty }}</div>
                                                                        <div class="fw-semibold text-gray-400">عدد الباحثين</div>
                                                                    </div>
                                                                @else
                                                                    <!--end::Stats-->
                                                                    <!--begin::Stats-->
                                                                    <div class="min-w-80px mx-2 mb-3 rounded border border-dashed border-gray-300 px-4 py-3">
                                                                        <div class="fs-6 fw-bold text-gray-700">{{ $project_fieldwork_team->auditor_qty }}</div>
                                                                        <div class="fw-semibold text-gray-400">عدد المدققين</div>
                                                                    </div>
                                                                    <!--end::Stats-->
                                                                @endif
                                                            </div>
                                                            <!--end::Info-->
                                                        </div>
                                                        <!--end::Card body-->
                                                    </div>
                                                </a>
                                                <!--end::Card-->
                                            </div>
                                            <!--end::Col-->
                                        @empty
                                            {{ __('site.empty_transactions_history') }}
                                        @endforelse

                                    </div>
                                    <!--end::Row-->
                                    <!--begin::Pagination-->
                                    <div class="d-flex flex-stack flex-wrap pt-10">
                                        {!! $project_fieldwork_teams->links() !!}
                                    </div>
                                    <!--end::Pagination-->
                                </div>
                                <!--end::Tab pane-->
                            </div>
                            <!--end::Tab Content-->
                            <div class="text-center">
                                <a href="{{ route('ExportEx', ['projectId' => $row->id]) }}" id="kt_edit_project_export" class="btn btn-success me-3">تصدير ملف تفاصيل فريق العمل</a>
                            </div>

                            @if ($project_transaction_history->is_done == 0)
                                <!--begin::Notice-->
                                <div class="notice d-flex bg-light-warning border-warning mb-9 mt-8 rounded border border-dashed p-6">
                                    <!--begin::Icon-->
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen044.svg-->
                                    <span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor" />
                                            <rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="currentColor" />
                                            <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                    <!--end::Icon-->
                                    <!--begin::Wrapper-->
                                    <div class="d-flex flex-stack flex-grow-1">
                                        <!--begin::Content-->
                                        <div class="fw-semibold">
                                            <h4 class="fw-bold text-gray-900">لإنهاء وتسليم المهمة</h4>
                                            <div class="fs-6 text-gray-700">حتى يمكنك إنهاء وتسليم المهمة، يجب عليك إضافة الحسابات في برنامج كاشف لكل أفراد الفريق - الباحثين والمدققين</div>
                                        </div>
                                        <!--end::Content-->
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Notice-->
                                <form class="form" action="{{ url('equipment/accounts-created') }}" enctype="multipart/form-data" novalidate="novalidate" method="post">
                                    <div class="card card-flush py-4">
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h4>هل تريد إيقاف إرسال رسالة بالحسابات إلى أفراد الفريق</h4>
                                            </div>
                                        </div>
                                        <div class="card-body pt-0">
                                            <div>
                                                <label class="form-check form-switch form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value="1" name="is_send_kashif_accounts" id="is_send_kashif_accounts" checked onchange="manageSendKashifAccounts(this)" />
                                                    <span class="form-check-label fw-semibold text-muted">نعم</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div id="kashif_email_accounts_sendDIV" class="card-header d-none">
                                            <div class="card-title">
                                                <h4>هل هناك حاجة إلى إضافة نمط موحد في طريقة إضافت الحسابات إلى برنامج كاشف؟</h4>
                                            </div>
                                        </div>
                                        <div id="kashif_email_accounts_sendDIV2" class="card-body pt-0 d-none">
                                            <div>
                                                <label class="form-check form-switch form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value="1" name="is_kashif_accounts_changed" id="is_kashif_accounts_changed" onchange="manageKashifEmailPrefix(this)" />
                                                    <span class="form-check-label fw-semibold text-muted">نعم</span>
                                                </label>
                                            </div>
                                            <div id="kashif_email_accounts_prefixDIV" class="d-none mt-6">
                                                <label class="form-label text-danger">الرجاء إدخال النمط الموحد التي تريد أن تكون مميزة للبريد الإلكتروني</label>
                                                <input id="kashif_email_accounts_prefix" name="kashif_email_accounts_prefix" class="form-control mb-2" tabindex="-1">
                                                <div class="text-muted fs-7"> سيتم إضافة النمط الموحد قبل علامه
                                                    <code>@</code> الخاص بالبريد الإلكتروني .
                                                </div>
                                            </div>
                                        </div>
                                    </div>
 
                                    @csrf
                                    <input type="hidden" name="project_id" id="project_id" value="{{ $row->id }}" />
                                    <div class="mt-8 text-center">
                                        <button type="submit" id="kt_edit_project_submit" class="btn btn-primary me-3">إنهاء وتسليم المهمة</button>
                                        <button type="reset" id="kt_cancel_equipment" class="btn btn-secondary me-3">إلغاء</button>
                                    </div>
                                </form>
                            @else
                                <!--begin::Alert-->
                                <div class="alert alert-dismissible bg-light-success border-success d-flex flex-column flex-sm-row mb-10 border border-dashed p-5 mt-8">
                                    <!--begin::Icon-->
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen048.svg-->
                                    <span class="svg-icon svg-icon-2tx svg-icon-success me-4">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.3"
                                                d="M20.5543 4.37824L12.1798 2.02473C12.0626 1.99176 11.9376 1.99176 11.8203 2.02473L3.44572 4.37824C3.18118 4.45258 3 4.6807 3 4.93945V13.569C3 14.6914 3.48509 15.8404 4.4417 16.984C5.17231 17.8575 6.18314 18.7345 7.446 19.5909C9.56752 21.0295 11.6566 21.912 11.7445 21.9488C11.8258 21.9829 11.9129 22 12.0001 22C12.0872 22 12.1744 21.983 12.2557 21.9488C12.3435 21.912 14.4326 21.0295 16.5541 19.5909C17.8169 18.7345 18.8277 17.8575 19.5584 16.984C20.515 15.8404 21 14.6914 21 13.569V4.93945C21 4.6807 20.8189 4.45258 20.5543 4.37824Z"
                                                fill="currentColor" />
                                            <path d="M10.5606 11.3042L9.57283 10.3018C9.28174 10.0065 8.80522 10.0065 8.51412 10.3018C8.22897 10.5912 8.22897 11.0559 8.51412 11.3452L10.4182 13.2773C10.8099 13.6747 11.451 13.6747 11.8427 13.2773L15.4859 9.58051C15.771 9.29117 15.771 8.82648 15.4859 8.53714C15.1948 8.24176 14.7183 8.24176 14.4272 8.53714L11.7002 11.3042C11.3869 11.6221 10.874 11.6221 10.5606 11.3042Z" fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Icon-->

                                    <!--begin::Wrapper-->
                                    <div class="d-flex flex-column pe-sm-10 pe-0">
                                        <h5 class="mb-1">تنبيه</h5>
                                        <span>لقد تم بالفعل إنهاء وتسليم المهمة بنجاح.</span>
                                    </div>
                                    <!--end::Wrapper-->

                                    <!--begin::Close-->
                                    <button type="button" class="position-absolute position-sm-relative m-sm-0 btn btn-icon ms-sm-auto end-0 top-0 m-2" data-bs-dismiss="alert">
                                        <i class="ki-duotone ki-cross fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
                                    </button>
                                    <!--end::Close-->
                                </div>
                                <!--end::Alert-->
                            @endif
                        </div>
                        <!--end::Content-->
                    </div>
                </div>
                <!--end::Content-->
            </div>
            <!--end::Layout-->
        </div>
    </div>
@stop

@section('scripts')
    <script>
        function manageSendKashifAccounts(checkboxItem) {
            if (!checkboxItem.checked) {
                document.getElementById("kashif_email_accounts_sendDIV").classList.remove("d-none");
                document.getElementById("kashif_email_accounts_sendDIV2").classList.remove("d-none");
            } else {
                document.getElementById("kashif_email_accounts_sendDIV").classList.add("d-none");
                document.getElementById("kashif_email_accounts_sendDIV2").classList.add("d-none");
            }
        }

        function manageKashifEmailPrefix(checkboxItem) {
            if (checkboxItem.checked) {
                document.getElementById("kashif_email_accounts_prefixDIV").classList.remove("d-none");
            } else {
                document.getElementById("kashif_email_accounts_prefixDIV").classList.add("d-none");
            }
        }
    </script>
    <script src="{{ asset('assets/js/custom/utilities/modals/create-account.js') }}"></script>
    <script src="{{ asset('assets/js/custom/account/referrals/referral-program.js') }}"></script>
    <script src="{{ asset('assets/js/custom/backoffice/equipment.js') }}"></script>
@stop
