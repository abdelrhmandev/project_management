@extends('layouts.app')

@section('style')
<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />
@stop

@section('breadcrumbs')
<div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
   <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">{{ $list }}
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
      <h3 class="fw-bold my-2">{{ __('project.search_case')}}</h3>
      <!--end::Heading-->
      <div class="d-flex flex-wrap my-2">
         @include('partials.backoffice.filter',['placeholder'=>$placeholder])
      </div>
   </div>
   <!--end::Toolbar-->
   <!--begin::Row-->
   <div class="row g-6 g-xl-9" id="projectList">
      @forelse($rows as $row)
      <div class="col-md-6 col-xl-4 projectData" data-name="{{ $row->title }}">
         <!--begin:: Card header-->
         <a href="{{ $row->status->id >= 3 ? url('operation/followup/' . $row->id) : route($resource.'.edit', $row->id)}}" id="{{$row->status->id == 4 ? 'timing' : ''}}" data-value="{{ $row->id }}" class="card border-hover-primary" data-bs-toggle="{{ $row->status->id == 4 ? 'modal' : ''}}" data-bs-target="{{ $row->status->id == 4 ? '#kt_modal_new_card':''}}">
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
               <p class="text-gray-400 fw-semibold fs-5 mt-1 mb-7">إجمالي العدد: {{ $row->cases_count ?? $row->EmpowerCharity->charity_count ?? $row->building_count ?? '-' }}</p>
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

<!--begin::Modal - New Card-->
<div class="modal fade" id="kt_modal_new_card" tabindex="-1" aria-hidden="true">
   <!--begin::Modal dialog-->
   <div class="modal-dialog modal-dialog-centered mw-650px">
      <!--begin::Modal content-->
      <div class="modal-content">
         <!--begin::Modal header-->
         <div class="modal-header">
            <!--begin::Modal title-->
            <h2>الأيام المسموحة لإنهاء المهام</h2>
            <!--end::Modal title-->
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
         <!--end::Modal header-->
         <!--begin::Account Modal body-->
         <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
            <!--begin::Form-->
            <form class="form" id="dept-timing-form" data-route-url="{{ url('operation/dept-timing')}}" autocomplete="off" novalidate="novalidate" method="post">
               @csrf
               <input type="hidden" name="project_id" id="project_id" value="" />
               <!--begin::Input group-->
               <div class="d-flex flex-column fv-row">
                  <!--begin::Label-->
                  <label class="d-flex align-items-center fs-6 fw-semibold form-label">
                     <span class="required">أيام إنهاء التهيئة</span>
                  </label>
                  <!--end::Label-->
                  <input type="text" onkeypress="return isNumberKey(event)" class="form-control form-control-solid" placeholder="عدد الأيام" name="preparation_days" id="preparation_days" />
               </div>
               <!--end::Input group-->
               <!--begin::Input group-->
               <div class="d-flex flex-column mb-7 fv-row">
                  <!--begin::Label-->
                  <label class="required fs-6 fw-semibold form-label mb-2">أيام التنفيذ</label>
                  <!--end::Label-->
                  <!--begin::Input wrapper-->
                  <div class="position-relative">
                     <!--begin::Input-->
                     <input type="text" onkeypress="return isNumberKey(event)" class="form-control form-control-solid" placeholder="عدد الأيام" name="execution_days" id="execution_days" />
                     <!--end::Input-->
                  </div>
                  <!--end::Input wrapper-->
               </div>
               <!--end::Input group-->
               <!--begin::Actions-->
               <div class="text-center">
                  <button type="subtmit" class="btn btn-primary me-2" id="dept-timing-btn">إرسال</button>
                  <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
               </div>
               <!--end::Actions-->
            </form>
            <!--end::Form-->
         </div>
         <!--end::Account Modal body-->
      </div>
      <!--end::Modal content-->
   </div>
   <!--end::Modal dialog-->
</div>
<!--end::Modal - New Card-->
@stop

@section('scripts')
<script src="{{ asset('assets/js/custom/backoffice/operation-dues.js') }}"></script>
<script src="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
<script>
   $(document).on("click", "#timing", function() {
      var project_id = $(this).data("value");
      $('#project_id').val(project_id);
   });
</script>
@stop
