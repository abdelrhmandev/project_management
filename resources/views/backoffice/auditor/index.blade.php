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
   <!--begin::Toolbar-->
   <div class="d-flex flex-wrap flex-stack mb-6">
      <!--begin::Heading-->
      <h3 class="fw-bold my-2">قائمة المشاريع</h3>
      <!--end::Heading-->
      <!--begin::Actions-->
      <div class="d-flex flex-wrap my-2">
      @include('partials.backoffice.filter')
      </div>
      <!--end::Actions-->
   </div>
   <!--end::Toolbar-->

   <!--begin::Row-->
   <div class="row g-6 g-xl-9" id="projectList">
      @forelse($rows as $row)
      <div class="col-md-6 col-xl-4 projectData" data-name="{{ $row->title }}">
         <!--begin:: Card header-->
         <a href="{{ $row->status_id === 8 ? url('auditor/get-team-members/'.$row->id) : route($resource.'.edit', $row->id) }}" class="card border-hover-primary">
            <div class="card-header border-0 pt-9">
               <div class="card-title m-0">
                  <div class="symbol symbol-50px w-50px bg-light"> <img src="{{ asset("storage/".$row->logo) }}" alt="{{ $row->title }}" class="p-3" /> </div>
               </div>
               <div class="card-toolbar"> <span class="badge badge-light-primary fw-bold me-auto px-4 py-3">{{ $status[$row->status_id-1]->trans }}</span></div>
            </div>
            <!--end:: Card header-->
            <!--begin:: Card body-->
            <div class="card-body p-9">
               <!--begin::Name-->
               <div class="fs-3 fw-bold text-dark">{{ $row->title }}</div>
               <!--end::Name-->
               <!--begin::Description-->
               <p class="text-gray-400 fw-semibold fs-5 mt-1 mb-7">إجمالي العدد: {{ $row->cases_count ?? $row->EmpowerCharity->charity_count ?? $row->building_count ?? '-'}}</p>
               <!--end::Description-->
               <!--begin::Info-->
               <div class="d-flex flex-wrap mb-5">
                  <!--begin::Due-->
                  <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-7 mb-3">
                     <div class="fs-6 text-gray-800 fw-bold">{{ $row->start_date ?? '-' }}</div>
                     <div class="fw-semibold text-gray-400">{{ __('project.start_date') }}</div>
                  </div>
                  <!--end::Due-->
                  <!--begin::Budget-->
                  <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 mb-3">
                     <div class="fs-6 text-gray-800 fw-bold">{{ $row->end_date ?? '-' }}</div>
                     <div class="fw-semibold text-gray-400">{{ __('project.end_date') }}</div>
                  </div>
                  <!--end::Budget-->
               </div>
               <!--end::Info-->
               <!--begin::Progress-->
               <div class="h-4px w-100 bg-light mb-5" data-bs-toggle="tooltip" title="تم إنجاز ما يقارب {{$row->progress_bar}}% من المشروع">
                  <div class="bg-primary rounded h-4px" role="progressbar" style="width:{{$row->progress_bar}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                  {{ $row->progress_bar }}%
               </div>
               <!--end::Progress-->
            </div>
            <!--end:: Card body-->
         </a>
         <!--end::Card-->
      </div>
      @empty @include('partials.alerts.empty',['msg'=>__('project.empty')]) @endforelse
      <div class="d-flex flex-stack flex-wrap pt-10">
         {!! $rows->links() !!}
      </div>
   </div>
   <!--end::Row-->
</div>
<!--end::Container-->
@stop