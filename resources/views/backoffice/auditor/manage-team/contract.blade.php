@extends('layouts.app')
@section('breadcrumbs')
<div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
   <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">
      <span class="h-20px border-gray-200 border-start ms-3 mx-2">{{ __('project.contract_details') }}</span>
      <small class="text-muted fs-7 fw-semibold my-1 ms-1">{{ __('title_nav.dashboard') }}</small>
   </h1>
</div>
@stop
@section('style')
<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />
<style>
   @font-face {font-family: "Sakkal Majalla";
   src: url("//db.onlinewebfonts.com/t/708bed747111fd418c6b35b909cd1d3a.eot");
   src: url("//db.onlinewebfonts.com/t/708bed747111fd418c6b35b909cd1d3a.eot?#iefix") format("embedded-opentype"),
   url("//db.onlinewebfonts.com/t/708bed747111fd418c6b35b909cd1d3a.woff2") format("woff2"),
   url("//db.onlinewebfonts.com/t/708bed747111fd418c6b35b909cd1d3a.woff") format("woff"),
   url("//db.onlinewebfonts.com/t/708bed747111fd418c6b35b909cd1d3a.ttf") format("truetype"),
   url("//db.onlinewebfonts.com/t/708bed747111fd418c6b35b909cd1d3a.svg#Sakkal Majalla") format("svg"); }
   .divContractPreview{
   font-family: 'Sakkal Majalla', sans-serif !important;
   font-size: 20px;
   }
   #clear_button {
   z-index: 10;
   position: absolute;
   padding: 1.5em 2em;
   color: #21cfa6;
   font-weight: 600;
   font-size: 12px;
   cursor: pointer;
   }
   #finish_button {
   z-index: 10;
   position: absolute;
   left: 2em;
   padding: 26.0em 0.5em;
   color:#1aa8f8;
   font-weight: 600;
   font-size: 12px;
   cursor: pointer;
   }
</style>
@endsection
@section('content')
<!--begin::Content-->
<div id="kt_content_container" class="container-xxl">
   <!--begin::Form-->
   <form id="kt_ecommerce_add_product_form" method="post" action="{{ route('team-member-generate-contract',[$projectId,$teamuserId,$typeTd]) }}" class="form d-flex flex-column flex-lg-row">
      @csrf
      @method('PUT')
      <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
         <div class="d-flex flex-column gap-7 gap-lg-10">
            <!--begin::General options-->
            <div class="card card-flush py-4">
               <!--begin::Card header-->
               <div class="card-header">
                  <div class="card-title">
                     <h2>{{ __('project.contract_details')}}</h2>
                  </div>
               </div>
               <!--end::Card header-->
               <!--begin::Card body-->
               <div class="card-body pt-0">
                  <!--begin::Input group-->
                  <div class="mb-10 fv-row">
                     @include('pages.contracts.index',[
                     'div_class'                   =>'divContractPreview',
                     'attracting'                  =>$row,
                     'team_rank_item'              =>$team_rank_item,
                     'typeTd'                      => Crypt::decrypt($typeTd),
                     'logo'                        =>$logo,
                     'team_rank_type_trans'        =>$team_rank_type_trans,
                     'today_day_arabic'            =>$today_day_arabic,
                     'project_title'               =>$project_title,
                     'contract_research_items'     =>$contract_research_items,
                     ])
                  </div>
                  <!--end::Input group-->
               </div>
               <!--end::Card header-->
            </div>
            <!--end::General options-->
         </div>
         <!--end::Tab content-->
         <div class="d-flex justify-content-end">
            <!--begin::Button-->
            <button id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">{{ __('site.cancel')}}</button>
            <!--end::Button-->
            <!--begin::Button-->
            <button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-primary">
            <span class="indicator-label">{{ __('site.save')}}</span>
            <span class="indicator-progress">{{ __('site.please_wait')}}...
            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
            <!--end::Button-->
         </div>
      </div>
   </form>
   <!--end::Main column-->
   <!--end::Form-->
</div>
<!--end::Content-->
@stop
