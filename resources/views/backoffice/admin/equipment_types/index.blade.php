@extends('layouts.app')
@section('breadcrumbs')
<div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
   <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">{{ __('equipment.type') }}
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
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <div class="d-flex align-items-center position-relative my-1">
                    <span class="svg-icon svg-icon-1 position-absolute ms-6">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                            <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                        </svg>
                    </span>
                    <input type="text" data-kt-table-filter="search" class="form-control form-control-solid w-200px ps-15" placeholder="{{ __('site.search') }} ......" />
                </div>
            </div>

            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-table-toolbar="base">
                    <a class="btn btn-primary" href="{{ route('admin.equipment_type.create') }}">{{ __('equipment.create_type')}}</a>
                </div>
                <div class="d-flex justify-content-end align-items-center d-none" data-kt-table-toolbar="selected">
                    <div class="fw-bold me-5">
                        <span class="me-2" data-kt-table-select="selected_count"></span>{{ __('customer.selected') }}
                    </div>
                    <button type="button" class="btn btn-danger" id="destroyMultipleroute" data-destroyMultiple-route="{{ route('admin.equipments.destroyMultipleEquipmentType') }}" data-kt-table-select="delete_selected">{{ __('customer.delete-selected') }}</button>
                </div>
            </div>
        </div>
        <div class="card-body pt-0">
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_datatable">
                <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th class="w-10px pe-2 noExport">
                            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_datatable .form-check-input" value="1" />
                            </div>
                        </th>
                        <th class="min-w-125px">{{ __('equipment.type')}}</th>
                        <th class="text-end min-w-70px">{{ __('customer.options')}}</th>
                    </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600">
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop

@section('scripts')
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
@include('includes.datatables')

<script>
    var dynamicColumns = [{
            data: 'id',
            name: 'id',
            exportable: false
        },{
            data: 'title',
            name: 'title'
        },{
            data: 'actions',
            name: 'actions'
        },
    ];

    KTUtil.onDOMContentLoaded(function() {
        loadDatatable('{{ route('admin.equipment_types.index') }}', dynamicColumns);
    });
</script>
@stop