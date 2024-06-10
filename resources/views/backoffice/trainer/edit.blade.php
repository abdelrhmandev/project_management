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

                    @if ($row->type_id != 13 && $row->type_id != 14)
                        <!--begin::Content-->
                        <div class="tab-pane fade show active">
                            @include('partials.backoffice.research-details')

                            @if ($row->type_id != 12)
                                @include('partials.backoffice.kashef-accounts')
                            @else
                                @include('partials.backoffice.survey-accounts')
                            @endif

                            <div class="g-5 g-xl-8">
                                <!--begin::Col-->
                                <div class="col-xl-12">
                                    <div class="card card-xl-stretch mb-xl-8">
                                        <div class="card-header pt-5">
                                            <h3 class="card-title align-items-start flex-column">
                                                <span class="card-label fw-bold fs-3 mb-1">روابط التدريب</span>
                                            </h3>
                                            <div class="card-toolbar">
                                                <ul class="nav">
                                                    <li class="nav-item d-flex">
                                                        <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#kt_modal_training_url">إضافة رابط تدريب</a>
                                                        <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light-primary active fw-bold" data-bs-toggle="tab" href="#kt_table_widget_7_tab_1">{{ count($training_urls) }}</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="card-body pt-0">
                                            <div class="mt-5 gap-5">
                                                <a href="#" class="text-hover-primary me-5 mb-2 text-gray-400">
                                                    <span class="svg-icon svg-icon-4 me-1">
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path opacity="0.3" d="M18.0624 15.3453L13.1624 20.7453C12.5624 21.4453 11.5624 21.4453 10.9624 20.7453L6.06242 15.3453C4.56242 13.6453 3.76242 11.4453 4.06242 8.94534C4.56242 5.34534 7.46242 2.44534 11.0624 2.04534C15.8624 1.54534 19.9624 5.24534 19.9624 9.94534C20.0624 12.0453 19.2624 13.9453 18.0624 15.3453Z" fill="currentColor" />
                                                            <path d="M12.0624 13.0453C13.7193 13.0453 15.0624 11.7022 15.0624 10.0453C15.0624 8.38849 13.7193 7.04535 12.0624 7.04535C10.4056 7.04535 9.06241 8.38849 9.06241 10.0453C9.06241 11.7022 10.4056 13.0453 12.0624 13.0453Z" fill="currentColor" />
                                                        </svg>
                                                    </span>تاريخ تدريب الباحثين
                                                    {{ $financial_bid_estimate->observer_training_date }}
                                                </a>
                                                <a href="#" class="text-hover-primary me-5 mb-2 text-gray-400">
                                                    <span class="svg-icon svg-icon-4 me-1">
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path opacity="0.3" d="M18.0624 15.3453L13.1624 20.7453C12.5624 21.4453 11.5624 21.4453 10.9624 20.7453L6.06242 15.3453C4.56242 13.6453 3.76242 11.4453 4.06242 8.94534C4.56242 5.34534 7.46242 2.44534 11.0624 2.04534C15.8624 1.54534 19.9624 5.24534 19.9624 9.94534C20.0624 12.0453 19.2624 13.9453 18.0624 15.3453Z" fill="currentColor" />
                                                            <path d="M12.0624 13.0453C13.7193 13.0453 15.0624 11.7022 15.0624 10.0453C15.0624 8.38849 13.7193 7.04535 12.0624 7.04535C10.4056 7.04535 9.06241 8.38849 9.06241 10.0453C9.06241 11.7022 10.4056 13.0453 12.0624 13.0453Z" fill="currentColor" />
                                                        </svg>
                                                    </span>تاريخ تدريب المدققين
                                                    {{ $financial_bid_estimate->auditor_training_date }}
                                                </a>
                                            </div>
                                        </div>

                                        <div class="card-body py-3">
                                            <div class="tab-content">
                                                <div class="tab-pane fade show active" id="kt_table_widget_7_tab_1">
                                                    <div class="table-responsive">
                                                        <table class="gs-0 gy-3 mb-4 table align-middle">
                                                            <thead>
                                                                <tr class="fw-bold text-muted">
                                                                    <th class="min-w-120px p-0">عنوان التدريب</th>
                                                                    <th class="min-w-120px p-0">فئة التدريب</th>
                                                                    <th class="min-w-120px p-0">رابط التدريب</th>
                                                                    <th class="min-w-120px p-0 text-end">الخيارات</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($training_urls as $training_url)
                                                                    <tr>
                                                                        <td>
                                                                            <span class="text-dark fw-bold fs-6 mb-1">{{ $training_url->title }}</span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="text-dark fw-bold fs-6 mb-1">{{ $team_ranks->where('id', $training_url->type_id)->first()->trans }}</span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="text-dark fw-bold fs-6 mb-1">{{ $training_url->url }}</span>
                                                                        </td>
                                                                        <td class="text-end">
                                                                            <a href="#" onclick="deleteTrainingUrl(this)" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                                                                                <input type="hidden" id="urlId" value="{{ $training_url->id }}" />
                                                                                <span class="svg-icon svg-icon-3">
                                                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                        <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor" />
                                                                                        <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor" />
                                                                                        <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor" />
                                                                                    </svg>
                                                                                </span>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                @if ($financial_bid_estimate->observer_training_date <= Carbon\Carbon::now() && count($training_urls->where('type_id', 5)) > 0)
                                    <div class="col-xl-12">
                                        <div class="card card-xl-stretch mb-xl-8">
                                            <div class="card-header pt-5">
                                                <h3 class="card-title align-items-start flex-column">
                                                    <span class="card-label fw-bold fs-3 mb-1">الرجاء تحديد الباحثين المتلقين للتدريب</span>
                                                </h3>
                                            </div>
                                            <div class="card-body py-3">
                                                <form class="form" action="{{ url('trainer/save-received-train') }}" novalidate="novalidate" method="post">
                                                    @csrf
                                                    <input type="hidden" name="project_id" id="project_id" value="{{ $row->id }}" />
                                                    <input type="hidden" name="type_id" id="type_id" value="4" />
                                                    <div data-kt-search-element="results">
                                                        <div class="mh-375px scroll-y me-n7 pe-7">
                                                            @foreach ($selected_researchers as $selected_researcher)
                                                                <div class="d-flex flex-stack bg-active-lighten rounded p-4" data-user-id="0">
                                                                    <div class="d-flex align-items-center">
                                                                        <label class="form-check form-check-custom form-check-solid me-5">
                                                                            <input class="form-check-input" type="checkbox" name="user-checkbox[]" id="researcher{{ $selected_researcher->team_user_id }}" value="{{ $selected_researcher->team_user_id }}" data-kt-check="true" data-kt-check-target="[data-user-id='{{ $selected_researcher->team_user_id }}']" {{ $selected_researcher->received_train == '1' ? 'checked' : '' }} />
                                                                        </label>
                                                                        <div class="ms-5">
                                                                            <a href="#" class="fs-5 fw-bold text-hover-primary mb-2 text-gray-900">{{ $attracting_teams->where('id', $selected_researcher->team_user_id)->first()->name ?? '' }}</a>
                                                                            <div class="fw-semibold text-muted">
                                                                                {{ $attracting_teams->where('id', $selected_researcher->team_user_id)->first()->email ?? '' }}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="fw-semibold text-muted">
                                                                        @if ($selected_researcher->received_train == '1')
                                                                            <span class="w-80px badge badge-light-success me-4">قد تم تحضيره</span>
                                                                        @else
                                                                            <span class="w-80px badge badge-light-danger me-4">لم يتم تحضيره</span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="border-bottom border-bottom-dashed border-gray-300">
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer mt-8 mb-3">
                                                        <button type="submit" class="btn btn-primary me-3">حفظ الباحثين المتلقين للتدريب</button>
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if ($financial_bid_estimate->auditor_training_date <= Carbon\Carbon::now() && count($training_urls->where('type_id', 3)) > 0)
                                    <div class="col-xl-12">
                                        <div class="card card-xl-stretch mb-xl-8">
                                            <div class="card-header pt-5">
                                                <h3 class="card-title align-items-start flex-column">
                                                    <span class="card-label fw-bold fs-3 mb-1">الرجاء تحديد المدققين المتلقين للتدريب</span>
                                                </h3>
                                            </div>
                                            <div class="card-body py-3">
                                                <form class="form" action="{{ url('trainer/save-received-train') }}" novalidate="novalidate" method="post">
                                                    @csrf
                                                    <input type="hidden" name="project_id" id="project_id" value="{{ $row->id }}" />
                                                    <input type="hidden" name="type_id" id="type_id" value="5" />
                                                    <div data-kt-search-element="results">
                                                        <div class="mh-375px scroll-y me-n7 pe-7">
                                                            @foreach ($selected_auditors as $selected_auditor)
                                                                <div class="d-flex flex-stack bg-active-lighten rounded p-4" data-user-id="0">
                                                                    <div class="d-flex align-items-center">
                                                                        <label class="form-check form-check-custom form-check-solid me-5">
                                                                            <input class="form-check-input" type="checkbox" name="user-checkbox[]" id="auditor{{ $selected_auditor->team_user_id }}" value="{{ $selected_auditor->team_user_id }}" data-kt-check="true" data-kt-check-target="[data-user-id='{{ $selected_auditor->team_user_id }}']" {{ $selected_auditor->received_train == '1' ? 'checked' : '' }} />
                                                                        </label>
                                                                        <div class="ms-5">
                                                                            <a href="#" class="fs-5 fw-bold text-hover-primary mb-2 text-gray-900">{{ $attracting_teams->where('id', $selected_auditor->team_user_id)->first()->name ?? '' }}</a>
                                                                            <div class="fw-semibold text-muted">
                                                                                {{ $attracting_teams->where('id', $selected_auditor->team_user_id)->first()->email ?? '' }}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="fw-semibold text-muted">
                                                                        @if ($selected_auditor->received_train == '1')
                                                                            <span class="w-80px badge badge-light-success me-4">قد تم تحضيره</span>
                                                                        @else
                                                                            <span class="w-80px badge badge-light-danger me-4">لم يتم تحضيره</span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="border-bottom border-bottom-dashed border-gray-300">
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer mt-8 mb-3">
                                                        <button type="submit" class="btn btn-primary me-3">حفظ المدققين المتلقين للتدريب</button>
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <!--end::Col-->
                                @if ($financial_bid_estimate->observer_training_date <= Carbon\Carbon::now() && $financial_bid_estimate->auditor_training_date <= Carbon\Carbon::now())
                                    <form class="form" action="{{ url('trainer/hand-offer-task') }}" enctype="multipart/form-data" novalidate="novalidate" method="post">
                                        @csrf
                                        <input type="hidden" name="project_id" id="project_id" value="{{ $row->id }}" />
                                        <div class="mt-8 text-center">
                                            <div class="notice d-flex bg-light-warning border-warning min-w-lg-600px flex-shrink-0 rounded border border-dashed p-6">
                                                <!--begin::Icon-->
                                                <!--begin::Svg Icon | path: icons/duotune/coding/cod004.svg-->
                                                <span class="svg-icon svg-icon-2tx svg-icon-primary me-4">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.3" d="M19.0687 17.9688H11.0687C10.4687 17.9688 10.0687 18.3687 10.0687 18.9688V19.9688C10.0687 20.5687 10.4687 20.9688 11.0687 20.9688H19.0687C19.6687 20.9688 20.0687 20.5687 20.0687 19.9688V18.9688C20.0687 18.3687 19.6687 17.9688 19.0687 17.9688Z" fill="currentColor" />
                                                        <path d="M4.06875 17.9688C3.86875 17.9688 3.66874 17.8688 3.46874 17.7688C2.96874 17.4688 2.86875 16.8688 3.16875 16.3688L6.76874 10.9688L3.16875 5.56876C2.86875 5.06876 2.96874 4.46873 3.46874 4.16873C3.96874 3.86873 4.56875 3.96878 4.86875 4.46878L8.86875 10.4688C9.06875 10.7688 9.06875 11.2688 8.86875 11.5688L4.86875 17.5688C4.66875 17.7688 4.36875 17.9688 4.06875 17.9688Z" fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                                <!--end::Icon-->
                                                <!--begin::Wrapper-->
                                                <div class="d-flex flex-stack flex-grow-1 flex-md-nowrap flex-wrap">
                                                    <!--begin::Content-->
                                                    <div class="mb-md-0 fw-semibold mb-3">
                                                        <h4 class="fw-bold text-gray-900">حتى تتمكن من إنهاء المهمة يجب عليك </h4>
                                                        <div class="fs-6 pe-7 text-gray-700">
                                                            تحديد علي الاقل شحص من الباحثين المتلقين للتدريب
                                                            <p>
                                                                تحديد علي الاقل شحص من المدققين المتلقين للتدريب
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <!--end::Content-->
                                                    <!--begin::Action-->
                                                    <button type="submit" id="kt_edit_project_submit" class="btn btn-warning" {{ $is_observer_auditor_team_ready > 0 ? '' : '' }}>إنهاء وتسليم المهمة</button>
                                                    <!--end::Action-->
                                                </div>
                                                <!--end::Wrapper-->
                                            </div>
                                        </div>
                                    </form>
                                @else
                                    <div class="notice d-flex bg-light-warning border-warning min-w-lg-600px flex-shrink-0 rounded border border-dashed p-6">
                                        <!--begin::Icon-->
                                        <!--begin::Svg Icon | path: icons/duotune/coding/cod004.svg-->
                                        <span class="svg-icon svg-icon-2tx svg-icon-primary me-4">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.3" d="M19.0687 17.9688H11.0687C10.4687 17.9688 10.0687 18.3687 10.0687 18.9688V19.9688C10.0687 20.5687 10.4687 20.9688 11.0687 20.9688H19.0687C19.6687 20.9688 20.0687 20.5687 20.0687 19.9688V18.9688C20.0687 18.3687 19.6687 17.9688 19.0687 17.9688Z" fill="currentColor" />
                                                <path d="M4.06875 17.9688C3.86875 17.9688 3.66874 17.8688 3.46874 17.7688C2.96874 17.4688 2.86875 16.8688 3.16875 16.3688L6.76874 10.9688L3.16875 5.56876C2.86875 5.06876 2.96874 4.46873 3.46874 4.16873C3.96874 3.86873 4.56875 3.96878 4.86875 4.46878L8.86875 10.4688C9.06875 10.7688 9.06875 11.2688 8.86875 11.5688L4.86875 17.5688C4.66875 17.7688 4.36875 17.9688 4.06875 17.9688Z" fill="currentColor" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                        <!--end::Icon-->
                                        <!--begin::Wrapper-->
                                        <div class="d-flex flex-stack flex-grow-1 flex-md-nowrap flex-wrap">
                                            <!--begin::Content-->
                                            <div class="mb-md-0 fw-semibold mb-3">
                                                <h4 class="fw-bold text-gray-900">حتى تتمكن من إنهاء المهمة يجب عليك </h4>
                                                <div class="fs-6 pe-7 text-gray-700">
                                                    تحديد علي الاقل شحص من الباحثين المتلقين للتدريب
                                                    <p>
                                                        تحديد علي الاقل شحص من المدققين المتلقين للتدريب
                                                    </p>
                                                </div>
                                            </div>
                                            <!--end::Content-->
                                            <!--begin::Action-->
                                            <button type="submit" id="kt_edit_project_submit" class="btn btn-warning" {{ $is_observer_auditor_team_ready > 0 ? '' : '' }}>إنهاء وتسليم المهمة</button>
                                            <!--end::Action-->
                                        </div>
                                        <!--end::Wrapper-->
                                    </div>
                                @endif
                            </div>
                        </div>
                        <!--end::Content-->
                    @else
                        <div class="row g-5 g-xl-8 d-none">
                            <div class="col-xl-6">
                                <div class="card mb-xl-8">
                                    <div class="card-header">
                                        <h3 class="card-title align-items-start flex-column">
                                            <span class="card-label fw-bold fs-3 mb-1">المدربين</span>
                                        </h3>
                                    </div>
                                    <div class="card-body py-3">
                                        <div class="tab-content">
                                            <div class="tab-pane fade show active" id="kt_table_widget_7_tab_1">
                                                <div class="table-responsive">
                                                    <table class="observer gs-0 gy-3 table align-middle">
                                                        <thead>
                                                            <tr class="fw-bold text-muted">
                                                                <th class="min-w-50px p-0">المدرب</th>
                                                                <th class="min-w-10px p-0 text-end">الخيارات</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if (!empty($training->trainer_id))
                                                                <tr>
                                                                    <td>
                                                                        <span class="text-dark fw-bold fs-6 mb-1">{{ $training->user[0]->name }}</span>
                                                                    </td>
                                                                    <td class="text-end">
                                                                        <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm" onclick="deleteTrainer(this)">
                                                                            <input type="hidden" id="trainer_id" value="{{ $training->trainer_id }}" name="trainer_id" />
                                                                            <span class="svg-icon svg-icon-3">
                                                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                    <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor" />
                                                                                    <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor" />
                                                                                    <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor" />
                                                                                </svg>
                                                                            </span>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                    <div class="d-flex flex-center mb-2">
                                                        <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#kt_modal_trainer">إدارة المدربين</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-5 g-xl-8">
                            <input type="hidden" name="training_plan" id="training_plan" value="{{ $training->training_plan ?? '' }}" />
                            <div class="col-xl-6">
                                <div class="card mb-xl-8">
                                    <div class="card-header">
                                        <h3 class="card-title align-items-start flex-column">
                                            <span class="card-label fw-bold fs-3 mb-1">ملف الخطة التدريبية</span>
                                        </h3>
                                    </div>
                                    <div class="card-body py-3">
                                        <div class="tab-content">
                                            <div class="tab-pane fade show active" id="kt_table_widget_7_tab_1">
                                                <div class="table-responsive">
                                                    <!--begin::Form-->
                                                    <div class="fv-row">
                                                        <!--begin::Dropzone-->
                                                        <div class="dropzone" id="training_plan_file">
                                                            <!--begin::Message-->
                                                            <div class="dz-message needsclick">
                                                                <!--begin::Icon-->
                                                                <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                                                <!--end::Icon-->
                                                                <!--begin::Info-->
                                                                <div class="ms-4">
                                                                    <h3 class="fs-5 fw-bold mb-1 text-gray-900">الرجاء رفع ملف الخطة التدريبية هنا</h3>
                                                                </div>
                                                                <!--end::Info-->
                                                            </div>
                                                        </div>
                                                        <!--end::Dropzone-->
                                                    </div>
                                                    <!--end::Form-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="user_manual" id="user_manual" value="{{ $training->user_manual ?? '' }}" />
                            <div class="col-xl-6">
                                <div class="card mb-xl-8">
                                    <div class="card-header">
                                        <h3 class="card-title align-items-start flex-column">
                                            <span class="card-label fw-bold fs-3 mb-1">ملف دليل المستخدم</span>
                                        </h3>
                                    </div>
                                    <div class="card-body py-3">
                                        <div class="tab-content">
                                            <div class="tab-pane fade show active" id="kt_table_widget_7_tab_2">
                                                <div class="table-responsive">
                                                    <!--begin::Form-->
                                                    <div class="fv-row">
                                                        <!--begin::Dropzone-->
                                                        <div class="dropzone" id="user_manual_file">
                                                            <!--begin::Message-->
                                                            <div class="dz-message needsclick">
                                                                <!--begin::Icon-->
                                                                <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                                                <!--end::Icon-->
                                                                <!--begin::Info-->
                                                                <div class="ms-4">
                                                                    <h3 class="fs-5 fw-bold mb-1 text-gray-900">الرجاء رفع ملف دليل المستخدم هنا</h3>
                                                                </div>
                                                                <!--end::Info-->
                                                            </div>
                                                        </div>
                                                        <!--end::Dropzone-->
                                                    </div>
                                                    <!--end::Form-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-5 g-xl-8">
                            <input type="hidden" name="training_material" id="training_material" value="{{ $training->training_material ?? '' }}" />
                            <div class="col-xl-6">
                                <div class="card mb-xl-8">
                                    <div class="card-header">
                                        <h3 class="card-title align-items-start flex-column">
                                            <span class="card-label fw-bold fs-3 mb-1">ملف دليل المستخدم</span>
                                        </h3>
                                    </div>
                                    <div class="card-body py-3">
                                        <div class="tab-content">
                                            <div class="tab-pane fade show active" id="kt_table_widget_7_tab_3">
                                                <div class="table-responsive">
                                                    <!--begin::Form-->
                                                    <div class="fv-row">
                                                        <!--begin::Dropzone-->
                                                        <div class="dropzone" id="training_material_file">
                                                            <!--begin::Message-->
                                                            <div class="dz-message needsclick">
                                                                <!--begin::Icon-->
                                                                <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                                                <!--end::Icon-->
                                                                <!--begin::Info-->
                                                                <div class="ms-4">
                                                                    <h3 class="fs-5 fw-bold mb-1 text-gray-900">الرجاء رفع ملف دليل المستخدم هنا</h3>
                                                                </div>
                                                                <!--end::Info-->
                                                            </div>
                                                        </div>
                                                        <!--end::Dropzone-->
                                                    </div>
                                                    <!--end::Form-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="training_report" id="training_report" value="{{ $training->training_report ?? '' }}" />
                            <div class="col-xl-6">
                                <div class="card mb-xl-8">
                                    <div class="card-header">
                                        <h3 class="card-title align-items-start flex-column">
                                            <span class="card-label fw-bold fs-3 mb-1">تقرير التدريب</span>
                                        </h3>
                                    </div>
                                    <div class="card-body py-3">
                                        <div class="tab-content">
                                            <div class="tab-pane fade show active" id="kt_table_widget_7_tab_4">
                                                <div class="table-responsive">
                                                    <!--begin::Form-->
                                                    <div class="fv-row">
                                                        <!--begin::Dropzone-->
                                                        <div class="dropzone" id="training_report_file">
                                                            <!--begin::Message-->
                                                            <div class="dz-message needsclick">
                                                                <!--begin::Icon-->
                                                                <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                                                <!--end::Icon-->
                                                                <!--begin::Info-->
                                                                <div class="ms-4">
                                                                    <h3 class="fs-5 fw-bold mb-1 text-gray-900">الرجاء رفع التقرير النهائي للتدريب هنا</h3>
                                                                </div>
                                                                <!--end::Info-->
                                                            </div>
                                                        </div>
                                                        <!--end::Dropzone-->
                                                    </div>
                                                    <!--end::Form-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="g-5 g-xl-8 text-center">
                                <form class="form" id="trainer-hand-offer-task-form" action="{{ route('trainers.endtask') }}" method="post">                                    
                                    <input type="hidden" name="project" value="{{ $row->id }}">
                                    @method('PUT')
                                    @csrf
                                    <button type="submit" class="btn btn-warning me-3" id="trainer-hand-offer-task-btn">إنهاء وتسليم المهمة</button>
                                    <button type="reset" id="kt_edit_project_cancel" class="btn btn-secondary">إلغاء</button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
                <!--end::Content-->
            </div>
            <!--end::Layout-->

            <!--begin::MODALS-->
            <!--begin::Modal - training url-->
            <div class="modal fade" id="kt_modal_training_url" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered mw-1000px">
                    <div class="modal-content">
                        <form class="form" id="trainingForm" data-route-url="{{ url('trainer/training-url') }}" autocomplete="off" method="post" data-redirect-url="{{ url('trainers/' . $row->id . '/edit') }}">
                            @csrf
                            <input type="hidden" name="project_id" id="project_id" value="{{ $row->id }}" />
                            <input type="hidden" name="type_id" id="type_id" value="1" />

                            <div class="modal-header">
                                <h3 class="modal-title">إنشاء رابط تدريب جديد</h3>
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
                                <div class="fv-row mb-8">
                                    <label class="required fs-6 fw-semibold mb-2">عنوان التدريب</label>
                                    <input type="text" class="form-control form-control-solid" name="title" id="title" placeholder="عنوان التدريب" />
                                </div>
                                <div class="fv-row mb-8">
                                    <label class="required d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                                        فئة التدريب
                                    </label>
                                    <select class="form-select form-select-solid" name="type_id" id="type_id" data-control="select2" data-hide-search="true" data-placeholder="فئة التدريب">
                                        <option value="5">الباحثين</option>
                                        <option value="3">المدققين</option>
                                    </select>
                                </div>
                                <div class="my-5 gap-5">
                                    <a href="#" class="me-5 mb-2">
                                        <span class="svg-icon svg-icon-4 me-1">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.3" d="M18.0624 15.3453L13.1624 20.7453C12.5624 21.4453 11.5624 21.4453 10.9624 20.7453L6.06242 15.3453C4.56242 13.6453 3.76242 11.4453 4.06242 8.94534C4.56242 5.34534 7.46242 2.44534 11.0624 2.04534C15.8624 1.54534 19.9624 5.24534 19.9624 9.94534C20.0624 12.0453 19.2624 13.9453 18.0624 15.3453Z" fill="currentColor" />
                                                <path d="M12.0624 13.0453C13.7193 13.0453 15.0624 11.7022 15.0624 10.0453C15.0624 8.38849 13.7193 7.04535 12.0624 7.04535C10.4056 7.04535 9.06241 8.38849 9.06241 10.0453C9.06241 11.7022 10.4056 13.0453 12.0624 13.0453Z" fill="currentColor" />
                                            </svg>
                                        </span>تاريخ تدريب الباحثين
                                        {{ $financial_bid_estimate->observer_training_date }}
                                        <input type="hidden" class="form-control form-control-solid" name="observer_training_date" id="observer_training_date" value="{{ $financial_bid_estimate->observer_training_date }}" />
                                    </a>
                                    <a href="#" class="me-5 mb-2">
                                        <span class="svg-icon svg-icon-4 me-1">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.3" d="M18.0624 15.3453L13.1624 20.7453C12.5624 21.4453 11.5624 21.4453 10.9624 20.7453L6.06242 15.3453C4.56242 13.6453 3.76242 11.4453 4.06242 8.94534C4.56242 5.34534 7.46242 2.44534 11.0624 2.04534C15.8624 1.54534 19.9624 5.24534 19.9624 9.94534C20.0624 12.0453 19.2624 13.9453 18.0624 15.3453Z" fill="currentColor" />
                                                <path d="M12.0624 13.0453C13.7193 13.0453 15.0624 11.7022 15.0624 10.0453C15.0624 8.38849 13.7193 7.04535 12.0624 7.04535C10.4056 7.04535 9.06241 8.38849 9.06241 10.0453C9.06241 11.7022 10.4056 13.0453 12.0624 13.0453Z" fill="currentColor" />
                                            </svg>
                                        </span>تاريخ تدريب المدققين
                                        {{ $financial_bid_estimate->auditor_training_date }}
                                        <input type="hidden" class="form-control form-control-solid" name="auditor_training_date" id="auditor_training_date" value="{{ $financial_bid_estimate->auditor_training_date }}" />
                                    </a>
                                </div>

                                <div class="row g-9 mb-8">
                                    <div class="col-md-6 fv-row">
                                        <label class="required fs-6 fw-semibold mb-2">وقت البدء</label>
                                        <div class="position-relative d-flex align-items-center">
                                            <span class="svg-icon svg-icon-2 position-absolute mx-4">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z" fill="currentColor" />
                                                    <path d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z" fill="currentColor" />
                                                    <path
                                                        d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z"
                                                        fill="currentColor" />
                                                </svg>
                                            </span>
                                            <input class="form-control ps-12" placeholder="تاريخ و وقت البدء" name="start_date" id="start_date" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 fv-row">
                                        <label class="required fs-6 fw-semibold mb-2">وقت النهاية</label>
                                        <div class="position-relative d-flex align-items-center">
                                            <span class="svg-icon svg-icon-2 position-absolute mx-4">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z" fill="currentColor" />
                                                    <path d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z" fill="currentColor" />
                                                    <path
                                                        d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z"
                                                        fill="currentColor" />
                                                </svg>
                                            </span>
                                            <input class="form-control ps-12" placeholder="تاريخ و وقت النهاية" name="end_date" id="end_date" />
                                        </div>
                                    </div>
                                </div>

                                <div class="fv-row mb-8">
                                    <label class="required fs-6 fw-semibold mb-2">رابط التدريب</label>
                                    <input type="text" class="form-control form-control-solid" name="url" id="url" placeholder="رابط التدريب" />
                                </div>

                                <div class="fv-row mb-8">
                                    <!--begin::Wrapper-->
                                    <div class="d-flex flex-stack">
                                        <!--begin::Label-->
                                        <div class="me-5">
                                            <label class="fs-6 fw-semibold text-primary">هل تريد رفع رابط ملف التدريب
                                                ؟</label>
                                        </div>
                                        <!--end::Label-->
                                        <!--begin::Switch-->
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" value="1" name="train_file_url_check" onchange="manageTrain(this,'TrainurlDiv')" />
                                            <span class="form-check-label fw-semibold text-muted">{{ __('site.yes') }}</span>
                                        </label>
                                        <!--end::Switch-->
                                    </div>
                                    <!--end::Wrapper-->
                                </div>

                                <div class="fv-row d-none mb-8" id="TrainurlDiv">
                                    <label class="required fs-6 fw-semibold mb-2">رابط ملف التدريب</label>
                                    <input type="text" class="form-control form-control-solid" name="train_file_url" id="train_file_url" placeholder="رابط التدريب" />
                                </div>

                                <div class="fv-row mb-8">
                                    <!--begin::Wrapper-->
                                    <div class="d-flex flex-stack">
                                        <!--begin::Label-->
                                        <div class="me-5">
                                            <label class="fs-6 fw-semibold text-primary">هل تريد إضافة بيانات برنامج كاشف
                                                ؟</label>
                                        </div>
                                        <!--end::Label-->
                                        <!--begin::Switch-->
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" value="1" name="train_kashef_data_check" onchange="manageTrain(this,'kashefDataDiv')" />
                                            <span class="form-check-label fw-semibold text-muted">{{ __('site.yes') }}</span>
                                        </label>
                                        <!--end::Switch-->
                                    </div>
                                    <!--end::Wrapper-->
                                </div>

                                <div class="d-none" id="kashefDataDiv">
                                    <div class="fv-row d mb-8">
                                        <label class="required fs-6 fw-semibold mb-2">رابط تدريب برنامج كاشف</label>
                                        <input type="text" class="form-control form-control-solid" name="train_kashef_url" id="train_kashef_url" placeholder="رابط تدريب برنامج كاشف" />
                                    </div>
                                    <div class="fv-row d mb-8">
                                        <label class="required fs-6 fw-semibold mb-2">البريد الإلكتروني</label>
                                        <input type="text" class="form-control form-control-solid" name="train_kashef_account_email" id="train_kashef_account_email" placeholder="البريد الإلكتروني" />
                                    </div>
                                    <div class="fv-row d mb-8">
                                        <label class="required fs-6 fw-semibold mb-2">كلمه المرور</label>
                                        <input type="password" class="form-control form-control-solid" name="train_kashef_account_password" id="train_kashef_account_password" placeholder="كلمه المرور" />
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                                <button type="button" class="btn btn-primary" id="kt_page_loading_overlay">إضافة</button>
                            </div>
                        </form>
                    </div>
                    <!--end::MODALS-->
                </div>
            </div>
            <!--end::Modal - training url-->
            <!--begin::Modal - trainer-->
            <div class="modal fade" id="kt_modal_trainer" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered mw-1000px">
                    <div class="modal-content">
                        <form class="form" action="{{ route('trainers.create-team-trainer') }}" novalidate="novalidate" method="POST">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="project_id" id="project_id" value="{{ $row->id }}" />

                            <div class="modal-header">
                                <h3 class="modal-title">إدارة المدربين</h3>
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
                                <!--begin::Results(add d-none to below element to hide the users list by default)-->
                                <div data-kt-search-element="results">
                                    <!--begin::Users-->
                                    <div class="mh-375px scroll-y me-n7 pe-7">
                                        <div class="d-flex flex-stack bg-active-lighten rounded" data-user-id="0">
                                            <div class="d-flex align-items-center">
                                                <label class="form-check form-check-custom form-check-solid">
                                                    <h4>حدد المدرب</h4>
                                                </label>
                                            </div>
                                        </div>

                                        @foreach ($team_members->where('role_id', 12) as $inspector)
                                            <!--begin::User-->
                                            <div class="d-flex flex-stack bg-active-lighten rounded p-4" data-user-id="0">
                                                <!--begin::Details-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Checkbox-->
                                                    <label class="form-check form-check-custom form-check-solid me-5">
                                                        <input class="form-check-input" type="radio" name="user-checkbox" {{ !empty($training) ? ($training->trainer_id != null ? ($training->trainer_id == $inspector->id ? 'checked' : '') : '') : '' }} value="{{ $inspector->id }}" data-kt-check="true" data-kt-check-target="[data-user-id='{{ $inspector->id }}']" />
                                                    </label>
                                                    <!--end::Checkbox-->
                                                    <!--begin::Details-->
                                                    <div class="ms-5">
                                                        <a href="#" class="fs-5 fw-bold text-hover-primary mb-2 text-gray-900">{{ $inspector->name }}</a>
                                                        <div class="fw-semibold text-muted">{{ $inspector->email }}</div>
                                                    </div>
                                                    <!--end::Details-->
                                                </div>
                                                <!--end::Details-->
                                            </div>
                                            <!--end::User-->
                                            <!--begin::Separator-->
                                            <div class="border-bottom border-bottom-dashed border-gray-300"></div>
                                            <!--end::Separator-->
                                        @endforeach
                                    </div>
                                    <!--end::Users-->
                                </div>
                                <!--end::Results-->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                                <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                            </div>
                        </form>
                    </div>
                    <!--end::MODALS-->
                </div>
            </div>
            <!--end::Modal - trainer-->
            <!--end::MODALS-->
        </div>
        @include('partials.obstacle._obstacle')
    </div>
