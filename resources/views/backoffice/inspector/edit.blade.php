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
                    @if($row->type_id != 12 && $row->type_id != 10)
                    @include('partials.backoffice.kashef-accounts')
                    @else
                    @include('partials.backoffice.survey-accounts')
                    @endif
                </div>
            </div>
            <!--begin::Content-->
            <div class="flex-lg-row-fluid ms-lg-15">
                <form class="form" action="{{ url('inspector/hand-offer-task')}}" novalidate="novalidate" method="post">
                    @csrf

                    <input type="hidden" name="project_id" id="project_id" value="{{ $row->id }}" />
                    <div class="text-center mt-8">
                        <button type="reset" id="kt_edit_tour_cancel" class="btn btn-secondary me-3">{{ __('site.cancel')}}</button>
                        <button type="submit" class="btn btn-primary">إنهاء الزيارة التفتيشية</button>
                    </div>
                </form>
            </div>
            <!--end::Content-->
        </div>
    </div>
    @include('partials.obstacle._obstacle')
</div>
@stop

@section('scripts')
<script src="{{ asset('assets/js/custom/account/referrals/referral-program.js')}}"></script>
@stop