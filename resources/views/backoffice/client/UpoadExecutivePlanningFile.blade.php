@extends('layouts.app')

@section('breadcrumbs')
<div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
   <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">{{ $row->title }}
      <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
      <small class="text-muted fs-7 fw-semibold my-1 ms-1">{{ __('title_nav.dashboard') }}</small>
   </h1>
</div>
@stop

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div id="kt_content_container" class="container-xxl">
        <div class="card mb-5 mb-xl-10">
            <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0"> الخطه التنفيذيه الخاصه بمشروع {{ $row->title }} </h3>
                </div>
            </div>
            <div id="kt_account_settings_profile_details" class="collapse show">
                <form class="form" action="{{ route('RejectedProjectsPlanningSubmitUploadExFile',$row->id)}}" enctype="multipart/form-data" novalidate="novalidate" id="kt_account_profile_details_form" method="post">
                    @csrf
                    @method('PUT')
                    <div class="card-body border-top p-9">
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-semibold fs-6">رفع ملف الخطه التنفيذيه</label>
                            <div class="col-lg-8 fv-row">
                                <input type="file" name="executive_planning_file" accept=".doc,.docx" required/>
                            </div>
                        </div>                                                                                                   
                    </div>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <button type="reset" class="btn btn-light btn-active-light-primary me-2" id="kt_cancel_customer">{{ __('admin.cancel') }}</button>
                        <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">{{ __('admin.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('scripts')
<script src="{{ asset('assets/js/custom/backoffice/admin.js')}}"></script>
@stop
