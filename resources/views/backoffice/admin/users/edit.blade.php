@extends('layouts.app')

@section('breadcrumbs')
<div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
    <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">{{ __($trans_file . '.all') }}
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
                    <h3 class="fw-bold m-0">{{ __('user.info') }}</h3>
                </div>
            </div>
            <div id="kt_account_settings_profile_details" class="collapse show">
                <form class="form" action="{{ route('admin.users.update',$row->id) }}" enctype="multipart/form-data" novalidate="novalidate" id="kt_account_profile_details_form" method="post">
                    @csrf
                    @method('PUT')
                    <div class="card-body border-top p-9">
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('site.name') }}</label>
                            <div class="col-lg-8 fv-row">
                                <input type="text" name="name" value="{{ $row->name }}" class="form-control form-control-lg form-control-solid" placeholder="{{ __('site.name') }}" />
                                @error('name')
                                <div class="fv-plugins-message-container invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('role.title') }}</label>
                            <div class="col-lg-8 fv-row">
                                <?php if (!empty($row->getRoleNames())) {
                                    foreach ($row->getRoleNames() as $v) {
                                        if (!empty($v)) {
                                            echo $v;
                                        }
                                    }
                                }
                                ?>
                            </div>
                        </div>

                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('site.email') }}</label>
                            <div class="col-lg-8 fv-row">
                                <input type="text" name="email" value="{{ $row->email }}" class="form-control form-control-lg form-control-solid" placeholder="{{ __('site.email') }}" />
                                @error('email')
                                <div class="fv-plugins-message-container invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('site.username') }}</label>
                            <div class="col-lg-8 fv-row">
                                <input type="text" name="username" value="{{ $row->username }}" class="form-control form-control-lg form-control-solid" placeholder="{{ __('site.username') }}" />
                                @error('username')
                                <div class="fv-plugins-message-container invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        {{-- <div class="row mb-6">
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('site.password') }}</label>
                        <div class="col-lg-8 fv-row">
                            <input type="password" name="password" class="form-control form-control-lg form-control-solid" placeholder="{{ __('site.password') }}" />
                            @error('password')
                            <div class="fv-plugins-message-container invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div> --}}

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('site.avatar') }}</label>
                        <div class="col-lg-8 fv-row">
                            <!--begin::Label-->
                            <label class="d-block fw-semibold fs-6 mb-5">
                                <span class="required">{{ __('site.avatar') }}</span>
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="{{ __('site.avatar') }}"></i>
                            </label>
                            <!--end::Label-->
                            <!--begin::Image input placeholder-->
                            <style>
                                .image-input-placeholder {
                                    background-image: url({{ asset('assets/media/svg/files/blank-image.svg')}});
                                }

                                @if($row->avatar) .image-input-placeholder {
                                    background-image: url({{ asset("storage/".$row->avatar)}});
                                }

                                @endif [data-theme="dark"] .image-input-placeholder {
                                    background-image: url('assets/media/svg/files/blank-image-dark.svg');
                                }
                            </style>
                            <!--end::Image input placeholder-->
                            <!--begin::Image input-->
                            <div class="image-input image-input-empty image-input-outline image-input-placeholder" data-kt-image-input="true">
                                <!--begin::Preview existing avatar-->
                                <div class="image-input-wrapper w-125px h-125px"></div>
                                <!--end::Preview existing avatar-->
                                <!--begin::Label-->
                                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="{{ __('site.edit') }}">
                                    <i class="bi bi-pencil-fill fs-7"></i>
                                    <!--begin::Inputs-->
                                    <input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
                                    <input type="hidden" name="avatar_remove" />
                                    <!--end::Inputs-->
                                </label>
                                @error('avatar')
                                <div class="fv-plugins-message-container invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                                <!--end::Label-->
                                <!--begin::Cancel-->
                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="{{ __('site.cancel') }}">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                                <!--end::Cancel-->
                                <!--begin::Remove-->
                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="{{ __('site.remove') }}">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                                <!--end::Remove-->
                            </div>
                            <!--end::Image input-->
                            <!--begin::Hint-->
                            <div class="form-text">{{ __('site.allowed_file') }} png, jpg, jpeg </div>
                            <!--end::Hint-->
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('site.activeted') }}</label>
                        <div class="col-lg-8 fv-row">
                            <label class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" name="active_status" id="active_status" @if($row->active_status == 1) checked @endif/>
                                <span class="form-check-label fw-semibold text-muted">{{ __('site.activeted') }}</span>
                            </label>
                        </div>
                    </div>
            </div>

            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button type="reset" class="btn btn-light btn-active-light-primary me-2" id="kt_cancel_user">{{ __('admin.cancel') }}</button>
                <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">{{ __('admin.save') }}</button>
            </div>
            </form>
        </div>
    </div>
</div>
</div>
@stop

@section('scripts')
<script src="{{ asset('assets/js/custom/backoffice/admin.js') }}"></script>
@stop
