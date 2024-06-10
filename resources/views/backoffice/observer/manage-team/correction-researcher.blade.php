@extends('layouts.app')
@section('content')
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">
        <div class="content d-flex flex-row">
            <!--begin::Search-->
            <div class="col-lg-6 col-xl-3 mb-8">
                <!--begin::Contacts-->
                <div class="card card-flush" id="kt_contacts_list">
                    <!--begin::Card header-->
                    <div class="card-header pt-7" id="kt_contacts_list_header">
                        <!--begin::Form-->
                        <form class="d-flex align-items-center position-relative w-100 m-0" autocomplete="off">
                            <!--begin::Icon-->
                            <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                            <span class="svg-icon svg-icon-3 svg-icon-gray-500 position-absolute top-50 ms-5 translate-middle-y">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                    <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <!--end::Icon-->
                            <!--begin::Input-->
                            <input type="hidden" class="form-control form-control-solid ps-13" name="project_id" id="project_id" value="{{ $project_id }}" />
                            <input type="text" class="form-control form-control-solid ps-13" name="search" value="" placeholder="إبحث عن المشرفين" />
                            <!--end::Input-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-5" id="kt_contacts_list_body">
                        <!--begin::List-->
                        <div class="scroll-y me-n5 pe-5 h-300px h-xl-auto" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_header, #kt_toolbar, #kt_footer, #kt_contacts_list_header" data-kt-scroll-wrappers="#kt_content, #kt_contacts_list_body" data-kt-scroll-stretch="#kt_contacts_list, #kt_contacts_main" data-kt-scroll-offset="5px">
                            @foreach($observer_teams->where('type_id', 4)->where('superior_id', Auth::user()->id)->all() as $observer_team)
                            <div class="mb-2">
                                <!--begin::Option-->
                                <label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex align-items-center form-check-label" for="kt_create_account_form_account_type_personal . {{$observer_team->team_user_id}}">
                                    <input type="radio" onClick="reloadResearcher({{ $observer_team->team_user_id }}, {{ $project_id }}, 'correction')" class="form-check-input" name="team_user_id" value="{{$observer_team->superior_id}}" id="kt_create_account_form_account_type_personal . {{$observer_team->team_user_id}}" />
                                    <!--begin::Details-->
                                    <div class="ms-4">
                                        <span class="fs-6 fw-bold text-gray-900">{{ $attracting_teams->where('id', $observer_team->team_user_id)->first()->name }}</span>
                                        <div class="fw-semibold fs-7 text-muted text-start">{{ $attracting_teams->where('id', $observer_team->team_user_id)->first()->performance_percentage }}% - الباحثين {{$observer_teams->where('superior_team_id', $observer_team->team_user_id)->count()}} / {{$observer_team->qty}}</div>
                                    </div>
                                    <!--end::Details-->
                                </label>
                            </div>
                            <!--end::Option-->
                            <!--begin::Separator-->
                            <div class="separator separator-dashed d-none mt-4"></div>
                            <!--end::Separator-->
                            @endforeach
                        </div>
                        <!--end::List-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Contacts-->
            </div>
            <!--end::Search-->
            <!--begin::Search-->
            <div class="col-lg-6 col-xl-6 mb-8 mx-8">
                <!--begin::Contacts-->
                <div class="card card-flush" id="kt_contacts_list">
                    <!--begin::Card header-->
                    <div class="card-header pt-7" id="kt_contacts_list_header">
                        <!--begin::Form-->
                        <form class="d-flex align-items-center position-relative" autocomplete="off">
                            <!--begin::Icon-->
                            <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                            <span class="svg-icon svg-icon-3 svg-icon-gray-500 position-absolute top-50 ms-5 translate-middle-y">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                    <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <!--end::Icon-->
                            <!--begin::Input-->
                            <input type="hidden" id="observerFilterUrl" value="{{ url('observer/ajaxFilter/'.$project_id) }}">
                            <input type="hidden" name="filter_superior_id" id="filter_superior_id"  value="" />
                            <input type="text" disabled id="observerFilterResearcher" class="form-control form-control-solid ps-13" name="search" value="" placeholder="إبحث عن الباحثين" style="padding-left:25rem"/>
                            <!--end::Input-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-8" id="kt_contacts_list_body">
                        <input type="hidden" name="superior_id" id="superior_id" value="" />
                        <input type="hidden" name="project_id" id="project_id" value="{{ $project_id }}" />
                        <input type="hidden" name="is_correction" id="is_correction" value="true" />

                        <!--begin::List-->
                        <div class="scroll-y me-n5 pe-5 h-600px h-xl-auto" id="researcherlist" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_header, #kt_toolbar, #kt_footer, #kt_contacts_list_header" data-kt-scroll-wrappers="#kt_content, #kt_contacts_list_body" data-kt-scroll-stretch="#kt_contacts_list, #kt_contacts_main" data-kt-scroll-offset="5px">
                            @include('partials.backoffice.observer.correctionResearcherlist')
                        </div>
                        <!--end::List-->
                    </div>
                    <!--end::Card body-->
                    <div class="text-center mb-3">
                        <a href="#" class="btn btn-primary me-3" id="kt_save_correction_researcher_list" data-bs-toggle="tooltip" data-bs-dismiss="click" data-bs-trigger="hover">حفظ التغييرات</a>
                        <a href="#" class="btn btn-secondary" id="kt_cancel_correction_researcher_list" data-bs-toggle="tooltip" data-bs-dismiss="click" data-bs-trigger="hover">إلغاء</a>
                    </div>
                </div>
                <!--end::Contacts-->
            </div>
            <!--end::Search-->
        </div>
    </div>
    <!--end::Container-->
</div>
<!--end::Content-->
@stop

@section('scripts')
<script src="{{ asset('assets/js/custom/backoffice/observer.js') }}"></script>
@stop
