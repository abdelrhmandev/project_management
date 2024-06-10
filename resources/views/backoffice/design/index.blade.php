@extends('layouts.app')

@section('breadcrumbs')
<div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
   <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">{{ __('project.all') }}
      <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
      <small class="text-muted fs-7 fw-semibold my-1 ms-1">{{ __('title_nav.dashboard') }}</small>
   </h1>
</div>
@stop

@section('content')
<!--begin::Container-->
<div id="kt_content_container" class="container-xxl">
    <div class="d-flex flex-center">
        <img class="py-2" data-dz-thumbnail="" alt="1" src="{{ asset('assets/media/underconstruction.svg') }}">
    </div>
    <div class="d-flex flex-center mt-8">
        <h1>جاري العمل على تطوير هذه الصفحة......</h1>
    </div>
    <div class="d-flex flex-center mt-2">
        <h5>يمكنك الإطلاع على باقي الأقسام المتوفرة داخل النظام</h5>
    </div>
</div>
<!--end::Container-->
@stop
