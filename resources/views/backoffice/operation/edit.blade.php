@extends('layouts.app')

@section('style')
<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('footer') @endsection

@section('content')
<div id="kt_content_container" class="container-xxl">
    <!--begin::Layout-->
    <div class="d-flex flex-column flex-xl-row">
        <!--begin::Sidebar-->
        @include('partials.backoffice.sidebar-project')
        <!--end::Sidebar-->

        <!--begin::Content-->
        <div class="flex-lg-row-fluid ms-lg-15">
            <div class="tab-content">
                @if ($row->type_id <= 4 || $row->type_id == 12)
                    <form class="form" action="{{ url('operation/request-exploration-tour') }}" novalidate="novalidate" method="post">
                        <div class="col-xl-12">
                            <div class="card card-xl-stretch mb-8 p-4">
                                @csrf
                                <input type="hidden" name="project_id" id="project_id" value="{{ $row->id }}" />
                                <div class="d-flex flex-stack mt-4">
                                    <div class="d-flex">
                                        <i class="bi bi-disc fs-3x w-30px me-6"></i>
                                        <div class="d-flex flex-column">
                                            <a href="#" class="fs-5 text-dark text-hover-primary fw-bold">الجولة الإستكشافية</a>
                                            <div class="fs-6 fw-semibold text-gray-400">هل هناك حاجة إلى جولة إستكشافية للمنطقة؟</div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <div class="form-check form-check-solid form-check-custom form-switch">
                                            @if (!@empty($financial_bid_estimate->is_explore_tour_required == 1))
                                            <input class="form-check-input w-45px h-30px" type="checkbox" value="1" name="is_explore_tour_required" id="is_explore_tour_required" disabled {{ $financial_bid_estimate->is_explore_tour_required == 1 ? 'checked="checked"' : '' }} />
                                            @else
                                            <input class="form-check-input w-45px h-30px" type="checkbox" value="1" name="is_explore_tour_required" id="is_explore_tour_required" onchange="manageExplorVisit(this)" />
                                            @endif
                                            <label class="form-check-label" for="is_explore_tour_required">{{ __('site.yes') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div id="explorVisit-btn" class="text-center d-none my-8">
                                    <button type="submit" id="kt_edit_project_submit" class="btn btn-primary">إرسال طلب الجولة الإستكشافية</button>
                                </div>
                            </div>
                            @if (!@empty($financial_bid_estimate->is_explore_tour_required == 1))
                            <!--begin::Notice-->
                            <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed mb-9 p-6">
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
                                        <h4 class="text-gray-900 fw-bold">بانتظار وصول ملفات الجولة الإستكشافية</h4>
                                        <div class="fs-6 text-gray-700">فريق العمل يعمل على تجهيز ملفات الجولة الإستكشافية وفي حال الإنتهاء ستظهر هنا</div>
                                    </div>
                                    <!--end::Content-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Notice-->
                            @endif
                        </div>
                    </form>
                    <div class="fv-row w-100 flex-md-root">
                        <div class="text-center mt-4">
                            @include('partials.backoffice.observer.tourfiles')
                        </div>
                    </div>
                    @endif
                    @if (@empty(!$project_family_development->family_list))
                    <div id="explorVisit" class="{{ ($row->type_id <= 4 || $row->type_id == 12) && $financial_bid_estimate->is_explore_tour_required == 1 ? 'd-none' : '' }}">
                        @else
                        <div id="explorVisit" class="{{ ($row->type_id <= 4 || $row->type_id == 12) }}">
                            @endif
                            <form class="form" id="financial-bid-estimates" action="{{ url('operation/financial-bid-estimates') }}" method="post" enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                <input type="hidden" name="project_id" id="project_id" value="{{ $row->id }}" />
                                <!--begin:::Tab pane-->
                                <div class="tab-pane show mt-8">
                                    <h2>التجهيزات المطلوبة للمشروع</h2>
                                    <!--begin::Card-->
                                    <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10 mt-8">
                                        @if ($row->type_id != 14)
                                        <!--begin::Payment address-->
                                        <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                                            <!--begin::Card header-->
                                            <div class="card-header">
                                                <div class="card-title">
                                                    <span class="fs-5 text-dark fw-bold">التجهيزات العامة</span>
                                                </div>
                                            </div>
                                            <!--end::Card header-->
                                            <!--begin::Card body-->
                                            <div class="card">
                                                <!--begin::Body-->
                                                <div class="card-body pt-3">
                                                    <!--begin::Table container-->
                                                    <div class="table-responsive">
                                                        <!--begin::Table-->
                                                        <table class="table table-row-dashed table-row-gray-300 align-middle">
                                                            <!--begin::Table head-->
                                                            <thead>
                                                                <tr class="border-0">
                                                                    <th class="p-0 max-w-30px"></th>
                                                                    <th class="p-0 min-w-30px"></th>
                                                                    <th class="p-0 min-w-30px"></th>
                                                                </tr>
                                                            </thead>
                                                            <!--end::Table head-->
                                                            <!--begin::Table body-->
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <a href="#" class="text-dark fw-bold d-block mb-1 fs-6">العدد
                                                                            الكلي</a>
                                                                    </td>
                                                                    <td>
                                                                        <a href="#" class="text-dark fw-bold mb-1 fs-6">{{ $project_equipments->firstWhere('type_id', '1')->qty ?? 0 }}</a>
                                                                    </td>
                                                                    <td>
                                                                        <a href="#" class="text-dark fw-bold mb-1 fs-6">التكلفة
                                                                            الإجمالية</a>
                                                                    </td>
                                                                    <td>
                                                                        <a href="#" class="text-dark fw-bold mb-1 fs-6">{{ $project_equipments->firstWhere('type_id', '1')->price ?? 0.0 }}</a>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                            <!--end::Table body-->
                                                        </table>
                                                        <!--end::Table-->
                                                        <div class="d-flex flex-center">
                                                            <a href="#" class="btn btn-sm" style="background-color:#004A61;color:white" data-bs-toggle="modal" data-bs-target="#kt_modal_general_equipment">إدارة التجهيزات العامة</a>
                                                        </div>
                                                    </div>
                                                    <!--end::Table container-->
                                                </div>
                                                <!--begin::Body-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        @endif
                                        <!--end::Payment address-->
                                        <!--begin::Shipping address-->
                                        @if ($row->type_id != 10)
                                        <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                                            <!--begin::Card header-->
                                            <div class="card-header">
                                                <div class="card-title">
                                                    <span class="fs-5 text-dark fw-bold">تجهيزات قسم التدريب</span>
                                                </div>
                                            </div>
                                            <!--end::Card header-->
                                            <!--begin::Card body-->
                                            <div class="card mb-5 mb-xl-8">
                                                <!--begin::Body-->
                                                <div class="card-body pt-3">
                                                    <!--begin::Table container-->
                                                    <div class="table-responsive">
                                                        <!--begin::Table-->
                                                        <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                                            <!--begin::Table head-->
                                                            <thead>
                                                                <tr class="border-0">
                                                                    <th class="p-0"></th>
                                                                    <th class="p-0 min-w-30px"></th>
                                                                    <th class="p-0 min-w-30px"></th>
                                                                </tr>
                                                            </thead>
                                                            <!--end::Table head-->
                                                            <!--begin::Table body-->
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <a href="#" class="text-dark fw-bold d-block mb-1 fs-6">العدد الكلي</a>
                                                                    </td>
                                                                    <td>
                                                                        <a href="#" class="text-dark fw-bold mb-1 fs-6">{{ $project_equipments->firstWhere('type_id', '2')->qty ?? 0 }}</a>
                                                                    </td>
                                                                    <td>
                                                                        <a href="#" class="text-dark fw-bold mb-1 fs-6">التكلفة الإجمالية</a>
                                                                    </td>
                                                                    <td>
                                                                        <a href="#" class="text-dark fw-bold mb-1 fs-6">{{ $project_equipments->firstWhere('type_id', '2')->price ?? 0.0 }}</a>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                            <!--end::Table body-->
                                                        </table>
                                                        <!--end::Table-->
                                                        <div class="d-flex flex-center">
                                                            <a href="#" class="btn btn-sm" style="background-color:#004A61;color:white" data-bs-toggle="modal" data-bs-target="#kt_modal_training_equipment">إدارة تجهيزات
                                                                قسم التدريب</a>
                                                        </div>
                                                    </div>
                                                    <!--end::Table container-->
                                                </div>
                                                <!--begin::Body-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        @endif
                                        <!--end::Shipping address-->
                                    </div>
                                    <!--end::Card-->
                                    <!--begin::Card-->
                                    <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10 mt-8">
                                        @if ($row->type_id != 14 && $row->type_id != 10)
                                        <!--begin::Payment address-->
                                        <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                                            <!--begin::Card header-->
                                            <div class="card-header">
                                                <div class="card-title">
                                                    <span class="fs-5 text-dark fw-bold">تجهيزات إفتتاح مشروع</span>
                                                </div>
                                            </div>
                                            <!--end::Card header-->
                                            <!--begin::Card body-->
                                            <div class="card mb-5 mb-xl-8">
                                                <!--begin::Body-->
                                                <div class="card-body pt-3">
                                                    <!--begin::Table container-->
                                                    <div class="table-responsive">
                                                        <!--begin::Table-->
                                                        <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                                            <!--begin::Table head-->
                                                            <thead>
                                                                <tr class="border-0">
                                                                    <th class="p-0"></th>
                                                                    <th class="p-0 min-w-30px"></th>
                                                                    <th class="p-0 min-w-30px"></th>
                                                                </tr>
                                                            </thead>
                                                            <!--end::Table head-->
                                                            <!--begin::Table body-->
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <a href="#" class="text-dark fw-bold d-block mb-1 fs-6">العدد الكلي</a>
                                                                    </td>
                                                                    <td>
                                                                        <a href="#" class="text-dark fw-bold mb-1 fs-6">{{ $project_equipments->firstWhere('type_id', '3')->qty ?? 0 }}</a>
                                                                    </td>
                                                                    <td>
                                                                        <a href="#" class="text-dark fw-bold mb-1 fs-6">التكلفة الإجمالية</a>
                                                                    </td>
                                                                    <td>
                                                                        <a href="#" class="text-dark fw-bold mb-1 fs-6">{{ $project_equipments->firstWhere('type_id', '3')->price ?? 0.0 }}</a>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                            <!--end::Table body-->
                                                        </table>
                                                        <!--end::Table-->
                                                        <div class="d-flex flex-center">
                                                            <a href="#" class="btn btn-sm" style="background-color:#004A61;color:white" data-bs-toggle="modal" data-bs-target="#kt_modal_opening_equipment">إدارة تجهيزات إفتتاح مشروع</a>
                                                        </div>
                                                        <!--end::Table-->
                                                    </div>
                                                    <!--end::Table container-->
                                                </div>
                                                <!--begin::Body-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        @endif
                                        <!--end::Payment address-->
                                        <!--begin::Shipping address-->
                                        @if ($row->type_id != 14 && $row->type_id != 10 && $row->type_id != 9)
                                        <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                                            <!--begin::Card header-->
                                            <div class="card-header">
                                                <div class="card-title">
                                                    <span class="fs-5 text-dark fw-bold">تجهيزات التدقيق</span>
                                                </div>
                                            </div>
                                            <!--end::Card header-->
                                            <!--begin::Card body-->
                                            <div class="card mb-5 mb-xl-8">
                                                <!--begin::Body-->
                                                <div class="card-body pt-3">
                                                    <!--begin::Table container-->
                                                    <div class="table-responsive">
                                                        <!--begin::Table-->
                                                        <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                                            <!--begin::Table head-->
                                                            <thead>
                                                                <tr class="border-0">
                                                                    <th class="p-0"></th>
                                                                    <th class="p-0 min-w-30px"></th>
                                                                    <th class="p-0 min-w-30px"></th>
                                                                </tr>
                                                            </thead>
                                                            <!--end::Table head-->
                                                            <!--begin::Table body-->
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <a href="#" class="text-dark fw-bold d-block mb-1 fs-6">العدد الكلي</a>
                                                                    </td>
                                                                    <td>
                                                                        <a href="#" class="text-dark fw-bold mb-1 fs-6">{{ $project_equipments->firstWhere('type_id', '4')->qty ?? 0 }}</a>
                                                                    </td>
                                                                    <td>
                                                                        <a href="#" class="text-dark fw-bold mb-1 fs-6">التكلفة الإجمالية</a>
                                                                    </td>
                                                                    <td>
                                                                        <a href="#" class="text-dark fw-bold mb-1 fs-6">{{ $project_equipments->firstWhere('type_id', '4')->price ?? 0.0 }}</a>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                            <!--end::Table body-->
                                                        </table>
                                                        <!--end::Table-->
                                                        <div class="d-flex flex-center">
                                                            <a href="#" class="btn btn-sm" style="background-color:#004A61;color:white" data-bs-toggle="modal" data-bs-target="#kt_modal_auditing_equipment">إدارة تجهيزات قسم التدقيق</a>
                                                        </div>
                                                        <!--end::Table-->
                                                    </div>
                                                    <!--end::Table container-->
                                                </div>
                                                <!--begin::Body-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        @endif
                                        <!--end::Shipping address-->
                                    </div>
                                    <!--end::Card-->
                                </div>
                                <!--end:::Tab pane-->
                                <!--begin:::Tab pane-->
                                @if ($row->type_id != 14)
                                <div class="tab-pane show mt-8">
                                    <h2>تسعيرات الفرق البحثية</h2>
                                    <!--begin::Card-->
                                    <div class="card pt-4 mb-6 mb-xl-9 mt-8">
                                        <div class="card card-flush py-4">
                                            <!--begin::Card body-->
                                            <div class="card-body pt-0">
                                                <div id="kt_modal_team_rank_handler" data-kt-search-keypress="true" data-kt-search-min-length="2" data-kt-search-enter="enter" data-kt-search-layout="inline">
                                                    <div class="py-5">
                                                        <div class="mh-450px scroll-y me-n7 pe-7">
                                                            <table id="kt_datatable_team_rank_item" class="table table-row-bordered table-row-dashed gy-5">
                                                                <thead>
                                                                    <tr class="fw-semibold fs-6 text-gray-800">
                                                                        <th class="text-center mw-30px">
                                                                            {{ __('equipment.id') }}
                                                                        </th>
                                                                        <th class="text-center">
                                                                            {{ __('equipment.team-rank') }}
                                                                        </th>
                                                                        <th class="text-center mw-100px">
                                                                            {{ __('equipment.kader-qty') }}
                                                                        </th>
                                                                        <th class="text-center mw-100px">
                                                                            {{ __('equipment.kashif-price') }}
                                                                        </th>
                                                                        <th class="text-center mw-100px">
                                                                            {{ __('equipment.contract-terms') }}
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($team_ranks as $team_rank)
                                                                    @php
                                                                    $qty =$team_rank->title.'_qty';
                                                                    $price =$team_rank->title.'_price';
                                                                    @endphp
                                                                    @if (
                                                                    ($row->type_id == 9 && ($team_rank->id == 1 || $team_rank->id == 7)) ||
                                                                    ($row->type_id == 10 && $team_rank->id == 6))
                                                                    <tr>
                                                                        <td><input type="text" class="form-control form-control-solid mw-50px" id="team-{{ $team_rank->id }}-id" name="team-{{ $team_rank->id }}-id" value="{{ $team_rank->id }}" disabled /></td>
                                                                        <td><input type="text" class="form-control form-control-solid" id="team-{{ $team_rank->id }}-title" name="team-{{ $team_rank->id }}-title" value="{{ $team_rank->trans }}" disabled /></td>
                                                                        <td><input type="text" class="form-control form-control-solid mw-100px" id="team-{{ $team_rank->id }}-qty" name="team-{{ $team_rank->id }}-qty" value="{{ $financial_bid_estimate->$qty ?? 0 }}" oninput="_changeKaderQty('{{$team_rank->title}}',{{$financial_bid_estimate->project_id ?? $row->id }},$(this).val(),'{{csrf_token()}}');" />
                                                                        </td>
                                                                        <td><input type="text" class="form-control form-control-solid mw-100px" id="team-{{ $team_rank->id }}-price" name="team-{{ $team_rank->id }}-price" value="{{ $financial_bid_estimate->$price ?? 0 }}" oninput="_changeKaderPrice('{{$team_rank->title}}',{{$financial_bid_estimate->project_id ?? $row->id }},$(this).val(),'{{csrf_token()}}');" />
                                                                        </td>
                                                                        <td class="text-end">
                                                                            <a href="#" data-bs-toggle="modal" id="modal_team_rank_{{$team_rank->id}}" data-bs-target="#kt_modal_team_rank" class="btn btn-bg-light btn-color-muted btn-active-color-primary btn-sm px-4 me-2" value="row-{{ $team_rank->id }}-id">إضافة
                                                                                بند</a>
                                                                            <a href="#" class="btn btn-bg-secondary btn-color-muted btn-sm px-4">{{ $team_rank_items->firstWhere('type_id', $team_rank->id)->qty ?? 0 }}</a>
                                                                        </td>
                                                                    </tr>
                                                                    @elseif($row->type_id != 10 && $row->type_id != 9 && ($team_rank->id != 7 && $team_rank->id != 6))
                                                                    <tr>
                                                                        <td><input type="text" class="form-control form-control-solid mw-50px" id="team-{{ $team_rank->id }}-id" name="team-{{ $team_rank->id }}-id" value="{{ $team_rank->id }}" disabled /></td>
                                                                        <td><input type="text" class="form-control form-control-solid" id="team-{{ $team_rank->id }}-title" name="team-{{ $team_rank->id }}-title" value="{{ $team_rank->trans }}" disabled /></td>
                                                                        <td><input type="text" class="form-control form-control-solid mw-100px" id="team-{{ $team_rank->id }}-qty" name="team-{{ $team_rank->id }}-qty" value="{{ $financial_bid_estimate->$qty ?? 0 }}" oninput="_changeKaderQty('{{$team_rank->title}}',{{$financial_bid_estimate->project_id ?? $row->id }},$(this).val(),'{{csrf_token()}}');" />
                                                                        </td>
                                                                        <td><input type="text" class="form-control form-control-solid mw-100px" id="team-{{ $team_rank->id }}-price" name="team-{{ $team_rank->id }}-price" value="{{ $financial_bid_estimate->$price ?? 0 }}" oninput="_changeKaderPrice('{{$team_rank->title}}',{{$financial_bid_estimate->project_id ?? $row->id}},$(this).val(),'{{csrf_token()}}');" />
                                                                        </td>
                                                                        <td class="text-end">
                                                                            <a href="#" data-bs-toggle="modal" id="modal_team_rank_{{ $team_rank->id }}" data-bs-target="#kt_modal_team_rank" class="btn btn-bg-light btn-color-muted btn-active-color-primary btn-sm px-4 me-2" value="row-{{ $team_rank->id }}-id">إضافة
                                                                                بند</a>
                                                                            <a href="#" class="btn btn-bg-secondary btn-color-muted btn-sm px-4">{{ $team_rank_items->firstWhere('type_id', $team_rank->id)->qty ?? 0 }}</a>
                                                                        </td>
                                                                    </tr>
                                                                    @endif
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        @if (($row->type_id != 9 && $row->type_id != 10 && ($team_rank->id == 1 || $team_rank->id == 7)) || ($row->type_id == 10 && $team_rank->id == 6))
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#kt_modal_contract_realestate_items" class="btn btn-offical btn-sm px-4 me-2">إضافة فئات الحالات المبحوثة</a>
                                                        @endif
                                                    </div>
                                                </div>
                                                <!--end:Tax-->
                                            </div>
                                            <!--end::Card header-->
                                        </div>
                                        <!--end::Card body-->
                                    </div>
                                    <!--end::Card-->
                                </div>
                                @endif
                                <!--end:::Tab pane-->
                                <!--begin:::Tab pane-->
                                @if ($row->type_id != 14 && $row->type_id != 9)
                                <div class="tab-pane show mt-8">
                                    <h2>المعلومات العامة للمشروع</h2>
                                    <!--begin::Card-->
                                    <div class="card pt-4 mb-6 mb-xl-9 mt-8">
                                        <div class="card card-flush py-4">
                                            <div class="card-body pt-0">
                                                @if ($row->type_id != 14 && $row->type_id != 9 && $row->type_id != 10)
                                                <div class="d-flex flex-wrap gap-5 mt-5">
                                                    <div class="fv-row w-100 flex-md-root">
                                                        <label class="required fs-6 fw-semibold mb-2">{{ __('site.start_date') }}</label>
                                                        <div class="position-relative d-flex align-items-center">
                                                            <span class="svg-icon svg-icon-2 position-absolute mx-4">
                                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z" fill="currentColor" />
                                                                    <path d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z" fill="currentColor" />
                                                                    <path d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z" fill="currentColor" />
                                                                </svg>
                                                            </span>
                                                            @php
                                                            $date_rang = '';
                                                            if(!empty($financial_bid_estimate[0]->start_date) && !empty($financial_bid_estimate[0]->end_date)) {
                                                            $date_rang = $financial_bid_estimate[0]->start_date.' - '.$financial_bid_estimate[0]->end_date;
                                                            }
                                                            @endphp
                                                            <input class="form-control form-control-solid ps-12" placeholder="{{ __('site.start_date') }}" value="{{ $date_rang }}" name="date_range" id="date_range" />
                                                        </div>
                                                    </div>
                                                    <div class="fv-row w-100 flex-md-root">
                                                        <label class="required form-label">{{ __('project.beneficiary_preparation_pricing') }}</label>
                                                        <input type="text" class="form-control mb-2" onkeypress="return isNumberKey(event)" value="{{ $financial_bid_estimate[0]->beneficiary_preparation_pricing ?? '' }}" id="beneficiary_preparation_pricing" name="beneficiary_preparation_pricing" />
                                                        <div class="text-muted fs-7">{{ __('site.ksa_currency') }}.
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                                <div class="d-flex flex-wrap gap-5 mt-5">
                                                    @if ($row->type_id == 10 || $row->type_id == 2)
                                                    <div class="fv-row w-100 flex-md-root">
                                                        <label class="required form-label">تكلفة كتابة التقارير</label>
                                                        <input type="text" onkeypress="return isNumberKey(event)" class="form-control mb-2" value="{{ $financial_bid_estimate[0]->writing_report_cost ?? '' }}" id="writing_report_cost" name="writing_report_cost" />
                                                        <div class="text-muted fs-7">{{ __('site.ksa_currency') }}.
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                                <div class="gap-5 mt-5">
                                                    @if ($row->type_id == 1)
                                                    <div class="d-flex flex-stack">
                                                        <div class="d-flex">
                                                            <i class="bi bi-people fs-3x w-30px me-6"></i>
                                                            <div class="d-flex flex-column">
                                                                <a href="#" class="fs-5 text-dark text-hover-primary fw-bold required">قائمة الأسر</a>
                                                                <div class="fs-6 fw-semibold text-gray-400">هل يتطلب المشروع قائمة الأسر؟</div>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-end">
                                                            <div class="form-check form-check-solid form-check-custom form-switch">
                                                                <input class="form-check-input w-45px h-30px" type="checkbox" value="1" id="is_family_list_required" name="is_family_list_required" {{ $row->opening == 1 ? 'checked="checked"' : '' }} />
                                                                <label class="form-check-label" for="is_family_list_required">{{ __('site.yes') }}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @elseif($row->type_id == 2)
                                                    <div class="d-flex flex-stack">
                                                        <div class="d-flex">
                                                            <i class="bi bi-compass fs-3x w-30px me-6"></i>
                                                            <div class="d-flex flex-column">
                                                                <a href="#" class="fs-5 text-dark text-hover-primary fw-bold required">ملف الإحداثيات</a>
                                                                <div class="fs-6 fw-semibold text-gray-400">هل يتطلب المشروع ملف الإحداثيات؟</div>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-end">
                                                            <div class="form-check form-check-solid form-check-custom form-switch">
                                                                <input class="form-check-input w-45px h-30px" type="checkbox" value="1" id="is_coordinate_required" name="is_coordinate_required" {{ $row->opening == 1 ? 'checked="checked"' : '' }} />
                                                                <label class="form-check-label" for="is_coordinate_required">{{ __('site.yes') }}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Card body-->
                                    </div>
                                    <!--end::Card-->
                                </div>
                                @endif

                                <div class="text-center">
                                    <button type="reset" id="kt_edit_quote_cancel" class="btn btn-secondary me-3">إلغاء</button>
                                    <button id="kt_docs_form_validation_text_submit" type="submit" class="btn btn-primary">
                                        <span class="indicator-label">إنهاء وتسليم المهمة</span>
                                        <span class="indicator-progress">
                                            {{ __('site.please_wait')}} <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                        </span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
            </div>
            <!--end::Content-->
        </div>
        <!--end::Layout-->

        <input type="hidden" name="project_id" id="project_id" value="{{ $row->id }}" />

        <!--begin::MODALS-->
        <!--begin::Modal - Genderal Equipment-->
        <div class="modal fade" id="kt_modal_general_equipment" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-1000px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <div class="text-center">
                            <h1 class="text-success">التجهيزات العامة</h1>
                        </div>
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
                    <!--begin::Modal header-->
                    <!--begin::Modal body-->
                    <div class="modal-body scroll-y pt-0">
                        <div id="kt_modal_general_equipment_handler" data-kt-search-keypress="true" data-kt-search-min-length="2" data-kt-search-enter="enter" data-kt-search-layout="inline">
                            <div class="">
                                <form class="form" method="post" action="{{ url('operation/create') }}" novalidate="novalidate">
                                    @csrf
                                    <input type="hidden" name="project_id" id="project_id" value="{{ $row->id }}" />
                                    <input type="hidden" name="equipment_type" id="equipment_type" value="1" />

                                    <div class="modal-body scroll-y">
                                        <!--begin::Results(add d-none to below element to hide the users list by default)-->
                                        <div data-kt-search-element="results">
                                            <!--begin::Users-->
                                            <div class="mh-375px scroll-y me-n7 pe-2">
                                                @include('partials.backoffice.equipment.equipments_modal_header')
                                                @foreach ($selected_equipments as $selected_equipment)
                                                @if ($equipments->where('id', $selected_equipment->equipment_id)->first()->type_id == 1)
                                                <!--begin::User-->
                                                <div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="0">
                                                    <!--begin::Details-->
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Checkbox-->
                                                        <label class="form-check form-check-custom form-check-solid me-5">
                                                            <input checked id="{{ $selected_equipment->equipment_id }}" class="form-check-input" onclick="disable_option({{ $selected_equipment->equipment_id }},{{ $selected_equipment->equipment_type }},'selected')" type="checkbox" name="selected-equipment-checkbox[]" value="{{ $selected_equipment->equipment_id }}" />
                                                        </label>
                                                        <!--end::Checkbox-->
                                                        <!--begin::Details-->
                                                        <div class="ms-5">
                                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">{{ $equipments->where('id', $selected_equipment->equipment_id)->first()->title }}</a>
                                                        </div>
                                                        <!--end::Details-->
                                                    </div>
                                                    <!--end::Details-->
                                                    <!--begin::Access menu-->
                                                    <div class="ms-2">
                                                        <input type="text" onkeypress="return isNumberKey(event)" class="form-control" id="selected-equipment-price-{{ $selected_equipment->equipment_type }}-{{ $selected_equipment->equipment_id }}" name="selected-equipment-price[{{ $selected_equipment->equipment_id }}]" value="{{ $selected_equipment->price }}" />
                                                    </div>
                                                    <div class="ms-2">
                                                        <input type="text" onkeypress="return isNumberKey(event)" class="form-control" id="selected-equipment-qty-{{ $selected_equipment->equipment_type }}-{{ $selected_equipment->equipment_id }}" name="selected-equipment-qty[{{ $selected_equipment->equipment_id }}]" value="{{ $selected_equipment->qty }}" />
                                                    </div>
                                                    <!--end::Access menu-->
                                                </div>
                                                <!--end::User-->
                                                <!--begin::Separator-->
                                                <div class="border-bottom border-gray-300 border-bottom-dashed">
                                                </div>
                                                <!--end::Separator-->
                                                @endif
                                                @endforeach

                                                @foreach ($remaining_equipments->where('type_id', 1) as $equipment)
                                                <!--begin::User-->
                                                <div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="0">
                                                    <!--begin::Details-->
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Checkbox-->
                                                        <label class="form-check form-check-custom form-check-solid me-5">
                                                            <input id="{{ $equipment->id }}" class="form-check-input" type="checkbox" onclick="disable_option({{ $equipment->id }},{{ $equipment->type_id }},'remaining')" name="equipment-checkbox[]" value="{{ $equipment->id }}" data-kt-check="true" data-kt-check-target="[data-user-id='{{ $equipment->id }}']" />
                                                        </label>
                                                        <!--end::Checkbox-->
                                                        <!--begin::Details-->
                                                        <div class="ms-5">
                                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary">{{ $equipment->title }}</a>
                                                        </div>
                                                        <!--end::Details-->
                                                    </div>
                                                    <!--end::Details-->
                                                    <!--begin::Access menu-->
                                                    <div class="ms-2">
                                                        <input type="text" disabled onkeypress="return isNumberKey(event)" class="form-control" id="remaining-equipment-price-{{ $equipment->type_id }}-{{ $equipment->id }}" name="equipment-price[{{ $equipment->id }}]" placeholder="0" />
                                                    </div>
                                                    <div class="ms-2">
                                                        <input type="text" disabled onkeypress="return isNumberKey(event)" class="form-control" id="remaining-equipment-qty-{{ $equipment->type_id }}-{{ $equipment->id }}" name="equipment-qty[{{ $equipment->id }}]" placeholder="0" />
                                                    </div>
                                                    <!--end::Access menu-->
                                                </div>
                                                <!--end::User-->
                                                <!--begin::Separator-->
                                                <div class="border-bottom border-gray-300 border-bottom-dashed"></div>
                                                <!--end::Separator-->
                                                @endforeach
                                            </div>
                                            <!--end::Users-->
                                        </div>
                                        <!--end::Results-->
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                                        <button type="submit" id="save-equipments" class="btn btn-primary">حفظ التغييرات</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
        <!--end::Modals-->

        <!--begin::Modal - Training Equipment-->
        <div class="modal fade" id="kt_modal_training_equipment" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-1000px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <div class="text-center">
                            <h1 class="text-info">تجهيزات قسم التدريب</h1>
                        </div>
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
                    <!--begin::Modal header-->
                    <!--begin::Modal body-->
                    <div class="modal-body scroll-y pt-0">
                        <div id="kt_modal_training_equipment_handler" data-kt-search-keypress="true" data-kt-search-min-length="2" data-kt-search-enter="enter" data-kt-search-layout="inline">

                            <form class="form" action="{{ url('operation/create') }}" novalidate="novalidate" method="post">
                                @csrf
                                <input type="hidden" name="project_id" id="project_id" value="{{ $row->id }}" />
                                <input type="hidden" name="equipment_type" id="equipment_type" value="2" />

                                <div class="modal-body scroll-y">
                                    <!--begin::Results(add d-none to below element to hide the users list by default)-->
                                    <div data-kt-search-element="results">
                                        <!--begin::Users-->
                                        <div class="mh-375px scroll-y me-n7 pe-7">
                                            @include('partials.backoffice.equipment.equipments_modal_header')

                                            @foreach ($selected_equipments as $selected_equipment)
                                            @if ($equipments->where('id', $selected_equipment->equipment_id)->first()->type_id == 2)
                                            <!--begin::User-->
                                            <div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="0">
                                                <!--begin::Details-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Checkbox-->
                                                    <label class="form-check form-check-custom form-check-solid me-5">
                                                        <input checked id="{{ $selected_equipment->equipment_id }}" class="form-check-input" onclick="disable_option({{ $selected_equipment->equipment_id }},{{ $selected_equipment->equipment_type }},'selected')" type="checkbox" name="selected-equipment-checkbox[]" value="{{ $selected_equipment->equipment_id }}" />
                                                    </label>
                                                    <!--end::Checkbox-->
                                                    <!--begin::Details-->
                                                    <div class="ms-5">
                                                        <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">{{ $equipments->where('id', $selected_equipment->equipment_id)->first()->title }}</a>
                                                    </div>
                                                    <!--end::Details-->
                                                </div>
                                                <!--end::Details-->
                                                <!--begin::Access menu-->
                                                <div class="ms-2">
                                                    <input type="text" onkeypress="return isNumberKey(event)" class="form-control" id="selected-equipment-price-{{ $selected_equipment->equipment_type }}-{{ $selected_equipment->equipment_id }}" name="selected-equipment-price[{{ $selected_equipment->equipment_id }}]" value="{{ $selected_equipment->price }}" />
                                                </div>
                                                <div class="ms-2">
                                                    <input type="text" onkeypress="return isNumberKey(event)" class="form-control" id="selected-equipment-qty-{{ $selected_equipment->equipment_type }}-{{ $selected_equipment->equipment_id }}" name="selected-equipment-qty[{{ $selected_equipment->equipment_id }}]" value="{{ $selected_equipment->qty }}" />
                                                </div>
                                                <!--end::Access menu-->
                                            </div>
                                            <!--end::User-->
                                            <!--begin::Separator-->
                                            <div class="border-bottom border-gray-300 border-bottom-dashed">
                                            </div>
                                            <!--end::Separator-->
                                            @endif
                                            @endforeach

                                            @foreach ($remaining_equipments->where('type_id', 2) as $equipment)
                                            <!--begin::User-->
                                            <div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="0">
                                                <!--begin::Details-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Checkbox-->
                                                    <label class="form-check form-check-custom form-check-solid me-5">
                                                        <input id="{{ $equipment->id }}" class="form-check-input" type="checkbox" onclick="disable_option({{ $equipment->id }},{{ $equipment->type_id }},'remaining')" name="equipment-checkbox[]" value="{{ $equipment->id }}" data-kt-check="true" data-kt-check-target="[data-user-id='{{ $equipment->id }}']" />
                                                    </label>
                                                    <!--end::Checkbox-->
                                                    <!--begin::Details-->
                                                    <div class="ms-5">
                                                        <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">{{ $equipment->title }}</a>

                                                    </div>
                                                    <!--end::Details-->
                                                </div>
                                                <!--end::Details-->
                                                <!--begin::Access menu-->
                                                <div class="ms-2">
                                                    <input type="text" disabled onkeypress="return isNumberKey(event)" class="form-control" id="remaining-equipment-price-{{ $equipment->type_id }}-{{ $equipment->id }}" name="equipment-price[{{ $equipment->id }}]" placeholder="0" />
                                                </div>
                                                <div class="ms-2">
                                                    <input type="text" disabled onkeypress="return isNumberKey(event)" class="form-control" id="remaining-equipment-qty-{{ $equipment->type_id }}-{{ $equipment->id }}" name="equipment-qty[{{ $equipment->id }}]" placeholder="0" />
                                                </div>
                                                <!--end::Access menu-->
                                            </div>
                                            <!--end::User-->
                                            <!--begin::Separator-->
                                            <div class="border-bottom border-gray-300 border-bottom-dashed"></div>
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
                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
        <!--end::Modals-->

        <!--begin::Modal - Opening Equipment-->
        <div class="modal fade" id="kt_modal_opening_equipment" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-1000px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <div class="text-center">
                            <h1 class="text-warning">تجهيزات إفتتاح/إغلاق مشروع</h1>
                        </div>
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
                    <!--begin::Modal header-->
                    <!--begin::Modal body-->
                    <div class="modal-body scroll-y pt-0">
                        <div id="kt_modal_opening_equipment_handler" data-kt-search-keypress="true" data-kt-search-min-length="2" data-kt-search-enter="enter" data-kt-search-layout="inline">
                            <form class="form" action="{{ url('operation/create') }}" novalidate="novalidate" method="post">
                                @csrf
                                <input type="hidden" name="project_id" id="project_id" value="{{ $row->id }}" />
                                <input type="hidden" name="equipment_type" id="equipment_type" value="3" />

                                <div class="modal-body scroll-y">
                                    <!--begin::Results(add d-none to below element to hide the users list by default)-->
                                    <div data-kt-search-element="results">
                                        <!--begin::Users-->
                                        <div class="mh-375px scroll-y me-n7 pe-7">
                                            @include('partials.backoffice.equipment.equipments_modal_header')

                                            @foreach ($selected_equipments as $selected_equipment)
                                            @if ($equipments->where('id', $selected_equipment->equipment_id)->first()->type_id == 3)
                                            <!--begin::User-->
                                            <div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="0">
                                                <!--begin::Details-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Checkbox-->
                                                    <label class="form-check form-check-custom form-check-solid me-5">
                                                        <input checked id="{{ $selected_equipment->equipment_id }}" class="form-check-input" onclick="disable_option({{ $selected_equipment->equipment_id }},{{ $selected_equipment->equipment_type }},'selected')" type="checkbox" name="selected-equipment-checkbox[]" value="{{ $selected_equipment->equipment_id }}" />
                                                    </label>
                                                    <!--end::Checkbox-->
                                                    <!--begin::Details-->
                                                    <div class="ms-5">
                                                        <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">{{ $equipments->where('id', $selected_equipment->equipment_id)->first()->title }}</a>
                                                    </div>
                                                    <!--end::Details-->
                                                </div>
                                                <!--end::Details-->
                                                <!--begin::Access menu-->
                                                <div class="ms-2">
                                                    <input type="text" onkeypress="return isNumberKey(event)" class="form-control" id="selected-equipment-price-{{ $selected_equipment->equipment_type }}-{{ $selected_equipment->equipment_id }}" name="selected-equipment-price[{{ $selected_equipment->equipment_id }}]" value="{{ $selected_equipment->price }}" />
                                                </div>
                                                <div class="ms-2">
                                                    <input type="text" onkeypress="return isNumberKey(event)" class="form-control" id="selected-equipment-qty-{{ $selected_equipment->equipment_type }}-{{ $selected_equipment->equipment_id }}" name="selected-equipment-qty[{{ $selected_equipment->equipment_id }}]" value="{{ $selected_equipment->qty }}" />
                                                </div>
                                                <!--end::Access menu-->
                                            </div>
                                            <!--end::User-->
                                            <!--begin::Separator-->
                                            <div class="border-bottom border-gray-300 border-bottom-dashed">
                                            </div>
                                            <!--end::Separator-->
                                            @endif
                                            @endforeach

                                            @foreach ($remaining_equipments->where('type_id', 3) as $equipment)
                                            <!--begin::User-->
                                            <div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="0">
                                                <!--begin::Details-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Checkbox-->
                                                    <label class="form-check form-check-custom form-check-solid me-5">
                                                        <input id="{{ $equipment->id }}" class="form-check-input" type="checkbox" onclick="disable_option({{ $equipment->id }},{{ $equipment->type_id }},'remaining')" name="equipment-checkbox[]" value="{{ $equipment->id }}" data-kt-check="true" data-kt-check-target="[data-user-id='{{ $equipment->id }}']" />
                                                    </label>
                                                    <!--end::Checkbox-->
                                                    <!--begin::Details-->
                                                    <div class="ms-5">
                                                        <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">{{ $equipment->title }}</a>
                                                    </div>
                                                    <!--end::Details-->
                                                </div>
                                                <!--end::Details-->
                                                <!--begin::Access menu-->
                                                <div class="ms-2">
                                                    <input type="text" disabled onkeypress="return isNumberKey(event)" class="form-control" id="remaining-equipment-price-{{ $equipment->type_id }}-{{ $equipment->id }}" name="equipment-price[{{ $equipment->id }}]" placeholder="0" />
                                                </div>
                                                <div class="ms-2">
                                                    <input type="text" disabled onkeypress="return isNumberKey(event)" class="form-control" id="remaining-equipment-qty-{{ $equipment->type_id }}-{{ $equipment->id }}" name="equipment-qty[{{ $equipment->id }}]" placeholder="0" />
                                                </div>
                                                <!--end::Access menu-->
                                            </div>
                                            <!--end::User-->
                                            <!--begin::Separator-->
                                            <div class="border-bottom border-gray-300 border-bottom-dashed"></div>
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
                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
        <!--end::Modals-->

        <!--begin::Modal - Audting Equipment-->
        <div class="modal fade" id="kt_modal_auditing_equipment" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-1000px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <div class="text-center">
                            <h1 class="text-primary">تجهيزات قسم التدقيق</h1>
                        </div>
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
                    <!--begin::Modal header-->
                    <!--begin::Modal body-->
                    <div class="modal-body scroll-y pt-0">
                        <div id="kt_modal_auditing_equipment_handler" data-kt-search-keypress="true" data-kt-search-min-length="2" data-kt-search-enter="enter" data-kt-search-layout="inline">
                            <form class="form" action="{{ url('operation/create') }}" novalidate="novalidate" method="post">
                                @csrf
                                <input type="hidden" name="project_id" id="project_id" value="{{ $row->id }}" />
                                <input type="hidden" name="equipment_type" id="equipment_type" value="4" />

                                <div class="modal-body scroll-y">
                                    <!--begin::Results(add d-none to below element to hide the users list by default)-->
                                    <div data-kt-search-element="results">
                                        <!--begin::Users-->
                                        <div class="mh-375px scroll-y me-n7 pe-7">
                                            @include('partials.backoffice.equipment.equipments_modal_header')

                                            @foreach ($selected_equipments as $selected_equipment)
                                            @if ($equipments->where('id', $selected_equipment->equipment_id)->first()->type_id == 4)
                                            <!--begin::User-->
                                            <div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="0">
                                                <!--begin::Details-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Checkbox-->
                                                    <label class="form-check form-check-custom form-check-solid me-5">
                                                        <input checked id="{{ $selected_equipment->equipment_id }}" class="form-check-input" onclick="disable_option({{ $selected_equipment->equipment_id }},{{ $selected_equipment->equipment_type }},'selected')" type="checkbox" name="selected-equipment-checkbox[]" value="{{ $selected_equipment->equipment_id }}" />
                                                    </label>
                                                    <!--end::Checkbox-->
                                                    <!--begin::Details-->
                                                    <div class="ms-5">
                                                        <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">{{ $equipments->where('id', $selected_equipment->equipment_id)->first()->title }}</a>
                                                        <div class="fw-semibold text-muted">
                                                            {{ $selected_equipment->title }}
                                                        </div>
                                                    </div>
                                                    <!--end::Details-->
                                                </div>
                                                <!--end::Details-->
                                                <!--begin::Access menu-->
                                                <div class="ms-2">
                                                    <input type="text" onkeypress="return isNumberKey(event)" class="form-control" id="selected-equipment-price-{{ $selected_equipment->equipment_type }}-{{ $selected_equipment->equipment_id }}" name="selected-equipment-price[{{ $selected_equipment->equipment_id }}]" value="{{ $selected_equipment->price }}" />
                                                </div>
                                                <div class="ms-2">
                                                    <input type="text" onkeypress="return isNumberKey(event)" class="form-control" id="selected-equipment-qty-{{ $selected_equipment->equipment_type }}-{{ $selected_equipment->equipment_id }}" name="selected-equipment-qty[{{ $selected_equipment->equipment_id }}]" value="{{ $selected_equipment->qty }}" />
                                                </div>
                                                <!--end::Access menu-->
                                            </div>
                                            <!--end::User-->
                                            <!--begin::Separator-->
                                            <div class="border-bottom border-gray-300 border-bottom-dashed">
                                            </div>
                                            <!--end::Separator-->
                                            @endif
                                            @endforeach

                                            @foreach ($remaining_equipments->where('type_id', 4) as $equipment)
                                            <!--begin::User-->
                                            <div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="0">
                                                <!--begin::Details-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Checkbox-->
                                                    <label class="form-check form-check-custom form-check-solid me-5">
                                                        <input id="{{ $equipment->id }}" class="form-check-input" type="checkbox" onclick="disable_option({{ $equipment->id }},{{ $equipment->type_id }},'remaining')" name="equipment-checkbox[]" value="{{ $equipment->id }}" data-kt-check="true" data-kt-check-target="[data-user-id='{{ $equipment->id }}']" />
                                                    </label>
                                                    <!--end::Checkbox-->
                                                    <!--begin::Details-->
                                                    <div class="ms-5">
                                                        <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">{{ $equipment->title }}</a>
                                                        <div class="fw-semibold text-muted">
                                                            {{ $equipment->title }}
                                                        </div>
                                                    </div>
                                                    <!--end::Details-->
                                                </div>
                                                <!--end::Details-->
                                                <!--begin::Access menu-->
                                                <div class="ms-2">
                                                    <input type="text" disabled onkeypress="return isNumberKey(event)" class="form-control" id="remaining-equipment-price-{{ $equipment->type_id }}-{{ $equipment->id }}" name="equipment-price[{{ $equipment->id }}]" placeholder="0" />
                                                </div>
                                                <div class="ms-2">
                                                    <input type="text" disabled onkeypress="return isNumberKey(event)" class="form-control" id="remaining-equipment-qty-{{ $equipment->type_id }}-{{ $equipment->id }}" name="equipment-qty[{{ $equipment->id }}]" placeholder="0" />
                                                </div>
                                                <!--end::Access menu-->
                                            </div>
                                            <!--end::User-->
                                            <!--begin::Separator-->
                                            <div class="border-bottom border-gray-300 border-bottom-dashed"></div>
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
                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
        <!--end::Modals-->

        <!--begin::Modal - Team Rank-->
        <div class="modal fade" id="kt_modal_team_rank" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered mw-1000px">
                <div class="modal-content">
                    <div class="modal-header pb-0 border-0 justify-content-end">
                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                            <span class="svg-icon svg-icon-1">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                    <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                                </svg>
                            </span>
                        </div>
                    </div>
                    <div class="modal-body scroll-y pt-0 pb-15">
                        <form class="form" action="{{ url('operation/create-team-quote') }}" enctype="multipart/form-data" novalidate="novalidate" method="post">
                            @csrf
                            <input type="hidden" name="project_id" id="project_id" value="{{ $row->id }}" />
                            <input type="hidden" name="type_id" id="type_id" />
                            <div class="text-center mb-13">
                                <h1 class="mb-3">بنود العقد</h1>
                                <div class="text-muted fw-semibold fs-5">من هنا يمكنك إضافة بنود العقد لرتبة <span id="rank"></span></div>
                            </div>
                            <div id="contract_term_repeater">
                                <div class="form-group">
                                    <div data-repeater-list="contract_term_repeater">
                                        <div id="teamItemList">
                                            @include('partials.backoffice.project.team-item-list')
                                        </div>
                                        <div data-repeater-item>
                                            <div class="form-group row text-center">
                                                <div class="fv-row w-100 flex-md-root">
                                                    <label class="required form-label">{{ __('equipment.contract-term') }}</label>
                                                    <input type="text" class="form-control mb-2 w-540px" placeholder="{{ __('equipment.contract-term') }}" name="contract-term" />
                                                </div>
                                                <div class="col-md-4">
                                                    <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3 mt-md-8"><i class="la la-trash-o"></i>حذف</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-5">
                                    <a href="javascript:;" data-repeater-create class="btn btn-light-primary"><i class="la la-plus"></i>{{ __('project.add_contract_term') }}</a>
                                </div>
                                <div class="text-center">
                                    <button type="reset" data-bs-dismiss="modal" class="btn btn-secondary me-3">إلغاء</button>
                                    <button type="submit" class="btn btn-primary" id="kt_datatable_term_contract_submit">حفظ التغييرات</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Modals-->

        <!--begin::Modal - kt_modal_contract_realestate_items-->
        <div class="modal fade" id="kt_modal_contract_realestate_items" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered mw-1000px">
                <div class="modal-content">
                    <div class="modal-header pb-0 border-0 justify-content-end">
                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                            <span class="svg-icon svg-icon-1">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                    <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                                </svg>
                            </span>
                        </div>
                    </div>
                    <div class="modal-body scroll-y pt-0 pb-15">
                        <form class="form contractresearch" action="{{ url('operation/create-contract-research-items') }}" enctype="multipart/form-data" novalidate="novalidate" method="post">
                            @csrf
                            <input type="hidden" name="project_id" id="project_id" value="{{ $row->id }}" />
                            <div class="text-center mb-13">
                                <h1 class="mb-3">فئات الحالات المبحوثة</h1>
                                <div class="text-muted fw-semibold fs-5">من هنا يمكنك إضافة فئات الحالات<span id="rank"></span></div>
                            </div>
                            <div id="realestate_term_repeater">
                                <div class="form-group">
                                    <div data-repeater-list="realestate_term_repeater">
                                        <div class="form-group row text-center">
                                            <div class="col-md-4">
                                                <strong>
                                                    نوع العقار المحصور
                                                </strong>
                                                <br></br>
                                            </div>
                                            <div class="col-md-4">
                                                <strong>
                                                    فئة التسعيرة
                                                </strong>
                                                <br></br>
                                            </div>
                                            <div class="col-md-4">

                                            </div>
                                        </div>
                                        @php
                                        $realestatesIDs= [];
                                        @endphp
                                        @foreach ($project_contract_research_items as $project_contract_research_item)
                                        @php
                                        $realestatesIDs[]=$project_contract_research_item->realestate_id;
                                        @endphp
                                        <div written-realestate-repeater-item>
                                            <input type="hidden" class="form-control mb-2 w-540px" value="{{ $project_contract_research_item->id }}" id="realestate-id" />
                                            <div class="form-group row text-center">
                                                <div class="col-md-4">
                                                    <br>
                                                    <p>{{ $project_contract_research_item->realestateType[0]->title }}</p>
                                                    <input type="hidden" name="written-realestate-type[{{ $project_contract_research_item->id }}]" value="{{ $project_contract_research_item->id }}">
                                                </div>
                                                <div class="col-md-4 priceparentCC">
                                                    <span style="color:red;"></span>
                                                    {{-- TEST ABOIVE --}}
                                                    <input type="text" class="form-control mb-2 w-540px priceclassCC" value="{{ $project_contract_research_item->price }}" name="written-category-price[{{ $project_contract_research_item->id }}]" />
                                                </div>
                                                <div class="col-md-4">
                                                    <a href="javascript:;" written-realestate-repeater-delete class="btn btn-sm btn-light-danger" style="margin-top:6px;">
                                                        <i class="la la-trash-o"></i>حذف</a>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach

                                        @foreach ($realestate_types as $realestate)
                                        @php
                                        if(!in_array($realestate->id,$realestatesIDs)){
                                        @endphp
                                        <div data-repeater-item>
                                            <div class="form-group row text-center">
                                                <div class="col-md-4">
                                                    {{--
                                                    <label class="form-label">نوع العقار المحصور</label><br><br>
                                                    <select class="form-select" data-kt-repeater="select2" data-placeholder="إختر العقار" name="realestate-type">
                                                        @foreach ($realestate_types as $realestate_type)
                                           <option value="{{ $realestate_type->id }}" {{($realestate->id == $realestate_type->id) ? "selected" : ""}}>
                                                    {{ $realestate_type->title }}
                                                    </option>
                                                    @endforeach
                                                    </select>
                                                    --}}
                                                    <br>
                                                    <p>{{ $realestate->title }}</p>
                                                    <input type="hidden" name="realestate-type" value="{{$realestate->id}}">

                                                </div>
                                                <div class="col-md-4 priceparent">
                                                    <span style="color:red;"></span>
                                                    <input type="text" class="form-control mb-2 w-540px priceclass" value="0" name="category-price" />
                                                </div>
                                                <div class="col-md-4">
                                                    <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger" style="margin-top:6px;">
                                                        <i class="la la-trash-o"></i>حذف</a>
                                                </div>
                                            </div>
                                        </div>
                                        @php
                                        }
                                        @endphp
                                        @endforeach
                                    </div>
                                </div>
                                <div class="text-center mt-8" style="text-align:center;">
                                    <button type="reset" data-bs-dismiss="modal" class="btn btn-secondary me-3">إلغاء</button>
                                    <button type="button" class="btn btn-primary" id="kt_datatable_term_contract_submit" onclick="_checkPrice();">حفظ التغييرات</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Modals-->
        <!--end::MODALS-->
    </div>
    @include('partials.obstacle._obstacle')
</div>
@stop

@php
$startFinancial = '';
$endFinancial = '';
if(!empty($financial_bid_estimate[0]->start_date)) {
    $startFinancial = \Carbon\Carbon::parse($financial_bid_estimate[0]->start_date)->format('m/d/Y');
}
if(!empty($financial_bid_estimate[0]->end_date)) {
    $endFinancial = \Carbon\Carbon::parse($financial_bid_estimate[0]->end_date)->format('m/d/Y');
}
@endphp

@section('scripts')
<script>
    var startFinancial = '{{ $startFinancial }}';
    var endFinancial = '{{ $endFinancial}}';
    var p_startDateCa = "{{ \Carbon\Carbon::parse($row->start_date)->format('m/d/Y') }}";
    var p_endDateCa = "{{ \Carbon\Carbon::parse($row->end_date)->format('m/d/Y')}}";
    var date = new Date();
    $('#date_range').daterangepicker({
            minDate: p_startDateCa,
            maxDate: p_endDateCa,
            start: startFinancial,
            end: endFinancial,
        },
    );

    var kaderQtyURL = projectBaseUrl + '/operation/kader/qty';
    var kaderPriceURL = projectBaseUrl + '/operation/kader/price';
    function _changeKaderQty(team_title, project_id, qty, token) {
        let dat = {
            '_token': token,
            'team_title': team_title,
            'project_id': project_id,
            'qty': qty
        };
        $.post(kaderQtyURL, dat, function(data) {
            console.log(data.MSG);
        });
    }

    function _changeKaderPrice(team_title, project_id, price, token) {
        let dat = {
            '_token': token,
            'team_title': team_title,
            'project_id': project_id,
            'price': price
        };
        $.post(kaderPriceURL, dat, function(data) {
            console.log(data.MSG);
        });
    }

    var _checkPrice = () => {
        const error = new Array();
        for (let i = 0; i < $('div.priceparentCC').length; i++) {
            var pricer = $('div.priceparentCC:eq(' + i + ') input.priceclassCC').val();
            if (pricer === null || pricer.trim() === "") {
                $("div.priceparentCC:eq(" + i + ") span").html("ادخل السعر المناسب");
                error.push(1);
            } else {
                $("div.priceparentCC:eq(" + i + ") span").html("");
            }
        }
        if (error.length == 0) {
            $("form.contractresearch").submit();
        }
    }

    function deleteTeamRankItem(id) {
        Swal.fire({
            text: "{{ __('site.confirmMultiDeleteMessage') }}" + "؟",
            icon: "warning",
            showCancelButton: true,
            buttonsStyling: false,
            showLoaderOnConfirm: true,
            confirmButtonText: "{{ __('site.confirmButtonText') }}",
            cancelButtonText: "{{ __('site.cancelButtonText') }}",
            customClass: {
                confirmButton: "btn fw-bold btn-danger",
                cancelButton: "btn fw-bold btn-active-light-primary"
            },
        }).then(function(result) {
            const destroyRoute = 'operation/remove-team-rank-item';
            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: projectBaseUrl + destroyRoute,
                data: {
                    '_method': 'delete',
                    'id': id,
                },
                success: function(response, textStatus, xhr) {
                    if (result.value) {
                        Swal.fire({
                            text: "{{ __('site.deletingselecteditem') }}",
                            icon: "info",
                            buttonsStyling: false,
                            showConfirmButton: false,
                            timer: 2000
                        }).then(function() {
                            Swal.fire({
                                text: response['msg'], // respose from controller
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "{{ __('site.confirmButtonTextGotit') }}",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary",
                                }
                            }).then(function() {
                                // delete row data from server and re-draw datatable
                                dt.draw();
                            });

                            location.reload();
                        });
                    } else if (result.dismiss === 'cancel') {
                        Swal.fire({
                            text: "{{ __('site.notdeletedMessage') }}",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "{{ __('site.confirmButtonTextGotit') }}",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary",
                            }
                        });
                    }
                }
            });
        });
    }
</script>
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
<script src="{{ asset('assets/plugins/custom/fslightbox/fslightbox.bundle.js') }}"></script>
<script src="{{ asset('assets/js/custom/backoffice/operation.js') }}"></script>
@stop