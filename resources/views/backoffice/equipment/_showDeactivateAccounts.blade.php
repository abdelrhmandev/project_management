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
                        @if ($row->type_id != 10 && $row->type_id != 12)
                            @include('partials.backoffice.kashef-accounts')
                        @else
                            @include('partials.backoffice.survey-accounts')
                        @endif
                        <!--begin::Card-->
                        <div class="card mb-xl-9 mb-6">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2> الحسابات المحذوفة من برنامج كاشف</h2>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-0 pb-5">
                                <!--begin::Table-->
                                <table class="table-row-dashed gy-5 table align-middle" id="kt_table_customers_payment">
                                    <!--begin::Table head-->
                                    <thead class="border-bottom fs-7 fw-bold border-gray-200">
                                        <!--begin::Table row-->
                                        <tr class="text-muted text-uppercase gs-0 text-start">
                                            <th></th>
                                            <th class="min-w-100px">الإسم</th>
                                            <th>الرتبه</th>
                                            <th class="min-w-100px">المشرف المباشر</th>
                                            <th>رقم الجوال</th>
                                            <th class="min-w-70px">الايميل</th>
                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    <tbody class="fs-6 fw-semibold text-gray-600">
                                        @foreach ($deactivateAccounts as $v)
                                            @php
                                                if (isset($v->superior_team_id)) {
                                                    $superior = \App\Models\AttractingTeam::find($v->superior_team_id)->name;
                                                } else {
                                                    $superior = '-';
                                                }
                                            @endphp
                                            <tr>
                                                <td><input class="form-check-input me-2" type="checkbox" value="" name=""></td>
                                                <td>{{ $v->name }}</td>
                                                <td>{{ \App\Models\TeamRankType::find($v->type)->trans }}</td>
                                                <td>{{ $superior }}</td>
                                                <td>{{ $v->mobile }}</td>
                                                <td>{{ $v->email }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>
                            <!--end::Card body-->
                        </div>

                        <div class="col-lg-12">
                            <!--begin::Notice-->
                            <div class="notice d-flex bg-light-warning border-warning mb-9 rounded border border-dashed p-6">
                                <!--begin::Icon-->
                                <!--begin::Svg Icon | path: icons/duotune/general/gen044.svg-->
                                <span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor" />
                                        <rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="currentColor" />
                                        <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                <!--end::Icon-->
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-stack flex-grow-1">
                                    <!--begin::Content-->
                                    <div class="fw-semibold">
                                        <h4 class="fw-bold text-gray-900">لإنهاء وتسليم المهمة</h4>
                                        <div class="fs-6 text-gray-700">حتى يمكنك إنهاء وتسليم المهمة، يجب عليك إضافة الحسابات في برنامج كاشف لكل أفراد الفريق - الباحثين والمدققين</div>
                                    </div>
                                    <!--end::Content-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Notice-->
                            <form class="form" action="{{ url('equipment/accounts-created') }}" enctype="multipart/form-data" novalidate="novalidate" method="post">
                                @csrf
                                <input type="hidden" name="project_id" id="project_id" value="{{ $row->id }}" />
                                <div class="mt-8 text-center">
                                    <button type="submit" id="kt_edit_project_submit" class="btn btn-primary me-3">إنهاء وتسليم المهمة</button>
                                    <button type="reset" id="kt_cancel_equipment" class="btn btn-secondary me-3">إلغاء</button>
                                </div>
                            </form>
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
    <script src="{{ asset('assets/js/custom/backoffice/equipment.js') }}"></script>
@stop
