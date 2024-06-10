@extends('layouts.app')

@section('content')
<div id="kt_content_container" class="container-xxl">
    <!--begin::Layout-->
    <div class="d-flex flex-column flex-xl-row">
        <!--begin::Sidebar-->
        @include('partials.backoffice.sidebar-project')
        <!--end::Sidebar-->

        <!--begin::Content-->
        <div class="flex-lg-row-fluid ms-lg-15">
            <div class="tab-content" id="myTabContent">
                <!--begin::Content-->
                <div class="tab-pane fade show active">
                    @include('partials.backoffice.research-details')
                    
                    <div role="alert" aria-live="assertive" aria-atomic="true" id="approveTeamMembersToastDIV" class="toast fixed-top m-5 ms-auto d-none" data-bs-autohide="true">
                        <div class="toast-header">
                            <strong class="me-auto text-success">{{ __('site.message') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body text-success fw-semibold" id="HTMLResponsemessage">{{ __('site.mission_completed') }}</div>
                    </div>

                    <div class="row g-5 g-xl-8">
                        <!--begin::Col-->
                        <div class="col-xl-12">
                            <div class="card card-xl-stretch mb-xl-8">
                                <div class="card-header pt-5">
                                    <h3 class="card-title align-items-start flex-column">
                                        <span class="card-label fw-bold fs-3 mb-1">{{ __('project.approve_team_members') }}</span>
                                    </h3>
                                </div>
                                <div class="card-body py-3">
                                    <form class="form" id="FormId" data-route-url="{{ url('observer/approve-team-members') }}" novalidate="novalidate" method="post">
                                        @csrf
                                        <input type="hidden" name="taskType" id="taskType" value="{{ $taskType ?? 'none' }}" />
                                        <input type="hidden" name="project_id" id="project_id" value="{{ $row->id }}" />
                                        <input type="hidden" id="redirectUrl" data-redirect-url="{{ $taskType === 'approval'? url('observer/projects/correction') : url('observer/projects') }}" />
                                        <div data-kt-search-element="results">
                                            <div class="mh-375px scroll-y me-n7 pe-7">
                                                @foreach ($selected_researchers as $selected_researcher)
                                                <div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="0">
                                                    <div class="d-flex align-items-center">
                                                        <label class="form-check form-check-custom form-check-solid me-5">
                                                            <input class="form-check-input" type="checkbox" name="user-checkbox[]" value="{{ $selected_researcher->team_user_id }}" data-kt-check="true" data-kt-check-target="[data-user-id='{{ $selected_researcher->team_user_id }}']" {{ $selected_researcher->received_train == '1' ? 'checked' : '' }} />
                                                        </label>
                                                        <div class="ms-5">
                                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">{{ $attracting_teams->where('id', $selected_researcher->team_user_id)->first()->name ?? '' }}</a>
                                                            <div class="fw-semibold text-muted">
                                                                {{ $attracting_teams->where('id', $selected_researcher->team_user_id)->first()->email ?? '' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="fw-semibold text-muted">
                                                        @if($selected_researcher->received_train == '1')
                                                        <span class="w-80px badge badge-light-success me-4">قد حضر التدريب</span>
                                                        @else
                                                        <span class="w-80px badge badge-light-danger me-4">لم يحضر التدريب</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="border-bottom border-gray-300 border-bottom-dashed">
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="modal-footer mt-8 mb-3">
                                            <button type="button" class="btn btn-light me-3" id="kt_cancel_approve_researcher">{{ __('site.cancel') }}</button>
                                            <button type="button" class="btn btn-primary" id="kt_page_loading_overlay">{{ __('project.approve_team_members') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Content-->
                </div>
            </div>
            <!--end::Content-->
        </div>
        <!--end::Layout-->
    </div>
</div>
@stop

@section('scripts')
<script src="{{ asset('assets/js/custom/utilities/modals/create-account.js') }}"></script>
<script src="{{ asset('assets/js/custom/account/referrals/referral-program.js') }}"></script>
<script src="{{ asset('assets/js/custom/backoffice/observer.js') }}"></script>
<script src="{{ asset('assets/js/custom/loading-page.js') }}"></script>
@stop
