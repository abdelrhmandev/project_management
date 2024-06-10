<!--begin::research details-->
<div class="card mb-xl-8 mb-3">
    <div class="card-body pt-9 pb-0">
        <!--begin::Details-->
        <div class="d-flex flex-sm-nowrap mb-3 flex-wrap">
            <!--begin::Info-->
            <div class="flex-grow-1">
                <!--begin::Title-->
                <div class="d-flex justify-content-between align-items-start mb-2 flex-wrap">
                    <!--begin::User-->
                    <div class="d-flex flex-column">
                        <!--begin::Name-->
                        <div class="d-flex align-items-center mb-2">
                            <a href="#" class="text-hover-primary fs-2 fw-bold me-1 text-gray-900">الكوادر المخصصة للمشروع</a>
                            <a href="#">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen026.svg-->
                                <span class="svg-icon svg-icon-1 svg-icon-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                                        <path
                                            d="M10.0813 3.7242C10.8849 2.16438 13.1151 2.16438 13.9187 3.7242V3.7242C14.4016 4.66147 15.4909 5.1127 16.4951 4.79139V4.79139C18.1663 4.25668 19.7433 5.83365 19.2086 7.50485V7.50485C18.8873 8.50905 19.3385 9.59842 20.2758 10.0813V10.0813C21.8356 10.8849 21.8356 13.1151 20.2758 13.9187V13.9187C19.3385 14.4016 18.8873 15.491 19.2086 16.4951V16.4951C19.7433 18.1663 18.1663 19.7433 16.4951 19.2086V19.2086C15.491 18.8873 14.4016 19.3385 13.9187 20.2758V20.2758C13.1151 21.8356 10.8849 21.8356 10.0813 20.2758V20.2758C9.59842 19.3385 8.50905 18.8873 7.50485 19.2086V19.2086C5.83365 19.7433 4.25668 18.1663 4.79139 16.4951V16.4951C5.1127 15.491 4.66147 14.4016 3.7242 13.9187V13.9187C2.16438 13.1151 2.16438 10.8849 3.7242 10.0813V10.0813C4.66147 9.59842 5.1127 8.50905 4.79139 7.50485V7.50485C4.25668 5.83365 5.83365 4.25668 7.50485 4.79139V4.79139C8.50905 5.1127 9.59842 4.66147 10.0813 3.7242V3.7242Z"
                                            fill="currentColor" />
                                        <path d="M14.8563 9.1903C15.0606 8.94984 15.3771 8.9385 15.6175 9.14289C15.858 9.34728 15.8229 9.66433 15.6185 9.9048L11.863 14.6558C11.6554 14.9001 11.2876 14.9258 11.048 14.7128L8.47656 12.4271C8.24068 12.2174 8.21944 11.8563 8.42911 11.6204C8.63877 11.3845 8.99996 11.3633 9.23583 11.5729L11.3706 13.4705L14.8563 9.1903Z" fill="white" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </a>
                        </div>
                        <!--end::Name-->
                        @if ($row->type_id != 10)
                            <!--begin::Info-->
                            <div class="d-flex fw-semibold fs-6 pe-2 mb-4 flex-wrap">
                                <a href="#" class="d-flex align-items-center text-hover-primary me-5 mb-2 text-gray-400">
                                    <!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
                                    <span class="svg-icon svg-icon-4 me-1">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.3" d="M18.0624 15.3453L13.1624 20.7453C12.5624 21.4453 11.5624 21.4453 10.9624 20.7453L6.06242 15.3453C4.56242 13.6453 3.76242 11.4453 4.06242 8.94534C4.56242 5.34534 7.46242 2.44534 11.0624 2.04534C15.8624 1.54534 19.9624 5.24534 19.9624 9.94534C20.0624 12.0453 19.2624 13.9453 18.0624 15.3453Z" fill="currentColor" />
                                            <path d="M12.0624 13.0453C13.7193 13.0453 15.0624 11.7022 15.0624 10.0453C15.0624 8.38849 13.7193 7.04535 12.0624 7.04535C10.4056 7.04535 9.06241 8.38849 9.06241 10.0453C9.06241 11.7022 10.4056 13.0453 12.0624 13.0453Z" fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->تاريخ بدء العمل {{ $financial_bid_estimate->start_date }}
                                </a>
                                <a href="#" class="d-flex align-items-center text-hover-primary me-5 mb-2 text-gray-400">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen018.svg-->
                                    <span class="svg-icon svg-icon-4 me-1">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.3" d="M18.0624 15.3453L13.1624 20.7453C12.5624 21.4453 11.5624 21.4453 10.9624 20.7453L6.06242 15.3453C4.56242 13.6453 3.76242 11.4453 4.06242 8.94534C4.56242 5.34534 7.46242 2.44534 11.0624 2.04534C15.8624 1.54534 19.9624 5.24534 19.9624 9.94534C20.0624 12.0453 19.2624 13.9453 18.0624 15.3453Z" fill="currentColor" />
                                            <path d="M12.0624 13.0453C13.7193 13.0453 15.0624 11.7022 15.0624 10.0453C15.0624 8.38849 13.7193 7.04535 12.0624 7.04535C10.4056 7.04535 9.06241 8.38849 9.06241 10.0453C9.06241 11.7022 10.4056 13.0453 12.0624 13.0453Z" fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->تاريخ إنهاء العمل {{ $financial_bid_estimate->end_date }}
                                </a>
                                <a href="#" class="d-flex align-items-center text-hover-primary mb-2 text-gray-400">
                            </div>
                            <!--end::Info-->
                        @else
                            <!--begin::Info-->
                            <div class="d-flex fw-semibold fs-6 pe-2 mb-4 flex-wrap">
                                <a href="#" class="d-flex align-items-center text-hover-primary me-5 mb-2 text-gray-400">
                                    <!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
                                    <span class="svg-icon svg-icon-4 me-1">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.3" d="M18.0624 15.3453L13.1624 20.7453C12.5624 21.4453 11.5624 21.4453 10.9624 20.7453L6.06242 15.3453C4.56242 13.6453 3.76242 11.4453 4.06242 8.94534C4.56242 5.34534 7.46242 2.44534 11.0624 2.04534C15.8624 1.54534 19.9624 5.24534 19.9624 9.94534C20.0624 12.0453 19.2624 13.9453 18.0624 15.3453Z" fill="currentColor" />
                                            <path d="M12.0624 13.0453C13.7193 13.0453 15.0624 11.7022 15.0624 10.0453C15.0624 8.38849 13.7193 7.04535 12.0624 7.04535C10.4056 7.04535 9.06241 8.38849 9.06241 10.0453C9.06241 11.7022 10.4056 13.0453 12.0624 13.0453Z" fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->موعد تنفيذ الزيارة التفتيشية: {{ $financial_bid_estimate->inspector_visit_date }}
                                </a>
                            </div>
                            <!--end::Info-->
                        @endif
                    </div>
                    <!--end::User-->
                    <!--begin::Actions-->
                    <div class="d-flex my-4">
                        <a href="#" class="btn btn-sm btn-light me-2" data-bs-toggle="modal" data-bs-target="#kt_modal_contact_information">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr012.svg-->
                            <span class="svg-icon svg-icon-3 d-none">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.3" d="M10 18C9.7 18 9.5 17.9 9.3 17.7L2.3 10.7C1.9 10.3 1.9 9.7 2.3 9.3C2.7 8.9 3.29999 8.9 3.69999 9.3L10.7 16.3C11.1 16.7 11.1 17.3 10.7 17.7C10.5 17.9 10.3 18 10 18Z" fill="currentColor" />
                                    <path d="M10 18C9.7 18 9.5 17.9 9.3 17.7C8.9 17.3 8.9 16.7 9.3 16.3L20.3 5.3C20.7 4.9 21.3 4.9 21.7 5.3C22.1 5.7 22.1 6.30002 21.7 6.70002L10.7 17.7C10.5 17.9 10.3 18 10 18Z" fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <!--begin::Indicator label-->
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor" />
                                <rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="currentColor" />
                                <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor" />
                            </svg>
                            <span class="indicator-label">معلومات التواصل</span>
                            <!--end::Indicator label-->
                            <!--begin::Indicator progress-->
                            <span class="indicator-progress">الرجاء الإنتظار...
                                <span class="spinner-border spinner-border-sm ms-2 align-middle"></span></span>
                            <!--end::Indicator progress-->
                        </a>
                    </div>
                    <!--end::Actions-->
                    @if ($row->status_id == 10 && Auth::user()->hasRole('operation'))
                        <div class="d-flex {{ $row->status_id == 10 ? '' : 'invisible' }} my-4">
                            <form class="form" id="FormId" data-route-url="{{ url('fieldwork/start-field') }}" enctype="multipart/form-data" novalidate="novalidate" method="POST">
                                @csrf
                                <input type="hidden" name="project_id" id="project_id" value="{{ $row->id }}" />
                                <input type="hidden" id="redirectUrl" data-redirect-url="{{ url('fieldworks/' . $row->id . '/edit') }}" />
                                <input type="hidden" name="project_title" id="project_title" value="{{ $row->title }}" />
                                <button type="button" class="btn btn-sm btn-primary me-2" id="kt_page_loading_overlay" data-kt-element="files-next">بدء العمل الميداني</button>
                            </form>
                        </div>
                    @endif
                </div>
                <!--end::Title-->
                <!--begin::Stats-->
                <div class="d-flex flex-stack flex-wrap">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-column flex-grow-1 pe-8">
                        <!--begin::Stats-->
                        <div class="d-flex flex-wrap">
                            @php
                                if (\Auth::user()->hasRole('observer')) {
                                    $supervisors = $fieldworkCounts->supervisors;
                                    $researchers = $fieldworkCounts->researchers;
                                    $auditors = $financial_bid_estimate->auditor_qty;
                                } else {
                                    $supervisors = $financial_bid_estimate->supervisor_qty;
                                    $researchers = $financial_bid_estimate->researcher_qty;
                                    $auditors = $financial_bid_estimate->auditor_qty;
                                }
                            @endphp
                            @if ($row->type_id != 9 && $row->type_id != 10)
                                <!--begin::Stat-->
                                <div class="min-w-125px me-6 mb-3 rounded border border-dashed border-gray-300 py-3 px-4">
                                    <!--begin::Number-->
                                    <div class="d-flex align-items-center">
                                        <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="{{ $supervisors }}">0</div>
                                    </div>
                                    <!--end::Number-->
                                    <!--begin::Label-->
                                    <div class="fw-semibold fs-6 text-gray-400">مشرف
                                        @if (\Auth::user()->hasRole('observer'))
                                            <button type="button" class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto" data-bs-toggle="modal" data-bs-target="#kt_modal_update_team">
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
                                            </button>
                                        @endif
                                    </div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Stat-->
                                <!--begin::Stat-->
                                <div class="min-w-125px me-6 mb-3 rounded border border-dashed border-gray-300 py-3 px-4">
                                    <!--begin::Number-->
                                    <div class="d-flex align-items-center">
                                        <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="{{ $researchers }}">0</div>
                                    </div>
                                    <!--end::Number-->
                                    <!--begin::Label-->
                                    <div class="fw-semibold fs-6 text-gray-400">باحث
                                        @if (\Auth::user()->hasRole('observer'))
                                            <button type="button" class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto" data-bs-toggle="modal" data-bs-target="#kt_modal_update_team">
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
                                            </button>
                                        @endif
                                    </div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Stat-->
                                <!--begin::Stat-->
                                <div class="min-w-125px me-6 mb-3 rounded border border-dashed border-gray-300 py-3 px-4">
                                    <!--begin::Number-->
                                    <div class="d-flex align-items-center">
                                        <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="{{ $auditors }}">0</div>
                                    </div>
                                    <!--end::Number-->
                                    <!--begin::Label-->
                                    <div class="fw-semibold fs-6 text-gray-400">مدقق</div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Stat-->
                            @elseif($row->type_id == 10)
                                <!--begin::Stat-->
                                <div class="min-w-125px me-6 mb-3 rounded border border-dashed border-gray-300 py-3 px-4">
                                    <!--begin::Number-->
                                    <div class="d-flex align-items-center">
                                        <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="{{ $financial_bid_estimate->inspector_qty }}">0</div>
                                    </div>
                                    <!--end::Number-->
                                    <!--begin::Label-->
                                    <div class="fw-semibold fs-6 text-gray-400">الفاحصين</div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Stat-->
                            @else
                                <!--begin::Stat-->
                                <div class="min-w-125px me-6 mb-3 rounded border border-dashed border-gray-300 py-3 px-4">
                                    <!--begin::Number-->
                                    <div class="d-flex align-items-center">
                                        <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="{{ $financial_bid_estimate->trainer_qty }}">0</div>
                                    </div>
                                    <!--end::Number-->
                                    <!--begin::Label-->
                                    <div class="fw-semibold fs-6 text-gray-400">المدربين</div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Stat-->
                            @endif
                        </div>
                        <!--end::Stats-->
                    </div>
                    <!--end::Wrapper-->
                    <!--begin::Progress-->
                    <div class="d-flex align-items-center w-200px w-sm-300px flex-column mt-3">
                        <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                            <span class="fw-bold fs-6 text-gray-400">الإنجازية</span>
                            <span class="fw-bold fs-6">{{ $row->progress_bar }}%</span>
                        </div>
                        <div class="h-5px w-100 bg-light mx-3 mb-3">
                            <div class="bg-success h-5px rounded" role="progressbar" style="width:{{ $row->progress_bar }}%;" aria-valuenow="{{ $row->progress_bar }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <!--end::Progress-->
                </div>
                <!--end::Stats-->
            </div>
            <!--end::Info-->
        </div>
        <!--end::Details-->
    </div>
