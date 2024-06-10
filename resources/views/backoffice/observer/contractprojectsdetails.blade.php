@extends('layouts.app')

@section('breadcrumbs')
<div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
    <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">العقود
        <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
        <small class="text-muted fs-7 fw-semibold my-1 ms-1">{{ __('title_nav.dashboard') }}</small>
    </h1>
</div>
@stop

@section('style')
<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />
@stop

@section('content')
<div id="kt_content_container" class="container-xxl">
    <div class="card">
        <div class="card-toolbar">
            <div class="d-flex justify-content-end" data-kt-table-toolbar="base">
                {{-- <a class="btn btn-primary" href="{{ route('admin.users.create') }}">{{ __($trans_file.'.create')}}</a> --}}
            </div>
            <div class="d-flex justify-content-end align-items-center d-none" data-kt-table-toolbar="selected">
                <button type="button" class="btn btn-danger" id="destroyMultipleroute" data-destroyMultiple-route="{{ route('admin.users.destroyMultipleUser') }}" data-kt-table-select="delete_selected">{{ __('customer.delete-selected') }}</button>
            </div>
        </div>
        <div class="card-body pt-4">
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_datatable">
                <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-125px">{{ __('site.name')}}</th>
                        <th class="min-w-5px">{{ __('site.national_id')}}</th>
                        <th class="min-w-5px">{{ __('site.mobile')}}</th>
                        <th class="min-w-125px">{{ __('site.email')}}</th>
                        <th class="min-w-5px">حالة الموافقة</th>
                        <th class="min-w-250px">التفاصيل</th>
                    </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600">
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="kt_modal_view_rejection_reason" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold">سبب رفض العقد</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <span class="svg-icon svg-icon-1">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                        </svg>
                    </span>
                </div>
            </div>
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <div class="fv-row mb-7">
                    <label class="fs-6 fw-semibold form-label mb-2">
                        <span class="">سبب الرفض</span>
                    </label>
                    <div class="alert alert-dismissible bg-light-danger border border-dashed d-flex flex-column flex-sm-row p-5 mb-10" style="height: 130px;">
                        <i class="ki-duotone ki-search-list fs-2hx text-success me-4 mb-5 mb-sm-0"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                        <div class="d-flex flex-column pe-0 pe-sm-10">
                            <div id="rejection_reason" class="text-gray-900 text-hover-primary fs-6 fw-bold"></div>
                        </div>
                        <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                            <i class="ki-duotone ki-cross fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
                        </button>
                    </div>
                </div>
                <div class="text-center pt-15">
                    <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">{{__('site.cancel')}}</button>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('scripts')
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
@include('includes.datatables_contract')
@include('scripts.contract-actions')
<script>
    var dynamicColumns = [{
        data: 'name',
        name: 'name'
    }, {
        data: 'national_id',
        name: 'national_id'
    }, {
        data: 'mobile',
        name: 'mobile'
    }, {
        data: 'email',
        name: 'email'
    }, {
        data: 'approved',
        name: 'approved'
    }, {
        data: 'contract_url',
        name: 'contract_url'
    }];

    KTUtil.onDOMContentLoaded(function() {
        loadDatatable('{{ $url }}', dynamicColumns);
    });
</script>
@stop