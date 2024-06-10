<!--begin::Sidebar-->
<div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10">
    <!--begin::Card-->
    <div class="card mb-5 mb-xl-8">
        <!--begin::Card body-->
        <div class="card-body pt-15">
            <!--begin::Summary-->
            <div class="d-flex flex-center flex-column mb-5">
                <!--begin::Avatar-->
                <div class="d-flex flex-stack">
                    <div class="d-flex">
                        <div class="d-flex flex-column">
                            <div class="symbol symbol-100px symbol-circle mb-7">
                                <img src="{{ asset('storage/' . $row->logo) }}" alt="{{ $row->title }}" />
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Avatar-->
                <!--begin::Name-->
                <a href="#" class="fs-3 text-gray-800 text-hover-primary fw-bold">{{ $row->title }}</a>
                <!--end::Name-->
                <!--begin::Position-->
                <div class="fs-5 fw-semibold text-muted mb-6">{{ $row->customer->title }}</div>
                <!--end::Position-->
                <!--begin::Info-->
                <div class="d-flex flex-wrap flex-center">
                    <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-7 mb-3">
                        <div class="fs-6 fw-semibold text-muted">{{ $row->start_date ?? '-' }}</div>
                        <div class="fw-semibold text-dark-400 fw-bold">{{ __('project.start_date') }}</div>
                    </div>
                    <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 mb-3">
                        <div class="fs-6 fw-semibold text-muted">{{ $row->end_date ?? '-' }}</div>
                        <div class="fw-semibold text-dark-400 fw-bold">{{ __('project.end_date') }}</div>
                    </div>
                </div>
                <div class="d-flex flex-wrap flex-center">
                    <div class="fs-4 fw-semibold">إنتهاء المشروع - </div>
                    <div class="fs-4 text-gray-800 fw-semibold"> {{ \Carbon\Carbon::parse($row->end_date)->diffForHumans($row->start_date) }}</div>
                    @if(!empty($project_explore_tour->city) && $row->status_id == 2)
                    <a href="#" class="btn btn-sm btn-light me-2 mt-4" data-bs-toggle="modal" data-bs-target="#kt_modal_contact_information">
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
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        <!--end::Indicator progress-->
                    </a>
                    @endif
                </div>
                <div class="d-flex my-4">
                    <a href="#" class="btn btn-sm btn-light-danger btnObs" data-bs-toggle="modal" data-bs-target="#kt_modal_project_obstacles">إبلاغ عن عرقلة</a>
                </div>
                <!--end::Info-->
            </div>
            <!--end::Summary-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->

    <!--begin::essential information-->
    <div class="card mb-xl-8">
        <!--begin::Card header-->
        <div class="card-header card-header-stretch pb-0">
            <!--begin::Toolbar-->
            <div class="card-toolbar m-0">
                <!--begin::Tab nav-->
                <ul class="nav nav-stretch nav-line-tabs border-transparent" role="tablist">
                    <!--begin::Tab item-->
                    <li class="nav-item" role="presentation">
                        <a id="kt_essential_data_tab" class="nav-link fs-2 fw-bold me-5 active" data-bs-toggle="tab" role="tab" href="#kt_essential_data">المعلومات الأساسية</a>
                    </li>
                    <!--end::Tab item-->
                    @if (!Auth::user()->hasRole('observer'))
                    <!--begin::Tab item-->
                    <li class="nav-item" role="presentation">
                        <a id="kt_attachment_tab" class="nav-link fs-2 fw-bold " data-bs-toggle="tab" role="tab" href="#kt_attachment">المرفقات</a>
                    </li>
                    <!--end::Tab item-->
                    @endif
                </ul>
                <!--end::Tab nav-->
            </div>
            <!--end::Toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Tab content-->
        <div id="kt_billing_payment_tab_content" class="card-body tab-content">
            <!--begin::Tab panel-->
            <div id="kt_essential_data" class="tab-pane fade show active" role="tabpanel">
                <!--begin::Items-->
                <div class="py-2">
                    <div class="d-flex flex-stack">
                        <div class="d-flex">

                            <div class="d-flex flex-column">
                                <span class="fs-5 text-dark text-hover-primary fw-bold">{{ __('project.type') }}</span>
                                <div class="fs-6 fw-semibold text-muted">{{ $row->type->title }}</div>
                            </div>
                        </div>
                    </div>
                    <!--end::Item-->
                    @if($row->type_id != 14)
                    <!--begin::Item-->
                    <div class="separator separator-dashed my-5"></div>
                    <div class="d-flex flex-stack">
                        <div class="d-flex">
                            <div class="d-flex flex-column">
                                <span class="fs-5 text-dark text-hover-primary fw-bold">{{ __('project.region') }}</span>
                                <div class="fs-6 fw-semibold text-muted">
                                    @foreach ($row->region as $region)
                                    <span class="badge badge-light-success">{{ $region->title }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Item-->
                    @endif
                    @if(!empty($project_explore_tour->city))
                    <!--begin::Item-->
                    <div class="separator separator-dashed my-5"></div>
                    <div class="d-flex flex-stack">
                        <div class="d-flex">
                            <div class="d-flex flex-column">
                                <span class="fs-5 text-dark text-hover-primary fw-bold">مدينة الزيارة المطلوبة</span>
                                <div class="fs-2hx fw-bold text-muted">
                                    <span class="fs-2x badge badge-light-success">{{ $project_explore_tour->city->title }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Item-->
                    @endif
                    @if($row->type_id == 14)
                    <!--begin::Item-->
                    <div class=" separator separator-dashed my-5"></div>
                    <div class="d-flex flex-stack">
                        <div class="d-flex">
                            <div class="d-flex flex-column">
                                <span class="fs-5 text-dark text-hover-primary fw-bold">عدد المتدربين</span>
                                <div class="fs-2hx fw-bold">{{ $training->training_count ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class=" separator separator-dashed my-5"></div>
                    <div class="d-flex flex-stack">
                        <div class="d-flex">
                            <div class="d-flex flex-column">
                                <span class="fs-5 text-dark text-hover-primary fw-bold">مقر التدريب</span>
                                <div class="fs-6 fw-semibold text-muted">{{ $training->training_headquarter ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class=" separator separator-dashed my-5"></div>
                    <div class="d-flex flex-stack">
                        <div class="d-flex">
                            <div class="d-flex flex-column">
                                <span class="fs-5 text-dark text-hover-primary fw-bold">التدريب على</span>
                                <div class="fs-6 fw-semibold text-muted">{{ $training->training_on ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class=" separator separator-dashed my-5"></div>
                    <div class="d-flex flex-stack">
                        <div class="d-flex">
                            <div class="d-flex flex-column">
                                <span class="fs-5 text-dark text-hover-primary fw-bold">موعد التدريب</span>
                                <div class="fs-6 fw-semibold text-muted">{{ $training->training_date ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class=" separator separator-dashed my-5"></div>
                    <div class="d-flex flex-stack">
                        <div class="d-flex">
                            <div class="d-flex flex-column">
                                <span class="fs-5 text-dark text-hover-primary fw-bold">مدة التدريب</span>
                                <div class="fs-6 fw-semibold text-muted">{{ $training->duration ?? '-' }} يوم</div>
                            </div>
                        </div>
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class=" separator separator-dashed my-5"></div>
                    <div class="d-flex flex-stack">
                        <div class="d-flex">
                            <div class="d-flex flex-column">
                                <span class="fs-5 text-dark text-hover-primary fw-bold">الحاجة إلى قاعة؟</span>
                                <div class="fs-6 fw-semibold text-muted">{{ $training->is_hall_required == 1? 'نعم' : 'لا'}}</div>
                            </div>
                        </div>
                    </div>
                    <!--end::Item-->
                    @elseif($row->type_id == 9)
                    <!--begin::Item-->
                    <div class=" separator separator-dashed my-5"></div>
                    <div class="d-flex flex-stack">
                        <div class="d-flex">
                            <div class="d-flex flex-column">
                                <span class="fs-5 text-dark text-hover-primary fw-bold">عدد الجمعيات</span>
                                <div class="fs-2hx fw-bold">{{ $project_empower_charity->charity_count }}</div>
                            </div>
                        </div>
                    </div>
                    <!--end::Item-->
                    @else
                    <!--begin::Item-->
                    <div class=" separator separator-dashed my-5"></div>
                    <div class="d-flex flex-stack">
                        <div class="d-flex">
                            <div class="d-flex flex-column">
                                <span class="fs-5 text-dark text-hover-primary fw-bold">{{ __('project.cases-count') }}</span>
                                <div class="fs-2hx fw-bold">{{ $row->cases_count ?? ($row->EmpowerCharity->charity_count ?? $row->building_count ?? '-') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Item-->
                    @endif

                    <div class=" separator separator-dashed my-5"></div>
                    <div class="d-flex flex-stack">
                        <div class="d-flex">
                            <div class="d-flex flex-column">
                                <span class="fs-5 text-dark text-hover-primary fw-bold"> هل هناك مرونة في تواريخ المشروع؟</span>
                                <div class="fs-6 fw-semibold text-muted">
                                    {{ $row->flexibility_project_dates == 1 ? __('site.yes') : __('site.no') }}
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class=" separator separator-dashed my-5"></div>
                    <div class="d-flex flex-stack">
                        <div class="d-flex">
                            <div class="d-flex flex-column">
                                <span class="fs-5 text-dark text-hover-primary fw-bold">هل العميل سيعمل/سينخرط في هذا النظام؟</span>
                                <div class="fs-6 fw-semibold text-muted">
                                    {{ $row->is_client_involved == 1 ? __('site.yes') : __('site.no') }}
                                </div>
                            </div>
                        </div>
                    </div>




                </div>
                <!--end::Items-->
            </div>
            <!--end::Tab panel-->
            <!--begin::Tab panel-->
            <div id="kt_attachment" class="tab-pane fade" role="tabpanel" aria-labelledby="kt_attachment_tab">
                <!--begin::Row-->
                <div class="row gx-9 gy-6">
                    <!--begin::Items-->
                    <div class="py-2">
                        @if (!empty($row->confirm_letter))
                        <!--begin::Item-->
                        <div class="d-flex flex-stack">
                            <div class="d-flex">
                                <div class="d-flex flex-column">
                                    <div class="fs-6 fw-semibold text-muted">
                                        <div class="card-toolbar">
                                            <a href="{{ asset('storage/' . $row->confirm_letter) }}" class="btn btn-sm btn-flex btn-light-warning">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen035.svg-->
                                                <span class="svg-icon svg-icon-3">
                                                    <svg width="62" height="62" viewBox="0 0 62 62" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M15.5 0C13.3687 0 11.625 1.74375 11.625 3.875V58.125C11.625 60.2562 13.3687 62 15.5 62H54.25C56.3812 62 58.125 60.2562 58.125 58.125V15.5L42.625 0H15.5Z" fill="#E2E5E7" />
                                                        <path d="M46.5 15.5H58.125L42.625 0V11.625C42.625 13.7563 44.3687 15.5 46.5 15.5Z" fill="#B0B7BD" />
                                                        <path d="M58.125 27.125L46.5 15.5H58.125V27.125Z" fill="#CAD1D8" />
                                                        <path d="M50.375 50.375C50.375 51.4406 49.5031 52.3125 48.4375 52.3125H5.8125C4.74687 52.3125 3.875 51.4406 3.875 50.375V31C3.875 29.9344 4.74687 29.0625 5.8125 29.0625H48.4375C49.5031 29.0625 50.375 29.9344 50.375 31V50.375Z" fill="#F15642" />
                                                        <path d="M12.3203 36.7099C12.3203 36.1984 12.7233 35.6404 13.3724 35.6404H16.9509C18.9659 35.6404 20.7794 36.9889 20.7794 39.5735C20.7794 42.0225 18.9659 43.3865 16.9509 43.3865H14.3644V45.4325C14.3644 46.1145 13.9304 46.5001 13.3724 46.5001C12.8609 46.5001 12.3203 46.1145 12.3203 45.4325V36.7099ZM14.3644 37.5914V41.4509H16.9509C17.9894 41.4509 18.8109 40.5345 18.8109 39.5735C18.8109 38.4904 17.9894 37.5914 16.9509 37.5914H14.3644Z" fill="white" />
                                                        <path d="M23.8136 46.5C23.3021 46.5 22.7441 46.221 22.7441 45.5409V36.7408C22.7441 36.1847 23.3021 35.7798 23.8136 35.7798H27.3612C34.4408 35.7798 34.2858 46.5 27.5007 46.5H23.8136ZM24.7901 37.6708V44.6109H27.3612C31.5443 44.6109 31.7303 37.6708 27.3612 37.6708H24.7901Z" fill="white" />
                                                        <path d="M36.7966 37.7948V40.2573H40.7472C41.3052 40.2573 41.8632 40.8153 41.8632 41.3559C41.8632 41.8674 41.3052 42.2859 40.7472 42.2859H36.7966V45.539C36.7966 46.0815 36.4111 46.498 35.8686 46.498C35.1866 46.498 34.77 46.0815 34.77 45.539V36.7388C34.77 36.1828 35.1885 35.7778 35.8686 35.7778H41.3071C41.9891 35.7778 42.3921 36.1828 42.3921 36.7388C42.3921 37.2348 41.9891 37.7928 41.3071 37.7928H36.7966V37.7948Z" fill="white" />
                                                        <path d="M48.4375 52.3125H11.625V54.25H48.4375C49.5031 54.25 50.375 53.3781 50.375 52.3125V50.375C50.375 51.4406 49.5031 52.3125 48.4375 52.3125Z" fill="#CAD1D8" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->خطاب الترسية
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Item-->
                        <div class="separator separator-dashed my-5"></div>
                        @endif
                        @if ($row->status_id == 3)
                        <div class="d-flex flex-stack">
                            <div class="d-flex">
                                <div class="d-flex flex-column">
                                    <div class="fs-6 fw-semibold text-muted">
                                        <div class="card-toolbar">
                                            <a href="{{ asset('storage/' . $project_finanical_estimate->finance_file) }}" class="btn btn-sm btn-flex btn-light-warning">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen035.svg-->
                                                <span class="svg-icon svg-icon-3">
                                                    <svg width="62" height="62" viewBox="0 0 62 62" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M15.5 0C13.3687 0 11.625 1.74375 11.625 3.875V58.125C11.625 60.2562 13.3687 62 15.5 62H54.25C56.3812 62 58.125 60.2562 58.125 58.125V15.5L42.625 0H15.5Z" fill="#E2E5E7" />
                                                        <path d="M46.5 15.5H58.125L42.625 0V11.625C42.625 13.7563 44.3687 15.5 46.5 15.5Z" fill="#B0B7BD" />
                                                        <path d="M58.125 27.125L46.5 15.5H58.125V27.125Z" fill="#CAD1D8" />
                                                        <path d="M50.375 50.375C50.375 51.4406 49.5031 52.3125 48.4375 52.3125H5.8125C4.74687 52.3125 3.875 51.4406 3.875 50.375V31C3.875 29.9344 4.74687 29.0625 5.8125 29.0625H48.4375C49.5031 29.0625 50.375 29.9344 50.375 31V50.375Z" fill="#F15642" />
                                                        <path d="M12.3203 36.7099C12.3203 36.1984 12.7233 35.6404 13.3724 35.6404H16.9509C18.9659 35.6404 20.7794 36.9889 20.7794 39.5735C20.7794 42.0225 18.9659 43.3865 16.9509 43.3865H14.3644V45.4325C14.3644 46.1145 13.9304 46.5001 13.3724 46.5001C12.8609 46.5001 12.3203 46.1145 12.3203 45.4325V36.7099ZM14.3644 37.5914V41.4509H16.9509C17.9894 41.4509 18.8109 40.5345 18.8109 39.5735C18.8109 38.4904 17.9894 37.5914 16.9509 37.5914H14.3644Z" fill="white" />
                                                        <path d="M23.8136 46.5C23.3021 46.5 22.7441 46.221 22.7441 45.5409V36.7408C22.7441 36.1847 23.3021 35.7798 23.8136 35.7798H27.3612C34.4408 35.7798 34.2858 46.5 27.5007 46.5H23.8136ZM24.7901 37.6708V44.6109H27.3612C31.5443 44.6109 31.7303 37.6708 27.3612 37.6708H24.7901Z" fill="white" />
                                                        <path d="M36.7966 37.7948V40.2573H40.7472C41.3052 40.2573 41.8632 40.8153 41.8632 41.3559C41.8632 41.8674 41.3052 42.2859 40.7472 42.2859H36.7966V45.539C36.7966 46.0815 36.4111 46.498 35.8686 46.498C35.1866 46.498 34.77 46.0815 34.77 45.539V36.7388C34.77 36.1828 35.1885 35.7778 35.8686 35.7778H41.3071C41.9891 35.7778 42.3921 36.1828 42.3921 36.7388C42.3921 37.2348 41.9891 37.7928 41.3071 37.7928H36.7966V37.7948Z" fill="white" />
                                                        <path d="M48.4375 52.3125H11.625V54.25H48.4375C49.5031 54.25 50.375 53.3781 50.375 52.3125V50.375C50.375 51.4406 49.5031 52.3125 48.4375 52.3125Z" fill="#CAD1D8" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->ملف العرض المالي
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="separator separator-dashed my-5"></div>
                        <!--begin::Item-->
                        @endif
                        <!--begin::Item-->
                        <div class="d-flex flex-stack">
                            <div class="d-flex">
                                <div class="d-flex flex-column">
                                    <div class="fs-6 fw-semibold text-muted">
                                        <div class="card-toolbar">
                                            <a href="{{ asset('storage/' . $row->rfp) }}" class="btn btn-sm btn-flex btn-light-warning">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen035.svg-->
                                                <span class="svg-icon svg-icon-3">
                                                    <svg width="62" height="62" viewBox="0 0 62 62" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M15.5 0C13.3687 0 11.625 1.74375 11.625 3.875V58.125C11.625 60.2562 13.3687 62 15.5 62H54.25C56.3812 62 58.125 60.2562 58.125 58.125V15.5L42.625 0H15.5Z" fill="#E2E5E7" />
                                                        <path d="M46.5 15.5H58.125L42.625 0V11.625C42.625 13.7563 44.3687 15.5 46.5 15.5Z" fill="#B0B7BD" />
                                                        <path d="M58.125 27.125L46.5 15.5H58.125V27.125Z" fill="#CAD1D8" />
                                                        <path d="M50.375 50.375C50.375 51.4406 49.5031 52.3125 48.4375 52.3125H5.8125C4.74687 52.3125 3.875 51.4406 3.875 50.375V31C3.875 29.9344 4.74687 29.0625 5.8125 29.0625H48.4375C49.5031 29.0625 50.375 29.9344 50.375 31V50.375Z" fill="#F15642" />
                                                        <path d="M12.3203 36.7099C12.3203 36.1984 12.7233 35.6404 13.3724 35.6404H16.9509C18.9659 35.6404 20.7794 36.9889 20.7794 39.5735C20.7794 42.0225 18.9659 43.3865 16.9509 43.3865H14.3644V45.4325C14.3644 46.1145 13.9304 46.5001 13.3724 46.5001C12.8609 46.5001 12.3203 46.1145 12.3203 45.4325V36.7099ZM14.3644 37.5914V41.4509H16.9509C17.9894 41.4509 18.8109 40.5345 18.8109 39.5735C18.8109 38.4904 17.9894 37.5914 16.9509 37.5914H14.3644Z" fill="white" />
                                                        <path d="M23.8136 46.5C23.3021 46.5 22.7441 46.221 22.7441 45.5409V36.7408C22.7441 36.1847 23.3021 35.7798 23.8136 35.7798H27.3612C34.4408 35.7798 34.2858 46.5 27.5007 46.5H23.8136ZM24.7901 37.6708V44.6109H27.3612C31.5443 44.6109 31.7303 37.6708 27.3612 37.6708H24.7901Z" fill="white" />
                                                        <path d="M36.7966 37.7948V40.2573H40.7472C41.3052 40.2573 41.8632 40.8153 41.8632 41.3559C41.8632 41.8674 41.3052 42.2859 40.7472 42.2859H36.7966V45.539C36.7966 46.0815 36.4111 46.498 35.8686 46.498C35.1866 46.498 34.77 46.0815 34.77 45.539V36.7388C34.77 36.1828 35.1885 35.7778 35.8686 35.7778H41.3071C41.9891 35.7778 42.3921 36.1828 42.3921 36.7388C42.3921 37.2348 41.9891 37.7928 41.3071 37.7928H36.7966V37.7948Z" fill="white" />
                                                        <path d="M48.4375 52.3125H11.625V54.25H48.4375C49.5031 54.25 50.375 53.3781 50.375 52.3125V50.375C50.375 51.4406 49.5031 52.3125 48.4375 52.3125Z" fill="#CAD1D8" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->{{ __('project.rfp') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Item-->
                        @if (!empty($row->additional_questions))
                        <div class="separator separator-dashed my-5"></div>
                        <div class="d-flex flex-stack">
                            <div class="d-flex">
                                <div class="d-flex flex-column">
                                    <div class="fs-6 fw-semibold text-muted">
                                        <div class="card-toolbar">
                                            <a href="{{ asset('storage/' . $row->additional_questions) }}" class="btn btn-sm btn-flex btn-light-warning">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen035.svg-->
                                                <span class="svg-icon svg-icon-3">
                                                    <svg width="62" height="62" viewBox="0 0 62 62" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M15.5 0C13.3687 0 11.625 1.74375 11.625 3.875V58.125C11.625 60.2562 13.3687 62 15.5 62H54.25C56.3812 62 58.125 60.2562 58.125 58.125V15.5L42.625 0H15.5Z" fill="#E2E5E7" />
                                                        <path d="M46.5 15.5H58.125L42.625 0V11.625C42.625 13.7563 44.3687 15.5 46.5 15.5Z" fill="#B0B7BD" />
                                                        <path d="M58.125 27.125L46.5 15.5H58.125V27.125Z" fill="#CAD1D8" />
                                                        <path d="M50.375 50.375C50.375 51.4406 49.5031 52.3125 48.4375 52.3125H5.8125C4.74687 52.3125 3.875 51.4406 3.875 50.375V31C3.875 29.9344 4.74687 29.0625 5.8125 29.0625H48.4375C49.5031 29.0625 50.375 29.9344 50.375 31V50.375Z" fill="#F15642" />
                                                        <path d="M12.3203 36.7099C12.3203 36.1984 12.7233 35.6404 13.3724 35.6404H16.9509C18.9659 35.6404 20.7794 36.9889 20.7794 39.5735C20.7794 42.0225 18.9659 43.3865 16.9509 43.3865H14.3644V45.4325C14.3644 46.1145 13.9304 46.5001 13.3724 46.5001C12.8609 46.5001 12.3203 46.1145 12.3203 45.4325V36.7099ZM14.3644 37.5914V41.4509H16.9509C17.9894 41.4509 18.8109 40.5345 18.8109 39.5735C18.8109 38.4904 17.9894 37.5914 16.9509 37.5914H14.3644Z" fill="white" />
                                                        <path d="M23.8136 46.5C23.3021 46.5 22.7441 46.221 22.7441 45.5409V36.7408C22.7441 36.1847 23.3021 35.7798 23.8136 35.7798H27.3612C34.4408 35.7798 34.2858 46.5 27.5007 46.5H23.8136ZM24.7901 37.6708V44.6109H27.3612C31.5443 44.6109 31.7303 37.6708 27.3612 37.6708H24.7901Z" fill="white" />
                                                        <path d="M36.7966 37.7948V40.2573H40.7472C41.3052 40.2573 41.8632 40.8153 41.8632 41.3559C41.8632 41.8674 41.3052 42.2859 40.7472 42.2859H36.7966V45.539C36.7966 46.0815 36.4111 46.498 35.8686 46.498C35.1866 46.498 34.77 46.0815 34.77 45.539V36.7388C34.77 36.1828 35.1885 35.7778 35.8686 35.7778H41.3071C41.9891 35.7778 42.3921 36.1828 42.3921 36.7388C42.3921 37.2348 41.9891 37.7928 41.3071 37.7928H36.7966V37.7948Z" fill="white" />
                                                        <path d="M48.4375 52.3125H11.625V54.25H48.4375C49.5031 54.25 50.375 53.3781 50.375 52.3125V50.375C50.375 51.4406 49.5031 52.3125 48.4375 52.3125Z" fill="#CAD1D8" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->{{ __('project.additional_questions') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--begin::Item-->
                        @endif
                        <div class="separator separator-dashed my-5"></div>
                        <!--begin::Item-->
                        <div class="d-flex flex-stack">
                            <div class="d-flex">
                                <div class="d-flex flex-column">
                                    <div class="fs-6 fw-semibold text-muted">
                                        <div class="card-toolbar">
                                            <a href="{{ asset('storage/' . $row->requirements_specifications) }}" class="btn btn-sm btn-flex btn-light-warning">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen035.svg-->
                                                <span class="svg-icon svg-icon-3">
                                                    <svg width="62" height="62" viewBox="0 0 62 62" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M15.5 0C13.3687 0 11.625 1.74375 11.625 3.875V58.125C11.625 60.2562 13.3687 62 15.5 62H54.25C56.3812 62 58.125 60.2562 58.125 58.125V15.5L42.625 0H15.5Z" fill="#E2E5E7" />
                                                        <path d="M46.5 15.5H58.125L42.625 0V11.625C42.625 13.7563 44.3687 15.5 46.5 15.5Z" fill="#B0B7BD" />
                                                        <path d="M58.125 27.125L46.5 15.5H58.125V27.125Z" fill="#CAD1D8" />
                                                        <path d="M50.375 50.375C50.375 51.4406 49.5031 52.3125 48.4375 52.3125H5.8125C4.74687 52.3125 3.875 51.4406 3.875 50.375V31C3.875 29.9344 4.74687 29.0625 5.8125 29.0625H48.4375C49.5031 29.0625 50.375 29.9344 50.375 31V50.375Z" fill="#F15642" />
                                                        <path d="M12.3203 36.7099C12.3203 36.1984 12.7233 35.6404 13.3724 35.6404H16.9509C18.9659 35.6404 20.7794 36.9889 20.7794 39.5735C20.7794 42.0225 18.9659 43.3865 16.9509 43.3865H14.3644V45.4325C14.3644 46.1145 13.9304 46.5001 13.3724 46.5001C12.8609 46.5001 12.3203 46.1145 12.3203 45.4325V36.7099ZM14.3644 37.5914V41.4509H16.9509C17.9894 41.4509 18.8109 40.5345 18.8109 39.5735C18.8109 38.4904 17.9894 37.5914 16.9509 37.5914H14.3644Z" fill="white" />
                                                        <path d="M23.8136 46.5C23.3021 46.5 22.7441 46.221 22.7441 45.5409V36.7408C22.7441 36.1847 23.3021 35.7798 23.8136 35.7798H27.3612C34.4408 35.7798 34.2858 46.5 27.5007 46.5H23.8136ZM24.7901 37.6708V44.6109H27.3612C31.5443 44.6109 31.7303 37.6708 27.3612 37.6708H24.7901Z" fill="white" />
                                                        <path d="M36.7966 37.7948V40.2573H40.7472C41.3052 40.2573 41.8632 40.8153 41.8632 41.3559C41.8632 41.8674 41.3052 42.2859 40.7472 42.2859H36.7966V45.539C36.7966 46.0815 36.4111 46.498 35.8686 46.498C35.1866 46.498 34.77 46.0815 34.77 45.539V36.7388C34.77 36.1828 35.1885 35.7778 35.8686 35.7778H41.3071C41.9891 35.7778 42.3921 36.1828 42.3921 36.7388C42.3921 37.2348 41.9891 37.7928 41.3071 37.7928H36.7966V37.7948Z" fill="white" />
                                                        <path d="M48.4375 52.3125H11.625V54.25H48.4375C49.5031 54.25 50.375 53.3781 50.375 52.3125V50.375C50.375 51.4406 49.5031 52.3125 48.4375 52.3125Z" fill="#CAD1D8" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->{{ __('project.requirements_specifications') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Item-->
                        @if ($row->type_id == 1 || $row->type_id == 2 || $row->type_id == 10)
                        <div class="separator separator-dashed my-5"></div>
                        <div class="d-flex flex-stack">
                            <div class="d-flex">
                                <div class="d-flex flex-column">
                                    <div class="fs-6 fw-semibold text-muted">
                                        <div class="card-toolbar">
                                            <a href="{{ asset('storage/' . $row->google_map) }}" class="btn btn-sm btn-flex btn-light-warning">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen035.svg-->
                                                <span class="svg-icon svg-icon-3">
                                                    <svg width="62" height="62" viewBox="0 0 62 62" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M15.5 0C13.3687 0 11.625 1.74375 11.625 3.875V58.125C11.625 60.2562 13.3687 62 15.5 62H54.25C56.3812 62 58.125 60.2562 58.125 58.125V15.5L42.625 0H15.5Z" fill="#E2E5E7" />
                                                        <path d="M46.5 15.5H58.125L42.625 0V11.625C42.625 13.7563 44.3687 15.5 46.5 15.5Z" fill="#B0B7BD" />
                                                        <path d="M58.125 27.125L46.5 15.5H58.125V27.125Z" fill="#CAD1D8" />
                                                        <path d="M50.375 50.375C50.375 51.4406 49.5031 52.3125 48.4375 52.3125H5.8125C4.74687 52.3125 3.875 51.4406 3.875 50.375V31C3.875 29.9344 4.74687 29.0625 5.8125 29.0625H48.4375C49.5031 29.0625 50.375 29.9344 50.375 31V50.375Z" fill="#F15642" />
                                                        <path d="M12.3203 36.7099C12.3203 36.1984 12.7233 35.6404 13.3724 35.6404H16.9509C18.9659 35.6404 20.7794 36.9889 20.7794 39.5735C20.7794 42.0225 18.9659 43.3865 16.9509 43.3865H14.3644V45.4325C14.3644 46.1145 13.9304 46.5001 13.3724 46.5001C12.8609 46.5001 12.3203 46.1145 12.3203 45.4325V36.7099ZM14.3644 37.5914V41.4509H16.9509C17.9894 41.4509 18.8109 40.5345 18.8109 39.5735C18.8109 38.4904 17.9894 37.5914 16.9509 37.5914H14.3644Z" fill="white" />
                                                        <path d="M23.8136 46.5C23.3021 46.5 22.7441 46.221 22.7441 45.5409V36.7408C22.7441 36.1847 23.3021 35.7798 23.8136 35.7798H27.3612C34.4408 35.7798 34.2858 46.5 27.5007 46.5H23.8136ZM24.7901 37.6708V44.6109H27.3612C31.5443 44.6109 31.7303 37.6708 27.3612 37.6708H24.7901Z" fill="white" />
                                                        <path d="M36.7966 37.7948V40.2573H40.7472C41.3052 40.2573 41.8632 40.8153 41.8632 41.3559C41.8632 41.8674 41.3052 42.2859 40.7472 42.2859H36.7966V45.539C36.7966 46.0815 36.4111 46.498 35.8686 46.498C35.1866 46.498 34.77 46.0815 34.77 45.539V36.7388C34.77 36.1828 35.1885 35.7778 35.8686 35.7778H41.3071C41.9891 35.7778 42.3921 36.1828 42.3921 36.7388C42.3921 37.2348 41.9891 37.7928 41.3071 37.7928H36.7966V37.7948Z" fill="white" />
                                                        <path d="M48.4375 52.3125H11.625V54.25H48.4375C49.5031 54.25 50.375 53.3781 50.375 52.3125V50.375C50.375 51.4406 49.5031 52.3125 48.4375 52.3125Z" fill="#CAD1D8" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->{{ __('project.google_map') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Item-->
                        @endif
                        @if ((($row->type_id >= 2 && $row->type_id <= 5) || $row->type_id == 2) && !empty($project_local_development->research_survey))
                        <div class="separator separator-dashed my-5"></div>
                        <div class="d-flex flex-stack">
                            <div class="d-flex">
                                <div class="d-flex flex-column">
                                    <div class="fs-6 fw-semibold text-muted">
                                        <div class="card-toolbar">
                                            <a href="{{ asset('storage/' . $project_local_development->research_survey) }}" class="btn btn-sm btn-flex btn-light-warning">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen035.svg-->
                                                <span class="svg-icon svg-icon-3">
                                                    <svg width="62" height="62" viewBox="0 0 62 62" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M15.5 0C13.3687 0 11.625 1.74375 11.625 3.875V58.125C11.625 60.2562 13.3687 62 15.5 62H54.25C56.3812 62 58.125 60.2562 58.125 58.125V15.5L42.625 0H15.5Z" fill="#E2E5E7" />
                                                        <path d="M46.5 15.5H58.125L42.625 0V11.625C42.625 13.7563 44.3687 15.5 46.5 15.5Z" fill="#B0B7BD" />
                                                        <path d="M58.125 27.125L46.5 15.5H58.125V27.125Z" fill="#CAD1D8" />
                                                        <path d="M50.375 50.375C50.375 51.4406 49.5031 52.3125 48.4375 52.3125H5.8125C4.74687 52.3125 3.875 51.4406 3.875 50.375V31C3.875 29.9344 4.74687 29.0625 5.8125 29.0625H48.4375C49.5031 29.0625 50.375 29.9344 50.375 31V50.375Z" fill="#F15642" />
                                                        <path d="M12.3203 36.7099C12.3203 36.1984 12.7233 35.6404 13.3724 35.6404H16.9509C18.9659 35.6404 20.7794 36.9889 20.7794 39.5735C20.7794 42.0225 18.9659 43.3865 16.9509 43.3865H14.3644V45.4325C14.3644 46.1145 13.9304 46.5001 13.3724 46.5001C12.8609 46.5001 12.3203 46.1145 12.3203 45.4325V36.7099ZM14.3644 37.5914V41.4509H16.9509C17.9894 41.4509 18.8109 40.5345 18.8109 39.5735C18.8109 38.4904 17.9894 37.5914 16.9509 37.5914H14.3644Z" fill="white" />
                                                        <path d="M23.8136 46.5C23.3021 46.5 22.7441 46.221 22.7441 45.5409V36.7408C22.7441 36.1847 23.3021 35.7798 23.8136 35.7798H27.3612C34.4408 35.7798 34.2858 46.5 27.5007 46.5H23.8136ZM24.7901 37.6708V44.6109H27.3612C31.5443 44.6109 31.7303 37.6708 27.3612 37.6708H24.7901Z" fill="white" />
                                                        <path d="M36.7966 37.7948V40.2573H40.7472C41.3052 40.2573 41.8632 40.8153 41.8632 41.3559C41.8632 41.8674 41.3052 42.2859 40.7472 42.2859H36.7966V45.539C36.7966 46.0815 36.4111 46.498 35.8686 46.498C35.1866 46.498 34.77 46.0815 34.77 45.539V36.7388C34.77 36.1828 35.1885 35.7778 35.8686 35.7778H41.3071C41.9891 35.7778 42.3921 36.1828 42.3921 36.7388C42.3921 37.2348 41.9891 37.7928 41.3071 37.7928H36.7966V37.7948Z" fill="white" />
                                                        <path d="M48.4375 52.3125H11.625V54.25H48.4375C49.5031 54.25 50.375 53.3781 50.375 52.3125V50.375C50.375 51.4406 49.5031 52.3125 48.4375 52.3125Z" fill="#CAD1D8" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->{{ __('project.form') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if ($row->type_id == 14 && !empty($training->trainee_list))
                        <div class="separator separator-dashed my-5"></div>
                        <div class="d-flex flex-stack">
                            <div class="d-flex">
                                <div class="d-flex flex-column">
                                    <div class="fs-6 fw-semibold text-muted">
                                        <div class="card-toolbar">
                                            <a href="{{ asset('storage/' . $training->trainee_list) }}" class="btn btn-sm btn-flex btn-light-warning">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen035.svg-->
                                                <span class="svg-icon svg-icon-3">
                                                    <svg width="62" height="62" viewBox="0 0 62 62" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M15.5 0C13.3687 0 11.625 1.74375 11.625 3.875V58.125C11.625 60.2562 13.3687 62 15.5 62H54.25C56.3812 62 58.125 60.2562 58.125 58.125V15.5L42.625 0H15.5Z" fill="#E2E5E7" />
                                                        <path d="M46.5 15.5H58.125L42.625 0V11.625C42.625 13.7563 44.3687 15.5 46.5 15.5Z" fill="#B0B7BD" />
                                                        <path d="M58.125 27.125L46.5 15.5H58.125V27.125Z" fill="#CAD1D8" />
                                                        <path d="M50.375 50.375C50.375 51.4406 49.5031 52.3125 48.4375 52.3125H5.8125C4.74687 52.3125 3.875 51.4406 3.875 50.375V31C3.875 29.9344 4.74687 29.0625 5.8125 29.0625H48.4375C49.5031 29.0625 50.375 29.9344 50.375 31V50.375Z" fill="#F15642" />
                                                        <path d="M12.3203 36.7099C12.3203 36.1984 12.7233 35.6404 13.3724 35.6404H16.9509C18.9659 35.6404 20.7794 36.9889 20.7794 39.5735C20.7794 42.0225 18.9659 43.3865 16.9509 43.3865H14.3644V45.4325C14.3644 46.1145 13.9304 46.5001 13.3724 46.5001C12.8609 46.5001 12.3203 46.1145 12.3203 45.4325V36.7099ZM14.3644 37.5914V41.4509H16.9509C17.9894 41.4509 18.8109 40.5345 18.8109 39.5735C18.8109 38.4904 17.9894 37.5914 16.9509 37.5914H14.3644Z" fill="white" />
                                                        <path d="M23.8136 46.5C23.3021 46.5 22.7441 46.221 22.7441 45.5409V36.7408C22.7441 36.1847 23.3021 35.7798 23.8136 35.7798H27.3612C34.4408 35.7798 34.2858 46.5 27.5007 46.5H23.8136ZM24.7901 37.6708V44.6109H27.3612C31.5443 44.6109 31.7303 37.6708 27.3612 37.6708H24.7901Z" fill="white" />
                                                        <path d="M36.7966 37.7948V40.2573H40.7472C41.3052 40.2573 41.8632 40.8153 41.8632 41.3559C41.8632 41.8674 41.3052 42.2859 40.7472 42.2859H36.7966V45.539C36.7966 46.0815 36.4111 46.498 35.8686 46.498C35.1866 46.498 34.77 46.0815 34.77 45.539V36.7388C34.77 36.1828 35.1885 35.7778 35.8686 35.7778H41.3071C41.9891 35.7778 42.3921 36.1828 42.3921 36.7388C42.3921 37.2348 41.9891 37.7928 41.3071 37.7928H36.7966V37.7948Z" fill="white" />
                                                        <path d="M48.4375 52.3125H11.625V54.25H48.4375C49.5031 54.25 50.375 53.3781 50.375 52.3125V50.375C50.375 51.4406 49.5031 52.3125 48.4375 52.3125Z" fill="#CAD1D8" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->قائمة المتدربين
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="separator separator-dashed my-5"></div>
                        <div class="d-flex flex-stack">
                            <div class="d-flex">
                                <div class="d-flex flex-column">
                                    <div class="fs-6 fw-semibold text-muted">
                                        <div class="card-toolbar">
                                            <a href="{{ asset('storage/' . $training->training_agenda) }}" class="btn btn-sm btn-flex btn-light-warning">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen035.svg-->
                                                <span class="svg-icon svg-icon-3">
                                                    <svg width="62" height="62" viewBox="0 0 62 62" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M15.5 0C13.3687 0 11.625 1.74375 11.625 3.875V58.125C11.625 60.2562 13.3687 62 15.5 62H54.25C56.3812 62 58.125 60.2562 58.125 58.125V15.5L42.625 0H15.5Z" fill="#E2E5E7" />
                                                        <path d="M46.5 15.5H58.125L42.625 0V11.625C42.625 13.7563 44.3687 15.5 46.5 15.5Z" fill="#B0B7BD" />
                                                        <path d="M58.125 27.125L46.5 15.5H58.125V27.125Z" fill="#CAD1D8" />
                                                        <path d="M50.375 50.375C50.375 51.4406 49.5031 52.3125 48.4375 52.3125H5.8125C4.74687 52.3125 3.875 51.4406 3.875 50.375V31C3.875 29.9344 4.74687 29.0625 5.8125 29.0625H48.4375C49.5031 29.0625 50.375 29.9344 50.375 31V50.375Z" fill="#F15642" />
                                                        <path d="M12.3203 36.7099C12.3203 36.1984 12.7233 35.6404 13.3724 35.6404H16.9509C18.9659 35.6404 20.7794 36.9889 20.7794 39.5735C20.7794 42.0225 18.9659 43.3865 16.9509 43.3865H14.3644V45.4325C14.3644 46.1145 13.9304 46.5001 13.3724 46.5001C12.8609 46.5001 12.3203 46.1145 12.3203 45.4325V36.7099ZM14.3644 37.5914V41.4509H16.9509C17.9894 41.4509 18.8109 40.5345 18.8109 39.5735C18.8109 38.4904 17.9894 37.5914 16.9509 37.5914H14.3644Z" fill="white" />
                                                        <path d="M23.8136 46.5C23.3021 46.5 22.7441 46.221 22.7441 45.5409V36.7408C22.7441 36.1847 23.3021 35.7798 23.8136 35.7798H27.3612C34.4408 35.7798 34.2858 46.5 27.5007 46.5H23.8136ZM24.7901 37.6708V44.6109H27.3612C31.5443 44.6109 31.7303 37.6708 27.3612 37.6708H24.7901Z" fill="white" />
                                                        <path d="M36.7966 37.7948V40.2573H40.7472C41.3052 40.2573 41.8632 40.8153 41.8632 41.3559C41.8632 41.8674 41.3052 42.2859 40.7472 42.2859H36.7966V45.539C36.7966 46.0815 36.4111 46.498 35.8686 46.498C35.1866 46.498 34.77 46.0815 34.77 45.539V36.7388C34.77 36.1828 35.1885 35.7778 35.8686 35.7778H41.3071C41.9891 35.7778 42.3921 36.1828 42.3921 36.7388C42.3921 37.2348 41.9891 37.7928 41.3071 37.7928H36.7966V37.7948Z" fill="white" />
                                                        <path d="M48.4375 52.3125H11.625V54.25H48.4375C49.5031 54.25 50.375 53.3781 50.375 52.3125V50.375C50.375 51.4406 49.5031 52.3125 48.4375 52.3125Z" fill="#CAD1D8" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->ملف الأجندة
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if ($row->type_id == 9 && @empty(!$project_empower_charity->charity_list_file))
                        <div class="separator separator-dashed my-5"></div>
                        <div class="d-flex flex-stack">
                            <div class="d-flex">
                                <div class="d-flex flex-column">
                                    <div class="fs-6 fw-semibold text-muted">
                                        <div class="card-toolbar">
                                            <a href="{{ asset('storage/' . $project_empower_charity->charity_list_file) }}" class="btn btn-sm btn-flex btn-light-warning">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen035.svg-->
                                                <span class="svg-icon svg-icon-3">
                                                    <svg width="62" height="62" viewBox="0 0 62 62" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M15.5 0C13.3687 0 11.625 1.74375 11.625 3.875V58.125C11.625 60.2562 13.3687 62 15.5 62H54.25C56.3812 62 58.125 60.2562 58.125 58.125V15.5L42.625 0H15.5Z" fill="#E2E5E7" />
                                                        <path d="M46.5 15.5H58.125L42.625 0V11.625C42.625 13.7563 44.3687 15.5 46.5 15.5Z" fill="#B0B7BD" />
                                                        <path d="M58.125 27.125L46.5 15.5H58.125V27.125Z" fill="#CAD1D8" />
                                                        <path d="M50.375 50.375C50.375 51.4406 49.5031 52.3125 48.4375 52.3125H5.8125C4.74687 52.3125 3.875 51.4406 3.875 50.375V31C3.875 29.9344 4.74687 29.0625 5.8125 29.0625H48.4375C49.5031 29.0625 50.375 29.9344 50.375 31V50.375Z" fill="#F15642" />
                                                        <path d="M12.3203 36.7099C12.3203 36.1984 12.7233 35.6404 13.3724 35.6404H16.9509C18.9659 35.6404 20.7794 36.9889 20.7794 39.5735C20.7794 42.0225 18.9659 43.3865 16.9509 43.3865H14.3644V45.4325C14.3644 46.1145 13.9304 46.5001 13.3724 46.5001C12.8609 46.5001 12.3203 46.1145 12.3203 45.4325V36.7099ZM14.3644 37.5914V41.4509H16.9509C17.9894 41.4509 18.8109 40.5345 18.8109 39.5735C18.8109 38.4904 17.9894 37.5914 16.9509 37.5914H14.3644Z" fill="white" />
                                                        <path d="M23.8136 46.5C23.3021 46.5 22.7441 46.221 22.7441 45.5409V36.7408C22.7441 36.1847 23.3021 35.7798 23.8136 35.7798H27.3612C34.4408 35.7798 34.2858 46.5 27.5007 46.5H23.8136ZM24.7901 37.6708V44.6109H27.3612C31.5443 44.6109 31.7303 37.6708 27.3612 37.6708H24.7901Z" fill="white" />
                                                        <path d="M36.7966 37.7948V40.2573H40.7472C41.3052 40.2573 41.8632 40.8153 41.8632 41.3559C41.8632 41.8674 41.3052 42.2859 40.7472 42.2859H36.7966V45.539C36.7966 46.0815 36.4111 46.498 35.8686 46.498C35.1866 46.498 34.77 46.0815 34.77 45.539V36.7388C34.77 36.1828 35.1885 35.7778 35.8686 35.7778H41.3071C41.9891 35.7778 42.3921 36.1828 42.3921 36.7388C42.3921 37.2348 41.9891 37.7928 41.3071 37.7928H36.7966V37.7948Z" fill="white" />
                                                        <path d="M48.4375 52.3125H11.625V54.25H48.4375C49.5031 54.25 50.375 53.3781 50.375 52.3125V50.375C50.375 51.4406 49.5031 52.3125 48.4375 52.3125Z" fill="#CAD1D8" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->قائمة الجمعيات
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if ($row->type_id == 1 && @empty(!$project_family_development->family_list))
                        <div class="separator separator-dashed my-5"></div>
                        <div class="d-flex flex-stack">
                            <div class="d-flex">
                                <div class="d-flex flex-column">
                                    <div class="fs-6 fw-semibold text-muted">
                                        <div class="card-toolbar">
                                            <a href="{{ asset('storage/' . $project_family_development->family_list) }}" class="btn btn-sm btn-flex btn-light-warning">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen035.svg-->
                                                <span class="svg-icon svg-icon-3">
                                                    <svg width="62" height="62" viewBox="0 0 62 62" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M15.5 0C13.3687 0 11.625 1.74375 11.625 3.875V58.125C11.625 60.2562 13.3687 62 15.5 62H54.25C56.3812 62 58.125 60.2562 58.125 58.125V15.5L42.625 0H15.5Z" fill="#E2E5E7" />
                                                        <path d="M46.5 15.5H58.125L42.625 0V11.625C42.625 13.7563 44.3687 15.5 46.5 15.5Z" fill="#B0B7BD" />
                                                        <path d="M58.125 27.125L46.5 15.5H58.125V27.125Z" fill="#CAD1D8" />
                                                        <path d="M50.375 50.375C50.375 51.4406 49.5031 52.3125 48.4375 52.3125H5.8125C4.74687 52.3125 3.875 51.4406 3.875 50.375V31C3.875 29.9344 4.74687 29.0625 5.8125 29.0625H48.4375C49.5031 29.0625 50.375 29.9344 50.375 31V50.375Z" fill="#F15642" />
                                                        <path d="M12.3203 36.7099C12.3203 36.1984 12.7233 35.6404 13.3724 35.6404H16.9509C18.9659 35.6404 20.7794 36.9889 20.7794 39.5735C20.7794 42.0225 18.9659 43.3865 16.9509 43.3865H14.3644V45.4325C14.3644 46.1145 13.9304 46.5001 13.3724 46.5001C12.8609 46.5001 12.3203 46.1145 12.3203 45.4325V36.7099ZM14.3644 37.5914V41.4509H16.9509C17.9894 41.4509 18.8109 40.5345 18.8109 39.5735C18.8109 38.4904 17.9894 37.5914 16.9509 37.5914H14.3644Z" fill="white" />
                                                        <path d="M23.8136 46.5C23.3021 46.5 22.7441 46.221 22.7441 45.5409V36.7408C22.7441 36.1847 23.3021 35.7798 23.8136 35.7798H27.3612C34.4408 35.7798 34.2858 46.5 27.5007 46.5H23.8136ZM24.7901 37.6708V44.6109H27.3612C31.5443 44.6109 31.7303 37.6708 27.3612 37.6708H24.7901Z" fill="white" />
                                                        <path d="M36.7966 37.7948V40.2573H40.7472C41.3052 40.2573 41.8632 40.8153 41.8632 41.3559C41.8632 41.8674 41.3052 42.2859 40.7472 42.2859H36.7966V45.539C36.7966 46.0815 36.4111 46.498 35.8686 46.498C35.1866 46.498 34.77 46.0815 34.77 45.539V36.7388C34.77 36.1828 35.1885 35.7778 35.8686 35.7778H41.3071C41.9891 35.7778 42.3921 36.1828 42.3921 36.7388C42.3921 37.2348 41.9891 37.7928 41.3071 37.7928H36.7966V37.7948Z" fill="white" />
                                                        <path d="M48.4375 52.3125H11.625V54.25H48.4375C49.5031 54.25 50.375 53.3781 50.375 52.3125V50.375C50.375 51.4406 49.5031 52.3125 48.4375 52.3125Z" fill="#CAD1D8" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->قائمة الأسر
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if ($row->type_id == 2 && @empty(!$project_local_development->coordinate_file))
                        <div class="separator separator-dashed my-5"></div>
                        <div class="d-flex flex-stack">
                            <div class="d-flex">
                                <div class="d-flex flex-column">
                                    <div class="fs-6 fw-semibold text-muted">
                                        <div class="card-toolbar">
                                            <a href="{{ asset('storage/' . $project_local_development->coordinate_file) }}" class="btn btn-sm btn-flex btn-light-warning">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen035.svg-->
                                                <span class="svg-icon svg-icon-3">
                                                    <svg width="62" height="62" viewBox="0 0 62 62" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M15.5 0C13.3687 0 11.625 1.74375 11.625 3.875V58.125C11.625 60.2562 13.3687 62 15.5 62H54.25C56.3812 62 58.125 60.2562 58.125 58.125V15.5L42.625 0H15.5Z" fill="#E2E5E7" />
                                                        <path d="M46.5 15.5H58.125L42.625 0V11.625C42.625 13.7563 44.3687 15.5 46.5 15.5Z" fill="#B0B7BD" />
                                                        <path d="M58.125 27.125L46.5 15.5H58.125V27.125Z" fill="#CAD1D8" />
                                                        <path d="M50.375 50.375C50.375 51.4406 49.5031 52.3125 48.4375 52.3125H5.8125C4.74687 52.3125 3.875 51.4406 3.875 50.375V31C3.875 29.9344 4.74687 29.0625 5.8125 29.0625H48.4375C49.5031 29.0625 50.375 29.9344 50.375 31V50.375Z" fill="#F15642" />
                                                        <path d="M12.3203 36.7099C12.3203 36.1984 12.7233 35.6404 13.3724 35.6404H16.9509C18.9659 35.6404 20.7794 36.9889 20.7794 39.5735C20.7794 42.0225 18.9659 43.3865 16.9509 43.3865H14.3644V45.4325C14.3644 46.1145 13.9304 46.5001 13.3724 46.5001C12.8609 46.5001 12.3203 46.1145 12.3203 45.4325V36.7099ZM14.3644 37.5914V41.4509H16.9509C17.9894 41.4509 18.8109 40.5345 18.8109 39.5735C18.8109 38.4904 17.9894 37.5914 16.9509 37.5914H14.3644Z" fill="white" />
                                                        <path d="M23.8136 46.5C23.3021 46.5 22.7441 46.221 22.7441 45.5409V36.7408C22.7441 36.1847 23.3021 35.7798 23.8136 35.7798H27.3612C34.4408 35.7798 34.2858 46.5 27.5007 46.5H23.8136ZM24.7901 37.6708V44.6109H27.3612C31.5443 44.6109 31.7303 37.6708 27.3612 37.6708H24.7901Z" fill="white" />
                                                        <path d="M36.7966 37.7948V40.2573H40.7472C41.3052 40.2573 41.8632 40.8153 41.8632 41.3559C41.8632 41.8674 41.3052 42.2859 40.7472 42.2859H36.7966V45.539C36.7966 46.0815 36.4111 46.498 35.8686 46.498C35.1866 46.498 34.77 46.0815 34.77 45.539V36.7388C34.77 36.1828 35.1885 35.7778 35.8686 35.7778H41.3071C41.9891 35.7778 42.3921 36.1828 42.3921 36.7388C42.3921 37.2348 41.9891 37.7928 41.3071 37.7928H36.7966V37.7948Z" fill="white" />
                                                        <path d="M48.4375 52.3125H11.625V54.25H48.4375C49.5031 54.25 50.375 53.3781 50.375 52.3125V50.375C50.375 51.4406 49.5031 52.3125 48.4375 52.3125Z" fill="#CAD1D8" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->ملف الإحداثيات
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <!--end::Row-->
            </div>
            <!--end::Tab panel-->
        </div>
        <!--end::Tab content-->
    </div>
    <!--end::essential information-->

    @if(!Auth::user()->hasRole('observer') && !Auth::user()->hasRole('inspector') && $row->type_id != 14)
    <!--begin::Opening & closing tabs-->
    <div class="card mb-xl-8">
        <!--begin::Card header-->
        <div class="card-header card-header-stretch pb-0">
            <!--begin::Toolbar-->
            <div class="card-toolbar m-0">
                <!--begin::Tab nav-->
                <ul class="nav nav-stretch nav-line-tabs border-transparent" role="tablist">
                    <!--begin::Tab item-->
                    <li class="nav-item" role="presentation">
                        <a id="kt_admin_opening_tab" class="nav-link fs-2 fw-bold me-5 active" data-bs-toggle="tab" role="tab" href="#kt_opening">إفتتاح مشروع</a>
                    </li>
                    <!--end::Tab item-->
                    <!--begin::Tab item-->
                    <li class="nav-item" role="presentation">
                        <a id="kt_report_closing_tab" class="nav-link fs-2 fw-bold" data-bs-toggle="tab" role="tab" href="#kt_closing">إغلاق مشروع</a>
                    </li>
                    <!--end::Tab item-->
                </ul>
                <!--end::Tab nav-->
            </div>
            <!--end::Toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Tab content-->
        <div id="kt_billing_payment_tab_content" class="card-body tab-content">
            <!--begin::Tab panel-->
            <div id="kt_opening" class="tab-pane fade show active" role="tabpanel">
                <!--begin::Items-->
                <div class="py-2">
                    <!--begin::Item-->
                    <div class="d-flex flex-stack">
                        <div class="d-flex">
                            <div class="d-flex flex-column">
                                <span class="fs-5 text-dark text-hover-primary fw-bold">{{ __('project.opening') }}</span>
                                <div class="fs-6 fw-semibold text-muted">
                                    {{ $row->opening == 1 ? __('site.yes') : __('site.no') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Item-->
                    @php
                    if($row->opening == 1) {
                    @endphp
                    <div class="separator separator-dashed my-5"></div>
                    <!--begin::Item-->
                    <div class="d-flex flex-stack">
                        <div class="d-flex">
                            <div class="d-flex flex-column">
                                <a href="#" class="fs-5 text-dark text-hover-primary fw-bold">{{ __('project.reserve_hall') }}</a>
                                <div class="fs-6 fw-semibold text-muted">
                                    {{ $row->opening_reserve_hall == 1 ? __('site.yes') : __('site.no') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Item-->
                    <div class="separator separator-dashed my-5"></div>
                    <!--begin::Item-->
                    <div class="d-flex flex-stack">
                        <div class="d-flex">
                            <div class="d-flex flex-column">
                                <a href="#" class="fs-5 text-dark text-hover-primary fw-bold">{{ __('project.attendance_nature') }}</a>
                                <div class="fs-6 fw-semibold text-muted">
                                    {{ __('project.' . $row->opening_attendance_nature) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="separator separator-dashed my-5"></div>
                    <div class="d-flex flex-stack">
                        <div class="d-flex">
                            <div class="d-flex flex-column">
                                <a href="#" class="fs-5 text-dark text-hover-primary fw-bold">{{ __('project.opening_date') }}</a>
                                <div class="fs-6 fw-semibold text-muted">{{ $row->opening_date }}</div>
                            </div>
                        </div>
                    </div>
                    <!--end::Item-->
                    @php } @endphp
                </div>
                <!--end::Items-->
            </div>
            <!--end::Tab panel-->
            <!--begin::Tab panel-->
            <div id="kt_closing" class="tab-pane fade" role="tabpanel" aria-labelledby="kt_report_closing_tab">
                <!--begin::Row-->
                <div class="row gx-9 gy-6">
                    <!--begin::Items-->
                    <div class="py-2">
                        <!--begin::Item-->
                        <div class="d-flex flex-stack">
                            <div class="d-flex">

                                <div class="d-flex flex-column">
                                    <span class="fs-5 text-dark text-hover-primary fw-bold">{{ __('project.closing') }}</span>
                                    <div class="fs-6 fw-semibold text-muted">
                                        {{ $row->closing == 1 ? __('site.yes') : __('site.no') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Item-->
                        @php
                        if($row->closing == 1) {
                        @endphp
                        <div class="separator separator-dashed my-5"></div>
                        <!--begin::Item-->
                        <div class="d-flex flex-stack">
                            <div class="d-flex">
                                <div class="d-flex flex-column">
                                    <a href="#" class="fs-5 text-dark text-hover-primary fw-bold">{{ __('project.reserve_hall') }}</a>
                                    <div class="fs-6 fw-semibold text-muted">
                                        {{ $row->closing_reserve_hall == 1 ? __('site.yes') : __('site.no') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Item-->
                        <div class="separator separator-dashed my-5"></div>
                        <!--begin::Item-->
                        <div class="d-flex flex-stack">
                            <div class="d-flex">
                                <div class="d-flex flex-column">
                                    <a href="#" class="fs-5 text-dark text-hover-primary fw-bold">{{ __('project.attendance_nature') }}</a>
                                    <div class="fs-6 fw-semibold text-muted">
                                        {{ __('project.' . $row->closing_attendance_nature) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="separator separator-dashed my-5"></div>
                        <div class="d-flex flex-stack">
                            <div class="d-flex">

                                <div class="d-flex flex-column">
                                    <a href="#" class="fs-5 text-dark text-hover-primary fw-bold">{{ __('project.closing_date') }}</a>
                                    <div class="fs-6 fw-semibold text-muted">{{ $row->closing_date }}</div>
                                </div>
                            </div>
                        </div>
                        <!--end::Item-->
                        @php } @endphp
                    </div>
                    <!--end::Items-->
                </div>
                <!--end::Row-->
            </div>
            <!--end::Tab panel-->
        </div>
        <!--end::Tab content-->
    </div>
    <!--end::Opening & closing tabs-->
    @endif
</div>
<!--end::Sidebar-->

@if(!empty($project_explore_tour->city) && $row->status_id == 2)
<!--begin::Modal - contact information-->
@include('partials.backoffice.contact-information-modal')
<!--end::Modals - contact information-->
@endif