</div>
<!--end::research details-->

<!--begin::Modal - contact information-->
@include('partials.backoffice.contact-information-modal')
<!--end::Modals - contact information-->

<div class="modal fade" id="kt_modal_update_team" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">تعديل عدد كادر العمل</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
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
            <!--begin::Modal body-->
            <div class="modal-body scroll-y mx-xl-15 mx-5 my-7">
                <!--begin::Form-->
                <form class="form" action="{{ url('observer/update-team-qty') }}" novalidate="novalidate" method="post">
                    @csrf
                    @php
                        $sum = \App\Models\ProjectObserverTeam::select(\DB::raw('SUM(qty) AS Qty'))
                            ->where('project_id', $row->id)
                            ->where('type_id', 4)
                            ->first()->Qty;
                    @endphp
                    <input type="hidden" name="project_id" id="project_id" value="{{ $row->id }}" />
                    <input type="hidden" value="{{ \Auth::user()->hasRole('observer')? $fieldwork_team->supervisor_qty -($observer_team->where('type_id', 4)->where('superior_id', Auth::user()->id)->first()->qty ??0): '' }}" id="remainSupers">
                    <input type="hidden" value="{{ \Auth::user()->hasRole('observer') ? $fieldwork_team->researcher_qty - ($observer_team_researchers->qty ?? 0) : '' }}" id="remainReasers">
                    <input type="hidden" id="numSupers" value="{{ $supervisors }}" />
                    <input type="hidden" id="numResearch" value="{{ $researchers }}" />
                    <input type="hidden" value="{{ $sum }}" id="numResearchers">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold form-label mb-2">
                            <span class="required">عدد المشرفين</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control form-control-solid" id="totSupers" name="supervisor_qty" value="{{ $supervisors }}" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold form-label mb-2">
                            <span class="required">عدد الباحثين</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control form-control-solid" id="totResearch" name="researcher_qty" value="{{ $researchers }}" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Actions-->
                    <div class="pt-15 text-center">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">{{ __('site.cancel') }}</button>
                        <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit" id="updateKader">
                            <span class="indicator-label">{{ __('site.send') }}</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm ms-2 align-middle"></span></span>
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
