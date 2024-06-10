@extends('layouts.app')

@section('style')
<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />
@stop

@section('content')
@if($row->status_id == 3 || $row->status_id == 16)
<div id="kt_content_container" class="container-xxl">
    <!--begin::Layout-->
    <div class="d-flex flex-column flex-xl-row">
        <!--begin::Sidebar-->
        @include('partials.backoffice.sidebar-project')
        <!--end::Sidebar-->

        <!--begin::Content-->
        <div class="flex-lg-row-fluid ms-lg-15">
            <div class="tab-pane pb-8" id="kt_project_equipment_tab" role="tabpanel">
                <!--begin::Col -->
                <div class="col-xl-12 d-flex flex-column gap-7">
                    <!--begin::Table Widget 6-->
                    @if ($row->type_id != 14)
                    <div class="card card-xl-stretch tab-pane">
                        <!--begin::Header-->
                        <div class="card-header cursor-pointer pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold fs-3 mb-1">
                                    التجهيزات العامة
                                </span>
                            </h3>
                            <div class="card-toolbar">
                                <ul class="nav">
                                    <li class="nav-item">
                                        <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-secondary fw-bold px-4 active" data-bs-toggle="tab" href="#kt_table_widget_6_tab_3">{{ $project_equipments->where('type_id', '1')->count() ?? 0 }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body py-3">
                            <div class="tab-content">
                                <div class="table-responsive">
                                    <table class="table align-middle gs-0 gy-3 fw-bold" id="eqPublic">
                                        <!--begin::Table head-->
                                        <thead>
                                            <tr>
                                                <th class="p-0 min-w-150px">الصنف</th>
                                                <th class="p-0">الكمية</th>
                                                <th class="p-0">التكلفة</th>
                                                <th class="p-0">هل وفر؟</th>
                                            </tr>
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody>
                                            @php $p=0; @endphp
                                            @foreach ($project_equipments->where('type_id', '1')->all() as $equipment)
                                            <input type="hidden" name="peID[]" value="{{ $equipment->peID }}">
                                            <tr>
                                                <td class="showw">
                                                    <a href="#" class="text-dark fw-semibold mb-1 fs-6">{{ $equipment->title }}</a>
                                                </td>
                                                <td class="show">
                                                    <span class="text-dark fw-semibold mb-1 fs-6 ">{{ $equipment->qty }}</span>
                                                </td>
                                                <td class="show">
                                                    <span class="text-dark fw-semibold mb-1 fs-6">{{ $equipment->price }}</span>
                                                </td>
                                                <td class="show">
                                                    @if ($equipment->send_equipment_receipt == 1)
                                                    <span class="w-80px badge badge-light-success me-4">تم
                                                        توفير التجهيز</span>
                                                    @else
                                                    <span class="w-100px badge badge-light-danger me-4">لم
                                                        يتم توفير التجهيز</span>
                                                    @endif
                                                </td>
                                                <td class="hide toggle">
                                                    <input class="form-check-input" type="checkbox" name="available[{{ $p }}]" value="1" {{ $equipment->send_equipment_receipt == 1 ? 'checked' : '' }}>
                                                </td>
                                            </tr>
                                            @php $p++; @endphp
                                            @endforeach
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                    @endif
                    <!--end::Table Widget 6-->
                    <!--begin::Table Widget 6-->
                    @if ($row->type_id != 10)
                    <div class="card card-xl-stretch">
                        <!--begin::Header-->
                        <div class="card-header pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold fs-3 mb-1">
                                    تجهيزات قسم التدريب
                                </span>
                            </h3>
                            <div class="card-toolbar">
                                <ul class="nav">
                                    <li class="nav-item">
                                        <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-secondary fw-bold px-4 active" data-bs-toggle="tab" href="#kt_table_widget_6_tab_3">{{ $project_equipments->where('type_id', '2')->count() ?? 0 }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body py-3">
                            <div class="tab-content">
                                <!--begin::Table container-->
                                <div class="table-responsive">
                                    <!--begin::Table-->
                                    <table class="table align-middle gs-0 gy-3 fw-bold" id="eqTrain">
                                        <!--begin::Table head-->
                                        <thead>
                                            <tr>
                                                <th class="p-0 min-w-150px">الصنف</th>
                                                <th class="p-0">الكمية</th>
                                                <th class="p-0">التكلفة</th>
                                                <th class="p-0">هل وفر؟</th>
                                            </tr>
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody>
                                            @php $t=0; @endphp
                                            @foreach ($project_equipments->where('type_id', '2')->all() as $equipment)
                                            <tr>
                                                <input type="hidden" name="peID[]" value="{{ $equipment->peID }}">
                                                <td class="showw">
                                                    <a href="#" class="text-dark fw-semibold mb-1 fs-6">{{ $equipment->title }}</a>
                                                </td>
                                                <td class="show">
                                                    <span class="text-dark fw-semibold mb-1 fs-6 ">{{ $equipment->qty }}</span>
                                                </td>
                                                <td class="show">
                                                    <span class="text-dark fw-semibold mb-1 fs-6">{{ $equipment->price }}</span>
                                                </td>
                                                <td class="show">
                                                    @if ($equipment->send_equipment_receipt == 1)
                                                    <span class="w-80px badge badge-light-success me-4">تم
                                                        توفير التجهيز</span>
                                                    @else
                                                    <span class="w-100px badge badge-light-danger me-4">لم
                                                        يتم توفير التجهيز</span>
                                                    @endif
                                                </td>
                                                <td class="hide toggle">
                                                    <input class="form-check-input" type="checkbox" name="available[{{ $t }}]" value="1" {{ $equipment->send_equipment_receipt == 1 ? 'checked' : '' }}>
                                                </td>
                                            </tr>
                                            @php $t++; @endphp
                                            @endforeach
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                </div>
                                <!--end::Table-->
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                    @endif
                    <!--end::Table Widget 6-->
                    <!--begin::Table Widget 6-->
                    @if ($row->type_id != 14 && $row->type_id != 10)
                    <div class="card card-xl-stretch">
                        <!--begin::Header-->
                        <div class="card-header pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold fs-3 mb-1">
                                    تجهيزات إفتتاح مشروع
                                </span>
                            </h3>
                            <div class="card-toolbar">
                                <ul class="nav">
                                    <li class="nav-item">
                                        <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-secondary fw-bold px-4 active" data-bs-toggle="tab" href="#kt_table_widget_6_tab_3">{{ $project_equipments->where('type_id', '3')->count() ?? 0 }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body py-3">
                            <div class="tab-content">
                                <!--begin::Table container-->
                                <div class="table-responsive">
                                    <!--begin::Table-->
                                    <!--begin::Table-->
                                    <table class="table align-middle gs-0 gy-3 fw-bold" id="eqOpen">
                                        <!--begin::Table head-->
                                        <thead>
                                            <tr>
                                                <th class="p-0 min-w-150px">الصنف</th>
                                                <th class="p-0">الكمية</th>
                                                <th class="p-0">التكلفة</th>
                                                <th class="p-0">هل وفر؟</th>
                                            </tr>
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody>
                                            @php $k=0; @endphp
                                            @foreach ($project_equipments->where('type_id', '3')->all() as $equipment)
                                            <tr>
                                                <input type="hidden" name="peID[]" value="{{ $equipment->peID }}">
                                                <td class="showw">
                                                    <a href="#" class="text-dark fw-semibold mb-1 fs-6">{{ $equipment->title }}</a>
                                                </td>
                                                <td class="show">
                                                    <span class="text-dark fw-semibold mb-1 fs-6 ">{{ $equipment->qty }}</span>
                                                </td>
                                                <td class="show">
                                                    <span class="text-dark fw-semibold mb-1 fs-6">{{ $equipment->price }}</span>
                                                </td>
                                                <td class="show">
                                                    @if ($equipment->send_equipment_receipt == 1)
                                                    <span class="w-80px badge badge-light-success me-4">تم
                                                        توفير التجهيز</span>
                                                    @else
                                                    <span class="w-100px badge badge-light-danger me-4">لم
                                                        يتم توفير التجهيز</span>
                                                    @endif
                                                </td>
                                                <td class="hide toggle">
                                                    <input class="form-check-input" type="checkbox" name="available[{{ $k }}]" value="1" {{ $equipment->send_equipment_receipt == 1 ? 'checked' : '' }}>
                                                </td>
                                            </tr>
                                            @php $k++; @endphp
                                            @endforeach
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                </div>
                                <!--end::Table-->
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                    @endif
                    <!--end::Table Widget 6-->
                    <!--begin::Table Widget 6-->
                    @if ($row->type_id != 14 && $row->type_id != 9 && $row->type_id != 10)
                    <div class="card card-xl-stretch">
                        <!--begin::Header-->
                        <div class="card-header pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold fs-3 mb-1">
                                    تجهيزات التدقيق
                                </span>
                            </h3>
                            <div class="card-toolbar">
                                <ul class="nav">
                                    <li class="nav-item">
                                        <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-secondary fw-bold px-4 active" data-bs-toggle="tab" href="#kt_table_widget_6_tab_3">{{ $project_equipments->where('type_id', '4')->count() ?? 0 }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body py-3">
                            <div class="tab-content">
                                <!--begin::Table container-->
                                <div class="table-responsive">
                                    <!--begin::Table-->
                                    <table class="table align-middle gs-0 gy-3 fw-bold" id="eqAudit">
                                        <!--begin::Table head-->
                                        <thead>
                                            <tr>
                                                <th class="p-0 min-w-150px">الصنف</th>
                                                <th class="p-0">الكمية</th>
                                                <th class="p-0">التكلفة</th>
                                                <th class="p-0">هل وفر؟</th>
                                            </tr>
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody>
                                            @php $i = 0; @endphp
                                            @foreach ($project_equipments->where('type_id', '4')->all() as $equipment)
                                            <tr>
                                                <input type="hidden" name="peID[]" value="{{ $equipment->peID }}">
                                                <td class="showw">
                                                    <a href="#" class="text-dark fw-semibold mb-1 fs-6">{{ $equipment->title }}</a>
                                                </td>
                                                <td class="show">
                                                    <span class="text-dark fw-semibold mb-1 fs-6">{{ $equipment->qty }}</span>
                                                </td>
                                                <td class="show">
                                                    <span class="text-dark fw-semibold mb-1 fs-6">{{ $equipment->price }}</span>
                                                </td>
                                                <td class="show">
                                                    @if ($equipment->send_equipment_receipt == 1)
                                                    <span class="w-80px badge badge-light-success me-4">تم
                                                        توفير التجهيز</span>
                                                    @else
                                                    <span class="w-100px badge badge-light-danger me-4">لم
                                                        يتم توفير التجهيز</span>
                                                    @endif
                                                </td>
                                                <td class="hide toggle">
                                                    <input class="form-check-input" type="checkbox" name="available[{{ $i }}]" value="1" {{ $equipment->send_equipment_receipt == 1 ? 'checked' : '' }}>
                                                </td>
                                            </tr>
                                            @php $i++; @endphp
                                            @endforeach
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                </div>
                                <!--end::Table-->
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                    @endif
                    <!--end::Table Widget 6-->
                    @include('partials.backoffice.equipment._equipmentsModals')
                </div>
                <!--end::Col-->
            </div>

            <!--begin::Status-->
            <div class="card card-flush py-4">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <h2>حالة ترسية المشروع</h2>
                    </div>
                    <!--end::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <div class="rounded-circle bg-warning w-15px h-15px" id="kt_project_status"></div>
                    </div>
                    <!--begin::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <form class="form" id="kt_docs_form_validation_approve_project" action="{{ route($resource.'.update', $row->id) }}" method="post" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        @method('PUT')
                        <!--begin::Select2-->
                        <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Select an option" id="kt_project_status_select" name="kt_project_status_select">
                            <option></option>
                            <option value="pending" selected="selected">بانتظار الترسية</option>
                            <option value="approved">تم الترسية</option>
                            <option value="reject">تم إلغاء المشروع</option>
                        </select>
                        <!--end::Select2-->
                        <!--begin::Description-->
                        <div class="text-muted fs-7">الرجاء تحديد حالة ترسية المشروع.</div>
                        <!--end::Description-->
                        <div class="d-none">
                            <div id="kt_project_approved" class="mt-8">
                                <!--begin::Card-->
                                <div class="card pt-4 mb-6 mb-xl-9">
                                    <div class="card card-flush py-4">
                                        <div class="card-body pt-0">
                                            <div class="w-100">
                                                <div class="row g-9 mb-8">
                                                    <div class="me-5">
                                                        <h3 class="fw-bold text-dark">{{ __('project.dates') }}</h3>
                                                    </div>
                                                    <!--begin::Col-->
                                                    <div class="col-md-6 fv-row">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('project.start_date') }}</label>
                                                        <div class="position-relative d-flex align-items-center">
                                                            <span class="svg-icon svg-icon-2 position-absolute mx-4">
                                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z" fill="currentColor" />
                                                                    <path d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z" fill="currentColor" />
                                                                    <path d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z" fill="currentColor" />
                                                                </svg>
                                                            </span>
                                                            <input class="form-control form-control-solid ps-12" value="{{ $row->start_date ?? '-' }}" name="start_date" id="start_date" />
                                                        </div>
                                                    </div>
                                                    <!--end::Col-->
                                                    <!--begin::Col-->
                                                    <div class="col-md-6 fv-row">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('project.end_date') }}</label>
                                                        <div class="position-relative d-flex align-items-center">
                                                            <span class="svg-icon svg-icon-2 position-absolute mx-4">
                                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z" fill="currentColor" />
                                                                    <path d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z" fill="currentColor" />
                                                                    <path d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z" fill="currentColor" />
                                                                </svg>
                                                            </span>
                                                            <input class="form-control form-control-solid ps-12" value="{{ $row->end_date ?? '-' }}" name="end_date" id="end_date" />
                                                        </div>
                                                    </div>

                                                    @if($row->type_id != 14)
                                                    <div class="mt-8">
                                                        <h3 class="fw-bold text-dark">{{ __('project.opening')}}</h3>
                                                    </div>
                                                    <!--end::Col-->
                                                    <div class="w-100">
                                                        <!--begin::Input group-->
                                                        <div class="fv-row mb-8">
                                                            <!--begin::Wrapper-->
                                                            <div class="d-flex flex-stack">
                                                                <!--begin::Label-->
                                                                <div class="me-5">
                                                                    <label class="fs-6 fw-semibold">{{ __('project.opening')}}</label>
                                                                </div>
                                                                <!--end::Label-->
                                                                <!--begin::Switch-->
                                                                <label class="form-check form-switch form-check-custom form-check-solid">
                                                                    <input class="form-check-input" id="opening" type="checkbox" value="1" name="opening" onchange="manageOpening(this)" {{ $row->opening == 1? 'checked="checked"' : '' }} />
                                                                    <span class="form-check-label fw-semibold text-muted">{{ __('site.yes')}}</span>
                                                                </label>
                                                                <!--end::Switch-->
                                                            </div>
                                                            <!--end::Wrapper-->
                                                        </div>
                                                        <div class="{{ $row->opening == 0? 'd-none' : ''}}" id="opening_div">
                                                            <div class="fv-row mb-8">
                                                                <!--begin::Wrapper-->
                                                                <div class="d-flex flex-stack">
                                                                    <!--begin::Label-->
                                                                    <div class="me-5">
                                                                        <label class="fs-6 fw-semibold">{{ __('project.reserve_hall')}}</label>
                                                                    </div>
                                                                    <!--end::Label-->
                                                                    <!--begin::Switch-->
                                                                    <label class="form-check form-switch form-check-custom form-check-solid">
                                                                        <input class="form-check-input" type="checkbox" value="1" name="opening_reserve_hall" {{ $row->opening_reserve_hall == 1? 'checked="checked"' : '' }} />
                                                                        <span class="form-check-label fw-semibold text-muted">{{ __('site.yes')}}</span>
                                                                    </label>
                                                                    <!--end::Switch-->
                                                                </div>
                                                                <!--end::Wrapper-->
                                                            </div>
                                                            <div class="fv-row mb-8">
                                                                <!--begin::Label-->
                                                                <div class="me-5">
                                                                    <h3 class="fw-bold text-dark">{{ __('project.attendance_nature') }}</h3>
                                                                </div>
                                                                <!--end::Label-->
                                                                <!--begin::Row-->
                                                                <div class="row g-9" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button='true']">
                                                                    <!--begin::Col-->
                                                                    <div class="col-md-6 col-lg-12 col-xxl-6">
                                                                        <!--begin::Option-->
                                                                        <label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6 {{ $row->opening_attendance_nature == 'regulars'? 'active' : '' }}" data-kt-button="true">
                                                                            <!--begin::Radio-->
                                                                            <span class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                                                <input class="form-check-input" type="radio" name="opening_attendance_nature" value="0" {{ $row->opening_attendance_nature == 'regulars'? 'checked="checked"' : '' }} />
                                                                            </span>
                                                                            <!--end::Radio-->
                                                                            <!--begin::Info-->
                                                                            <span class="ms-5">
                                                                                <span class="fs-4 fw-bold text-gray-800 mb-2 d-block">{{ __('project.regulars')}}</span>
                                                                            </span>
                                                                            <!--end::Info-->
                                                                        </label>
                                                                        <!--end::Option-->
                                                                    </div>
                                                                    <!--end::Col-->
                                                                    <!--begin::Col-->
                                                                    <div class="col-md-6 col-lg-12 col-xxl-6">
                                                                        <!--begin::Option-->
                                                                        <label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6 {{ $row->opening_attendance_nature == 'leaders'? 'active' : '' }}" data-kt-button="true">
                                                                            <!--begin::Radio-->
                                                                            <span class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                                                <input class="form-check-input" type="radio" name="opening_attendance_nature" value="1" {{ $row->opening_attendance_nature == 'leaders'? 'checked="checked"' : '' }} />
                                                                            </span>
                                                                            <!--end::Radio-->
                                                                            <!--begin::Info-->
                                                                            <span class="ms-5">
                                                                                <span class="fs-4 fw-bold text-gray-800 mb-2 d-block">{{ __('project.leaders')}}</span>
                                                                            </span>
                                                                            <!--end::Info-->
                                                                        </label>
                                                                        <!--end::Option-->
                                                                    </div>
                                                                    <!--end::Col-->
                                                                </div>
                                                                <!--end::Row-->
                                                            </div>
                                                            <!--end::Input group-->
                                                            <!--begin::Input group-->
                                                            <div class="fv-row mb-8">
                                                                <!--begin::Col-->
                                                                <label class="required fs-6 fw-semibold mb-2">{{ __('project.opening_date')}}</label>
                                                                <div class="position-relative d-flex align-items-center">
                                                                    <!--begin::Icon-->
                                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                                                                    <span class="svg-icon svg-icon-2 position-absolute mx-4">
                                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                            <path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z" fill="currentColor" />
                                                                            <path d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z" fill="currentColor" />
                                                                            <path d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z" fill="currentColor" />
                                                                        </svg>
                                                                    </span>
                                                                    <!--end::Svg Icon-->
                                                                    <!--end::Icon-->
                                                                    <!--begin::Datepicker-->
                                                                    <input class="form-control form-control-solid ps-12" value="{{ $row->opening_date }}" id="opening_date" name="opening_date" type="text" />
                                                                    <!--end::Datepicker-->
                                                                </div>
                                                                <!--end::Col-->
                                                            </div>
                                                            <!--end::Input group-->
                                                        </div>
                                                    </div>
                                                    <div class="me-5">
                                                        <h3 class="fw-bold text-dark">{{ __('project.closing')}}</h3>
                                                    </div>
                                                    @endif
                                                    <div class="w-100">
                                                        <!--begin::Heading-->
                                                        @if($row->type_id != 14)
                                                        <div class="fv-row mb-8">
                                                            <!--begin::Wrapper-->
                                                            <div class="d-flex flex-stack">
                                                                <!--begin::Label-->
                                                                <div class="me-5">
                                                                    <label class="fs-6 fw-semibold">{{ __('project.closing')}}</label>
                                                                </div>
                                                                <!--end::Label-->
                                                                <!--begin::Switch-->
                                                                <label class="form-check form-switch form-check-custom form-check-solid">
                                                                    <input class="form-check-input" id="closing" type="checkbox" value="1" name="closing" onchange="manageClosing(this)" {{ $row->closing == 1? 'checked="checked"' : '' }} />
                                                                    <span class="form-check-label fw-semibold text-muted">{{ __('site.yes')}}</span>
                                                                </label>
                                                                <!--end::Switch-->
                                                            </div>
                                                            <!--end::Wrapper-->
                                                        </div>
                                                        <div class="{{ $row->closing == 0? 'd-none' : ''}}" id="closing_div">
                                                            <div class="fv-row mb-8">
                                                                <!--begin::Wrapper-->
                                                                <div class="d-flex flex-stack">
                                                                    <!--begin::Label-->
                                                                    <div class="me-5">
                                                                        <label class="fs-6 fw-semibold">{{ __('project.reserve_hall')}}</label>
                                                                    </div>
                                                                    <!--end::Label-->
                                                                    <!--begin::Switch-->
                                                                    <label class="form-check form-switch form-check-custom form-check-solid">
                                                                        <input class="form-check-input" type="checkbox" value="1" name="closing_reserve_hall" {{ $row->closing_reserve_hall == 1? 'checked="checked"' : '' }} />
                                                                        <span class="form-check-label fw-semibold text-muted">{{ __('site.yes')}}</span>
                                                                    </label>
                                                                    <!--end::Switch-->
                                                                </div>
                                                                <!--end::Wrapper-->
                                                            </div>
                                                            <div class="fv-row mb-8">
                                                                <!--begin::Label-->
                                                                <div class="me-5">
                                                                    <h3 class="fw-bold text-dark">{{ __('project.attendance_nature') }}</h3>
                                                                </div>
                                                                <!--end::Label-->
                                                                <!--begin::Row-->
                                                                <div class="row g-9" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button='true']">
                                                                    <!--begin::Col-->
                                                                    <div class="col-md-6 col-lg-12 col-xxl-6">
                                                                        <!--begin::Option-->
                                                                        <label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6  {{ $row->closing_attendance_nature == 'regulars'? 'active' : '' }}" data-kt-button="true">
                                                                            <!--begin::Radio-->
                                                                            <span class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                                                <input class="form-check-input" type="radio" name="closing_attendance_nature" value="0" {{ $row->closing_attendance_nature == 'regulars'? 'checked="checked"' : '' }} />
                                                                            </span>
                                                                            <!--end::Radio-->
                                                                            <!--begin::Info-->
                                                                            <span class="ms-5">
                                                                                <span class="fs-4 fw-bold text-gray-800 mb-2 d-block">{{ __('project.regulars')}}</span>
                                                                            </span>
                                                                            <!--end::Info-->
                                                                        </label>
                                                                        <!--end::Option-->
                                                                    </div>
                                                                    <!--end::Col-->
                                                                    <!--begin::Col-->
                                                                    <div class="col-md-6 col-lg-12 col-xxl-6">
                                                                        <!--begin::Option-->
                                                                        <label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6 {{ $row->closing_attendance_nature == 'leaders'? 'active' : '' }}" data-kt-button="true">
                                                                            <!--begin::Radio-->
                                                                            <span class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                                                <input class="form-check-input" type="radio" name="closing_attendance_nature" value="1" {{ $row->closing_attendance_nature == 'leaders'? 'checked="checked"' : '' }} />
                                                                            </span>
                                                                            <!--end::Radio-->
                                                                            <!--begin::Info-->
                                                                            <span class="ms-5">
                                                                                <span class="fs-4 fw-bold text-gray-800 mb-2 d-block">{{ __('project.leaders')}}</span>
                                                                            </span>
                                                                            <!--end::Info-->
                                                                        </label>
                                                                        <!--end::Option-->
                                                                    </div>
                                                                    <!--end::Col-->
                                                                </div>
                                                                <!--end::Row-->
                                                            </div>
                                                            <div class="fv-row mb-8">
                                                                <label class="required fs-6 fw-semibold mb-2">{{ __('project.closing_date')}}</label>
                                                                <div class="position-relative d-flex align-items-center">
                                                                    <span class="svg-icon svg-icon-2 position-absolute mx-4">
                                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                            <path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z" fill="currentColor" />
                                                                            <path d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z" fill="currentColor" />
                                                                            <path d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z" fill="currentColor" />
                                                                        </svg>
                                                                    </span>
                                                                    <input class="form-control form-control-solid ps-12" value="{{ $row->closing_date }}" name="closing_date" id="closing_date" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif

                                                        <div class="fv-row mb-8">
                                                            <label class="required fs-6 fw-semibold mb-2">{{ __('project.confirm_letter')}}</label>
                                                            <input type="file" accept=".pdf" class="form-control form-control-solid" name="confirm_letter" placeholder="{{ $row->confirm_letter }}" />
                                                        </div>
                                                        @if($project_finanical_estimate->is_family_list_required == 1)
                                                        <div class="fv-row mb-8">
                                                            <label class="required fw-semibold fs-6 mb-2">ملف قائمة الأسر</label>
                                                            <input type="file" accept=".xlsx" id="family_list" class="form-control form-control-solid mb-2" name="family_list" />
                                                        </div>
                                                        @endif
                                                        @if($project_finanical_estimate->is_coordinate_required == 1)
                                                        <div class="fv-row mb-8">
                                                            <label class="required fs-6 fw-semibold mb-2">ملف الإحداثيات</label>
                                                            <input type="file" accept=".kmz" class="form-control form-control-solid" id="coordinate_file" name="coordinate_file" placeholder="{{ $project_finanical_estimate->is_coordinate_required }}" />
                                                        </div>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Card-->
                            </div>
                        </div>

                        <!--begin::Datepicker-->
                        <div class="mt-10">
                            <label for="kt_pending_date" class="form-label">التاريخ المتوقع للرد على ترسية المشروع</label>
                            <input class="form-control" id="kt_pending_date" name="kt_pending_date" placeholder="تحديد التاريخ" />
                            <div class="text-muted fs-7">الرجاء تحديد التاريخ المتوقع للترسية.</div>
                        </div>
                        <!--end::Datepicker-->

                        <!--begin::reject-->
                        <div class="d-none mt-10">
                            <label for="kt_rejection_reason" class="form-label">سبب إلغاء المشروع</label>
                            <!--begin::Editor-->
                            <div id="kt_rejection_reason" class="min-h-200px mb-2"></div>
                            <textarea name="rejection_reason" style="display:none" id="rejection_reason"></textarea>
                            <div class="text-muted fs-7">الرجاء كتابة سبب إلغاء المشروع.</div>
                            <!--end::Editor-->
                        </div>
                        <!--end::reject-->

                        <!--begin::Actions-->
                        <div class="d-flex flex-end mt-6">
                            <button type="button" class="btn btn-lg btn-light me-3" id="kt_approve_project_cancel" data-kt-element="files-previous">{{ __('site.cancel') }}</button>
                            <button id="kt_docs_approve_project_form_validation_text_submit" type="submit" class="btn btn-primary">
                                <span class="indicator-label">
                                    {{ __('project.confirm_project') }}
                                </span>
                                <span class="indicator-progress">
                                    {{ __('site.please_wait')}} <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Status-->

        </div>
        <!--end::Content-->
    </div>
    <!--end::Layout-->
</div>
@else

@section('scripts')
<script>
    history.go(-1);
</script>
@stop
@endif

@stop

@section('scripts')
<script src="{{ asset('assets/js/custom/backoffice/approve-project.js') }}"></script>
<script src="{{ asset('assets/js/custom/apps/ecommerce/catalog/save-product.js') }}"></script>
@stop