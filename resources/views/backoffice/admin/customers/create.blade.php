@extends('layouts.app')
@section('breadcrumbs')
<div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
   <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">{{ __($trans_file.'.create') }}
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
                    <h3 class="fw-bold m-0">{{ __('customer.customer-info') }}</h3>
                </div>
            </div>

            <div id="kt_account_settings_profile_details" class="collapse show">
                <form class="form" action="{{ route('admin.customers.store')}}" enctype="multipart/form-data" novalidate="novalidate" id="kt_account_profile_details_form" method="post">
                    @csrf
                    <div class="card-body border-top p-9">
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">العميل</label>
                            <div class="col-lg-8 fv-row">
                                <select name="user_id" aria-label="أختر العميل" data-control="select2" data-placeholder="العميل" class="form-select form-control form-control-lg form-control-solid">
                                    <option value=""></option>
                                    @foreach ($users as $users)
                                        <option value="{{ $users->id }}">{{ $users->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('customer.customer-name') }}</label>
                            <div class="col-lg-8 fv-row">
                                <input type="text" name="customer-name" class="form-control form-control-lg form-control-solid" placeholder="{{ __('customer.customer-name') }}" />
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('customer.principal-name') }}</label>
                            <div class="col-lg-8 fv-row">
                                <input type="text" name="principal-name" class="form-control form-control-lg form-control-solid" placeholder="{{ __('customer.principal-name') }}" />
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('customer.principal-position') }}</label>
                            <div class="col-lg-8 fv-row">
                                <input type="text" name="principal-position" class="form-control form-control-lg form-control-solid" placeholder="{{ __('customer.principal-position') }}" />
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                <span class="required">{{ __('customer.principal-mobile') }}</span>
                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Phone number must be active"></i>
                            </label>
                            <div class="col-lg-8 fv-row">
                                <input type="tel" name="principal-mobile" id="principal-mobile" class="form-control form-control-lg form-control-solid" placeholder="{{ __('customer.principal-mobile') }}" />
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('customer.principal-email') }}</label>
                            <div class="col-lg-8 fv-row">
                                <input type="text" name="principal-email" id="principal-email" class="form-control form-control-lg form-control-solid" placeholder="{{ __('customer.principal-email') }}" />
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <button type="reset" class="btn btn-light btn-active-light-primary me-2" id="kt_cancel_customer">{{ __('admin.cancel') }}</button>
                        <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">{{ __('admin.add') }}</button>
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
