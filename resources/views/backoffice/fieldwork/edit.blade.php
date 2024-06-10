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
                    <div class="tab-pane fade show active">
                
                        @if ($financial_bid_estimate->is_explore_tour_required == '0')
                            @include('partials.backoffice.research-details')
                            @if ($row->type_id != 10 && $row->type_id != 12)
                                @include('partials.backoffice.kashef-accounts')
                            @else
                                @include('partials.backoffice.survey-accounts')
                            @endif
                        @endif

                        <!--begin::Content-->
                        <form action="{{ url('fieldwork/hand-offer-task') }}" enctype="multipart/form-data" novalidate="novalidate" method="post">
                            @csrf
                            <div class="row g-5 g-xl-8">
                                <input type="hidden" name="project_id" id="project_id" value="{{ $row->id }}" />
                                <input type="hidden" name="project_explore_tour" id="project_explore_tour" value="{{ $project_explore_tour->explore_tour ?? '' }}" />
                                <input type="hidden" name="is_tour" id="is_tour" value="{{ $financial_bid_estimate->is_explore_tour_required == '0' ? 'false' : 'true' }}" />
                                <input type="hidden" name="type_id" id="type_id" value="{{ $row->type_id }}" />
                                @if ($row->type_id == 10)
                                    <!--begin::Col-->
                                    <div class="col-xl-6">
                                        <div class="card card-xl-stretch mb-xl-8">
                                            <div class="card-header">
                                                <h3 class="card-title align-items-start flex-column">
                                                    <span class="card-label fw-bold fs-3 mb-1">الفاحصين</span>
                                                </h3>
                                                <div class="card-toolbar">
                                                    <ul class="nav">
                                                        <li class="nav-item">
                                                            <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light-primary active fw-bold me-1 px-4" data-bs-toggle="tab" href="#kt_table_widget_7_tab_1">{{ $fieldwork_teams->count() ?? 0 }}</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="card-body py-3">
                                                <div class="tab-content">
                                                    <div class="tab-pane fade show active" id="kt_table_widget_7_tab_1">
                                                        <div class="table-responsive">
                                                            <table class="observer gs-0 gy-3 table align-middle">
                                                                <thead>
                                                                    <tr class="fw-bold text-muted">
                                                                        <th class="min-w-50px p-0">الفاحص</th>
                                                                        <th class="min-w-10px p-0 text-end">الخيارات</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @if ($fieldwork_teams != null && count($fieldwork_teams) > 0)
                                                                    @foreach($fieldwork_teams as $inspector)  
                                                                    <tr>
                                                                            <td>
                                                                                <span class="text-dark fw-bold fs-6 mb-1">{{ $inspector->name }}</span>
                                                                            </td>
                                                                            <td class="text-end">
                                                                                <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm" onclick="deleteTeamMember(this, false)">
                                                                                    <input type="hidden" id="observer_id" value="{{ $inspector->id }}" name="inspectorId" />
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
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                            <div class="d-flex flex-center mb-2">
                                                                @if (count($fieldwork_teams) == 0)
                                                                    <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#kt_modal_inspector">إدارة
                                                                        الفاحصين</a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Col-->

                                    <!--begin::Col-->
                                    <div class="col-xl-6 fv-row">
                                        <!--begin::Table Widget 7-->
                                        <div class="card card-xl-stretch mb-xl-8">
                                            <!--begin::Header-->
                                            <div class="card-header pt-5">
                                                <span class="required fs-2 fw-bold me-1">تاريخ تنفيذ الزيارة</span>
                                            </div>
                                            <!--end::Header-->
                                            <!--begin::Body-->
                                            <div class="card-body py-3">
                                                <!--begin::Input-->
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
                                                    <input class="form-control form-control-solid ps-12" placeholder="{{ $financial_bid_estimate->inspector_visit_date ?? 'موعد التنفيذ' }}" name="inspector_visit_date" id="inspector_visit_date" />
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Body-->
                                        </div>
                                        <!--end::Tables Widget 7-->
                                    </div>
                                    <!--end::Col-->
                                @endif

                                @if ($financial_bid_estimate->is_explore_tour_required == '1' || ($row->type_id == 9 && $row->type_id != 10))
                                    <!--begin::Col-->
                                    <div class="col-xl-6">
                                        <div class="card card-xl-stretch mb-xl-8">
                                            <div class="card-header">
                                                <h3 class="card-title align-items-start flex-column">
                                                    <span class="card-label fw-bold fs-3 mb-1">المراقب</span>
                                                </h3>
                                                <div class="card-toolbar">
                                                    <ul class="nav">
                                                        <li class="nav-item">
                                                            <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light-primary active fw-bold me-1 px-4" data-bs-toggle="tab" href="#kt_table_widget_7_tab_1">{{ $fieldwork_team->where('type_id', 1)->first()->qty ?? 0 }}</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="card-body py-3">
                                                <div class="tab-content">
                                                    <div class="tab-pane fade show active" id="kt_table_widget_7_tab_1">
                                                        <div class="table-responsive">
                                                            <table class="observer gs-0 gy-3 table align-middle">
                                                                <thead>
                                                                    <tr class="fw-bold text-muted">
                                                                        <th class="min-w-50px p-0">المراقب</th>
                                                                        <th class="min-w-10px p-0 text-end">الخيارات</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @if ($project_explore_tour != null && $project_explore_tour->name != null)
                                                                        <tr>
                                                                            <td>
                                                                                <span class="text-dark fw-bold fs-6 mb-1">{{ $project_explore_tour->name }}</span>
                                                                            </td>
                                                                            <td class="text-end">
                                                                                <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm" onclick="deleteTeamMember(this, true)">
                                                                                    <input type="hidden" id="observer_id" value="{{ $project_explore_tour->id }}" name="observerID" />
                                                                                    <input type="hidden" id="is_tour" value="true" />
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
                                                                    @elseif($row->type_id == 9 && count($fieldwork_teams) > 0)
                                                                        <tr>
                                                                            <td>
                                                                                <span class="text-dark fw-bold fs-6 mb-1">{{ $fieldwork_teams[0]->name }}</span>
                                                                            </td>
                                                                            <td class="text-end">
                                                                                <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm" onclick="deleteTeamMember(this, false)">
                                                                                    <input type="hidden" id="observer_id" value="{{ $fieldwork_teams[0]->id }}" name="observerID" />
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
                                                                @if (count($fieldwork_teams) == 0)
                                                                    <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#kt_modal_observer">إدارة
                                                                        المراقبين</a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!--end::Col-->
                                @endif

                                @if ($financial_bid_estimate->is_explore_tour_required == '1')
                                    <!--begin::Col-->
                                    <div class="col-xl-6">
                                        <div class="card card-xl-stretch mb-xl-8">
                                            <div class="card-header">
                                                <h3 class="card-title align-items-start flex-column">
                                                    <span class="card-label fw-bold fs-3 mb-1">إستمارة الجولة
                                                        الإستكشافية</span>
                                                </h3>
                                            </div>
                                            <div class="card-body py-3">
                                                <div class="tab-content">
                                                    <div class="tab-pane fade show active" id="kt_table_widget_7_tab_1">
                                                        <div class="table-responsive">
                                                            <!--begin::Form-->
                                                            <div class="fv-row">
                                                                <!--begin::Dropzone-->
                                                                <div class="dropzone" id="explore_tour_file">
                                                                    <!--begin::Message-->
                                                                    <div class="dz-message needsclick">
                                                                        <!--begin::Icon-->
                                                                        <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                                                        <!--end::Icon-->
                                                                        <!--begin::Info-->
                                                                        <div class="ms-4">
                                                                            <h3 class="fs-5 fw-bold mb-1 text-gray-900">
                                                                                الرجاء رفع ملف الإستمارة هنا</h3>
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
                                    <!--end::Col-->
                                @elseif ($row->type_id == 12)
                                    <div class="col-xl-12">
                                        <div class="card card-xl-stretch mb-8 p-4">
                                            <label class="form-label">
                                                <label class="form-check align-items-start">
                                                    <!--begin::Input-->
                                                    <input class="form-check-input me-3" type="checkbox" name="is_training_needed" value="1" onchange="manageNeedEspecialTraining(this)" {{ !empty($financial_bid_estimate->is_espeical_training_needed) == 1 ? 'checked' : '' }} />
                                                    <!--end::Input-->
                                                    <!--begin::Label-->
                                                    <span class="form-check-label d-flex flex-column align-items-start">
                                                        <span class="fw-bold fs-5 required mb-0">التدريب الخاص</span>
                                                        <span class="text-muted fs-6">هل هناك حاجة إلى تدريب خاص؟ </span>
                                                    </span>
                                                    <!--end::Label-->
                                                </label>
                                            </label>
                                        </div>
                                    </div>
                                @endif

                                @php
                                    $supervisor_qty = 0;
                                    $researcher_qty = 0;
                                    $auditor_qty = 0;
                                @endphp
                                @if ($row->type_id != 9 && $financial_bid_estimate->is_explore_tour_required == '0' && $row->type_id != 10)
                                    <!--begin::Col-->
                                    <div class="col-xl-6">
                                        <div class="card card-xl-stretch mb-xl-8">
                                            <div class="card-header">
                                                <h3 class="card-title align-items-start flex-column">
                                                    <span class="card-label fw-bold fs-3 mb-1">المراقب</span>
                                                </h3>
                                                <div class="card-toolbar">
                                                    <ul class="nav">
                                                        <li class="nav-item">
                                                            <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light-primary active fw-bold me-1 px-4" data-bs-toggle="tab" href="#kt_table_widget_7_tab_1">{{ $fieldwork_team->where('type_id', 1)->first()->qty ?? 0 }}</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="card-body py-3">
                                                <div class="tab-content">
                                                    <div class="tab-pane fade show active" id="kt_table_widget_7_tab_1">
                                                        <div class="table-responsive">
                                                            <table class="gs-0 gy-3 table align-middle">
                                                                <thead>
                                                                    <tr class="fw-bold text-muted">
                                                                        <th class="min-w-120px p-0">المراقب</th>
                                                                        <th class="min-w-120px p-0">عدد المشرفين</th>
                                                                        <th class="min-w-120px p-0">عدد الباحثين</th>
                                                                        <th class="min-w-120px p-0 text-end">الخيارات</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($fieldwork_teams->where('type_id', 1) as $team)
                                                                        <tr>
                                                                            <td>
                                                                                <span class="text-dark fw-bold fs-6 mb-1">{{ $team->name }}</span>
                                                                            </td>
                                                                            <td>
                                                                                <span class="text-dark fw-bold fs-6 mb-1">{{ $team->supervisor_qty }}</span>
                                                                            </td>
                                                                            <td>
                                                                                <span class="text-dark fw-bold fs-6 mb-1">{{ $team->researcher_qty }}</span>
                                                                            </td>
                                                                            <td class="text-end">
                                                                                <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm" onclick="deleteTeamMember(this)">
                                                                                    <input type="hidden" id="observer_id" value="{{ $team->id }}" />
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
                                                                        @php
                                                                            $supervisor_qty = $supervisor_qty + $team->supervisor_qty;
                                                                            $researcher_qty = $researcher_qty + $team->researcher_qty;
                                                                        @endphp
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                            <div class="d-flex flex-center mb-2">
                                                                <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#kt_modal_observer">إدارة المراقبين</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Col-->

                                    <!--begin::Col-->
                                    <div class="col-xl-6">
                                        <!--begin::Table Widget 7-->
                                        <div class="card card-xl-stretch mb-xl-8">
                                            <!--begin::Header-->
                                            <div class="card-header">
                                                <h3 class="card-title align-items-start flex-column">
                                                    <span class="card-label fw-bold fs-3 mb-1">مراقب التدقيق</span>
                                                </h3>
                                                <div class="card-toolbar">
                                                    <ul class="nav">
                                                        <li class="nav-item">
                                                            <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light-primary active fw-bold me-1 px-4" data-bs-toggle="tab" href="#kt_table_widget_7_tab_1">{{ $fieldwork_team->where('type_id', 2)->first()->qty ?? 0 }}</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <!--end::Header-->
                                            <!--begin::Body-->
                                            <div class="card-body py-3">
                                                <div class="tab-content">
                                                    <!--begin::Tap pane-->
                                                    <div class="tab-pane fade show active" id="kt_table_widget_7_tab_1">
                                                        <!--begin::Table container-->
                                                        <div class="table-responsive">
                                                            <!--begin::Table-->
                                                            <table class="gs-0 gy-3 table align-middle">
                                                                <!--begin::Table head-->
                                                                <thead>
                                                                    <tr class="fw-bold text-muted">
                                                                        <th class="min-w-120px p-0">مراقب التدقيق</th>
                                                                        <th class="min-w-120px p-0">عدد المدققين</th>
                                                                        <th class="min-w-120px p-0 text-end">الخيارات</th>
                                                                    </tr>
                                                                </thead>
                                                                <!--end::Table head-->
                                                                <!--begin::Table body-->
                                                                <tbody>
                                                                    @foreach ($fieldwork_teams->where('type_id', 2) as $team)
                                                                        <tr>
                                                                            <td>
                                                                                <span class="text-dark fw-bold fs-6 mb-1">{{ $team->name }}</span>
                                                                            </td>
                                                                            <td>
                                                                                <span class="text-dark fw-bold fs-6 mb-1">{{ $team->auditor_qty }}</span>
                                                                            </td>
                                                                            <td class="text-end">
                                                                                <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm" onclick="deleteTeamMember(this, false)">
                                                                                    <input type="hidden" id="audit_observer_id" value="{{ $team->id }}" />
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
                                                                        @php
                                                                            $auditor_qty = $auditor_qty + $team->auditor_qty;
                                                                        @endphp
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                            <div class="d-flex flex-center mb-2">
                                                                <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#kt_modal_audit_observer">إدارة مراقبي
                                                                    التدقيق</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--end::Tap pane-->
                                                </div>
                                            </div>
                                            <!--end::Body-->
                                        </div>
                                        <!--end::Tables Widget 7-->
                                    </div>
                                    <!--end::Col-->
                                @endif

                                <input type="hidden" name="project_id" id="project_id" value="{{ $row->id }}" />
                                @if ($row->type_id == 10)
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
                                                    تحديد الفاحصين وموعد التنفيذ
                                                </div>
                                            </div>
                                            <!--end::Content-->
                                            <!--begin::Action-->

                                         
                                            @if (
                                                $financial_bid_estimate->supervisor_qty == $supervisor_qty && 
                                                $financial_bid_estimate->researcher_qty == $researcher_qty && 
                                                $financial_bid_estimate->auditor_qty == $auditor_qty)
                                                <button type="submit" id="kt_edit_project_submit" class="btn btn-warning">إنهاء وتسليم المهمة</button>
                                            @endif
                                            <!--end::Action-->
                                        </div>
                                        <!--end::Wrapper-->
                                    </div>
                                @elseif ($financial_bid_estimate->is_explore_tour_required == '0')
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
                                                    عدد المشرفين ({{ $financial_bid_estimate->supervisor_qty }}) متبقي لك
                                                    ({{ $financial_bid_estimate->supervisor_qty - $supervisor_qty }})
                                                    |
                                                    عدد الباحثين ({{ $financial_bid_estimate->researcher_qty }}) متبقي لك
                                                    ({{ $financial_bid_estimate->researcher_qty - $researcher_qty }})
                                                    |
                                                    عدد المدققين ({{ $financial_bid_estimate->auditor_qty }}) متبقي لك
                                                    ({{ $financial_bid_estimate->auditor_qty - $auditor_qty }})
                                                </div>
                                            </div>
                                            <!--end::Content-->
                                            <!--begin::Action-->
                                            @if ($financial_bid_estimate->supervisor_qty == $supervisor_qty && $financial_bid_estimate->researcher_qty == $researcher_qty && $financial_bid_estimate->auditor_qty == $auditor_qty)
                                                <button type="submit" id="kt_edit_project_submit" class="btn btn-warning">إنهاء وتسليم المهمة</button>
                                            @endif
                                            <!--end::Action-->
                                        </div>
                                        <!--end::Wrapper-->
                                    </div>
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
                                            <div class="mb-md-0 mb-3">
                                                <h4 class="fw-bold text-gray-900">حتى تتمكن من إرسال طلب الجولة الإستكشافية
                                                </h4>
                                                <div class="fs-6 pe-7 fw-semibold text-gray-700">
                                                    <h5>1_ تحديد مراقب واحد على الأقل</h5>
                                                    <h5>2_ رفع إستمارة الجولة الإستكشافية</h51>
                                                </div>
                                            </div>
                                            <!--end::Content-->
                                            <!--begin::Action-->
                                            <button type="submit" id="kt_tour_submit" class="btn btn-warning">إنهاء
                                                وتسليم المهمة</button>
                                            <!--end::Action-->
                                        </div>
                                        <!--end::Wrapper-->
                                    </div>
                                @endif
                            </div>
                        </form>
                        <!--end::Content-->
                    </div>
                </div>
                <!--end::Content-->
            </div>
            <!--end::Layout-->

            <!--begin::MODALS-->
            <!--begin::Modal - inspector-->
            <div class="modal fade" id="kt_modal_inspector" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered mw-1000px">
                    <div class="modal-content">
                        <form class="form" action="{{ url('fieldwork/create-team-observer') }}" novalidate="novalidate" method="post">
                            @csrf
                            <input type="hidden" name="project_id" id="project_id" value="{{ $row->id }}" />
                            <input type="hidden" name="type_id" id="type_id" value="6" />
                            <input type="hidden" name="project_type_id" id="project_type_id" value="{{ $row->type_id }}" />
                            <input type="hidden" name="is_tour" id="is_tour" value="false" />

                            <div class="modal-header">
                                <h3 class="modal-title">إدارة الفاحصين</h3>
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
                                                    <h4>حدد الفاحص</h4>
                                                </label>
                                            </div>
                                        </div>

                                        @foreach ($team_members->where('role_id', 11) as $inspector)
                                            <!--begin::User-->
                                            <div class="d-flex flex-stack bg-active-lighten rounded p-4" data-user-id="0">
                                                <!--begin::Details-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Checkbox-->
                                                    <label class="form-check form-check-custom form-check-solid me-5">
                                                        <input class="form-check-input" type="checkbox" name="user-checkbox[]" value="{{ $inspector->id }}" data-kt-check="true" data-kt-check-target="[data-user-id='{{ $inspector->id }}']" />
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
            <!--end::Modal - inspector-->

            <!--begin::Modal - observer-->
            <div class="modal fade" id="kt_modal_observer" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered mw-1000px">
                    <div class="modal-content">
                        <form class="form" action="{{ url('fieldwork/create-team-observer') }}" novalidate="novalidate" method="post">
                            @csrf
                            <input type="hidden" name="project_id" id="project_id" value="{{ $row->id }}" />
                            <input type="hidden" name="type_id" id="type_id" value="1" />
                            <input type="hidden" name="project_type_id" id="project_type_id" value="{{ $row->type_id }}" />
                            @if ($financial_bid_estimate->is_explore_tour_required == '1')
                                <input type="hidden" name="is_tour" id="is_tour" value="true" />
                            @else
                                <input type="hidden" name="is_tour" id="is_tour" value="false" />
                            @endif
                            <div class="modal-header">
                                <h3 class="modal-title">إدارة المراقبين</h3>
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
                                                    <h4>حدد المراقب</h4>
                                                </label>
                                            </div>
                                            @if ($financial_bid_estimate->is_explore_tour_required == '0' && $row->type_id != 9)
                                                <div class="d-flex align-items-center">
                                                    <label class="form-check form-check-custom form-check-solid">
                                                        <h4>المشرفين</h4>
                                                    </label>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <label class="form-check form-check-custom form-check-solid me-10 mr-4">
                                                        <h4>الباحثين</h4>
                                                    </label>
                                                </div>
                                            @else
                                                <!--begin::Access menu-->
                                                <div class="d-flex align-items-center">
                                                    <label class="form-check form-check-custom form-check-solid me-10 mr-4">
                                                        <h4>المدينة</h4>
                                                    </label>
                                                </div>
                                                <!--end::Access menu-->
                                            @endif
                                        </div>

                                        @foreach ($team_members->where('role_id', 6) as $observer)
                                            <!--begin::User-->
                                            <div class="d-flex flex-stack bg-active-lighten rounded p-4" data-user-id="0">
                                                @if ($financial_bid_estimate->is_explore_tour_required == '0' && $row->type_id != 9)
                                                    <!--begin::Details-->
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Checkbox-->
                                                        <label class="form-check form-check-custom form-check-solid me-5">
                                                            <input class="form-check-input" type="checkbox" id="{{ $observer->id }}" onclick="fieldworks_disable_observer({{ $observer->id }},'supervisor','researcher')" name="user-checkbox[]" value="{{ $observer->id }}" data-kt-check="true" data-kt-check-target="[data-user-id='{{ $observer->id }}']" />
                                                        </label>
                                                        <!--end::Checkbox-->
                                                        <!--begin::Details-->
                                                        <div class="ms-5">
                                                            <a href="#" class="fs-5 fw-bold text-hover-primary mb-2 text-gray-900">{{ $observer->name }}</a>
                                                            <div class="fw-semibold text-muted">{{ $observer->email }}
                                                            </div>
                                                        </div>
                                                        <!--end::Details-->
                                                    </div>
                                                    <!--end::Details-->
                                                    <!--begin::Access menu-->
                                                    <div class="ms-2 w-100px">
                                                        <input type="text" disabled onkeypress="return isNumberKey(event)" class="form-control" id="supervisor-{{ $observer->id }}" name="supervisor-{{ $observer->id }}" />
                                                    </div>
                                                    <!--end::Access menu-->
                                                    <!--begin::Access menu-->
                                                    <div class="ms-2 w-100px">
                                                        <input type="text" disabled onkeypress="return isNumberKey(event)" class="form-control" id="researcher-{{ $observer->id }}" name="researcher-{{ $observer->id }}" />
                                                    </div>
                                                    <!--end::Access menu-->
                                                @else
                                                    <!--begin::Details-->
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Checkbox-->
                                                        <label class="form-check form-check-custom form-check-solid me-5">
                                                            <input class="form-check-input" type="radio" name="user-checkbox[]" value="{{ $observer->id }}" data-kt-check="true" data-kt-check-target="[data-user-id='{{ $observer->id }}']" {{ $project_explore_tour != null ? ($project_explore_tour->id == $observer->id ? 'checked' : '') : '' }} />
                                                        </label>
                                                        <!--end::Checkbox-->
                                                        <!--begin::Details-->
                                                        <div class="ms-5">
                                                            <a href="#" class="fs-5 fw-bold text-hover-primary mb-2 text-gray-900">{{ $observer->name }}</a>
                                                            <div class="fw-semibold text-muted">{{ $observer->email }}
                                                            </div>
                                                        </div>
                                                        <!--end::Details-->
                                                    </div>
                                                    <!--end::Details-->
                                                    <!--begin::Access menu-->
                                                    <div class="ms-2 w-100px">
                                                        <select id="city_id[{{ $observer->id }}]" name="city_id[{{ $observer->id }}]" class="form-control">
                                                            <option value="{{ $observer->id }}" selected>
                                                                {{ $project_explore_tour->city->title ?? '' }}</option>
                                                            @foreach (\App\Models\Project::findOrFail($row->id)->region()->get() as $region)
                                                                <optgroup label="{{ $region->title }}">
                                                                    @foreach (\App\Models\Region::findOrFail($region->id)->_city()->get() as $city)
                                                                        <option value="{{ $city->id }}">
                                                                            {{ $city->title }}</option>
                                                                    @endforeach
                                                                </optgroup>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <!--end::Access menu-->
                                                @endif
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
                            @if ($financial_bid_estimate->is_explore_tour_required == '0' && $row->type_id != 9)
                                <div class="modal-footer">
                                    <br>
                                    <p class="text-danger">عدد المراقبين هو
                                        {{ $financial_bid_estimate->observer_qty }}</p>
                                    <br>
                                    <p class="text-danger">إجمالي عدد المشرفين لا يتعدى
                                        {{ $financial_bid_estimate->supervisor_qty }}</p>
                                    <br />
                                    <p class="text-danger">إجمالي عدد الباحثين لا يتعدى
                                        {{ $financial_bid_estimate->researcher_qty }}</p>
                                    <br>
                                </div>
                            @endif
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                                <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                            </div>
                        </form>
                    </div>
                    <!--end::MODALS-->
                </div>
            </div>
            <!--end::Modal - observer-->

            <!--begin::Modal - audit-observer-->
            <div class="modal fade" id="kt_modal_audit_observer" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered mw-1000px">
                    <div class="modal-content">
                        <form class="form" action="{{ url('fieldwork/create-team-audit-observer') }}" novalidate="novalidate" method="post">
                            @csrf
                            <input type="hidden" name="project_id" id="project_id" value="{{ $row->id }}" />
                            <input type="hidden" name="type_id" id="type_id" value="2" />
                            <div class="modal-header">
                                <h3 class="modal-title">إدارة مراقبي التدقيق</h3>
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
                                                    <h4>حدد مراقب التدقيق</h4>
                                                </label>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <label class="form-check form-check-custom form-check-solid me-10 mr-4">
                                                    <h4>عدد المدققين</h4>
                                                </label>
                                            </div>
                                        </div>
                                        @foreach ($team_members->where('role_id', 7) as $auditor)
                                            <!--begin::User-->
                                            <div class="d-flex flex-stack bg-active-lighten rounded p-4" data-user-id="0">
                                                <!--begin::Details-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Checkbox-->
                                                    <label class="form-check form-check-custom form-check-solid me-5">
                                                        <input class="form-check-input" type="checkbox" id="{{ $auditor->id }}" onclick="fieldworks_disable_auditor({{ $auditor->id }},'auditor')" name="user-checkbox[]" value="{{ $auditor->id }}" data-kt-check="true" data-kt-check-target="[data-user-id='{{ $auditor->id }}']" />
                                                    </label>
                                                    <!--end::Checkbox-->
                                                    <!--begin::Details-->
                                                    <div class="ms-5">
                                                        <a href="#" class="fs-5 fw-bold text-hover-primary mb-2 text-gray-900">{{ $auditor->name }}</a>
                                                        <div class="fw-semibold text-muted">{{ $auditor->email }}</div>
                                                    </div>
                                                    <!--end::Details-->
                                                </div>
                                                <!--end::Details-->
                                                <!--begin::Access menu-->
                                                <div class="ms-2 w-100px">
                                                    <input type="text" disabled onkeypress="return isNumberKey(event)" class="form-control" id="auditor-{{ $auditor->id }}" name="auditor-{{ $auditor->id }}" />
                                                </div>
                                                <!--end::Access menu-->
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
                                <br>
                                <p class="text-danger">عدد مراقبي التدقيق هو
                                    {{ $financial_bid_estimate->observer_audit_qty }}</p>
                                <br>
                                <p class="text-danger">إجمالي عدد المدققين لا يتعدى
                                    {{ $financial_bid_estimate->auditor_qty }}</p>
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
            <!--end::Modal - audit-observer-->
            <!--end::MODALS-->
            @include('partials.obstacle._obstacle')
        </div>
    </div>
