@extends('layouts.app')

@section('breadcrumbs')
<div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
   <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">{{ __('user.all') }} {{ $counter }}
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
                <div class="fw-bold me-5">
                    <span class="me-2" data-kt-table-select="selected_count"></span>{{ __('customer.selected') }}
                </div>
                <button type="button" class="btn btn-danger" id="destroyMultipleroute" data-destroyMultiple-route="{{ route('admin.users.destroyMultipleUser') }}" data-kt-table-select="delete_selected">{{ __('customer.delete-selected') }}</button>
            </div>
        </div>
        <div class="card-body pt-4">
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_datatable">
                <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-125px">{{ __('site.name')}}</th>
                        <th class="min-w-125px">{{ __('site.national_id')}}</th>
                        <th class="min-w-125px">{{ __('site.mobile')}}</th>
                        <th class="min-w-125px">{{ __('site.email')}}</th>
                        <th class="min-w-125px">{{ __('site.contract')}}</th>
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
@include('includes.datatables_contract')

<script>
    var dynamicColumns = [{
            data: 'atttractingTeamInfo.name',
            name: 'atttractingTeamInfo.name'
        },{
            data: 'atttractingTeamInfo.national_id',
            name: 'atttractingTeamInfo.national_id'
        },{
            data: 'atttractingTeamInfo.mobile',
            name: 'atttractingTeamInfo.mobile'
        },{
            data: 'atttractingTeamInfo.email',
            name: 'atttractingTeamInfo.email'
        },{
            data: 'contract_url',
            name: 'contract_url'
        }
    ];

    KTUtil.onDOMContentLoaded(function() {
        loadDatatable('{{ $url }}', dynamicColumns);
    });
</script>
@stop