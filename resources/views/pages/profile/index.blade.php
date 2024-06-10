@extends('layouts.app')

@section('breadcrumbs')
<div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
    <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">{{ __('site.profile') }}
        <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
        <small class="text-muted fs-7 fw-semibold my-1 ms-1">{{ __('title_nav.dashboard') }}</small>
    </h1>
</div>
@stop

@section('content')
<div id="kt_content_container" class="container-xxl">
    <!--begin::Basic info-->
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">بيانات الحساب</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Card header-->
        <!--begin::Content-->
        <div id="kt_account_settings_profile_details" class="collapse show">
            <!--begin::Form-->
            <form method="post" enctype="multipart/form-data" id="kt_account_profile_details_form" class="form" action="{{ route('update.profile')}}">
                @method('PUT')
                @csrf
                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">الصوره الشخصيه</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Image input-->
                            <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('assets/media/svg/avatars/blank.svg')">
                                <!--begin::Preview existing avatar-->
                                <div class="image-input-wrapper w-125px h-125px" style="background-image: url({{ asset('storage/' . Auth::user()->avatar) }}), url({{ asset('assets/media/avatars/blank.png') }}) " ></div>
                                <!--end::Preview existing avatar-->
                                <!--begin::Label-->
                                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change">
                                    <i class="bi bi-pencil-fill fs-7"></i>
                                    <!--begin::Inputs-->
                                    <input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
                                    <input type="hidden" name="avatar_remove" />
                                    <!--end::Inputs-->
                                </label>
                                <!--end::Label-->
                                <!--begin::Cancel-->
                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                                <!--end::Cancel-->
                                <!--begin::Remove-->
                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                                <!--end::Remove-->
                            </div>
                            <!--end::Image input-->
                            <!--begin::Hint-->
                            <div class="form-text">الإمتدادات المسموحه: png, jpg, jpeg.</div>
                            <!--end::Hint-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">الإسم كاملاً
                        </label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="text" name="name" value="{{ auth()->user()->name }}" class="form-control form-control-lg form-control-solid" />
                            @error('name')
                            <div class="fv-plugins-message-container invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">
                            البريد الإلكتروني
                        </label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="text" name="email" value="{{ auth()->user()->email }}" class="form-control form-control-lg form-control-solid" disabled/>
                            @error('email')
                            <div class="fv-plugins-message-container invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">
                            <span>رقم الجوال</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="tel" name="mobile" value="{{ auth()->user()->mobile }}" class="form-control form-control-lg form-control-solid" />
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">
                            <span>رقم الهويه</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="text" name="national_id" value="{{ auth()->user()->national_id }}" class="form-control form-control-lg form-control-solid" />
                            @error('national_id')
                            <div class="fv-plugins-message-container invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">
                            <span>المنطقه</span>
                            <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="المنطقه"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <select name="region_id" aria-label="إختر المنطقه" data-control="select2" data-placeholder="إختر المنطقه..." class="form-select form-select-solid form-select-lg fw-semibold">
                                <option value="">إختر المنطقه...</option>
                                @foreach ($regions as $region)
                                <option value="{{ $region->id }}" {{ $region->id == auth()->user()->region_id ? 'selected':'dasdsa'; }}>{{ $region->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!--end::Col-->
                    </div>
                    <div class="row mb-0">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">تغير كلمه المرور</label>
                        <!--begin::Label-->
                        <!--begin::Label-->
                        <div class="col-lg-8 d-flex align-items-center">
                            <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                                <input class="form-check-input w-45px h-30px" type="checkbox" value="1" name="change_password" onchange="managePassword(this)" />
                                <label class="form-check-label" for="allowchangePassword"></label>
                            </div>
                        </div>
                        <!--begin::Label-->
                    </div>
                    <div class="row mb-6 d-none" id="passwordDiv">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">كلمه المرور</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row mt-4">
                            <input type="password" name="password" class="form-control form-control-lg form-control-solid" />
                            @error('password')
                            <div class="fv-plugins-message-container invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                </div>
                <!--end::Card body-->
                <!--begin::Actions-->
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="submit" class="btn btn-primary me-2" id="kt_account_profile_details_submit">حفظ التغييرات</button>
                    <button type="reset" class="btn btn-light btn-active-light-primary" id="kt_account_profile_details_cancel">{{ __('admin.cancel') }}</button>
                </div>
                <!--end::Actions-->
            </form>
            <!--end::Form-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Basic info-->
</div>
@stop

@section('scripts')
<script>
    function managePassword(checkboxItem) {
        if (checkboxItem.checked) {
            document.getElementById('passwordDiv').classList.remove("d-none");
        } else {
            document.getElementById('passwordDiv').classList.add("d-none");
        }
    }
    
    $(document).on("click", "#kt_account_profile_details_cancel", function() {
        window.location.href = projectBaseUrl+'/'+<?php echo json_encode(Illuminate\Support\Facades\Auth::user()->roles[0]->name); ?>; // make request
    });
</script>
@stop