@stop

@section('scripts')
    <script>
        var $project_id = $("#project_id");
        function manageTrain(checkboxItem, TargetDiv) {
            if (checkboxItem.checked) {
                document.getElementById(TargetDiv).classList.remove("d-none");
            } else {
                document.getElementById(TargetDiv).classList.add("d-none");
            }
        }

        var $training_plan = $('#training_plan');
        new Dropzone("#training_plan_file", {
            url: projectBaseUrl + '/trainer/upload-training-files', // Set the url for your upload script location
            paramName: "training_plan",
            method: "post",
            maxFiles: 100,
            maxFilesize: 10, // MB
            addRemoveLinks: true,
            acceptedFiles: "application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/msword,application/pdf,image/*",
            params: {
                'project_id': $project_id.val(),
                'type': 'training_plan'
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            accept: function(file, done) {
                if (file.name == "wow.jpg") {
                    done("Naha, you don't.");
                } else {
                    done();
                }
            },
            init: function() {
                if ($training_plan.val()) {
                    mockFile = {
                        name: projectBaseUrl + '/storage/' + $training_plan.val(),
                        id: 320212,
                        size: 452810,
                        accepted: true,
                        dataURL: projectBaseUrl + '/storage/' + $training_plan.val(),
                        oldFile: $training_plan.val()
                    };
                    this.displayExistingFile(mockFile, mockFile.dataURL);
                    this.files.push(mockFile);
                }
                this.on("removedfile", function(file) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: projectBaseUrl + '/trainer/remove-training-files',
                        dataType: "json",
                        data: {
                            'type': 'training_plan',
                            'project_id': $project_id.val()
                        },
                    });
                });
            }
        });

        var $user_manual = $('#user_manual');
        new Dropzone("#user_manual_file", {
            url: projectBaseUrl + '/trainer/upload-training-files', // Set the url for your upload script location
            paramName: "user_manual",
            method: "post",
            maxFiles: 100,
            maxFilesize: 10, // MB
            addRemoveLinks: true,
            acceptedFiles: "application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/msword,application/pdf,image/*",
            params: {
                'project_id': $project_id.val(),
                'type': 'user_manual'
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            accept: function(file, done) {
                if (file.name == "wow.jpg") {
                    done("Naha, you don't.");
                } else {
                    done();
                }
            },
            init: function() {
                if ($user_manual.val()) {
                    mockFile = {
                        name: projectBaseUrl + '/storage/' + $user_manual.val(),
                        id: 320212,
                        size: 452810,
                        accepted: true,
                        dataURL: projectBaseUrl + '/storage/' + $user_manual.val(),
                        oldFile: $user_manual.val()
                    };
                    this.displayExistingFile(mockFile, mockFile.dataURL);
                    this.files.push(mockFile);
                }
                this.on("removedfile", function(file) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: projectBaseUrl + '/trainer/remove-training-files',
                        dataType: "json",
                        data: {
                            'type': 'user_manual',
                            'project_id': $project_id.val()
                        },
                    });
                });
            }
        });

        var $training_material = $('#training_material');
        new Dropzone("#training_material_file", {
            url: projectBaseUrl + '/trainer/upload-training-files', // Set the url for your upload script location
            paramName: "training_material",
            method: "post",
            maxFiles: 100,
            maxFilesize: 10, // MB
            addRemoveLinks: true,
            acceptedFiles: "application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/msword,application/pdf,image/*",
            params: {
                'project_id': $project_id.val(),
                'type': 'training_material'
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            accept: function(file, done) {
                if (file.name == "wow.jpg") {
                    done("Naha, you don't.");
                } else {
                    done();
                }
            },
            init: function() {
                if ($training_material.val()) {
                    mockFile = {
                        name: projectBaseUrl + '/storage/' + $training_material.val(),
                        id: 320212,
                        size: 452810,
                        accepted: true,
                        dataURL: projectBaseUrl + '/storage/' + $training_material.val(),
                        oldFile: $training_material.val()
                    };
                    this.displayExistingFile(mockFile, mockFile.dataURL);
                    this.files.push(mockFile);
                }
                this.on("removedfile", function(file) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: projectBaseUrl + '/trainer/remove-training-files',
                        dataType: "json",
                        data: {
                            'type': 'training_material',
                            'project_id': $project_id.val()
                        },
                    });
                });
            }
        });

        var $training_report = $('#training_report');
        new Dropzone("#training_report_file", {
            url: projectBaseUrl + '/trainer/upload-training-files', // Set the url for your upload script location
            paramName: "training_report",
            method: "post",
            maxFiles: 100,
            maxFilesize: 10, // MB
            addRemoveLinks: true,
            acceptedFiles: "application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/msword,application/pdf,image/*",
            params: {
                'project_id': $project_id.val(),
                'type': 'training_report'
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            accept: function(file, done) {
                if (file.name == "wow.jpg") {
                    done("Naha, you don't.");
                } else {
                    done();
                }
            },
            init: function() {
                if ($training_report.val()) {
                    mockFile = {
                        name: projectBaseUrl + '/storage/' + $training_report.val(),
                        id: 320212,
                        size: 452810,
                        accepted: true,
                        dataURL: projectBaseUrl + '/storage/' + $training_report.val(),
                        oldFile: $training_report.val()
                    };
                    this.displayExistingFile(mockFile, mockFile.dataURL);
                    this.files.push(mockFile);
                }
                this.on("removedfile", function(file) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: projectBaseUrl + '/trainer/remove-training-files',
                        dataType: "json",
                        data: {
                            'type': 'training_report',
                            'project_id': $project_id.val()
                        },
                    });
                });
            }
        });
    </script>
    <script src="{{ asset('assets/js/custom/account/referrals/referral-program.js') }}"></script>
    <script src="{{ asset('assets/js/custom/backoffice/trainer.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
@stop
