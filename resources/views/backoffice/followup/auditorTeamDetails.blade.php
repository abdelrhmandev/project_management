@extends('layouts.app')

@section('style')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/custom/vis-timeline/vis-timeline.bundle.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content')
    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Layout-->
            <div class="d-flex flex-column flex-xl-row">
                <!--begin::Sidebar-->
                <div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10">
                    <!--begin::Card-->
                    <div class="card mb-xl-8 mb-5">
                        <!--begin::Card body-->
                        <div class="card-body pt-15">
                            <!--begin::Summary-->
                            <div class="d-flex flex-center flex-column mb-5">
                                <!--begin::Avatar-->
                                <div class="symbol symbol-150px symbol-circle mb-7">
                                    <span class="symbol-label fs-2x fw-semibold text-primary bg-light-primary">{{ substr($project_fieldwork_team->user[0]->username, 0, 1) }}</span>
                                </div>
                                <!--end::Avatar-->
                                <!--begin::Name-->
                                <a href="#" class="fs-3 text-hover-primary fw-bold mb-1 text-gray-800">{{ $project_fieldwork_team->user[0]->name }}</a>
                                <!--end::Name-->
                                <!--begin::Email-->
                                <a href="#" class="fs-5 fw-semibold text-muted text-hover-primary mb-6">{{ $project_fieldwork_team->user[0]->email }}</a>
                                <!--end::Email-->
                            </div>
                            <!--end::Summary-->
                            <!--begin::Details toggle-->
                            <div class="d-flex flex-stack fs-4 py-3">
                                <div class="fw-bold">تفاصيل الحساب</div>
                                <!--begin::Badge-->
                                <div class="badge badge-light-info d-inline">{{ $project_fieldwork_team->type[0]->trans }}</div>
                                <!--begin::Badge-->
                            </div>
                            <!--end::Details toggle-->
                            <div class="separator separator-dashed my-3"></div>
                            <!--begin::Details content-->
                            <div class="fs-6 pb-5">
                                <!--begin::Details item-->
                                <div class="fw-bold mt-5">تاريخ الإنضمام</div>
                                <div class="text-gray-600">
                                    <a href="#" class="text-hover-primary text-gray-600">{{ \Carbon\Carbon::parse($project_fieldwork_team->user[0]->created_at)->format('d-m-Y') }}</a>
                                </div>
                                <!--begin::Details item-->
                            </div>
                            <!--end::Details content-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Sidebar-->
                <!--begin::Content-->
                <div class="flex-lg-row-fluid ms-lg-15">
                    <!--begin:::Tab content-->
                    <div class="tab-content" id="myTabContent">
                        <!--begin:::Tab pane-->
                        <div class="tab-pane fade show active" id="kt_ecommerce_customer_overview" role="tabpanel">
                            <div class="row row-cols-1">
                                <!--begin::Col-->
                                <div class="col">
                                    <!--begin::Mixed Widget 1-->
                                    <div class="card card-xl-stretch mb-xl-12">
                                        <!--begin::Body-->
                                        <div class="card-body p-0">
                                            <!--begin::Header-->
                                            <div class="card-rounded h-275px w-100 bg-danger px-9 pt-7">
                                                <!--begin::Heading-->
                                                <div class="d-flex flex-stack">
                                                    <h3 class="fw-bold fs-3 m-0 text-white">المدققين</h3>
                                                    <div class="ms-1">
                                                        <!--begin::Menu-->
                                                        <button type="button" class="btn btn-sm btn-icon btn-color-white btn-active-white btn-active-color-danger me-n3 border-0" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                            <!--begin::Svg Icon | path: icons/duotune/general/gen024.svg-->
                                                            <span class="svg-icon svg-icon-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                        <rect x="5" y="5" width="5" height="5" rx="1" fill="currentColor" />
                                                                        <rect x="14" y="5" width="5" height="5" rx="1" fill="currentColor" opacity="0.3" />
                                                                        <rect x="5" y="14" width="5" height="5" rx="1" fill="currentColor" opacity="0.3" />
                                                                        <rect x="14" y="14" width="5" height="5" rx="1" fill="currentColor" opacity="0.3" />
                                                                    </g>
                                                                </svg>
                                                            </span>
                                                            <!--end::Svg Icon-->
                                                        </button>
                                                        <!--end::Menu-->
                                                    </div>
                                                </div>
                                                <!--end::Heading-->
                                                <!--begin::Balance-->
                                                <div class="d-flex flex-column pt-8 text-center text-white">
                                                    <span class="fw-semibold fs-7">العدد الإجمالي المطلوب</span>
                                                    <span class="fw-bold fs-2x pt-1">{{ $project_fieldwork_team->auditor_qty }}</span>
                                                </div>
                                                <!--end::Balance-->
                                            </div>
                                            <!--end::Header-->
                                            <!--begin::Items-->
                                            <div class="bg-body card-rounded position-relative z-index-1 mx-9 mb-9 px-6 py-9 shadow-sm" style="margin-top: -100px">
                                                <!--begin::Item-->
                                                <div class="d-flex align-items-center mb-6">
                                                    <!--begin::Symbol-->
                                                    <div class="symbol symbol-45px w-40px me-5">
                                                        <span class="symbol-label bg-lighten">
                                                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                            <span class="svg-icon svg-icon-1">
                                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <rect x="2" y="2" width="9" height="9" rx="2" fill="currentColor" />
                                                                    <rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2" fill="currentColor" />
                                                                    <rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2" fill="currentColor" />
                                                                    <rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2" fill="currentColor" />
                                                                </svg>
                                                            </span>
                                                            <!--end::Svg Icon-->
                                                        </span>
                                                    </div>
                                                    <!--end::Symbol-->
                                                    <!--begin::Description-->
                                                    <div class="d-flex align-items-center w-100 flex-wrap">
                                                        <!--begin::Title-->
                                                        <div class="pe-3 flex-grow-1 mb-1">
                                                            <a href="#" class="fs-5 text-hover-primary fw-bold text-gray-800">الموافقين منهم</a>
                                                        </div>
                                                        <!--end::Title-->
                                                        <!--begin::Label-->
                                                        <div class="d-flex align-items-center">
                                                            <div class="fw-bold fs-5 pe-1 text-gray-800">
                                                                {{ count($team_details->where('type_id', 3)->where('approved', '1')) }}
                                                            </div>
                                                        </div>
                                                        <!--end::Label-->
                                                    </div>
                                                    <!--end::Description-->
                                                </div>
                                                <!--end::Item-->
                                                <!--begin::Item-->
                                                <div class="d-flex align-items-center mb-6">
                                                    <!--begin::Symbol-->
                                                    <div class="symbol symbol-45px w-40px me-5">
                                                        <span class="symbol-label bg-lighten">
                                                            <!--begin::Svg Icon | path: icons/duotune/electronics/elc005.svg-->
                                                            <span class="svg-icon svg-icon-1">
                                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path opacity="0.3" d="M15 19H7C5.9 19 5 18.1 5 17V7C5 5.9 5.9 5 7 5H15C16.1 5 17 5.9 17 7V17C17 18.1 16.1 19 15 19Z" fill="currentColor" />
                                                                    <path d="M8.5 2H13.4C14 2 14.5 2.4 14.6 3L14.9 5H6.89999L7.2 3C7.4 2.4 7.9 2 8.5 2ZM7.3 21C7.4 21.6 7.9 22 8.5 22H13.4C14 22 14.5 21.6 14.6 21L14.9 19H6.89999L7.3 21ZM18.3 10.2C18.5 9.39995 18.5 8.49995 18.3 7.69995C18.2 7.29995 17.8 6.90002 17.3 6.90002H17V10.9H17.3C17.8 11 18.2 10.7 18.3 10.2Z" fill="currentColor" />
                                                                </svg>
                                                            </span>
                                                            <!--end::Svg Icon-->
                                                        </span>
                                                    </div>
                                                    <!--end::Symbol-->
                                                    <!--begin::Description-->
                                                    <div class="d-flex align-items-center w-100 flex-wrap">
                                                        <!--begin::Title-->
                                                        <div class="pe-3 flex-grow-1 mb-1">
                                                            <a href="#" class="fs-5 text-hover-primary fw-bold text-gray-800">بانتظار موافقتهم</a>
                                                        </div>
                                                        <!--end::Title-->
                                                        <!--begin::Label-->
                                                        <div class="d-flex align-items-center">
                                                            <div class="fw-bold fs-5 pe-1 text-gray-800">{{ count($team_details->where('type_id', 3)->where('approved', '0')) }}</div>
                                                        </div>
                                                        <!--end::Label-->
                                                    </div>
                                                    <!--end::Description-->
                                                </div>
                                                <!--end::Item-->
                                                <!--begin::Item-->
                                                <div class="d-flex align-items-center mb-6">
                                                    <!--begin::Symbol-->
                                                    <div class="symbol symbol-45px w-40px me-5">
                                                        <span class="symbol-label bg-lighten">
                                                            <!--begin::Svg Icon | path: icons/duotune/electronics/elc005.svg-->
                                                            <span class="svg-icon svg-icon-1">
                                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path opacity="0.3" d="M15 19H7C5.9 19 5 18.1 5 17V7C5 5.9 5.9 5 7 5H15C16.1 5 17 5.9 17 7V17C17 18.1 16.1 19 15 19Z" fill="currentColor" />
                                                                    <path d="M8.5 2H13.4C14 2 14.5 2.4 14.6 3L14.9 5H6.89999L7.2 3C7.4 2.4 7.9 2 8.5 2ZM7.3 21C7.4 21.6 7.9 22 8.5 22H13.4C14 22 14.5 21.6 14.6 21L14.9 19H6.89999L7.3 21ZM18.3 10.2C18.5 9.39995 18.5 8.49995 18.3 7.69995C18.2 7.29995 17.8 6.90002 17.3 6.90002H17V10.9H17.3C17.8 11 18.2 10.7 18.3 10.2Z" fill="currentColor" />
                                                                </svg>
                                                            </span>
                                                            <!--end::Svg Icon-->
                                                        </span>
                                                    </div>
                                                    <!--end::Symbol-->
                                                    <!--begin::Description-->
                                                    <div class="d-flex align-items-center w-100 flex-wrap">
                                                        <!--begin::Title-->
                                                        <div class="pe-3 flex-grow-1 mb-1">
                                                            <a href="#" class="fs-5 text-hover-primary fw-bold text-gray-800">المَرفوض منهم</a>
                                                        </div>
                                                        <!--end::Title-->
                                                        <!--begin::Label-->
                                                        <div class="d-flex align-items-center">
                                                            <div class="fw-bold fs-5 pe-1 text-gray-800">{{ $project_fieldwork_team->auditor_qty - count($team_details->where('type_id', 3)) }}</div>
                                                        </div>
                                                        <!--end::Label-->
                                                    </div>
                                                    <!--end::Description-->
                                                </div>
                                                <!--end::Item-->
                                            </div>
                                            <!--end::Items-->
                                        </div>
                                        <!--end::Body-->
                                    </div>
                                    <!--end::Mixed Widget 1-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--begin::Card-->
                            <div class="card mb-xl-9 mb-6">
                                <!--begin::Card header-->
                                <div class="card-header">
                                    <!--begin::Card title-->
                                    <div class="card-title">
                                        @if (Auth::user()->hasRole('equipment'))
                                            <h2>الرجاء تحديد الحسابات المضافة إلى برنامج كاشف</h2>
                                        @else
                                            <h2>تفاصيل حالة إضافة حسابات أفراد فريق العمل الميداني إلى برنامج كاشف</h2>
                                        @endif
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
                                                <th class="min-w-10px"></th>
                                                <th class="min-w-100px">الإسم</th>
                                                <th>نوع الدور</th>
                                                <th>رقم الجوال</th>
                                                <th class="min-w-100px">الايميل</th>
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="fs-6 fw-semibold text-gray-600">
                                            <input type="hidden" id="redirectUrl" value="{{ url('operation/followup/field-team-details/' . $project_fieldwork_team->project_id . '/' . $user_id) }}" />
                                            <input type="hidden" id="show_accounts_url" value="{{ url('equipment/show-accounts/' . $project_fieldwork_team->project_id) }}" />
                                            @foreach ($team_details as $project_auditor_team)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <!--begin::Checkbox-->
                                                            <label class="form-check form-check-custom form-check-solid me-5">
                                                                @if ($project_auditor_team->created_kashef == '1')
                                                                    @if (Auth::user()->hasRole('equipment'))
                                                                        <input class="form-check-input me-2" type="checkbox" name="created_kashef" checked="checked" onclick="return CreatedKashef(this,'remove')" value="{{ $project_auditor_team->id }}" />
                                                                    @endif
                                                                    <span class="badge badge-light-success me-4">مضاف</span>
                                                                @elseif($project_auditor_team->created_kashef == '0')
                                                                    @if (Auth::user()->hasRole('equipment'))
                                                                        <input class="form-check-input me-2" type="checkbox" name="created_kashef" onclick="return CreatedKashef(this,'create')" value="{{ $project_auditor_team->id }}" />
                                                                    @endif
                                                                    <span class="badge badge-light-danger me-4">غير مضاف</span>
                                                                @endif
                                                            </label>
                                                            <!--end::Checkbox-->
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a href="#" class="text-hover-primary mb-1 text-gray-600">{{ $project_auditor_team->name }}</a>
                                                    </td>
                                                    <td>{{ $project_auditor_team->type[0]->trans }}</td>
                                                    <td>{{ $project_auditor_team->mobile }}</td>
                                                    <td>{{ $project_auditor_team->email }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <!--end::Table-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card-->
                        </div>
                        <button type="button" class="btn btn me-2" id="kt_back_main_team" style="background: #004A61; color:white">الرجوع إلى قائمة فريق العمل الرئيسي</button>
                        <!--end:::Tab pane-->
                    </div>
                    <!--end:::Tab content-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Layout-->
            <!--begin::Modals-->
            <!--end::Modals-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Content-->
@stop

@section('scripts')
    <script src="{{ asset('assets/js/custom/account/referrals/referral-program.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/vis-timeline/vis-timeline.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/backoffice/project.js') }}"></script>
    <script>
        function CreatedKashef(checkboxItem, action) {
            var redirectUrl = $('#redirectUrl').val();
            if (checkboxItem.checked) {
                const loadingEl = document.createElement("div");
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: "{{ url('operation/SaveCreatedKashef') }}",
                    data: {
                        'id': checkboxItem.value,
                        'action': action,
                        'table': 'auditor',
                    },
                    beforeSend: function() {
                        document.body.prepend(loadingEl);
                        loadingEl.classList.add("page-loader");
                        loadingEl.classList.add("flex-column");
                        loadingEl.classList.add("bg-dark");
                        loadingEl.classList.add("bg-opacity-25");
                        loadingEl.innerHTML = `
				<span class="spinner-border text-primary" role="status"></span>
				<span class="text-gray-800 fs-6 fw-semibold mt-5">الرجاء الإنتظار...</span>
			`;
                        KTApp.showPageLoading();
                    },
                    success: function(response, textStatus, xhr) {
                        if (response['status'] == 'success') {
                            KTApp.hidePageLoading();
                            loadingEl.remove();
                            Swal.fire({
                                text: response["msg"], // respose from controller
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "حسنا موافق",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary",
                                },
                            });
                        }
                        window.location.href = redirectUrl;
                    },
                });
            }
        }

        $(document).on("click", "#kt_back_main_team", function() {
            window.location.href = $('#show_accounts_url').val(); // make request
        });
    </script>
@stop