@stop

@section('scripts')
    <script src="{{ asset('assets/js/custom/account/referrals/referral-program.js') }}"></script>
    <script src="{{ asset('assets/js/custom/loading-page.js') }}"></script>
    <script src="{{ asset('assets/js/custom/backoffice/admin.js') }}"></script>
    <script src="{{ asset('assets/js/custom/backoffice/fieldwork.js') }}"></script>
    <script>
        $("button#kt_tour_submit").hide()
        var observers = $("table.observer tbody tr").length;
        $(window).on("load", function() {
            var data = $("#explore_tour_file").html();
            if (data.includes("dz-preview") && observers != 0) {
                $("button#kt_tour_submit").show();
            }
            $("a.dz-remove").on("click", function() {
                let dd = $("#explore_tour_file").html();
                let filePath = $(this).parent().find(".dz-details .dz-filename span").html();
                $file = filePath.replace(projectBaseUrl + '/storage/', "");
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: projectBaseUrl + '/fieldwork/remove-explore-survey',
                    dataType: "json",
                    data: {
                        'project_id': $('#project_id').val(),
                        'oldFile': $file
                    },
                });
                if (!dd.includes("dz-preview")) {
                    $("button#kt_tour_submit").hide();
                }
            });
        });

        function fieldworks_disable_observer(id, supervisor, researcher) {
            var target_supervisor = 'supervisor-' + id;
            var target_researcher = 'researcher-' + id;
            if ($("#" + id).prop("checked")) {
                document.getElementById(target_supervisor).disabled = false;
                document.getElementById(target_researcher).disabled = false;
            } else {
                document.getElementById(target_supervisor).disabled = true;
                document.getElementById(target_researcher).disabled = true;
            }
        }

        function fieldworks_disable_auditor(id, auditor) {
            var target_auditor = 'auditor-' + id;

            if ($("#" + id).prop("checked")) {
                document.getElementById(target_auditor).disabled = false;
            } else {
                document.getElementById(target_auditor).disabled = true;
            }
        }

        var $project_id = $('#project_id');
        var $project_explore_tour = $('#project_explore_tour');
        var image = '{{ URL::asset('assets/media/svg/files/pdf.svg') }}';

        function deleteTeamMember(val, $is_tour) {
            var $team_memeber_id = val.firstElementChild.value;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var $postrequest = $.post(projectBaseUrl + '/fieldwork/delete-team-member/' + $project_id.val() + '/' +
                $team_memeber_id + '/' + $is_tour);
            $postrequest.done(function(data) { // success
                window.location.href = projectBaseUrl + '/fieldworks/' + $project_id.val() +
                    '/edit'; // make request
            });
        }

        new Dropzone("#explore_tour_file", {
            url: projectBaseUrl + '/fieldwork/upload-explore-survey', // Set the url for your upload script location
            method: "post",
            paramName: "file", // The name that will be used to transfer the file
            maxFiles: 5,
            maxFilesize: 10, // MB
            addRemoveLinks: true,
            acceptedFiles: "application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/msword,application/pdf,image/*",
            params: {
                'project_id': $project_id.val()
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            accept: function(file, done) {
                if (observers != 0) {
                    $("button#kt_tour_submit").show();
                }
                if (file.name == "wow.jpg") {
                    done("Naha, you don't.");
                } else {
                    done();
                }
            },
            init: function() {
                if ($project_explore_tour.val()) {
                    if ($project_explore_tour.val().includes("&&")) {
                        let allmocks = $project_explore_tour.val().split("&&");
                        for (let x in allmocks) {
                            mockFile = {
                                name: projectBaseUrl + '/storage/' + allmocks[x],
                                id: 320212,
                                size: 452810,
                                accepted: true,
                                dataURL: image,
                                oldFile: allmocks[x]
                            };
                            this.displayExistingFile(mockFile, mockFile.dataURL);
                            this.files.push(mockFile);
                        }
                    } else {
                        mockFile = {
                            name: projectBaseUrl + '/storage/' + $project_explore_tour.val(),
                            id: 320212,
                            size: 452810,
                            accepted: true,
                            dataURL: image,
                            oldFile: $project_explore_tour.val()
                        };
                        this.displayExistingFile(mockFile, mockFile.dataURL);
                        this.files.push(mockFile);
                    }
                }
                this.on("removedfile", function(file) {});
            }
        });

        function manageNeedEspecialTraining(checkboxItem) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (checkboxItem.checked) {
                $.post(projectBaseUrl + '/fieldwork/is-training-needed/' + $('#project_id').val() +
                    '/true'); // make request
            } else {
                $.post(projectBaseUrl + '/fieldwork/is-training-needed/' + $('#project_id').val() +
                    '/false'); // make request
            }
        }
    </script>
@stop
