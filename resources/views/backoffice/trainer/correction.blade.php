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
                    @if($row->type_id != 12)
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

                                <div class="card-body py-3">
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="kt_table_widget_7_tab_1">
                                            <div class="table-responsive">
                                                <table class="table align-middle gs-0 gy-3 mb-4">
                                                    <thead>
                                                        <tr class="fw-bold text-muted">
                                                            <th class="p-0 min-w-120px">عنوان التدريب</th>
                                                            <th class="p-0">الفئة</th>
                                                            <th class="p-0 min-w-200px">رابط التدريب</th>
                                                            <th class="p-0">التاريخ</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($training_urls as $training_url)
                                                        <tr>
                                                            <td>
                                                                <span class="text-dark fw-bold mb-1 fs-6">{{ $training_url->title }}</span>
                                                            </td>
                                                            <td>
                                                                <span class="text-dark fw-bold mb-1 fs-6">{{ $team_ranks->where('id', $training_url->type_id)->first()->trans }}</span>
                                                            </td>
                                                            <td>
                                                                <span class="text-dark fw-bold mb-1 fs-6">{{ $training_url->url }}</span>
                                                            </td>
                                                            <td>
                                                                <span class="text-dark fw-bold mb-1 fs-6">{{ \Carbon\Carbon::parse($training_url->start_date)->format('d-m-Y') }}</span>
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
                                                <div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="0">
                                                    <div class="d-flex align-items-center">
                                                        <label class="form-check form-check-custom form-check-solid me-5">
                                                            <input class="form-check-input" type="checkbox" name="user-checkbox[]" id="researcher{{ $selected_researcher->team_user_id }}" value="{{ $selected_researcher->team_user_id }}" data-kt-check="true" data-kt-check-target="[data-user-id='{{ $selected_researcher->team_user_id }}']" {{ $selected_researcher->received_train == '1' ? 'checked' : '' }} />
                                                        </label>
                                                        <div class="ms-5">
                                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">{{ $attracting_teams->where('id', $selected_researcher->team_user_id)->first()->name ?? '' }}</a>
                                                            <div class="fw-semibold text-muted">
                                                                {{ $attracting_teams->where('id', $selected_researcher->team_user_id)->first()->email ?? '' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="fw-semibold text-muted">
                                                        @if($selected_researcher->received_train == '1')
                                                        <span class="w-80px badge badge-light-success me-4">قد تم تحضيره</span>
                                                        @else
                                                        <span class="w-80px badge badge-light-danger me-4">لم يتم تحضيره</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="border-bottom border-gray-300 border-bottom-dashed">
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

                        @if ($financial_bid_estimate->observer_training_date <= Carbon\Carbon::now())
                        <form class="form" action="{{ url('trainer/hand-offer-correction') }}" enctype="multipart/form-data" novalidate="novalidate" method="post">
                            @csrf
                            <input type="hidden" name="project_id" id="project_id" value="{{ $row->id }}" />
                            <div class="text-center mt-8">
                                <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed min-w-lg-600px flex-shrink-0 p-6">
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
                                    <div class="d-flex flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
                                        <!--begin::Content-->
                                        <div class="mb-3 mb-md-0 fw-semibold">
                                            <h4 class="text-gray-900 fw-bold">حتى تتمكن من إنهاء المهمة يجب عليك </h4>
                                            <div class="fs-6 text-gray-700 pe-7">
                                                تحديد علي الاقل شحص من الباحثين المتلقين للتدريب
                                            </div>
                                        </div>
                                        <!--end::Content-->
                                        <!--begin::Action-->
                                        <button type="submit" id="kt_edit_project_submit" class="btn btn-warning" {{ $is_observer_team_ready > 0 ? '' : '' }}>إنهاء وتسليم المهمة</button>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                            </div>
                        </form>
                        @endif
                    </div>
                    <!--end::Content-->
                </div>
            </div>
            <!--end::Content-->
        </div>
        <!--end::Layout-->

        <!--begin::MODALS-->
        <!--begin::Modal - training url-->
        <div class="modal fade" id="kt_modal_training_url" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered mw-1000px">
                <div class="modal-content">
                    <form class="form" id="trainingForm" data-route-url="{{ url('trainer/training-url/correction') }}" autocomplete="off" method="post" data-redirect-url="{{ url('trainer/correction/' . $row->id) }}">
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
                        <div class="modal-body scroll-y mx-5 mx-xl-18 pb-15">
                            <div class="fv-row mb-8">
                                <label class="required fs-6 fw-semibold mb-2">عنوان التدريب</label>
                                <input type="text" class="form-control form-control-solid" name="title" id="title" placeholder="عنوان التدريب" />
                            </div>
                            <div class="fv-row mb-8">
                                <label class="required d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                                    فئة التدريب
                                </label>
                                <select class="form-select form-select-solid" name="type_id" id="type_id" data-control="select2" data-hide-search="true" data-placeholder="فئة التدريب">
                                    {{-- <option value=""></option> --}}
                                    <option value="5">الباحثين</option>
                                </select>
                            </div>
                            <div class="row g-9 mb-8">
                                <div class="col-md-6 fv-row">
                                    <label class="required fs-6 fw-semibold mb-2">تاريخ و وقت البدء</label>
                                    <div class="position-relative d-flex align-items-center">
                                        <span class="svg-icon svg-icon-2 position-absolute mx-4">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z" fill="currentColor" />
                                                <path d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z" fill="currentColor" />
                                                <path d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z" fill="currentColor" />
                                            </svg>
                                        </span>
                                        <input class="form-control ps-12" placeholder="تاريخ و وقت البدء" name="start_date" id="start_date" />
                                    </div>
                                </div>
                                <div class="col-md-6 fv-row">
                                    <label class="required fs-6 fw-semibold mb-2">تاريخ و وقت النهاية</label>
                                    <div class="position-relative d-flex align-items-center">
                                        <span class="svg-icon svg-icon-2 position-absolute mx-4">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z" fill="currentColor" />
                                                <path d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z" fill="currentColor" />
                                                <path d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z" fill="currentColor" />
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

                            <div class="fv-row mb-8 d-none" id="TrainurlDiv">
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
                                <div class="fv-row mb-8 d">
                                    <label class="required fs-6 fw-semibold mb-2">رابط تدريب برنامج كاشف</label>
                                    <input type="text" class="form-control form-control-solid" name="train_kashef_url" id="train_kashef_url" placeholder="رابط تدريب برنامج كاشف" />
                                </div>
                                <div class="fv-row mb-8 d">
                                    <label class="required fs-6 fw-semibold mb-2">البريد الإلكتروني</label>
                                    <input type="text" class="form-control form-control-solid" name="train_kashef_account_email" id="train_kashef_account_email" placeholder="البريد الإلكتروني" />
                                </div>
                                <div class="fv-row mb-8 d">
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
        <!--end::MODALS-->
    </div>
</div>
@stop

@section('scripts')
<script src="{{ asset('assets/js/custom/account/referrals/referral-program.js') }}"></script>
<script src="{{ asset('assets/js/custom/backoffice/trainer.js') }}"></script>
<script src="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
@stop