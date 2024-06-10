@extends('layouts.app')

@section('style')
    {{-- Messenger INI Files --}}
    <meta name="id" content="{{ $id }}">
    <meta name="type" content="{{ $type }}">
    <meta name="messenger-color" content="{{ $messengerColor }}">
    <meta name="url" content="{{ url('') . '/' . config('chatify.routes.prefix') }}" data-user="{{ Auth::user()->id }}">
    {{-- <meta name="url" content="{{ url('').'/'.config('chatify.routes.prefix') }}" data-user="{{ Auth::user()->id }}"> --}}
    {{-- End Messenger INI Files --}}
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/custom/vis-timeline/vis-timeline.bundle.css') }}" rel="stylesheet" type="text/css" />
    {{-- Messenger CSS Files --}}
    <link rel='stylesheet' href='https://unpkg.com/nprogress@0.2.0/nprogress.css' />
    <link href="{{ asset('css/chatify/style-discussion.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/chatify/' . $dark_mode . '.mode.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    {{-- End Messenger CSS Files --}}
@stop

@section('style')
    <style type="text/css">
        #sp_0 {
            color: #f00;
            /* padding: 5px; */
        }

        .hide {
            display: none !important;
        }
        #modalOutWrap
        td.index {
            position:relative;
            vertical-align: middle;
            text-align: center;
            box-sizing: border-box;
        }
        td.index div:first-child {
            margin-right: 15px;
            width: 50px;
            height: 26px;
        }
        #tblReq tr th {
            color: #666;
        }
  
    </style>
@append 

@section('content')
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">
        <!--begin::Navbar-->
        <div class="card mb-xl-10 mb-5">
            <div class="card-body pb-0 pt-9">
                <!--begin::Details-->
                <div class="d-flex flex-sm-nowrap mb-3 flex-wrap">
                    <!--begin: Pic-->
                    <div class="mb-4 me-7">
                        <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                            <img src="{{ asset('storage/' . $row->logo) }}" alt="{{ $row->title }}" />
                            <div class="position-absolute translate-middle start-100 bg-success rounded-circle border-body h-20px w-20px bottom-0 mb-6 border border-4">
                            </div>
                        </div>
                    </div>
                    <!--end::Pic-->
                    <!--begin::Info-->
                    <div class="flex-grow-1">
                        <!--begin::Title-->
                        <div class="d-flex justify-content-between align-items-start mb-2 flex-wrap">
                            <!--begin::User-->
                            <div class="d-flex flex-column">
                                <!--begin::Name-->
                                <div class="d-flex align-items-center mb-2">
                                    <a href="#" class="text-hover-primary fs-2 fw-bold me-1 text-gray-900" style="display:inline-block;{{ mb_strlen($row->title) > 40 ? ' width:350px;' : '' }}">
                                        {{ $row->title }}
                                    </a>
                                    <a href="#">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen026.svg-->
                                        <span class="svg-icon svg-icon-1 svg-icon-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                                                <path
                                                    d="M10.0813 3.7242C10.8849 2.16438 13.1151 2.16438 13.9187 3.7242V3.7242C14.4016 4.66147 15.4909 5.1127 16.4951 4.79139V4.79139C18.1663 4.25668 19.7433 5.83365 19.2086 7.50485V7.50485C18.8873 8.50905 19.3385 9.59842 20.2758 10.0813V10.0813C21.8356 10.8849 21.8356 13.1151 20.2758 13.9187V13.9187C19.3385 14.4016 18.8873 15.491 19.2086 16.4951V16.4951C19.7433 18.1663 18.1663 19.7433 16.4951 19.2086V19.2086C15.491 18.8873 14.4016 19.3385 13.9187 20.2758V20.2758C13.1151 21.8356 10.8849 21.8356 10.0813 20.2758V20.2758C9.59842 19.3385 8.50905 18.8873 7.50485 19.2086V19.2086C5.83365 19.7433 4.25668 18.1663 4.79139 16.4951V16.4951C5.1127 15.491 4.66147 14.4016 3.7242 13.9187V13.9187C2.16438 13.1151 2.16438 10.8849 3.7242 10.0813V10.0813C4.66147 9.59842 5.1127 8.50905 4.79139 7.50485V7.50485C4.25668 5.83365 5.83365 4.25668 7.50485 4.79139V4.79139C8.50905 5.1127 9.59842 4.66147 10.0813 3.7242V3.7242Z"
                                                    fill="currentColor" />
                                                <path d="M14.8563 9.1903C15.0606 8.94984 15.3771 8.9385 15.6175 9.14289C15.858 9.34728 15.8229 9.66433 15.6185 9.9048L11.863 14.6558C11.6554 14.9001 11.2876 14.9258 11.048 14.7128L8.47656 12.4271C8.24068 12.2174 8.21944 11.8563 8.42911 11.6204C8.63877 11.3845 8.99996 11.3633 9.23583 11.5729L11.3706 13.4705L14.8563 9.1903Z" fill="white" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </a>
                                    <a href="#" class="btn btn-sm btn-light-{{ $row->status->class }} fw-bold fs-8 ms-2 px-3 py-1" data-bs-toggle="modal" data-bs-target="#kt_modal_upgrade_plan">{{ $row->status->trans }}</a>
                                </div>
                                <!--end::Name-->
                                <!--begin::Info-->
                                <div class="d-flex fw-semibold fs-6 mb-4 flex-wrap pe-2">
                                    <a href="#" class="d-flex align-items-center text-hover-primary mb-2 me-5 text-gray-400">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen018.svg-->
                                        <span class="svg-icon svg-icon-4 me-1">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.3" d="M18.0624 15.3453L13.1624 20.7453C12.5624 21.4453 11.5624 21.4453 10.9624 20.7453L6.06242 15.3453C4.56242 13.6453 3.76242 11.4453 4.06242 8.94534C4.56242 5.34534 7.46242 2.44534 11.0624 2.04534C15.8624 1.54534 19.9624 5.24534 19.9624 9.94534C20.0624 12.0453 19.2624 13.9453 18.0624 15.3453Z" fill="currentColor" />
                                                <path d="M12.0624 13.0453C13.7193 13.0453 15.0624 11.7022 15.0624 10.0453C15.0624 8.38849 13.7193 7.04535 12.0624 7.04535C10.4056 7.04535 9.06241 8.38849 9.06241 10.0453C9.06241 11.7022 10.4056 13.0453 12.0624 13.0453Z" fill="currentColor" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                        @if (count($row->region) == 13)
                                            تم تحديد كل مناطق المملكة
                                        @else
                                            @foreach ($row->region as $region)
                                                {{ $region->title }},
                                            @endforeach
                                        @endif
                                    </a>
                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::User-->
                            <!--begin::Actions-->
                            <div class="d-flex my-4">
                                @if (Auth::user()->hasRole('operation'))
                                    <div class="d-flex {{ $row->status_id == 11 ? '' : ($row->status_id == 13 ? '' : 'invisible') }}">
                                        <form class="form" id="FormId" data-route-url="{{ url('operation/end-field') }}" enctype="multipart/form-data" novalidate="novalidate" method="POST">
                                            @csrf
                                            <input type="hidden" name="project_id" id="project_id" value="{{ $row->id }}" />
                                            <input type="hidden" id="redirectUrl" data-redirect-url="{{ url('operation/projects') }}" />
                                            <input type="hidden" name="project_title" id="project_title" value="{{ $row->title }}" />
                                            <button type="button" class="btn btn-sm btn-primary me-2" id="kt_page_loading_overlay">إنهاء العمل الميداني</button>
                                        </form>
                                    </div>
                                @endif
                                @if ($row->status_id == 10 && Auth::user()->hasRole('fieldwork'))
                                    <div class="{{ $row->status_id == 10 ? '' : 'invisible' }}">
                                        <form class="form" id="FormId" data-route-url="{{ url('fieldwork/start-field') }}" enctype="multipart/form-data" novalidate="novalidate" method="POST">
                                            @csrf
                                            <input type="hidden" name="project_id" id="project_id" value="{{ $row->id }}" />
                                            <input type="hidden" id="redirectUrl" data-redirect-url="{{ url('fieldwork/projects') }}" />
                                            <input type="hidden" name="project_title" id="project_title" value="{{ $row->title }}" />
                                            <button type="button" class="btn btn-sm btn-primary me-2" id="kt_page_loading_overlay" data-kt-element="files-next">بدء العمل الميداني</button>
                                        </form>
                                    </div>
                                @endif
                                <a href="#" class="btn btn-sm btn-light me-2" data-bs-toggle="modal" data-bs-target="#kt_modal_contact_information">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr012.svg-->
                                    <span class="svg-icon svg-icon-3 d-none">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.3" d="M10 18C9.7 18 9.5 17.9 9.3 17.7L2.3 10.7C1.9 10.3 1.9 9.7 2.3 9.3C2.7 8.9 3.29999 8.9 3.69999 9.3L10.7 16.3C11.1 16.7 11.1 17.3 10.7 17.7C10.5 17.9 10.3 18 10 18Z" fill="currentColor" />
                                            <path d="M10 18C9.7 18 9.5 17.9 9.3 17.7C8.9 17.3 8.9 16.7 9.3 16.3L20.3 5.3C20.7 4.9 21.3 4.9 21.7 5.3C22.1 5.7 22.1 6.30002 21.7 6.70002L10.7 17.7C10.5 17.9 10.3 18 10 18Z" fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                    <!--begin::Indicator label-->
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor" />
                                        <rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="currentColor" />
                                        <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor" />
                                    </svg>
                                    <span class="indicator-label">معلومات التواصل</span>
                                    <!--end::Indicator label-->
                                    <!--begin::Indicator progress-->
                                    <span class="indicator-progress">الرجاء الإنتظار...
                                        <span class="spinner-border spinner-border-sm ms-2 align-middle"></span></span>
                                    <!--end::Indicator progress-->
                                </a>
                                <a href="#" class="btn btn-sm btn-primary me-2" data-bs-toggle="modal" data-bs-target="#kt_modal_offer_a_deal">العهد</a>
                                <a href="#" class="btn btn-sm btn-light-danger" data-bs-toggle="modal" data-bs-target="#kt_modal_project_obstacles">إبلاغ عن عرقلة</a>
                            </div>
                            <!--end::Actions-->
                        </div>
                        <!--end::Title-->
                        <!--begin::Stats-->
                        <div class="d-flex flex-stack flex-wrap">
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-column flex-grow-1 pe-8">
                                <!--begin::Stats-->
                                <div class="d-flex flex-wrap">
                                    <!--begin::Stat-->
                                    <div class="min-w-125px mb-3 me-2 rounded border border-dashed border-gray-300 px-4 py-3">
                                        <!--begin::Number-->
                                        <div class="d-flex align-items-center">
                                            <div class="fs-6 fw-bold">{{ $row->customer->title }}</div>
                                        </div>
                                        <!--end::Number-->
                                        <!--begin::Label-->
                                        <div class="fw-semibold fs-6 text-gray-400">إسم الجهة</div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Stat-->
                                    <!--begin::Stat-->
                                    <div class="min-w-100px mb-3 me-2 rounded border border-dashed border-gray-300 px-2 py-3">
                                        <!--begin::Number-->
                                        <div class="d-flex align-items-center">
                                            <div class="fs-6 fw-bold">{{ $row->type->title }}</div>
                                        </div>
                                        <!--end::Number-->
                                        <!--begin::Label-->
                                        <div class="fw-semibold fs-6 text-gray-400">نوع المشروع</div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Stat-->
                                    <!--begin::Stat-->
                                    <div class="min-w-125px mb-3 me-2 rounded border border-dashed border-gray-300 px-4 py-3">
                                        <!--begin::Number-->
                                        <div class="d-flex align-items-center">
                                            <div class="fs-6 fw-bold">من {{ $row->start_date }} إلى {{ $row->end_date }}
                                            </div>
                                        </div>
                                        <!--end::Number-->
                                        <!--begin::Label-->
                                        <div class="fw-semibold fs-6 text-gray-400">المدة الزمنية للمشروع</div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Stat-->
                                </div>
                                <!--end::Stats-->
                            </div>
                            <!--end::Wrapper-->
                            <!--begin::Progress-->
                            <div class="d-flex align-items-center w-180px w-sm-300px flex-column mt-3">
                                <div class="d-flex justify-content-between w-100 mb-2 mt-auto">
                                    <span class="fw-semibold fs-6 text-gray-400">إكتمال المشروع</span>
                                    <span class="fw-bold fs-6">{{ $row->progress_bar }}%</span>
                                </div>
                                <div class="h-5px w-100 bg-light mx-3 mb-3">
                                    <div class="bg-success h-5px rounded" role="progressbar" style="width: {{ $row->progress_bar }}%;" aria-valuenow="{{ $row->progress_bar }}" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                            </div>
                            <!--end::Progress-->
                        </div>
                        <!--end::Stats-->
                    </div>
                    <!--end::Info-->
                </div>
                <!--end::Details-->
                <div class="separator"></div>
                <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x fs-5 fw-bold mt-4 border-transparent" id="myTabProjects">
                    <li class="nav-item">
                        <a class="nav-link text-active-primary active pb-4" data-toggle="tab" href="#kt_project_overview_tab">تفاصيل المشروع</a>
                    </li>
                    @if (!Auth::user()->hasRole('observer') && $row->type_id != 14)
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-toggle="tab" href="#kt_kashef_tab">تفاصيل الإستمارة</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4" data-toggle="tab" href="#kt_project_equipment_tab">تجهيزات المشروع</a>
                    </li>
                    @if ($row->type_id != 14)
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-toggle="tab" href="#kt_project_quotation_tab">تسعيرات الفرق البحثية</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-toggle="tab" href="#kt_project_team_member_tab">فريق عمل المشروع</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-toggle="tab" href="#kt_project_attachment_tab">مرفقات المشروع</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-toggle="tab" href="#kt_project_requirements_tab">الطلبات <span class="badge badge-warning badge-circle badge-md" style="margin-right:5px"> {{ $requirements->count() }}</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-toggle="tab" href="#kt_project_outcome_tab">المخرجات <span class="badge badge-warning badge-circle badge-md" style="margin-right:5px"> {{ $outcomes->count() }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-toggle="tab" href="#kt_project_redflags_tab">البلاغات <span class="badge badge-warning badge-circle badge-md" style="margin-right:5px"> {{ $RedFlagsCount }}</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-toggle="tab" href="#kt_project_life_cycle_tab">دورة حياة المشروع</a>
                    </li>
                    <!--<li class="nav-item">
                        <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-toggle="tab" href="#kt_project_discussions">مناقشات المشروع</a>
                    </li>-->
                </ul>
            </div>
        </div>
        <!--end::Navbar-->
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="kt_project_overview_tab" role="tabpanel">
                <!--begin::Card-->
                <form id="projectDetails" data-action="{{ route('project.details') }}">
                    <input type="hidden" name="projectID" value="{{ $row->id }}">
                    @csrf
                    <div class="card mb-xl-10 tab-pane mb-5">
                        <!--begin::Card header-->
                        <div class="card-header pt-5">
                            <div class="card-title align-items-start flex-column">
                                <h3 class="card-label fw-bold fs-3 mb-1">
                                    تفاصيل المشروع
                                    @if (!Auth::user()->hasRole('observer'))
                                        <label id="projectEditDetails" class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-bs-toggle="tooltip" title="تعديل" style="display:inline-block;margin:5px 10px 0 0;" data-kt-initialized="1">
                                            <i class="bi bi-pencil-fill fs-7"></i>
                                        </label>
                                    @endif
                                </h3>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div id="kt_customer_view_payment_method" class="card-body mt-4">
                            <!--begin::Option-->
                            <div class="py-0" data-kt-customer-payment-method="row">
                                <!--begin::Details-->
                                <div class="d-flex flex-wrap">
                                    <!--begin::Col-->
                                    <div class="flex-equal fs-5 me-5">
                                        @if ($row->type_id == 14)
                                            <input type="hidden" name="projectType" value="14">
                                            <table class="table-flush fw-bold gy-1 table">
                                                <tr>
                                                    <td class="text-muted min-w-125px w-250px">مقر التدريب</td>
                                                    <td class="show text-gray-800">{{ $training->training_headquarter }}
                                                    </td>
                                                    <td class="hide toggle text-gray-800">
                                                        <input class="form-control" type="text" name="trainers" value="{{ $training->training_headquarter }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted min-w-125px w-250px">عدد المتدربين</td>
                                                    <td class="show text-gray-800">{{ $training->training_count }}</td>
                                                    <td class="hide toggle text-gray-800">
                                                        <input class="form-control" type="text" name="trainers" value="{{ $training->id }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted min-w-125px w-250px">نوع التدريب</td>
                                                    <td class="show text-gray-800">{{ $training->training_type }}</td>
                                                    <td class="hide toggle text-gray-800">
                                                        <select class="form-control" name="traintype">
                                                            <option value="حضوري">حضوري</option>
                                                            <option value="اونلاين">أونلاين</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted min-w-125px w-250px">موعد التدريب</td>
                                                    <td class="show text-gray-800">{{ $training->training_date }}</td>
                                                    <td class="hide toggle text-gray-800">
                                                        <input class="form-control form-control-solid date ps-12" type="text" readonly="readonly" name="traindate" value="{{ $training->training_date }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted min-w-125px w-250px">الحاجة إلى قاعة تدريب</td>
                                                    <td class="min-w-125px text-gray-800">
                                                        <input class="form-check-input" type="checkbox" name="openinghall" value="1" {{ $training->is_hall_required == 1 ? 'checked="checked"' : '' }} disabled />
                                                    </td>
                                                </tr>
                                            </table>
                                        @elseif($row->type_id == 9)
                                            <input type="hidden" name="projectType" value="9">
                                            <table class="table-flush fw-bold gy-1 table">
                                                <tr>
                                                    <td class="text-muted min-w-125px w-250px">عدد الجمعيات</td>
                                                    <td class="show text-gray-800">
                                                        {{ $project_empower_charity->charity_count }}
                                                    </td>
                                                    <td class="hide toggle text-gray-800">
                                                        <input class="form-control" type="text" name="charity" value="{{ $project_empower_charity->charity_count }}">
                                                    </td>
                                                </tr>
                                            </table>
                                        @elseif($row->type_id == 10)
                                            <input type="hidden" name="projectType" value="10">
                                            <table class="table-flush fw-bold gy-1 table">
                                                <tr>
                                                    <td class="text-muted min-w-125px w-250px">اسم المحجر</td>
                                                    <td class="show text-gray-800">
                                                        {{ $project_inspection_visit->mine_title }}
                                                    </td>
                                                    <td class="hide toggle text-gray-800">
                                                        <input class="form-control" type="text" name="mine" value="{{ $project_inspection_visit->mine_title }}">
                                                    </td>
                                                </tr>
                                            </table>
                                        @else
                                            <input type="hidden" name="projectType" value="any">
                                            <table class="table-flush fw-bold gy-1 table">
                                                <tr>
                                                    <td class="text-muted min-w-125px w-250px">
                                                        {{ __('project.cases-count') }}
                                                    </td>
                                                    <td class="show text-gray-800">{{ $row->cases_count }}</td>
                                                    <td class="hide toggle text-gray-800">
                                                        <input class="form-control" type="text" name="cases" value="{{ $row->cases_count }}">
                                                    </td>
                                                </tr>
                                            </table>
                                        @endif
                                        <table class="table-flush fw-bold gy-1 table">
                                            <tr>
                                                <td class="text-muted min-w-125px w-250px">هل هناك مرونة في تواريخ المشروع؟
                                                </td>
                                                <td class="min-w-125px text-gray-800">
                                                    <div class="fv-row mb-8">
                                                        <!--begin::Wrapper-->
                                                        <div class="d-flex flex-stack">
                                                            <!--begin::Label-->
                                                            <!--end::Label-->
                                                            <!--begin::Switch-->
                                                            <label class="form-check form-switch form-check-custom form-check-solid">
                                                                {{ $row->flexibility_project_dates == 1 ? __('site.yes') : __('site.no') }}

                                                                {{-- <input class="form-check-input" type="checkbox" value="1" name="flexibility_project_dates" {{ $row->flexibility_project_dates == 1 ? 'checked' : '' }} disabled />
                                                            <span class="form-check-label fw-semibold text-muted">{{ __('site.yes') }}</span> --}}
                                                            </label>
                                                            <!--end::Switch-->
                                                        </div>
                                                        <!--end::Wrapper-->
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="flex-equal fs-5 me-5">
                                        @if ($row->type_id == 14)
                                            <table class="table-flush fw-bold gy-1 table">
                                                <tr>
                                                    <td class="text-muted min-w-125px w-250px">التدريب على</td>
                                                    <td class="show text-gray-800">{{ $training->training_on }}</td>
                                                    <td class="hide toggle text-gray-800">
                                                        <input class="form-control" type="text" name="trainon" value="{{ $training->training_on }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted min-w-125px w-250px">طبيعة الحضور</td>
                                                    <td class="show text-gray-800">{{ $training->participant_type }}</td>
                                                    <td class="hide toggle text-gray-800">
                                                        <select class="form-control" name="participant">
                                                            <option value="طلاب">طلاب</option>
                                                            <option value="موظفين">موظفين</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted min-w-125px w-250px">مدة التدريب بالأيام</td>
                                                    <td class="show text-gray-800">{{ $training->duration }}</td>
                                                    <td class="hide toggle text-gray-800">
                                                        <input class="form-control" type="text" name="duration" value="{{ $training->duration }}">
                                                    </td>
                                                </tr>
                                            </table>
                                        @elseif($row->type_id != 9)
                                            <table class="table-flush fw-bold gy-1 table">
                                                <tr>
                                                    <td class="text-muted min-w-125px w-250px">عدد المباني/المرافق التقديري
                                                        في الحصر</td>
                                                    <td class="show text-gray-800">{{ $row->building_count }}</td>
                                                    <td class="hide toggle text-gray-800">
                                                        <input class="form-control" type="text" name="building" value="{{ $row->building_count }}">
                                                    </td>
                                                </tr>
                                            </table>
                                        @endif
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Details-->
                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                    @if ($row->type_id != 14)
                        <div class="card mb-xl-10 tab-pane mb-5">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <!--begin::Card title-->
                                <div class="card-title m-0">
                                    <h3 class="fw-bold m-0">إفتتاح/إغلاق المشروع</h3>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--begin::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body p-9">
                                <div class="mt-8">
                                    <h3 class="fw-bold text-dark">{{ __('project.opening') }}</h3>
                                </div>
                                <!--end::Col-->
                                <div class="w-100">
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-8">
                                        <!--begin::Wrapper-->
                                        <div class="d-flex flex-stack">
                                            <!--begin::Label-->
                                            <div class="me-5">
                                                <label class="fs-6 fw-semibold">{{ __('project.opening') }}</label>
                                            </div>
                                            <!--end::Label-->
                                            <!--begin::Switch-->
                                            <label class="form-check form-switch form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" value="1" name="opening" onchange="manageOpening(this)" {{ $row->opening == 1 ? 'checked' : '' }} disabled />
                                                <span class="form-check-label fw-semibold text-muted">{{ __('site.yes') }}</span>
                                            </label>
                                            <!--end::Switch-->
                                        </div>
                                        <!--end::Wrapper-->
                                    </div>
                                    <div class="{{ $row->opening == 0 ? 'd-none' : '' }}" id="opening_div">
                                        <div class="fv-row mb-8">
                                            <!--begin::Wrapper-->
                                            <div class="d-flex flex-stack">
                                                <!--begin::Label-->
                                                <div class="me-5">
                                                    <label class="fs-6 fw-semibold">{{ __('project.reserve_hall') }}</label>
                                                </div>
                                                <!--end::Label-->
                                                <!--begin::Switch-->
                                                <label class="form-check form-switch form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value="1" name="opening_reserve_hall" {{ $row->opening_reserve_hall == 1 ? 'checked' : '' }} disabled />
                                                    <span class="form-check-label fw-semibold text-muted">{{ __('site.yes') }}</span>
                                                </label>
                                                <!--end::Switch-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </div>
                                        <div class="fv-row mb-8">
                                            <!--begin::Label-->
                                            <div class="me-5">
                                                <h3 class="fw-bold text-dark">{{ __('project.attendance_nature') }}</h3>
                                            </div>
                                            <!--end::Label-->
                                            <!--begin::Row-->
                                            <div class="row g-9" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button='true']">
                                                <!--begin::Col-->
                                                <div class="col-md-6 col-lg-12 col-xxl-6">
                                                    <!--begin::Option-->
                                                    <label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex {{ $row->opening_attendance_nature == 'regulars' ? 'active' : '' }} p-6 text-start" data-kt-button="true">
                                                        <!--begin::Radio-->
                                                        <span class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                            <input class="form-check-input" type="radio" name="opening_attendance_nature" value="regulars" {{ $row->opening_attendance_nature == 'regulars' ? 'checked="checked"' : '' }} disabled />
                                                        </span>
                                                        <!--end::Radio-->
                                                        <!--begin::Info-->
                                                        <span class="ms-5">
                                                            <span class="fs-4 fw-bold d-block mb-2 text-gray-800">{{ __('project.regulars') }}</span>
                                                        </span>
                                                        <!--end::Info-->
                                                    </label>
                                                    <!--end::Option-->
                                                </div>
                                                <!--end::Col-->
                                                <!--begin::Col-->
                                                <div class="col-md-6 col-lg-12 col-xxl-6">
                                                    <!--begin::Option-->
                                                    <label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex {{ $row->opening_attendance_nature == 'leaders' ? 'active' : '' }} p-6 text-start" data-kt-button="true">
                                                        <!--begin::Radio-->
                                                        <span class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                            <input class="form-check-input" type="radio" name="opening_attendance_nature" value="leaders" {{ $row->opening_attendance_nature == 'leaders' ? 'checked="checked"' : '' }} disabled />
                                                        </span>
                                                        <!--end::Radio-->
                                                        <!--begin::Info-->
                                                        <span class="ms-5">
                                                            <span class="fs-4 fw-bold d-block mb-2 text-gray-800">{{ __('project.leaders') }}</span>
                                                        </span>
                                                        <!--end::Info-->
                                                    </label>
                                                    <!--end::Option-->
                                                </div>
                                                <!--end::Col-->
                                            </div>
                                            <!--end::Row-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-8">
                                            <!--begin::Col-->
                                            <label class="required fs-6 fw-semibold mb-2">{{ __('project.opening_date') }}</label>
                                            <div class="position-relative d-flex align-items-center">
                                                <!--begin::Icon-->
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                                                <span class="svg-icon svg-icon-2 position-absolute mx-4">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z" fill="currentColor" />
                                                        <path d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z" fill="currentColor" />
                                                        <path
                                                            d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                                <!--end::Icon-->
                                                <!--begin::Datepicker-->
                                                <input class="form-control form-control-solid ps-12" value="{{ $row->opening_date }}" id="opening_date" name="opening_date" disabled />
                                                <!--end::Datepicker-->
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Input group-->
                                    </div>
                                </div>
                                <div class="me-5">
                                    <h3 class="fw-bold text-dark">{{ __('project.closing') }}</h3>
                                </div>
                                <div class="w-100">
                                    <!--begin::Heading-->
                                    <div class="fv-row mb-8">
                                        <!--begin::Wrapper-->
                                        <div class="d-flex flex-stack">
                                            <!--begin::Label-->
                                            <div class="me-5">
                                                <label class="fs-6 fw-semibold">{{ __('project.closing') }}</label>
                                            </div>
                                            <!--end::Label-->
                                            <!--begin::Switch-->
                                            <label class="form-check form-switch form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" value="1" name="closing" onchange="manageClosing(this)" {{ $row->closing == 1 ? 'checked="checked"' : '' }} disabled />
                                                <span class="form-check-label fw-semibold text-muted">{{ __('site.yes') }}</span>
                                            </label>
                                            <!--end::Switch-->
                                        </div>
                                        <!--end::Wrapper-->
                                    </div>
                                    <div class="{{ $row->closing == 0 ? 'd-none' : '' }}" id="closing_div">
                                        <div class="fv-row mb-8">
                                            <!--begin::Wrapper-->
                                            <div class="d-flex flex-stack">
                                                <!--begin::Label-->
                                                <div class="me-5">
                                                    <label class="fs-6 fw-semibold">{{ __('project.reserve_hall') }}</label>
                                                </div>
                                                <!--end::Label-->
                                                <!--begin::Switch-->
                                                <label class="form-check form-switch form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" name="closing_reserve_hall" value="1" {{ $row->closing_reserve_hall == 1 ? 'checked="checked"' : '' }} disabled />
                                                    <span class="form-check-label fw-semibold text-muted">{{ __('site.yes') }}</span>
                                                </label>
                                                <!--end::Switch-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </div>
                                        <div class="fv-row mb-8">
                                            <!--begin::Label-->
                                            <div class="me-5">
                                                <h3 class="fw-bold text-dark">{{ __('project.attendance_nature') }}</h3>
                                            </div>
                                            <!--end::Label-->
                                            <!--begin::Row-->
                                            <div class="row g-9" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button='true']">
                                                <!--begin::Col-->
                                                <div class="col-md-6 col-lg-12 col-xxl-6">
                                                    <!--begin::Option-->
                                                    <label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex {{ $row->closing_attendance_nature == 'regulars' ? 'active' : '' }} p-6 text-start" data-kt-button="true">
                                                        <!--begin::Radio-->
                                                        <span class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                            <input class="form-check-input" type="radio" name="closing_attendance_nature" value="regulars" {{ $row->closing_attendance_nature == 'regulars' ? 'checked="checked"' : '' }} disabled />
                                                        </span>
                                                        <!--end::Radio-->
                                                        <!--begin::Info-->
                                                        <span class="ms-5">
                                                            <span class="fs-4 fw-bold d-block mb-2 text-gray-800">{{ __('project.regulars') }}</span>
                                                        </span>
                                                        <!--end::Info-->
                                                    </label>
                                                    <!--end::Option-->
                                                </div>
                                                <!--end::Col-->
                                                <!--begin::Col-->
                                                <div class="col-md-6 col-lg-12 col-xxl-6">
                                                    <!--begin::Option-->
                                                    <label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex {{ $row->closing_attendance_nature == 'leaders' ? 'active' : '' }} p-6 text-start" data-kt-button="true">
                                                        <!--begin::Radio-->
                                                        <span class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                            <input class="form-check-input" type="radio" name="closing_attendance_nature" value="leaders" {{ $row->closing_attendance_nature == 'leaders' ? 'checked="checked"' : '' }} disabled />
                                                        </span>
                                                        <!--end::Radio-->
                                                        <!--begin::Info-->
                                                        <span class="ms-5">
                                                            <span class="fs-4 fw-bold d-block mb-2 text-gray-800">{{ __('project.leaders') }}</span>
                                                        </span>
                                                        <!--end::Info-->
                                                    </label>
                                                    <!--end::Option-->
                                                </div>
                                                <!--end::Col-->
                                            </div>
                                            <!--end::Row-->
                                        </div>
                                        <div class="fv-row mb-8">
                                            <label class="required fs-6 fw-semibold mb-2">{{ __('project.closing_date') }}</label>
                                            <div class="position-relative d-flex align-items-center">
                                                <span class="svg-icon svg-icon-2 position-absolute mx-4">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z" fill="currentColor" />
                                                        <path d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z" fill="currentColor" />
                                                        <path
                                                            d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <input class="form-control form-control-solid ps-12" value="{{ $row->closing_date }}" name="closing_date" id="closing_date" disabled />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Card body-->
                        </div>
                    @endif
                </form>
                <button type="button" id="projectDetailEdit" class="btn btn-primary hide me-2">حفظ التغييرات</button>
                <button type="button" id="projectDetailCancel" class="btn btn-light hide">إلغاء</button>
            </div>

            <div class="tab-pane fade" id="kt_kashef_tab" role="tabpanel">
                <div class="card mb-xl-10 tab-pane mb-5">
                    @if ($row->type_id != 10 && $row->type_id != 12)
                        @include('partials.backoffice.kashef-accounts')
                    @else
                        @include('partials.backoffice.survey-accounts')
                    @endif
                </div>
            </div>

            <div class="tab-pane fade" id="kt_project_equipment_tab" role="tabpanel">
                <!--begin::Col -->
                <div class="col-xl-12 d-flex flex-column gap-7">
                    <!--begin::Table Widget 6-->
                    @if ($row->type_id != 14)
                        <div class="card card-xl-stretch tab-pane">
                            <!--begin::Header-->
                            <div class="card-header cursor-pointer pt-5">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold fs-3 mb-1">
                                        التجهيزات العامة
                                        @if (!Auth::user()->hasRole('observer'))
                                            <label id="projectEditEqPublic" class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-bs-toggle="tooltip" title="تعديل" style="display:inline-block;margin:5px 10px 0 0;" data-kt-initialized="1">
                                                <i class="bi bi-pencil-fill fs-7"></i>
                                            </label>
                                            <span title="اضافه" data-bs-toggle="modal" data-bs-target="#kt_modal_general_equipment" class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" style="display:inline-block;margin:5px 10px 0 0;">
                                                <i class="bi bi-plus-circle fs-7"></i>
                                            </span>
                                        @endif
                                    </span>
                                </h3>
                                <div class="card-toolbar">
                                    <ul class="nav">
                                        <li class="nav-item">
                                            <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-secondary fw-bold active px-4" data-bs-toggle="tab" href="#kt_table_widget_6_tab_3">{{ $project_equipments->where('type_id', '1')->count() ?? 0 }}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body py-3">
                                <div class="tab-content">
                                    <!--begin::Table container-->
                                    <div class="table-responsive">
                                        <!--begin::Table-->
                                        <form class="projectEquipment" data-action="{{ route('project.equipment') }}">
                                            <input type="hidden" name="projectID" value="{{ $row->id }}">
                                            <input type="hidden" name="eqType" value="1">
                                            @csrf
                                            @method('PATCH')
                                            <table class="gs-0 gy-3 fw-bold table align-middle" id="eqPublic">
                                                <!--begin::Table head-->
                                                <thead>
                                                    <tr>
                                                        <th class="min-w-150px p-0">الصنف</th>
                                                        <th class="p-0">الكمية</th>
                                                        <th class="p-0">التكلفة</th>
                                                        <th class="p-0">هل وفر؟</th>
                                                    </tr>
                                                </thead>
                                                <!--end::Table head-->
                                                <!--begin::Table body-->
                                                <tbody>
                                                    @php $p=0; @endphp
                                                    @foreach ($project_equipments->where('type_id', '1')->all() as $equipment)
                                                        <input type="hidden" name="peID[]" value="{{ $equipment->peID }}">
                                                        <tr>
                                                            <td class="showw">
                                                                <a href="#" class="text-dark fw-semibold fs-6 mb-1">{{ $equipment->title }}</a>
                                                            </td>
                                                            {{--
                                            <td class="hide toggle">

                                               <select name="title[]" class="form-control">
                                                    <!--option value="{{$equipment->peID}}">{{ $equipment->title }}</option-->
                                                @foreach (\App\Models\Equipment::where('type_id', 1)->get() as $eq)

                                                <option value="{{$eq->id}}" {{($equipment->equipment_id == $eq->id ) ? "selected" : ""}}>{{ $eq->title }}</option>

                                                @endforeach
                                                </select>
                                                </td>
                                                --}}
                                                            <td class="show">
                                                                <span class="text-dark fw-semibold fs-6 mb-1">{{ $equipment->qty }}</span>
                                                            </td>
                                                            <td class="hide toggle">
                                                                <input class="form-control text-center" type="text" name="qty[]" value="{{ $equipment->qty }}">
                                                            </td>
                                                            <td class="show">
                                                                <span class="text-dark fw-semibold fs-6 mb-1">{{ $equipment->price }}</span>
                                                            </td>
                                                            <td class="hide toggle">
                                                                <input class="form-control text-center" type="text" name="price[]" value="{{ $equipment->price }}">
                                                            </td>
                                                            <td class="show">
                                                                @if ($equipment->send_equipment_receipt == 1)
                                                                    <span class="w-80px badge badge-light-success me-4">تم
                                                                        توفير التجهيز</span>
                                                                @else
                                                                    <span class="w-100px badge badge-light-danger me-4">لم
                                                                        يتم توفير التجهيز</span>
                                                                @endif
                                                            </td>
                                                            <td class="hide toggle">
                                                                <input class="form-check-input" type="checkbox" name="available[{{ $p }}]" value="1" {{ $equipment->send_equipment_receipt == 1 ? 'checked' : '' }}>
                                                            </td>
                                                        </tr>
                                                        @php $p++; @endphp
                                                    @endforeach
                                                </tbody>
                                                <!--end::Table body-->
                                            </table>
                                            <button type="button" id="projectEqPublicEdit" class="saveEq btn btn-primary hide me-2">حفظ التغييرات</button>
                                            <button type="button" id="projectEqPublicCancel" class="btn btn-light hide" onclick="window.location.reload(true);">إلغاء</button>
                                        </form>
                                    </div>
                                    <!--end::Table-->
                                </div>
                            </div>
                            <!--end::Body-->
                        </div>
                    @endif
                    <!--end::Table Widget 6-->
                    <!--begin::Table Widget 6-->
                    @if ($row->type_id != 10)
                        <div class="card card-xl-stretch">
                            <!--begin::Header-->
                            <div class="card-header pt-5">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold fs-3 mb-1">
                                        تجهيزات قسم التدريب
                                        @if (!Auth::user()->hasRole('observer'))
                                            <label id="projectEditEqTrain" class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-bs-toggle="tooltip" title="تعديل" style="display:inline-block;margin:5px 10px 0 0;" data-kt-initialized="1">
                                                <i class="bi bi-pencil-fill fs-7"></i>
                                            </label>
                                            <span title="اضافه" data-bs-toggle="modal" data-bs-target="#kt_modal_training_equipment" class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" style="display:inline-block;margin:5px 10px 0 0;">
                                                <i class="bi bi-plus-circle fs-7"></i>
                                            </span>
                                        @endif
                                    </span>
                                </h3>
                                <div class="card-toolbar">
                                    <ul class="nav">
                                        <li class="nav-item">
                                            <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-secondary fw-bold active px-4" data-bs-toggle="tab" href="#kt_table_widget_6_tab_3">{{ $project_equipments->where('type_id', '2')->count() ?? 0 }}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body py-3">
                                <div class="tab-content">
                                    <!--begin::Table container-->
                                    <div class="table-responsive">
                                        <!--begin::Table-->
                                        <form class="projectEquipment" data-action="{{ route('project.equipment') }}">
                                            <input type="hidden" name="projectID" value="{{ $row->id }}">
                                            <input type="hidden" name="eqType" value="2">
                                            @csrf
                                            @method('PATCH')
                                            <table class="gs-0 gy-3 fw-bold table align-middle" id="eqTrain">
                                                <!--begin::Table head-->
                                                <thead>
                                                    <tr>
                                                        <th class="min-w-150px p-0">الصنف</th>
                                                        <th class="p-0">الكمية</th>
                                                        <th class="p-0">التكلفة</th>
                                                        <th class="p-0">هل وفر؟</th>
                                                    </tr>
                                                </thead>
                                                <!--end::Table head-->
                                                <!--begin::Table body-->
                                                <tbody>
                                                    @php $t=0; @endphp
                                                    @foreach ($project_equipments->where('type_id', '2')->all() as $equipment)
                                                        <tr>
                                                            <input type="hidden" name="peID[]" value="{{ $equipment->peID }}">
                                                            <td class="showw">
                                                                <a href="#" class="text-dark fw-semibold fs-6 mb-1">{{ $equipment->title }}</a>
                                                            </td>
                                                            {{--
                                            <td class="hide toggle">
                                               <select name="title[]" class="form-control">
                                                    <!--option value="{{$equipment->peID}}">{{ $equipment->title }}</option-->
                                                @foreach (\App\Models\Equipment::where('type_id', 2)->get() as $eq)
                                                <option value="{{$eq->id}}" {{($equipment->equipment_id == $eq->id )? "selected" : ""}}>{{$eq->title}}</option>
                                                @endforeach
                                                </select>
                                                </td>
                                                --}}
                                                            <td class="show">
                                                                <span class="text-dark fw-semibold fs-6 mb-1">{{ $equipment->qty }}</span>
                                                            </td>
                                                            <td class="hide toggle">
                                                                <input class="form-control text-center" type="text" name="qty[]" value="{{ $equipment->qty }}">
                                                            </td>
                                                            <td class="show">
                                                                <span class="text-dark fw-semibold fs-6 mb-1">{{ $equipment->price }}</span>
                                                            </td>
                                                            <td class="hide toggle">
                                                                <input class="form-control text-center" type="text" name="price[]" value="{{ $equipment->price }}">
                                                            </td>
                                                            <td class="show">
                                                                @if ($equipment->send_equipment_receipt == 1)
                                                                    <span class="w-80px badge badge-light-success me-4">تم
                                                                        توفير التجهيز</span>
                                                                @else
                                                                    <span class="w-100px badge badge-light-danger me-4">لم
                                                                        يتم توفير التجهيز</span>
                                                                @endif
                                                            </td>
                                                            <td class="hide toggle">
                                                                <input class="form-check-input" type="checkbox" name="available[{{ $t }}]" value="1" {{ $equipment->send_equipment_receipt == 1 ? 'checked' : '' }}>
                                                            </td>
                                                        </tr>
                                                        @php $t++; @endphp
                                                    @endforeach
                                                </tbody>
                                                <!--end::Table body-->
                                            </table>
                                            <button type="button" id="projectEqTrainEdit" class="saveEq btn btn-primary hide me-2">حفظ التغييرات</button>
                                            <button type="button" id="projectEqTrainCancel" class="btn btn-light hide" onclick="window.location.reload(true);">إلغاء</button>
                                        </form>
                                    </div>
                                    <!--end::Table-->
                                </div>
                            </div>
                            <!--end::Body-->
                        </div>
                    @endif
                    <!--end::Table Widget 6-->
                    <!--begin::Table Widget 6-->
                    @if ($row->type_id != 14 && $row->type_id != 10)
                        <div class="card card-xl-stretch">
                            <!--begin::Header-->
                            <div class="card-header pt-5">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold fs-3 mb-1">
                                        تجهيزات إفتتاح مشروع
                                        @if (!Auth::user()->hasRole('observer'))
                                            <label id="projectEditEqOpen" class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-bs-toggle="tooltip" title="تعديل" style="display:inline-block;margin:5px 10px 0 0;" data-kt-initialized="1">
                                                <i class="bi bi-pencil-fill fs-7"></i>
                                            </label>
                                            <span title="اضافه" data-bs-toggle="modal" data-bs-target="#kt_modal_opening_equipment" class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" style="display:inline-block;margin:5px 10px 0 0;">
                                                <i class="bi bi-plus-circle fs-7"></i>
                                            </span>
                                        @endif
                                    </span>
                                </h3>
                                <div class="card-toolbar">
                                    <ul class="nav">
                                        <li class="nav-item">
                                            <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-secondary fw-bold active px-4" data-bs-toggle="tab" href="#kt_table_widget_6_tab_3">{{ $project_equipments->where('type_id', '3')->count() ?? 0 }}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body py-3">
                                <div class="tab-content">
                                    <!--begin::Table container-->
                                    <div class="table-responsive">
                                        <!--begin::Table-->
                                        <!--begin::Table-->
                                        <form class="projectEquipment" data-action="{{ route('project.equipment') }}">
                                            <input type="hidden" name="projectID" value="{{ $row->id }}">
                                            <input type="hidden" name="eqType" value="3">
                                            @csrf
                                            @method('PATCH')
                                            <table class="gs-0 gy-3 fw-bold table align-middle" id="eqOpen">
                                                <!--begin::Table head-->
                                                <thead>
                                                    <tr>
                                                        <th class="min-w-150px p-0">الصنف</th>
                                                        <th class="p-0">الكمية</th>
                                                        <th class="p-0">التكلفة</th>
                                                        <th class="p-0">هل وفر؟</th>
                                                    </tr>
                                                </thead>
                                                <!--end::Table head-->
                                                <!--begin::Table body-->
                                                <tbody>
                                                    @php $k=0; @endphp
                                                    @foreach ($project_equipments->where('type_id', '3')->all() as $equipment)
                                                        <tr>
                                                            <input type="hidden" name="peID[]" value="{{ $equipment->peID }}">
                                                            <td class="showw">
                                                                <a href="#" class="text-dark fw-semibold fs-6 mb-1">{{ $equipment->title }}</a>
                                                            </td>
                                                            {{--
                                            <td class="hide toggle">
                                               <select name="title[]" class="form-control">
                                                    <!--option value="{{$equipment->peID}}">{{ $equipment->title }}</option-->
                                                @foreach (\App\Models\Equipment::where('type_id', 3)->get() as $eq)
                                                <option value="{{$eq->id}}" {{($equipment->equipment_id == $eq->id )? "selected" : ""}}>{{$eq->title}}</option>
                                                @endforeach
                                                </select>
                                                </td>
                                                --}}
                                                            <td class="show">
                                                                <span class="text-dark fw-semibold fs-6 mb-1">{{ $equipment->qty }}</span>
                                                            </td>
                                                            <td class="hide toggle">
                                                                <input class="form-control text-center" type="text" name="qty[]" value="{{ $equipment->qty }}">
                                                            </td>
                                                            <td class="show">
                                                                <span class="text-dark fw-semibold fs-6 mb-1">{{ $equipment->price }}</span>
                                                            </td>
                                                            <td class="hide toggle">
                                                                <input class="form-control text-center" type="text" name="price[]" value="{{ $equipment->price }}">
                                                            </td>
                                                            <td class="show">
                                                                @if ($equipment->send_equipment_receipt == 1)
                                                                    <span class="w-80px badge badge-light-success me-4">تم
                                                                        توفير التجهيز</span>
                                                                @else
                                                                    <span class="w-100px badge badge-light-danger me-4">لم
                                                                        يتم توفير التجهيز</span>
                                                                @endif
                                                            </td>
                                                            <td class="hide toggle">
                                                                <input class="form-check-input" type="checkbox" name="available[{{ $k }}]" value="1" {{ $equipment->send_equipment_receipt == 1 ? 'checked' : '' }}>
                                                            </td>
                                                        </tr>
                                                        @php $k++; @endphp
                                                    @endforeach
                                                </tbody>
                                                <!--end::Table body-->
                                            </table>
                                            <button type="button" id="projectEqOpenEdit" class="saveEq btn btn-primary hide me-2">حفظ التغييرات</button>
                                            <button type="button" id="projectEqOpenCancel" class="btn btn-light hide" onclick="window.location.reload(true);">إلغاء</button>
                                        </form>
                                    </div>
                                    <!--end::Table-->
                                </div>
                            </div>
                            <!--end::Body-->
                        </div>
                    @endif
                    <!--end::Table Widget 6-->
                    <!--begin::Table Widget 6-->
                    @if ($row->type_id != 14 && $row->type_id != 9 && $row->type_id != 10)
                        <div class="card card-xl-stretch">
                            <!--begin::Header-->
                            <div class="card-header pt-5">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold fs-3 mb-1">
                                        تجهيزات التدقيق
                                        @if (!Auth::user()->hasRole('observer'))
                                            <label id="projectEditEqAudit" class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-bs-toggle="tooltip" title="تعديل" style="display:inline-block;margin:5px 10px 0 0;" data-kt-initialized="1">
                                                <i class="bi bi-pencil-fill fs-7"></i>
                                            </label>
                                            <span title="اضافه" data-bs-toggle="modal" data-bs-target="#kt_modal_auditing_equipment" class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" style="display:inline-block;margin:5px 10px 0 0;">
                                                <i class="bi bi-plus-circle fs-7"></i>
                                            </span>
                                        @endif
                                    </span>
                                </h3>
                                <div class="card-toolbar">
                                    <ul class="nav">
                                        <li class="nav-item">
                                            <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-secondary fw-bold active px-4" data-bs-toggle="tab" href="#kt_table_widget_6_tab_3">{{ $project_equipments->where('type_id', '4')->count() ?? 0 }}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body py-3">
                                <div class="tab-content">
                                    <!--begin::Table container-->
                                    <div class="table-responsive">
                                        <!--begin::Table-->
                                        <form class="projectEquipment" data-action="{{ route('project.equipment') }}">
                                            <input type="hidden" name="projectID" value="{{ $row->id }}">
                                            <input type="hidden" name="eqType" value="4">
                                            @csrf
                                            @method('PATCH')
                                            <table class="gs-0 gy-3 fw-bold table align-middle" id="eqAudit">
                                                <!--begin::Table head-->
                                                <thead>
                                                    <tr>
                                                        <th class="min-w-150px p-0">الصنف</th>
                                                        <th class="p-0">الكمية</th>
                                                        <th class="p-0">التكلفة</th>
                                                        <th class="p-0">هل وفر؟</th>
                                                    </tr>
                                                </thead>
                                                <!--end::Table head-->
                                                <!--begin::Table body-->
                                                <tbody>
                                                    @php $i = 0; @endphp
                                                    @foreach ($project_equipments->where('type_id', '4')->all() as $equipment)
                                                        <tr>
                                                            <input type="hidden" name="peID[]" value="{{ $equipment->peID }}">
                                                            <td class="showw">
                                                                <a href="#" class="text-dark fw-semibold fs-6 mb-1">{{ $equipment->title }}</a>
                                                            </td>
                                                            {{--
                                            <td class="hide toggle">
                                               <select name="title[]" class="form-control">
                                                    <!--option value="{{$equipment->peID}}">{{ $equipment->title }}</option-->
                                                @foreach (\App\Models\Equipment::where('type_id', 4)->get() as $eq)
                                                <option value="{{$eq->id}}" {{($equipment->equipment_id == $eq->id )? "selected" : ""}}>{{$eq->title}}</option>
                                                @endforeach
                                                </select>
                                                </td>
                                                --}}
                                                            <td class="show">
                                                                <span class="text-dark fw-semibold fs-6 mb-1">{{ $equipment->qty }}</span>
                                                            </td>
                                                            <td class="hide toggle">
                                                                <input class="form-control text-center" type="text" name="qty[]" value="{{ $equipment->qty }}">
                                                            </td>
                                                            <td class="show">
                                                                <span class="text-dark fw-semibold fs-6 mb-1">{{ $equipment->price }}</span>
                                                            </td>
                                                            <td class="hide toggle">
                                                                <input class="form-control text-center" type="text" name="price[]" value="{{ $equipment->price }}">
                                                            </td>
                                                            <td class="show">
                                                                @if ($equipment->send_equipment_receipt == 1)
                                                                    <span class="w-80px badge badge-light-success me-4">تم
                                                                        توفير التجهيز</span>
                                                                @else
                                                                    <span class="w-100px badge badge-light-danger me-4">لم
                                                                        يتم توفير التجهيز</span>
                                                                @endif
                                                            </td>
                                                            <td class="hide toggle">
                                                                <input class="form-check-input" type="checkbox" name="available[{{ $i }}]" value="1" {{ $equipment->send_equipment_receipt == 1 ? 'checked' : '' }}>
                                                            </td>
                                                        </tr>
                                                        @php $i++; @endphp
                                                    @endforeach
                                                </tbody>
                                                <!--end::Table body-->
                                            </table>
                                            <button type="button" id="projectEqAuditEdit" class="saveEq btn btn-primary hide me-2">حفظ التغييرات</button>
                                            <button type="button" id="projectEqAuditCancel" class="btn btn-light hide" onclick="window.location.reload(true);">إلغاء</button>
                                        </form>
                                    </div>
                                    <!--end::Table-->
                                </div>
                            </div>
                            <!--end::Body-->
                        </div>
                    @endif
                    <!--end::Table Widget 6-->
                    @include('partials.backoffice.equipment._equipmentsModals')
                </div>
                <!--end::Col-->
            </div>

            <div class="tab-pane fade" id="kt_project_quotation_tab" role="tabpanel">
                <!--begin::Col -->
                <div class="col-xl-12 d-flex flex-column gap-7">
                    <!--begin::Table Widget 6-->
                    <div class="card card-xl-stretch">
                        <!--begin::Header-->
                        <div class="card-header pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold fs-3 mb-1">
                                    تسعيرات الفرق البحثية
                                    @if (!Auth::user()->hasRole('observer'))
                                        <label id="projectEditfinance" class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-bs-toggle="tooltip" title="تعديل" style="display:inline-block;margin:5px 10px 0 0;" data-kt-initialized="1">
                                            <i class="bi bi-pencil-fill fs-7"></i>
                                        </label>
                                    @endif
                                </span>
                            </h3>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body py-3">
                            <div class="tab-content">
                                <!--begin::Table container-->
                                <div class="table-responsive">
                                    <!--begin::Table-->
                                    <form class="projectfinance" data-action="{{ route('project.finance') }}">
                                        <input type="hidden" name="projectID" value="{{ $row->id }}">
                                        @csrf
                                        @method('PUT')
                                        <table class="gs-0 gy-3 fw-bold fs-4 table align-middle" id="pFinance">
                                            <!--begin::Table head-->
                                            <thead>
                                                <tr>
                                                    <th class="min-w-70px p-0">الرتبة</th>
                                                    <th class="min-w-150px p-0 text-center">عدد الكوادر</th>
                                                    <th class="min-w-150px p-0 text-center">تسعيرات كاشف</th>
                                                    <th class="min-w-140px p-0 text-center">بنود العقد</th>
                                                </tr>
                                            </thead>
                                            <!--end::Table head-->
                                            <!--begin::Table body-->
                                            <tbody>
                                                @foreach ($team_ranks as $team_rank)
                                                    @if (($row->type_id == 10 && $team_rank->id == 6) || ($row->type_id == 9 && ($team_rank->id == 1 || $team_rank->id == 7)))
                                                        <tr>
                                                            <td>
                                                                <a href="#" class="text-dark fw-semibold mb-1">{{ $team_rank->trans }}</a>
                                                            </td>
                                                            <td class="show text-center">
                                                                <span class="text-dark fw-semibold mb-1">{{ $financial_bid_estimate[$team_rank->title . '_qty'] ?? 0 }}</span>
                                                            </td>
                                                            <td class="hide toggle">
                                                                <input class="form-control" type="text" name="{{ $team_rank->title . '_qty' }}" value="{{ $financial_bid_estimate[$team_rank->title . '_qty'] ?? 0 }}">
                                                            </td>
                                                            <td class="show text-center">
                                                                <span class="text-dark fw-semibold mb-1">{{ $financial_bid_estimate[$team_rank->title . '_price'] ?? 0 }}</span>
                                                            </td>
                                                            <td class="hide toggle">
                                                                <input class="form-control" type="text" name="{{ $team_rank->title . '_price' }}" value="{{ $financial_bid_estimate[$team_rank->title . '_price'] ?? 0 }}">
                                                            </td>
                                                            <td class="show text-center">
                                                                <a href="#" data-bs-toggle="modal" id="modal_team_rank_{{ $team_rank->id }}" data-bs-target="#kt_modal_team_rank" class="btn btn-bg-light btn-color-muted btn-active-color-primary btn-sm me-2 px-4" value="row-{{ $team_rank->id }}-id">الإطلاع على
                                                                    البنود</a>
                                                                <span class="text-dark fw-semibold mb-1">{{ $team_rank_items->firstWhere('type_id', $team_rank->id)->qty ?? 0 }}</span>
                                                            </td>
                                                        </tr>
                                                    @elseif($team_rank->id != 6 && $team_rank->id != 7)
                                                        <tr>
                                                            <td>
                                                                <a href="#" class="text-dark fw-semibold mb-1">{{ $team_rank->trans }}</a>
                                                            </td>
                                                            <td class="show text-center">
                                                                <span class="text-dark fw-semibold mb-1">{{ $financial_bid_estimate[$team_rank->title . '_qty'] ?? 0 }}</span>
                                                            </td>
                                                            <td class="hide toggle">
                                                                <input class="form-control" type="text" name="{{ $team_rank->title . '_qty' }}" value="{{ $financial_bid_estimate[$team_rank->title . '_qty'] ?? 0 }}">
                                                            </td>
                                                            <td class="show text-center">
                                                                <span class="text-dark fw-semibold mb-1">{{ $financial_bid_estimate[$team_rank->title . '_price'] ?? 0 }}</span>
                                                            </td>
                                                            <td class="hide toggle">
                                                                <input class="form-control" type="text" name="{{ $team_rank->title . '_price' }}" value="{{ $financial_bid_estimate[$team_rank->title . '_price'] ?? 0 }}">
                                                            </td>
                                                            <td class="text-center">
                                                                <a href="#" data-bs-toggle="modal" id="modal_team_rank_{{ $team_rank->id }}" data-bs-target="#kt_modal_team_rank" class="btn btn-bg-light btn-color-muted btn-active-color-primary btn-sm me-2 px-4" value="row-{{ $team_rank->id }}-id">الإطلاع على
                                                                    البنود</a>
                                                                <span class="text-dark fw-semibold mb-1">{{ $team_rank_items->firstWhere('type_id', $team_rank->id)->qty ?? 0 }}</span>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                            <!--end::Table body-->
                                        </table>
                                        <button type="button" id="projectFinanceEdit" class="btn btn-primary hide me-2">حفظ التغييرات</button>
                                        <button type="button" id="projectFinanceCancel" class="btn btn-light hide" onclick="window.location.reload(true);">إلغاء</button>
                                    </form>
                                </div>
                                <!--end::Table-->
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Table Widget 6-->
                </div>
                <!--end::Col-->
            </div>
            <div class="tab-pane fade" id="kt_project_attachment_tab" role="tabpanel">
                <!--begin::Row-->
                <div class="row g-6 g-xl-9 mb-xl-9 mb-6">
                    @if (!empty($row->confirm_letter))
                        <!--begin::Col-->
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="card h-100">

                                @if (!Auth::user()->hasRole('observer'))
                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="تعديل" style="display:inline-block;margin:10px 20px 0 0;" aria-label="كراسة نطاق عمل المشروع" data-bs-original-title="كراسة نطاق عمل المشروع" data-kt-initialized="1">
                                        <i class="bi bi-pencil-fill fs-7"></i>
                                        <form method="post" class="formup" enctype="multipart/form-data" data-action="{{ route('up.files') }}">
                                            <span style="display:inline-block;"></span>
                                            @csrf
                                            <input type="hidden" name="project_id" value="{{ $row->id }}">
                                            <input type="hidden" name="filetype" value="confirm_letter">
                                            <input type="hidden" name="type" value="projects">
                                            <input type="file" class="pdffile" id="confirm_letter" name="file" style="opacity:0;visibility:hidden;" onchange="_submitForm($(this),'confirm_letter');" accept=".pdf">
                                        </form>
                                    </label>
                                @endif


                                <div class="card-body d-flex justify-content-center flex-column p-8 text-center">
                                    <a href="{{ asset('storage/' . $row->confirm_letter) }}" class="text-hover-primary d-flex flex-column text-gray-800">
                                        <div class="symbol symbol-60px mb-5">
                                            <img src="{{ asset('assets/media/svg/files/' . \File::extension(asset('storage/' . $row->confirm_letter)) . '.svg') }}" class="theme-light-show" alt="" />
                                            <img src="{{ asset('assets/media/svg/files/' . \File::extension(asset('storage/' . $row->confirm_letter)) . '-dark.svg') }}" class="theme-dark-show" alt="" />
                                        </div>
                                        <div class="fs-5 fw-bold mb-2">خطاب الترسية</div>
                                    </a>
                                    <div class="fs-7 fw-semibold text-gray-400">تم الرفع:
                                        {{ $row->created_at->diffForHumans() }}
                                        بواسطة : {{ @\App\Models\User::find($row->user_add)->name }}
                                    </div>
                                    @if (!is_null($row->updated_at) && isset($row->updated_at))
                                        <div class="fs-7 fw-semibold text-gray-400">تم التحديث:
                                            {{ $row->updated_at->diffForHumans() }}
                                            بواسطة : {{ @\App\Models\User::find($row->user_edit)->name }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!--end::Col-->
                    @endif
                    <!--begin::Col-->
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="card h-100">
                            @if (!Auth::user()->hasRole('observer'))
                                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="تعديل" style="display:inline-block;margin:10px 20px 0 0;" aria-label="كراسة نطاق عمل المشروع" data-bs-original-title="كراسة نطاق عمل المشروع" data-kt-initialized="1">
                                    <i class="bi bi-pencil-fill fs-7"></i>
                                    <form method="post" class="formup" enctype="multipart/form-data" data-action="{{ route('up.files') }}">
                                        <span style="display:inline-block;"></span>
                                        @csrf
                                        <input type="hidden" name="project_id" value="{{ $row->id }}">
                                        <input type="hidden" name="filetype" value="rfp">
                                        <input type="hidden" name="type" value="projects">
                                        <input type="file" class="pdffile" id="rfp" name="file" style="opacity:0;visibility:hidden;" onchange="_submitForm($(this),'rfp');" accept=".pdf">
                                    </form>
                                </label>
                            @endif
                            <div class="card-body d-flex justify-content-center flex-column p-8 text-center">
                                <a href="{{ asset('storage/' . $row->rfp) }}" class="text-hover-primary d-flex flex-column text-gray-800">
                                    <div class="symbol symbol-60px mb-5">
                                        <img src="{{ asset('assets/media/svg/files/' . \File::extension(asset('storage/' . $row->rfp)) . '.svg') }}" class="theme-light-show" alt="" />
                                        <img src="{{ asset('assets/media/svg/files/' . \File::extension(asset('storage/' . $row->rfp)) . '-dark.svg') }}" class="theme-dark-show" alt="" />
                                    </div>
                                    <div class="fs-5 fw-bold mb-2">كراسة نطاق عمل المشروع</div>
                                </a>
                                <div class="fs-7 fw-semibold text-gray-400">تم الرفع:
                                    {{ $row->created_at->diffForHumans() }}
                                    بواسطة : {{ @\App\Models\User::find($row->user_add)->name }}
                                </div>
                                @if (!is_null($row->updated_at) && isset($row->updated_at))
                                    <div class="fs-7 fw-semibold text-gray-400">تم التحديث:
                                        {{ $row->updated_at->diffForHumans() }}
                                        بواسطة : {{ @\App\Models\User::find($row->user_edit)->name }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="card h-100">
                            @if (!Auth::user()->hasRole('observer'))
                                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="تعديل" style="display:inline-block;margin:10px 20px 0 0;" aria-label="كراسة نطاق عمل المشروع" data-bs-original-title="كراسة نطاق عمل المشروع" data-kt-initialized="1">
                                    <i class="bi bi-pencil-fill fs-7"></i>
                                    <form method="post" class="formup" enctype="multipart/form-data" data-action="{{ route('up.files') }}">
                                        <span style="display:inline-block;"></span>
                                        @csrf
                                        <input type="hidden" name="project_id" value="{{ $row->id }}">
                                        <input type="hidden" name="filetype" value="requirements_specifications">
                                        <input type="hidden" name="type" value="projects">
                                        <input type="file" class="pdffile" id="requirements_specifications" name="file" style="opacity:0;visibility:hidden;" onchange="_submitForm($(this),'requirements_specifications');" accept=".pdf">
                                    </form>
                                </label>
                            @endif
                            <div class="card-body d-flex justify-content-center flex-column p-8 text-center">
                                <a href="{{ asset('storage/' . $row->requirements_specifications) }}" class="text-hover-primary d-flex flex-column text-gray-800">
                                    <div class="symbol symbol-60px mb-5">
                                        <img src="{{ asset('assets/media/svg/files/' . \File::extension(asset('storage/' . $row->requirements_specifications)) . '.svg') }}" class="theme-light-show" alt="" />
                                        <img src="{{ asset('assets/media/svg/files/' . \File::extension(asset('storage/' . $row->requirements_specifications)) . '-dark.svg') }}" class="theme-dark-show" alt="" />
                                    </div>
                                    <div class="fs-5 fw-bold mb-2">كراسة الشروط والمواصفات</div>
                                </a>
                                <div class="fs-7 fw-semibold text-gray-400">تم الرفع:
                                    {{ $row->created_at->diffForHumans() }}
                                    بواسطة : {{ @\App\Models\User::find($row->user_add)->name }}
                                </div>
                                @if (!is_null($row->updated_at) && isset($row->updated_at))
                                    <div class="fs-7 fw-semibold text-gray-400">تم التحديث:
                                        {{ $row->updated_at->diffForHumans() }}
                                        بواسطة : {{ @\App\Models\User::find($row->user_edit)->name }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    @if (!empty($row->additional_questions))
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="card h-100">
                                @if (!Auth::user()->hasRole('observer'))
                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="تعديل" style="display:inline-block;margin:10px 20px 0 0;" aria-label="كراسة نطاق عمل المشروع" data-bs-original-title="كراسة نطاق عمل المشروع" data-kt-initialized="1">
                                        <i class="bi bi-pencil-fill fs-7"></i>
                                        <form method="post" class="formup" enctype="multipart/form-data" data-action="{{ route('up.files') }}">
                                            <span style="display:inline-block;"></span>
                                            @csrf
                                            <input type="hidden" name="project_id" value="{{ $row->id }}">
                                            <input type="hidden" name="filetype" value="additional_questions">
                                            <input type="hidden" name="type" value="projects">
                                            <input type="file" class="pdffile" id="additional_questions" name="file" style="opacity:0;visibility:hidden;" onchange="_submitForm($(this),'additional_questions');" accept=".pdf">
                                        </form>
                                    </label>
                                @endif
                                <div class="card-body d-flex justify-content-center flex-column p-8 text-center">
                                    <a href="{{ asset('storage/' . $row->additional_questions) }}" class="text-hover-primary d-flex flex-column text-gray-800">
                                        <div class="symbol symbol-60px mb-5">
                                            <img src="{{ asset('assets/media/svg/files/' . \File::extension(asset('storage/' . $row->additional_questions)) . '.svg') }}" class="theme-light-show" alt="" />
                                            <img src="{{ asset('assets/media/svg/files/' . \File::extension(asset('storage/' . $row->additional_questions)) . '-dark.svg') }}" class="theme-dark-show" alt="" />
                                        </div>
                                        <div class="fs-5 fw-bold mb-2">الأسئلة الإضافية</div>
                                    </a>
                                    <div class="fs-7 fw-semibold text-gray-400">تم الرفع:
                                        {{ $row->created_at->diffForHumans() }}
                                        بواسطة : {{ @\App\Models\User::find($row->user_add)->name }}
                                    </div>
                                    @if (!is_null($row->updated_at) && isset($row->updated_at))
                                        <div class="fs-7 fw-semibold text-gray-400">تم التحديث:
                                            {{ $row->updated_at->diffForHumans() }}
                                            بواسطة : {{ @\App\Models\User::find($row->user_edit)->name }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                    <!--end::Col-->
                    <!--begin::Col-->
                    @if ((($row->type_id >= 2 && $row->type_id <= 5) || $row->type_id == 12) && !empty($project_local_development->research_survey))
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="card h-100">
                                @if (!Auth::user()->hasRole('observer'))
                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="تعديل" style="display:inline-block;margin:10px 20px 0 0;" aria-label="كراسة نطاق عمل المشروع" data-bs-original-title="كراسة نطاق عمل المشروع" data-kt-initialized="1">
                                        <i class="bi bi-pencil-fill fs-7"></i>
                                        <form method="post" class="formup" enctype="multipart/form-data" data-action="{{ route('up.files') }}">
                                            <span style="display:inline-block;"></span>
                                            @csrf
                                            <input type="hidden" name="project_id" value="{{ $row->id }}">
                                            <input type="hidden" name="filetype" value="research_survey">
                                            <input type="hidden" name="type" value="project_local_development">
                                            <input type="file" class="pdffile" id="research_survey" name="file" style="opacity:0;visibility:hidden;" onchange="_submitForm($(this),'research_survey');" accept=".pdf">
                                        </form>
                                    </label>
                                @endif
                                <div class="card-body d-flex justify-content-center flex-column p-8 text-center">
                                    <a href="{{ asset('storage/' . $project_local_development->research_survey ?? '') }}" class="text-hover-primary d-flex flex-column text-gray-800">
                                        <div class="symbol symbol-60px mb-5">
                                            <img src="{{ asset('assets/media/svg/files/' . \File::extension(asset('storage/' . $project_local_development->research_survey)) . '.svg') }}" class="theme-light-show" alt="" />
                                            <img src="{{ asset('assets/media/svg/files/' . \File::extension(asset('storage/' . $project_local_development->research_survey)) . '-dark.svg') }}" class="theme-dark-show" alt="" />
                                        </div>
                                        <div class="fs-5 fw-bold mb-2">إستمارة البحث</div>
                                    </a>
                                    <div class="fs-7 fw-semibold text-gray-400">تم الرفع:
                                        {{ $project_local_development->created_at->diffForHumans() }}
                                        بواسطة : {{ @\App\Models\User::find($project_local_development->user_add)->name }}
                                    </div>
                                    @if (!is_null($project_local_development->updated_at) && isset($project_local_development->updated_at))
                                        <div class="fs-7 fw-semibold text-gray-400">تم التحديث:
                                            {{ $project_local_development->updated_at->diffForHumans() }}
                                            بواسطة : {{ @\App\Models\User::find($project_local_development->user_edit)->name }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                    <!--end::Col-->
                    <!--begin::Col-->
                    @if ($row->type_id == 14)
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="card h-100">
                                @if (!Auth::user()->hasRole('observer'))
                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="تعديل" style="display:inline-block;margin:10px 20px 0 0;" aria-label="كراسة نطاق عمل المشروع" data-bs-original-title="كراسة نطاق عمل المشروع" data-kt-initialized="1">
                                        <i class="bi bi-pencil-fill fs-7"></i>
                                        <form method="post" class="formup" enctype="multipart/form-data" data-action="{{ route('up.files') }}">
                                            <span style="display:inline-block;"></span>
                                            @csrf
                                            <input type="hidden" name="project_id" value="{{ $row->id }}">
                                            <input type="hidden" name="filetype" value="trainee_list">
                                            <input type="hidden" name="type" value="project_training_type">
                                            <input type="file" class="pdffile" id="trainee_list" name="file" style="opacity:0;visibility:hidden;" onchange="_submitForm($(this),'trainee_list');" accept=".pdf">
                                        </form>
                                    </label>
                                @endif
                                <div class="card-body d-flex justify-content-center flex-column p-8 text-center">
                                    <a href="{{ asset('storage/' . $training->trainee_list) }}" class="text-hover-primary d-flex flex-column text-gray-800">
                                        <div class="symbol symbol-60px mb-5">
                                            <img src="{{ asset('assets/media/svg/files/' . \File::extension(asset('storage/' . $training->trainee_list)) . '.svg') }}" class="theme-light-show" alt="" />
                                            <img src="{{ asset('assets/media/svg/files/' . \File::extension(asset('storage/' . $training->trainee_list)) . '-dark.svg') }}" class="theme-dark-show" alt="" />
                                        </div>
                                        <div class="fs-5 fw-bold mb-2">قائمة المتدربين</div>
                                    </a>
                                    <div class="fs-7 fw-semibold text-gray-400">تم الرفع:
                                        {{ $training->created_at->diffForHumans() }}
                                        بواسطة : {{ @\App\Models\User::find($training->user_add)->name }}
                                    </div>
                                    @if (!is_null($training->updated_at) && isset($training->updated_at))
                                        <div class="fs-7 fw-semibold text-gray-400">تم التحديث:
                                            {{ $training->updated_at->diffForHumans() }}
                                            بواسطة : {{ @\App\Models\User::find($training->user_edit)->name }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="card h-100">
                                @if (!Auth::user()->hasRole('observer'))
                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="تعديل" style="display:inline-block;margin:10px 20px 0 0;" aria-label="كراسة نطاق عمل المشروع" data-bs-original-title="كراسة نطاق عمل المشروع" data-kt-initialized="1">
                                        <i class="bi bi-pencil-fill fs-7"></i>
                                        <form method="post" class="formup" enctype="multipart/form-data" data-action="{{ route('up.files') }}">
                                            <span style="display:inline-block;"></span>
                                            @csrf
                                            <input type="hidden" name="project_id" value="{{ $row->id }}">
                                            <input type="hidden" name="filetype" value="training_agenda">
                                            <input type="hidden" name="type" value="project_training_type">
                                            <input type="file" class="pdffile" id="training_agenda" name="file" style="opacity:0;visibility:hidden;" onchange="_submitForm($(this),'training_agenda');" accept=".pdf">
                                        </form>
                                    </label>
                                @endif
                                <div class="card-body d-flex justify-content-center flex-column p-8 text-center">
                                    <a href="{{ asset('storage/' . $training->training_agenda) }}" class="text-hover-primary d-flex flex-column text-gray-800">
                                        <div class="symbol symbol-60px mb-5">
                                            <img src="{{ asset('assets/media/svg/files/' . \File::extension(asset('storage/' . $training->training_agenda)) . '.svg') }}" class="theme-light-show" alt="" />
                                            <img src="{{ asset('assets/media/svg/files/' . \File::extension(asset('storage/' . $training->training_agenda)) . '-dark.svg') }}" class="theme-dark-show" alt="" />
                                        </div>
                                        <div class="fs-5 fw-bold mb-2">ملف الأجندة</div>
                                    </a>
                                    <div class="fs-7 fw-semibold text-gray-400">تم الرفع:
                                        {{ $training->created_at->diffForHumans() }}
                                        بواسطة : {{ @\App\Models\User::find($training->user_add)->name }}
                                    </div>
                                    @if (!is_null($training->updated_at) && isset($training->updated_at))
                                        <div class="fs-7 fw-semibold text-gray-400">تم التحديث:
                                            {{ $training->updated_at->diffForHumans() }}
                                            بواسطة : {{ @\App\Models\User::find($training->user_edit)->name }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                    <!--end::Col-->
                    <!--begin::Col-->
                    @if ($row->type_id == 9)
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="card h-100">
                                @if (!Auth::user()->hasRole('observer'))
                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="تعديل" style="display:inline-block;margin:10px 20px 0 0;" aria-label="كراسة نطاق عمل المشروع" data-bs-original-title="كراسة نطاق عمل المشروع" data-kt-initialized="1">
                                        <i class="bi bi-pencil-fill fs-7"></i>
                                        <form method="post" class="formup" enctype="multipart/form-data" data-action="{{ route('up.files') }}">
                                            <span style="display:inline-block;"></span>
                                            @csrf
                                            <input type="hidden" name="project_id" value="{{ $row->id }}">
                                            <input type="hidden" name="filetype" value="charity_list_file">
                                            <input type="hidden" name="type" value="project_empower_charity">
                                            <input type="file" class="pdffile" id="charity_list_file" name="file" style="opacity:0;visibility:hidden;" onchange="_submitForm($(this),'charity_list_file');" accept=".pdf">
                                        </form>
                                    </label>
                                @endif
                                <div class="card-body d-flex justify-content-center flex-column p-8 text-center">
                                    <a href="{{ asset('storage/' . $project_empower_charity->charity_list_file) }}" class="text-hover-primary d-flex flex-column text-gray-800">
                                        <div class="symbol symbol-60px mb-5">
                                            <img src="{{ asset('assets/media/svg/files/' . \File::extension(asset('storage/' . $project_empower_charity->charity_list_file)) . '.svg') }}" class="theme-light-show" alt="" />
                                            <img src="{{ asset('assets/media/svg/files/' . \File::extension(asset('storage/' . $project_empower_charity->charity_list_file)) . '-dark.svg') }}" class="theme-dark-show" alt="" />
                                        </div>
                                        <div class="fs-5 fw-bold mb-2">قائمة الجمعيات</div>
                                    </a>
                                    <div class="fs-7 fw-semibold text-gray-400">تم الرفع:
                                        {{ $project_empower_charity->created_at->diffForHumans() }}
                                        بواسطة : {{ @\App\Models\User::find($project_empower_charity->user_add)->name }}
                                    </div>
                                    @if (!is_null($project_empower_charity->updated_at) && isset($project_empower_charity->updated_at))
                                        <div class="fs-7 fw-semibold text-gray-400">تم التحديث:
                                            {{ $project_empower_charity->updated_at->diffForHumans() }}
                                            بواسطة : {{ @\App\Models\User::find($project_empower_charity->user_edit)->name }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                    <!--end::Col-->
                    <!--begin::Col-->
                    @if ($row->type_id == 1 || $row->type_id == 2 || $row->type_id == 10 || $row->type_id == 12)
                    @php $k = 1; @endphp
                      @foreach($maps as $v)
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="card h-100">
                                @if (!Auth::user()->hasRole('observer'))
                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="تعديل" style="display:inline-block;margin:10px 20px 0 0;" aria-label="كراسة نطاق عمل المشروع" data-bs-original-title="كراسة نطاق عمل المشروع" data-kt-initialized="1">
                                        <i class="bi bi-pencil-fill fs-7"></i>
                                        <form method="post" class="formup" enctype="multipart/form-data" data-action="{{ route('up.files') }}">
                                            <span style="display:inline-block;"></span>
                                            @csrf
                                            <input type="hidden" name="project_id" value="{{ $row->id }}">
                                            <input type="hidden" name="fileID" value="{{ $v->id }}">
                                            <input type="hidden" name="filetype" value="google_map">
                                            <input type="hidden" name="type" value="project_maps">
                                            <input type="file" class="pdffile" id="google_map-{{ $v->id }}" name="file" style="opacity:0;visibility:hidden;" onchange="_submitForm($(this),'google_map-{{ $v->id }}');" accept=".pdf">
                                        </form>
                                    </label>
                                @endif
                                <div class="card-body d-flex justify-content-center flex-column p-8 text-center">
                                    <a href="{{ asset('storage/' . $v->google_map) }}" class="text-hover-primary d-flex flex-column text-gray-800">
                                        <div class="symbol symbol-60px mb-5">
                                            <img src="{{ asset('assets/media/svg/files/' . \File::extension(asset('storage/' . $v->google_map)) . '.svg') }}" class="theme-light-show" alt="" />
                                            <img src="{{ asset('assets/media/svg/files/' . \File::extension(asset('storage/' . $v->google_map)) . '-dark.svg') }}" class="theme-dark-show" alt="" />
                                        </div>
                                        <div class="fs-5 fw-bold mb-2">خرائط المواقع {{$k}}</div>
                                    </a>
                                    <div class="fs-7 fw-semibold text-gray-400">تم الرفع:
                                        {{ \Carbon\Carbon::parse($v->created_at)->diffForHumans() }}
                                        بواسطة : {{ @\App\Models\User::find($v->user_add)->name }}
                                    </div>
                                    @if (!is_null($v->updated_at) && isset($v->updated_at))
                                        <div class="fs-7 fw-semibold text-gray-400">تم التحديث:
                                            {{ \Carbon\Carbon::parse($v->updated_at)->diffForHumans() }}
                                            بواسطة : {{ @\App\Models\User::find($v->user_edit)->name }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @php $k++; @endphp
                        @endforeach
                    @endif
                    <!--end::Col-->
                    <!--begin::Col-->
                    @if ($row->type_id == 1 && !empty($project_family_development->family_list))
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="card h-100">
                                @if (!Auth::user()->hasRole('observer'))
                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="تعديل" style="display:inline-block;margin:10px 20px 0 0;" aria-label="كراسة نطاق عمل المشروع" data-bs-original-title="كراسة نطاق عمل المشروع" data-kt-initialized="1">
                                        <i class="bi bi-pencil-fill fs-7"></i>
                                        <form method="post" class="formup" enctype="multipart/form-data" data-action="{{ route('up.files') }}">
                                            <span style="display:inline-block;"></span>
                                            @csrf
                                            <input type="hidden" name="project_id" value="{{ $row->id }}">
                                            <input type="hidden" name="filetype" value="family_list">
                                            <input type="hidden" name="type" value="project_family_development">
                                            <input type="file" class="pdffile" id="family_list" name="file" style="opacity:0;visibility:hidden;" onchange="_submitForm($(this),'family_list');" accept=".pdf">
                                        </form>
                                    </label>
                                @endif
                                <div class="card-body d-flex justify-content-center flex-column p-8 text-center">
                                    <a href="{{ asset('storage/' . $project_family_development->family_list) }}" class="text-hover-primary d-flex flex-column text-gray-800">
                                        <div class="symbol symbol-60px mb-5">
                                            <img src="{{ asset('assets/media/svg/files/' . \File::extension(asset('storage/' . $project_family_development->family_list)) . '.svg') }}" class="theme-light-show" alt="" />
                                            <img src="{{ asset('assets/media/svg/files/' . \File::extension(asset('storage/' . $project_family_development->family_list)) . '-dark.svg') }}" class="theme-dark-show" alt="" />
                                        </div>
                                        <div class="fs-5 fw-bold mb-2">قائمة الأسر</div>
                                    </a>
                                    <div class="fs-7 fw-semibold text-gray-400">تم الرفع:
                                        {{ $project_family_development->created_at->diffForHumans() }}
                                        بواسطة : {{ @\App\Models\User::find($project_family_development->user_add)->name }}
                                    </div>
                                    @if (!is_null($project_family_development->updated_at) && isset($project_family_development->updated_at))
                                        <div class="fs-7 fw-semibold text-gray-400">تم التحديث:
                                            {{ $project_family_development->updated_at->diffForHumans() }}
                                            بواسطة : {{ @\App\Models\User::find($project_family_development->user_edit)->name }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                    <!--end::Col-->
                    <!--begin::Col-->
                    @if ($row->type_id == 2 && !empty($project_local_development->coordinate_file))
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="card h-100">
                                @if (!Auth::user()->hasRole('observer'))
                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="تعديل" style="display:inline-block;margin:10px 20px 0 0;" aria-label="كراسة نطاق عمل المشروع" data-bs-original-title="كراسة نطاق عمل المشروع" data-kt-initialized="1">
                                        <i class="bi bi-pencil-fill fs-7"></i>
                                        <form method="post" class="formup" enctype="multipart/form-data" data-action="{{ route('up.files') }}">
                                            <span style="display:inline-block;"></span>
                                            @csrf
                                            <input type="hidden" name="project_id" value="{{ $row->id }}">
                                            <input type="hidden" name="filetype" value="coordinate_file">
                                            <input type="hidden" name="type" value="project_local_development">
                                            <input type="file" class="pdffile" id="coordinate_file" name="file" style="opacity:0;visibility:hidden;" onchange="_submitForm($(this),'coordinate_file');" accept=".pdf">
                                        </form>
                                    </label>
                                @endif
                                <div class="card-body d-flex justify-content-center flex-column p-8 text-center">
                                    <a href="{{ asset('storage/' . $project_local_development->coordinate_file) }}" class="text-hover-primary d-flex flex-column text-gray-800">
                                        <div class="symbol symbol-60px mb-5">
                                            <img src="{{ asset('assets/media/svg/files/' . \File::extension(asset('storage/' . $project_local_development->coordinate_file)) . '.svg') }}" class="theme-light-show" alt="" />
                                            <img src="{{ asset('assets/media/svg/files/' . \File::extension(asset('storage/' . $project_local_development->coordinate_file)) . '-dark.svg') }}" class="theme-dark-show" alt="" />
                                        </div>
                                        <div class="fs-5 fw-bold mb-2">ملف الإحداثيات</div>
                                    </a>
                                    <div class="fs-7 fw-semibold text-gray-400">تم الرفع:
                                        {{ $project_local_development->created_at->diffForHumans() }}
                                        بواسطة : {{ @\App\Models\User::find($project_local_development->user_add)->name }}
                                    </div>
                                    @if (!is_null($project_local_development->updated_at) && isset($project_local_development->updated_at))
                                        <div class="fs-7 fw-semibold text-gray-400">تم التحديث:
                                            {{ $project_local_development->updated_at->diffForHumans() }}
                                            بواسطة : {{ @\App\Models\User::find($project_local_development->user_edit)->name }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                    <!--end::Col-->
                    <!--start::ClientFiles-->
                    @php $i=1; @endphp
                    @foreach ($clientFiles as $f)
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="card h-100">
                                @if (!Auth::user()->hasRole('observer'))
                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="تعديل" style="display:inline-block;margin:10px 20px 0 0;" aria-label="كراسة نطاق عمل المشروع" data-bs-original-title="كراسة نطاق عمل المشروع" data-kt-initialized="1">
                                        <i class="bi bi-pencil-fill fs-7"></i>
                                        <form method="post" class="formup" enctype="multipart/form-data" data-action="{{ route('up.files') }}">
                                            <span style="display:inline-block;"></span>
                                            @csrf
                                            <input type="hidden" name="project_id" value="{{ $row->id }}">
                                            <input type="hidden" name="fileID" value="{{ $f->id }}">
                                            <input type="hidden" name="filetype" value="file">
                                            <input type="hidden" name="type" value="project_client_attachments">
                                            <input type="file" class="pdffile" id="file-{{ $f->id }}" name="file" style="opacity:0;visibility:hidden;" onchange="_submitForm($(this),'file-{{ $f->id }}');" accept=".pdf">
                                        </form>
                                    </label>
                                @endif
                                <div class="card-body d-flex justify-content-center flex-column p-8 text-center">
                                    <a href="{{ asset('storage' . $f->file) }}" class="text-hover-primary d-flex flex-column text-gray-800">
                                        <div class="symbol symbol-60px mb-5">
                                            <img src="{{ asset('assets/media/svg/files/' . \File::extension(asset('storage' . $f->file)) . '.svg') }}" class="theme-light-show" alt="" />
                                            <img src="{{ asset('assets/media/svg/files/' . \File::extension(asset('storage' . $f->file)) . '-dark.svg') }}" class="theme-dark-show" alt="" />
                                        </div>
                                        <div class="fs-5 fw-bold mb-2">ملف العميل {{ $i }}</div>
                                    </a>
                                    <div class="fs-7 fw-semibold text-gray-400">تم الرفع:
                                        {{ \Carbon\Carbon::parse($f->created_at)->diffForHumans() }}
                                        بواسطة : {{ @\App\Models\User::find($f->user_add)->name }}
                                    </div>
                                    @if (!is_null($f->updated_at) && isset($f->updated_at))
                                        <div class="fs-7 fw-semibold text-gray-400">تم التحديث:
                                            {{ \Carbon\Carbon::parse($f->updated_at)->diffForHumans() }}
                                            بواسطة : {{ @\App\Models\User::find($f->user_edit)->name }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @php $i++; @endphp
                    @endforeach
                    <!--end::ClientFiles-->
                </div>
                <!--end:Row-->
            </div>

            <div class="tab-pane fade" id="kt_project_requirements_tab" role="tabpanel">
                <div class="col-lg-12">
                    <div class="card h-md-100 tab-pane">
                        <div class="card-header pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-dark">الطلبات</span>
                            </h3>
                        </div>
                        <div class="card-body px-0 pt-7">
                            <table id="tblReq kt_datatable_both_scrolls" class="table-striped table-row-bordered gy-5 gs-7 table">
                                <thead>
                                    <tr class="fw-semibold fs-7 border-bottom bg-danger border-gray-200 py-4 text-white">
                                        <th>&nbsp;</th>
                                        <th>تفاصيل طلب العميل</th>
                                        <th>تاريخ الطلب</th>
                                        <th>الرد</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $s ='a0b1c2d3e4f56789'; @endphp
                                    @foreach ($requirements as $v)
                                        @php
                                            $j = 0;
                                            $c = '';
                                            while ($j < 6) {
                                                $c .= $s[mt_rand(0, strlen($s) - 1)];
                                                $j++;
                                            }
                                        @endphp
                                        <tr class="fw-semibold border-bottom border-gray-300 py-5">
                                            <td class="index">
                                                <div style="border-right:4px solid #{{ $c }};">&nbsp;</div>
                                            </td>
                                            <td>{{ $v->title }}</td>
                                            <td>{{ $v->date }}</td>
                                            <td>
                                                <button class="addRF btn btn-sm me-2 btn-success" data-req="{{ $v->id }}" data-bs-toggle="modal" data-bs-target="#modalWrap"><i class="bi bi-upload"></i>إضافة الرد</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--modal-->

            <div class="tab-pane fade" id="kt_project_outcome_tab" role="tabpanel">
                <div class="col-lg-12">
                    <div class="card h-md-100 tab-pane">
                        <div class="card-header py-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-dark">المخرجات {{ $outcomeCount }}</span>
                            </h3>
                            <button type="button" data-bs-toggle="modal" data-bs-target="#modalOutWrap" id="addOutBtn" class="btn btn-sm me-2 btn-primary"><i class="bi bi-plus-square"></i>إنشاء مَخرج جديد</i></button>
                        </div>
                        <div class="card-body px-0 pt-7">
                            @if ($outcomeCount)
                                <table id="kt_datatable_both_scrolls" class="table-striped table-row-bordered gy-5 gs-7 table">
                                    <thead>
                                        <tr class="fw-semibold fs-7 border-bottom bg-success border-gray-200 py-4 text-white">
                                            <th>&nbsp;</th>
                                            <th>الاسمُ</th>
                                            <th>الوصف</th>
                                            <th>تاريخ أضافه المخرج</th>
                                            <th>نموذج للمخرج</th>
                                            <th>حالة النموذج</th>
                                            @if($outcomeCount === $outcomeAcceptedCount)
                                            <th>ملف المخرج</th>
                                            <th>حاله المخرج</th>
                                            @endif
                                            <th>&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($outcomes as $outcome)
                                            <tr class="fw-semibold border-bottom border-gray-300 py-5" data-row="R-{{$outcome->id}}">
                                            <td class="index">&nbsp;</td>
                                                <td> {{ $outcome->title }}</td>
                                                <td style="width:170px;height:80px;overflow:auto;"> {{ $outcome->description }}</td>
                                                <td>{{ \Carbon\Carbon::parse($outcome->created_at)->format('Y/m/d') . ' | ' . \Carbon\Carbon::parse($outcome->created_at)->diffForHumans() }}
                                                </td>
                                                <td>
                                                @if (!is_null($outcome->template) && isset($outcome->template))
                                                    <a href="{{ asset('storage/' . $outcome->template) }}" rel="alternate" download class="btn btn-sm me-2 btn-success">
                                                        <i class="bi bi-download"></i> تحميل الملف </a>
                                                @else
                                                    لايوجد ملف
                                                @endif
                                            </td>
                                            <td>
                                                @if (!is_null($outcome->is_template_approved) && isset($outcome->is_template_approved))
                                                        @if($outcome->is_template_approved == '1')
                                                            <span style="padding:10px 12px !important;" class="badge badge-light-success" title="موافق"> <i class="bi bi-check-circle-fill text-success" style=""></i> </span>
                                                        @else
                                                            <span style="padding:10px 12px !important;" class="badge badge-light-danger" title="مرفوض"> <i class="bi bi-exclamation-circle-fill text-danger" style=""></i> </span>
                                                            <span class="del_out" data-outcome="{!!$outcome->id!!}" title="حذف المخرج"> &nbsp;<i class="bi bi-trash" style="color:#888 !important;font-size:1.2em;cursor:pointer;"></i> </span>
                                                            <span class="edit_out" data-d="{{$outcome->description}}" data-outcome="{!!$outcome->id!!}" title="تعديل المخرج" data-bs-toggle="modal" data-bs-target="#modalRejEdit"> &nbsp;<i class="bi bi-pencil" style="color:#888 !important;font-size:1.2em;cursor:pointer;"></i> </span>
                                                            @if (!is_null($outcome->template_reject_reason) && isset($outcome->template_reject_reason))
                                                            &nbsp; <span style="color:#fff !important;cursor:pointer;" title="الملاحظات وسبب الرفض" onclick="_getRemarks('{{$outcome->template_reject_reason}}');"> <i class="bi bi-search" style="color:#888 !important;font-size:1.2em;"></i> </span>
                                                            @endif
                                                     @endif
                                                 @else
                                                    لم يحدد بعد 
                                                 @endif
                                                </td>
                                                @if($outcomeCount === $outcomeAcceptedCount)
                                                <td>
                                                    @if (!$outcome->file)
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#modalUploadNewFile"  data-outcome-id="{{ $outcome->id }}" class="outcome_ID handleOutCome btn-sm me-2 btn btn-primary"><i class="fas fa-envelope-open-text fs-4 me-2"></i>رفع ملف المخرجات</a>
                                                    @elseif ($outcome->file && $outcome->is_accepted == '0')
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#modalUploadOutfile" id="{{ $outcome->id }}" data-outcome-id="{{ $outcome->id }}" class="handleOutCome btn btn-sm me-2 btn-primary"><i class="fas fa-envelope-open-text fs-4 me-2"></i> رفع ملف المخرجات</a>
                                                    @else
                                                        <span class="svg-icon svg-icon-1 svg-icon-primary">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                                                                <path
                                                                    d="M10.0813 3.7242C10.8849 2.16438 13.1151 2.16438 13.9187 3.7242V3.7242C14.4016 4.66147 15.4909 5.1127 16.4951 4.79139V4.79139C18.1663 4.25668 19.7433 5.83365 19.2086 7.50485V7.50485C18.8873 8.50905 19.3385 9.59842 20.2758 10.0813V10.0813C21.8356 10.8849 21.8356 13.1151 20.2758 13.9187V13.9187C19.3385 14.4016 18.8873 15.491 19.2086 16.4951V16.4951C19.7433 18.1663 18.1663 19.7433 16.4951 19.2086V19.2086C15.491 18.8873 14.4016 19.3385 13.9187 20.2758V20.2758C13.1151 21.8356 10.8849 21.8356 10.0813 20.2758V20.2758C9.59842 19.3385 8.50905 18.8873 7.50485 19.2086V19.2086C5.83365 19.7433 4.25668 18.1663 4.79139 16.4951V16.4951C5.1127 15.491 4.66147 14.4016 3.7242 13.9187V13.9187C2.16438 13.1151 2.16438 10.8849 3.7242 10.0813V10.0813C4.66147 9.59842 5.1127 8.50905 4.79139 7.50485V7.50485C4.25668 5.83365 5.83365 4.25668 7.50485 4.79139V4.79139C8.50905 5.1127 9.59842 4.66147 10.0813 3.7242V3.7242Z"
                                                                    fill="currentColor" />
                                                                <path d="M14.8563 9.1903C15.0606 8.94984 15.3771 8.9385 15.6175 9.14289C15.858 9.34728 15.8229 9.66433 15.6185 9.9048L11.863 14.6558C11.6554 14.9001 11.2876 14.9258 11.048 14.7128L8.47656 12.4271C8.24068 12.2174 8.21944 11.8563 8.42911 11.6204C8.63877 11.3845 8.99996 11.3633 9.23583 11.5729L11.3706 13.4705L14.8563 9.1903Z" fill="white" />
                                                            </svg>
                                                        </span>
                                                        تم رفع الملف
                                                        <p>{{ \Carbon\Carbon::parse($outcome->updated_at)->format('Y/m/d') . ' | ' . \Carbon\Carbon::parse($outcome->updated_at)->diffForHumans() }}</p>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($outcome->is_accepted == 0 && $outcome->client_rejection_note)
                                                        <div class="position-relative py-2 pe-3 ps-6">
                                                            <span class="bullet bullet-dot bg-danger h-10px w-10px me-2"></span>
                                                            <a href="#" class="text-dark text-hover-danger mb-1">مخرج مرفوض </a>
                                                            <p>سبب رفض العميل للمخرج</p>
                                                            <div class="fs-7 text-danger">"{{ $outcome->client_rejection_note }}"</div>
                                                        </div>
                                                    @elseif($outcome->is_accepted == 1)
                                                        <div class="position-relative py-2 pe-3 ps-6">
                                                            <span class="bullet bullet-dot bg-success h-10px w-10px me-2"></span>
                                                            مخرج مقبول
                                                        </div>
                                                    @else
                                                        <div class="position-relative py-2 pe-3 ps-6">
                                                            <span class="bullet bullet-dot bg-primary h-10px w-10px me-2"></span>
                                                            مخرج جديد
                                                        </div>
                                                    @endif
                                                </td>
                                                @endif

                                                <td>&nbsp;</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                    
                            @else
                                <div class="flex-equal fs-5 me-5">
                                    <div class="alert alert-danger" role="alert">
                                        لا توجد مخرجات مضافه لهذا المشروع
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!--modal-->
 <div class="modal fade" id="modalUploadNewFile" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-1000px">
        <div class="modal-content">
        <div class="modal-header">
            <h3> <i class="fas fa-envelope-open-text" style="color:#fff;font-size:1.3rem;"></i> تحديث ملف المخرج </h3>
            <br>
        </div>
        <div class="modal-body scroll-y mx-xl-18 pb-15 mx-5">
            <form id="outcomeFile">
               @csrf 
               @method('Patch')
             <input type="hidden" name="outComeID" id="outID" value="">
             <input type="hidden" name="projectID"  value="{{$row->id}}">
             <label for="template" class="required fs-6 fw-semibold mb-2">ملف المخرج</label>
                <input type="file" id="template" class="form-control" name="OutFile">
                <br>
            </form>
            <div class="mt-5" style="border-top:1px solid #2a2a3f;padding-top:20px;">
            <input type="button" class="btn" data-bs-dismiss="modal" value="إلغاء" style="float:left;background:#F60F37;color:#fff;margin:0 10px;">
             <input type="button" class="btn" id="saveNewFile" value="حفظ التغيرات" style="float:left;background: #004A61; color:white;">
             <br clear="all">
             </div>
        </div>
        </div>
     </div>
     </div>
  <!--end-modal-->
            <!--modal-->
 <div class="modal fade" id="modalRejEdit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-1000px">
        <div class="modal-content">
        <div class="modal-header">
            <h3><i class="bi bi-pencil" style="color:#fff;font-size:1.3rem;"></i>  تعديل القالب للمخرج </h3>
            <br>
        </div>
        <div class="modal-body scroll-y mx-xl-18 pb-15 mx-5">
              <form method="post" action="{{route('edit.REJOUT')}}" enctype="multipart/form-data">
                @csrf 
                @method('PATCH')
                <input type="hidden" id="_outComeID" name="outcome" value="">
                <label for="_outComeDesc" class="required fs-6 fw-semibold mb-2">وصف المخرج</label>
                <textarea name="outdesc" class="form-control" id="_outComeDesc"></textarea>
                <br>
                <label for="template" class="required fs-6 fw-semibold mb-2">قالب المخرج</label>
                <input type="file" id="template" class="form-control" name="Outtemp">
                <div class="mt-5" style="border-top:1px solid #2a2a3f;padding-top:20px;">
                <input type="button" class="btn btn-secondary" data-bs-dismiss="modal" value="إلغاء" style="float:left;background:#F60F37;color:#fff;margin:0 10px;">
               <input type="submit" class="btn btn-primary" data-bs-dismiss="modal" value="حفظ التغيرات" style="float:left;background: #004A61; color:white">
               </div>
              </form>
        </div>
        </div>
     </div>
     </div>
  <!--end-modal-->

            <div class="modal fade" id="modalOutWrap" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered mw-1000px">
                <div class="modal-content">
                    <div class="modal-header mb-4">
                        <h3><i class="bi bi-plus-square mx-4" style="color:#fff;font-size:1.3rem;"></i>إنشاء مخرج جديد</h3>
                    </div>
                    <div class="modal-body scroll-y mx-xl-10 pb-15 mx-5">
                        <form id="addOut">
                            @csrf
                            <input type="hidden" name="project" value="{{ $row->id }}">
                            <div id="inputOutWrap" class="mb-12">
                                <div class="inputOut">
                                    <div class="row"> 
                                        <div class="col-11">
                                            <span id="errOut" style="color:#f1416c;"></span>
                                            <div class="mt-2">
                                                <input type="text" class="form-control" name="titleOut[]" placeholder="عنوان المخرج">
                                            </div>
                                             <div class="mt-2">
                                                    <textarea class="form-control" name="descOut[]" placeholder="وصف المخرج"></textarea>
                                            </div>
                                            <div class="mt-2">
                                                <label for="template" class="required fs-6 fw-semibold mb-2">القالب</label>
                                                <input type="file" id="template" class="form-control" name="fileOut[]">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5" style="border-top:1px solid #2a2a3f;padding-top:20px;">
                            <input type="button" id="cancelOut" class="canc btn" style="float:left;background:#F60F37;color:#fff;margin-left:10px;" data-bs-dismiss="modal" value="إلغاء">  
                            <input type="button" id="saveOut" class="btn btn me-2" style="float:left;background: #004A61; color:white" value="إضافة">
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>



            <div class="modal fade" id="modalUploadOutfile" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered mw-1000px">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3> <i class="bi bi-plus-square" style="color:#fff;font-size:1.3rem;"></i> إضافة ملف المخرجات</h3>
                            <br>
                        </div>
                        <div class="modal-body scroll-y mx-xl-18 pb-15 mx-5">
                            <form action="{{ route('outcome.uploadfile') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" id="is_approved" name="is_approved">
                                <input type="hidden" id="outcome_id" name="outcome_id">
                                <input type="hidden" id="project_id" name="project_id" value="{{ $id }}">

                                <div class="fv-row mb-8">
                                    <label class="required fs-6 fw-semibold mb-2">الملف</label>
                                    <input required type="file" accept=".pdf" class="form-control form-control-solid" name="file" />
                                </div>
                                <div class="mt-5" style="border-top:1px solid #2a2a3f;padding-top:20px;">
                                <input type="button" class="btn" data-bs-dismiss="modal" value="إلغاء" style="float:left;background:#F60F37;color:#fff;margin:0 10px;">
                                <input type="submit" class="btn" value="إضافة"  style="float:left;background: #004A61; color:white;">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalWrap" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered mw-1000px">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3> <i class="bi bi-plus-square mx-2" style="color:#fff;font-size:1.3rem;"></i>إضافة الرد</h3>
                            <br>
                        </div>
                        <div class="modal-body scroll-y mx-xl-18 pb-15 mx-5">
                            {{--
                            <!--begin::Dropzone-->
                            <div class="dropzone" id="add_req_file">
                                <!--begin::Message-->
                                <div class="dz-message needsclick">
                                    <!--begin::Icon-->
                                    <i class="bi bi-upload text-primary fs-2x"></i>
                                    <!--end::Icon-->
                                    <!--begin::Info-->
                                    <div class="ms-4">
                                        <h3 class="fs-5 fw-bold mb-1 text-gray-900"> إرفاق الملف </h3>
                                    </div>
                                    <!--end::Info-->
                                </div>
                            </div>
                            <!--end::Dropzone-->
                            --}}
                            <br>
                            <form id="formSaveReq">
                                @csrf 
                                @method('PATCH')
                                <input type="hidden" id="reqID" name="req_id" value="">
                                <input type="hidden" id="pID" name="project_id" value="{{$row->id}}">
                                <textarea class="form-control" id="remarks" name="notes" placeholder="أي ملاحظات"></textarea>
                            </form>
                            
                            <div class="mt-5" style="border-top:1px solid #2a2a3f;padding-top:20px;">
                            <input type="button" class="canc btn" data-bs-dismiss="modal" value="إلغاء" style="float:left;background:#F60F37;color:#fff;margin:0 10px;">
                            <input type="button" class="btn" id="saveReqFile" value="إضافة" style="float:left;background: #004A61; color:white">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end-modal-->
            
            <div class="tab-pane fade" id="kt_project_life_cycle_tab" role="tabpanel">
                <div class="col-lg-12">
                    <!--begin::Timeline widget 3-->
                    <div class="card h-md-100 tab-pane">
                        <!--begin::Header-->
                        <div class="card-header pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-dark">دورة حياة المشروع</span>
                            </h3>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body px-0 pt-7">
                            <!--begin::Tab Content (ishlamayabdi)-->
                            <div class="tab-content mb-2 px-9">
                                <div class="scroll h-300px tab-pane fade show active px-5" id="kt_timeline_widget_3_tab_content_4">
                                    <div class="fw-bold fs-6 mb-2 text-gray-800">الخطوة الحالية</div>
                                    @foreach ($transactions_history->where('is_done', '0') as $value)
                                        <div class="fw-semibold fs-6 text-gray-700">{{ $value->status->previous }} <span class="fw-semibold fs-7 text-gray-400">{{ $value->created_at->diffForHumans() }}</span>
                                        </div>
                                        <a href="{{ url('chats/' . $value->user_id . '?Ref=' . $value->user->name) }}" id="loadUserChat" class="text-primary opacity-75-hover fw-semibold" dir="rtl" data-user-id="{{ $value->user_id }}">لدى -
                                            {{ $value->user->name }}</a>
                                    @endforeach
                                    <div class="separator mt-4"></div>
                                    <!--begin::Wrapper-->
                                    @forelse($transactions_history->where('is_done', '1') as $value)
                                        <div class="d-flex align-items-center mb-6" style="margin-top:25px;">
                                            <!--begin::Bullet-->
                                            <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 bg-{{ $value->status->class }} me-4"></span>
                                            <!--end::Bullet-->
                                            <!--begin::Info-->
                                            <div class="flex-grow-1 me-5">
                                                <div class="fw-semibold fs-2 text-gray-800">
                                                    {{ $value->created_at->format('d/m/Y') }} في الساعة
                                                    {{ $value->created_at->format('h:i A') }}
                                                    <span class="fw-semibold fs-7 text-gray-400">
                                                        {{ $value->created_at->diffForHumans() }}
                                                    </span>
                                                </div>
                                                <div class="fw-semibold fs-6 text-gray-700">
                                                    {{ $value->status->title }}
                                                    {{ __('site.by') }}
                                                    <a href="{{ url('chats/' . $value->user_id . '?Ref=' . $value->user->name) }}" id="loadUserChat" class="text-primary opacity-75-hover fw-semibold" dir="rtl" data-user-id="{{ $value->user_id }}">{{ $value->user->name }}</a>
                                                </div>
                                                <div class="text-gray-400 fw-semibold fs-12">الأيام اللتي استغرقت لتنفيذ الخطوة {{ $value->created_at->diffInDays($value->updated_at) }} أيام</div>
                                            </div>
                                        </div>
                                    @empty
                                        {{ __('site.empty_transactions_history') }}
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        <!--end: Card Body-->
                    </div>
                    <!--end::Timeline widget 3-->
                </div>
            </div>

            {{-- /////////// --}}
            <div class="tab-pane fade" id="kt_project_discussions" role="tabpanel">
                <div class="col-lg-12">
                    <!--begin::Timeline widget 3-->
                    <div class="card h-md-100 tab-pane">
                        <!--begin::Header-->
                        <div class="card-header pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-dark">المناقشات </span>
                            </h3>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body px-0 pt-7">
                            <!--begin::Tab Content (ishlamayabdi)-->
                            <div class="tab-content">
                                @include('backoffice.followup.chat-discussions', ['project_id' => $row->id])
                            </div>
                        </div>
                        <!--end: Card Body-->
                    </div>
                    <!--end::Timeline widget 3-->
                </div>
            </div>

            {{-- ///////////////// --}}
            <div class="tab-pane fade" id="kt_project_team_member_tab" role="tabpanel">
                <div class="col-lg-12">
                    <!--begin::Toolbar-->
                    <div class="d-flex flex-stack flex-wrap pb-7">
                        <!--begin::Title-->
                        <div class="d-flex align-items-center my-1 flex-wrap">
                            <h3 class="fw-bold my-1 me-5">فريق العمل الرئيسي</h3>
                        </div>
                        <!--end::Title-->
                        <!--begin::Controls-->
                        <div class="d-flex my-1 flex-wrap">
                            <!--begin::Tab nav-->
                            <ul class="nav nav-pills mb-sm-0 mb-2 me-6">
                                <li class="nav-item m-0">
                                    <a class="btn btn-sm btn-icon btn-light btn-color-muted btn-active-primary active me-3" data-bs-toggle="tab" href="#kt_project_users_card_pane">
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
                                    </a>
                                </li>
                                <li class="nav-item m-0">
                                    <a class="btn btn-sm btn-icon btn-light btn-color-muted btn-active-primary" data-bs-toggle="tab" href="#kt_project_users_table_pane">
                                        <!--begin::Svg Icon | path: icons/duotune/abstract/abs015.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z" fill="currentColor" />
                                                <path opacity="0.3" d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z" fill="currentColor" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </a>
                                </li>
                            </ul>
                            <!--end::Tab nav-->
                        </div>
                        <!--end::Controls-->
                    </div>
                    <!--end::Toolbar-->
                    <!--begin::Tab Content-->
                    <div class="tab-content">
                        <!--begin::Tab pane-->
                        <div id="kt_project_users_card_pane" class="tab-pane fade show active">
                            <!--begin::Row-->
                            <div class="row g-6 g-xl-9">
                                @forelse($project_fieldwork_teams as $project_fieldwork_team)
                                    <!--begin::Col-->
                                    <div class="col-md-6 col-xxl-4">
                                        <!--begin::Card-->
                                        <a href="{{ url('operation/followup/field-team-details/' . $row->id . '/' . $project_fieldwork_team->user_id) }}" class="card border-hover-primary">
                                            <div class="card">
                                                <!--begin::Card body-->
                                                <div class="card-body d-flex flex-center flex-column p-9 pt-12">
                                                    <!--begin::Avatar-->
                                                    <div class="symbol symbol-65px symbol-circle mb-5">
                                                        <span class="symbol-label fs-2x fw-semibold text-primary bg-light-primary">{{ substr($project_fieldwork_team->user[0]->username, 0, 1) }}</span>
                                                        <div class="bg-success position-absolute border-body h-15px w-15px rounded-circle translate-middle start-100 top-100 ms-n3 mt-n3 border border-4">
                                                        </div>
                                                    </div>
                                                    <!--end::Avatar-->
                                                    <!--begin::Name-->
                                                    <a href="{{ url('chats/' . $project_fieldwork_team->user[0]->id . '?Ref=' . $project_fieldwork_team->user[0]->name) }}" class="fs-4 text-hover-primary fw-bold mb-0 text-gray-800">{{ $project_fieldwork_team->user[0]->name }}</a>
                                                    <!--end::Name-->
                                                    <!--begin::Position-->
                                                    <div class="fw-semibold mb-6 text-gray-400">
                                                        {{ $project_fieldwork_team->user[0]->email }}
                                                    </div>
                                                    <!--end::Position-->
                                                    <!--begin::Info-->
                                                    <div class="d-flex flex-center flex-wrap">
                                                        <!--begin::Stats-->
                                                        <div class="min-w-80px mx-2 mb-3 rounded border border-dashed border-gray-300 px-4 py-3">
                                                            <div class="fs-6 fw-bold text-gray-700">
                                                                {{ $project_fieldwork_team->type[0]->trans }}
                                                            </div>
                                                            <div class="fw-semibold text-gray-400">الدور العملي</div>
                                                        </div>
                                                        <!--end::Stats-->
                                                        @if ($project_fieldwork_team->supervisor_qty)
                                                            <!--begin::Stats-->
                                                            <div class="min-w-80px mx-2 mb-3 rounded border border-dashed border-gray-300 px-4 py-3">
                                                                <div class="fs-6 fw-bold text-gray-700">
                                                                    {{ $project_fieldwork_team->supervisor_qty }}
                                                                </div>
                                                                <div class="fw-semibold text-gray-400">عدد المشرفين</div>
                                                            </div>
                                                            <!--end::Stats-->
                                                            <!--begin::Stats-->
                                                            <div class="min-w-80px mx-2 mb-3 rounded border border-dashed border-gray-300 px-4 py-3">
                                                                <div class="fs-6 fw-bold text-gray-700">
                                                                    {{ $project_fieldwork_team->researcher_qty }}
                                                                </div>
                                                                <div class="fw-semibold text-gray-400">عدد الباحثين</div>
                                                            </div>
                                                        @else
                                                            <!--end::Stats-->
                                                            <!--begin::Stats-->
                                                            <div class="min-w-80px mx-2 mb-3 rounded border border-dashed border-gray-300 px-4 py-3">
                                                                <div class="fs-6 fw-bold text-gray-700">
                                                                    {{ $project_fieldwork_team->auditor_qty }}
                                                                </div>
                                                                <div class="fw-semibold text-gray-400">عدد المدققين</div>
                                                            </div>
                                                            <!--end::Stats-->
                                                        @endif
                                                    </div>
                                                    <!--end::Info-->
                                                </div>
                                                <!--end::Card body-->
                                            </div>
                                        </a>
                                        <!--end::Card-->
                                    </div>
                                    <!--end::Col-->
                                @empty
                                    {{ __('site.empty_transactions_history') }}
                                @endforelse
                            </div>
                            <!--end::Row-->
                            <!--begin::Pagination-->
                            <div class="d-flex flex-stack flex-wrap pt-10">
                                {!! $project_fieldwork_teams->links() !!}
                            </div>
                            <!--end::Pagination-->
                        </div>
                        <!--end::Tab pane-->
                    </div>
                    <!--end::Tab Content-->
                </div>
            </div>
            @if (auth()->user()->roles->first()->id == '1')
            @include('backoffice.followup.redflags.listings.admin') 
            @elseif (auth()->user()->roles->first()->id == '2')
                @include('backoffice.followup.redflags.listings.project_manager')
                @include('backoffice.followup.redflags.modals.project_manager_reply_admin')

            @else
                @include('backoffice.followup.redflags.listings.client')
            @endif
        </div>
 

        <!--begin::Modal - Team Rank-->
        <div class="modal fade" id="kt_modal_team_rank" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered mw-1000px">
                <div class="modal-content">
                    <div class="modal-header justify-content-end border-0 pb-0">
                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                            <span class="svg-icon svg-icon-1">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                    <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                                </svg>
                            </span>
                        </div>
                    </div>
                    <div class="modal-body scroll-y pb-15 pt-0">
                        <input type="hidden" name="project_id" id="project_id" value="{{ $row->id }}" />
                        <div class="mb-13 text-center">
                            <h1 class="mb-3">بنود العقد</h1>
                            <div class="text-muted fw-semibold fs-5">من هنا يمكنك إضافة بنود العقد لرتبة <span id="rank"></span></div>
                        </div>
                        <div id="contract_term_repeater">
                            <div class="form-group">
                                <div data-repeater-list="contract_term_repeater">
                                    <div id="teamItemList">
                                        @include('partials.backoffice.project.team-item-list')
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="reset" data-bs-dismiss="modal" class="btn btn-secondary me-3">إلغاء</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
 
        {{-- Red Flags Modals Includes --}}

        {{-- @include('backoffice.followup.PM-redflag-ReplyModal') --}}


        @include('backoffice.followup.redflags.modals.project_manager_reply_client')


        @include('backoffice.followup.redflags.modals.client_reply_project_manager')


        @if (auth()->user()->roles->first()->id == '1')
            @include('backoffice.followup.redflags.listings.admin')
            @include('backoffice.followup.redflags.modals.admin_reply_pm')
        @endif
 
        @include('partials.obstacle._obstacle')
        <!--begin::Modal - contact information-->
        @include('partials.backoffice.contact-information-modal')
        <!--end::Modals - contact information-->
    </div>
    <!--end::Container-->
@stop
@section('scripts')

    <script src="{{ asset('assets/js/custom/loading-page.js') }}"></script>
    <script src="{{ asset('assets/js/custom/backoffice/project.js') }}"></script>
    <script> const redflag_reply_route = '{{ route('reply.Redflag') }}'; </script>
    @if (auth()->user()->roles->first()->id == '1')
    <script> const admin_redflag_reply_pm_route = '{{ route('admin.reply.Redflag') }}'; </script>
    <script src="{{ asset('assets/js/custom/backoffice/redflags/admin-reply-pm.js') }}"></script>
    @elseif (auth()->user()->roles->first()->id == '2')
    <script> const pm_redflag_reply_admin_route = '{{ route('pm.reply.admin.Redflag') }}'; </script>
    <script src="{{ asset('assets/js/custom/backoffice/redflags/pm-reply-client.js') }}"></script>
    <script src="{{ asset('assets/js/custom/backoffice/redflags/pm-reply-admin.js') }}"></script> 
    @endif

    <script>
         $("a.outcome_ID").on("click",function(){
            $("input#outID").val($(this).data("outcome-id"));
         });

         $("input#saveNewFile").on("click",function(){
            $.ajax({
                url: "{{route('edit.outcomeFile')}}",
                type: "POST",
                data: new FormData(document.querySelector('form#outcomeFile')),
                beforeSend: function() {
                    console.log("Please Wait ...");
                },
                processData: false,
                contentType: false,
                cache: false,
                success: function(data, status) {
                    if(data.code == 400){
                    Swal.fire({
                            text: data.MSG, 
                            icon: 'error',
                            confirmButtonText: "موافق",
                        });
                    }else {
                        window.location.reload();
                    }
                },
                error: function(xhr, desc, err) {}
            });
         });

        $(".handleOutCome").click(function() {
            document.getElementById('outcome_id').value = $(this).attr('data-outcome-id');
        });

        $("input#saveRedflagReply").on("click", function() {
            $("div.input span").html("");
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            });
            $.ajax({
                type: "post",
                enctype: "multipart/form-data",
                url: '{{ route('reply.Redflag') }}',
                data: new FormData($("#addRedflagReply")[0]),
                processData: false,
                contentType: false,
                cache: false,
                success: function(response, textStatus, xhr) {
                    if (response["status"] == true) {
                        Swal.fire({
                            text: 'تم إرسال الرد علي البلاغ بنجاح', // respose from controller
                            icon: 'success',
                            buttonsStyling: false,
                            confirmButtonText: "موافق",
                            customClass: {
                                confirmButton: "btn btn-success",
                            }
                        }).then(function(result) {
                            window.location = window.location.href;
                        });
                    }

                },
            });

        });

        $("span.del_out").on("click",function(){
            let D = $(this).data("outcome");
            $.post("{{route('DEL.REJOUT')}}",{"ID":$(this).data("outcome"),"P":"{{$row->id}}","_token":"{{csrf_token()}}","_method":"DELETE"},function(){
              $("tr[data-row='R-"+D+"']").fadeOut();
            });
        });

        $("span.edit_out").on("click",function(){
           $("#_outComeID").val($(this).data("outcome"));
           $("#_outComeDesc").val($(this).data("d"));
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var _submitForm = (self,id) => {
            self.parent().find('span').html("<small>إنتظر.</small>");
            setTimeout(() => {
                $.ajax({
                url: self.parent().data("action"),
                type: "POST",
                data: new FormData(document.getElementById(id).form),
                beforeSend: function() {
                    console.log("Please Wait ...");
                },
                processData: false,
                contentType: false,
                cache: false,
                success: function(data, status) {
                    console.log(data.MSG);
                },
                error: function(xhr, desc, err) {}
            });
                self.parent().find('span')
                    .html("<small style='color:lightgreen;'>تم التعديل</small>");
            }, 2000);
        }
      
    
        $("input#saveOut").on("click",function(){
        var form = document.querySelector("form#addOut");
        $.ajax({
                url: "{{route('outcome.CADD')}}",
                type: "POST",
                data: new FormData(form),
                beforeSend: function() {
                    console.log("Please Wait ...");
                },
                processData: false,
                contentType: false,
                cache: false,
                success: function(data, status) {
                  if(data.code == 200) {
                    window.location.reload();
                  }else {
                    $("span#errOut").html(data.MSG);
                  }
                },
                error: function(xhr, desc, err) {}
            });
     });


        var _getRemarks = (R) => {
            Swal.fire({
                title: '<span style="color:#f00;">سبب رفض نموذج المخرج</span>' ,
                icon: 'info',
                html: '<p>'+R+'</p>',
                showCloseButton: true,  
                showCancelButton: false,
                showConfirmButton: true,
                confirmButtonText: "حسنا",
                confirmButtonColor: '#50cd89'
            });
        }

        $("#projectEditDetails").on("click", function() {
            $("form#projectDetails td.show").addClass("hide");
            $("form#projectDetails td.toggle").removeClass("hide");
            $("form#projectDetails input:disabled").removeAttr("disabled");
            $("button#projectDetailEdit,button#projectDetailCancel").removeClass("hide");
        });

        $("button#projectDetailEdit").on("click", function() {
            let url = $("form#projectDetails").data("action");
            $.post(url, $("form#projectDetails").serialize(), function(data) {
                window.location.reload(true);
            });
        });

        /*---------project form-------------*/
        $("#projectEditForm").on("click", function() {
            $("form#projectForm input").removeAttr("readonly");
            $("button#projectFormEdit,button#projectFormCancel").removeClass("hide");
        });

        $("button#projectFormEdit").on("click", function() {
            let url = $("form#projectForm").data("action");
            $.post(url, $("form#projectForm").serialize(), function(data) {
                window.location.reload(true);
            });
        });

        /*---------project equipment-------------*/
        $("#projectEditEqPublic").on("click", function() {
            $("table#eqPublic td.show").addClass("hide");
            $("table#eqPublic td.toggle").removeClass("hide");
            $("button#projectEqPublicEdit,button#projectEqPublicCancel").removeClass("hide");
        });

        $("#projectEditEqTrain").on("click", function() {
            $("table#eqTrain td.show").addClass("hide");
            $("table#eqTrain td.toggle").removeClass("hide");
            $("button#projectEqTrainEdit,button#projectEqTrainCancel").removeClass("hide");
        });

        $("#projectEditEqOpen").on("click", function() {
            $("table#eqOpen td.show").addClass("hide");
            $("table#eqOpen td.toggle").removeClass("hide");
            $("button#projectEqOpenEdit,button#projectEqOpenCancel").removeClass("hide");
        });

        $("#projectEditEqAudit").on("click", function() {
            $("table#eqAudit td.show").addClass("hide");
            $("table#eqAudit td.toggle").removeClass("hide");
            $("button#projectEqAuditEdit,button#projectEqAuditCancel").removeClass("hide");
        });

        $("button.saveEq").on("click", function() {
            let url = $(this).parent().data("action");
            $.post(url, $(this).parent().serialize(), function(data) {
                window.location.reload(true);
            });
        });

        /*----------project finance----------*/
        $("#projectEditfinance").on("click", function() {
            $("table#pFinance td.show").addClass("hide");
            $("table#pFinance td.toggle").removeClass("hide");
            $("button#projectFinanceEdit,button#projectFinanceCancel").removeClass("hide");
        });

        $("button#projectFinanceEdit").on("click", function() {
            let url = $(this).parent().data("action");
            $.post(url, $(this).parent().serialize(), function(data) {
                window.location.reload(true);
            });
        });
        // missing function added
        function disable_option(equipment_id, equipment_type, typecase) {
            var target_equipment_qty = typecase + '-equipment-qty-' + equipment_type + '-' + equipment_id;
            var target_equipment_price = typecase + '-equipment-price-' + equipment_type + '-' + equipment_id;
            if ($("#" + equipment_id).prop("checked")) {
                document.getElementById(target_equipment_qty).disabled = false;
                document.getElementById(target_equipment_price).disabled = false;
            } else {
                document.getElementById(target_equipment_qty).disabled = true;
                document.getElementById(target_equipment_price).disabled = true;
            }
        }

        $("button.addRF").on("click", function() {
            $("input#reqID").val($(this).data("req"));
            $("#remarks").val("");
        });

     /* new Dropzone("#add_req_file", {
            url: "{{ route('req.file') }}",
            method: "post",
            paramName: "file",
            maxFiles: 5,
            maxFilesize: 10, // MB
            addRemoveLinks: true,
            acceptedFiles: "application/pdf,image/*",
            autoProcessQueue: false,

            init: function() {
                var myDropzone = this;
                $("input#saveReqFile").click(function(e) {
                    e.preventDefault();
                    myDropzone.processQueue();
                });
                this.on("sending", function(file, xhr, formData) {
                    formData.append("req_id", $("input#reqID").val());
                    formData.append("notes", $("#remarks").val());
                    formData.append("project_id", {{ $row->id }});
                    formData.append("_token", '{{ csrf_token() }}');
                    formData.append("_method", "PATCH");
                });
            },
            accept: function(file, done) {
                if (file.name == "wow.jpg") {
                    done("Naha, you don't.");
                } else {
                    done();
                }
            },
            success: function(file) {
                window.location.reload();
            }
        });
        */
        $("input#saveReqFile").on("click",function() {
          $.post("{{ route('req.file') }}",$("form#formSaveReq").serialize(),function(data){
            window.location.reload();
          });
        });
    </script>
    <script src="{{ asset('assets/js/custom/account/referrals/referral-program.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/vis-timeline/vis-timeline.bundle.js') }}"></script>

    {{-- Messenger Js Files --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/chatify/font.awesome.min.js') }}"></script>
    <script src="{{ asset('js/chatify/autosize.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src='https://unpkg.com/nprogress@0.2.0/nprogress.js'></script>

    {{-- ////////// --}}
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <script src="https://js.pusher.com/7.0.3/pusher.min.js"></script>
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;
        var pusher = new Pusher("{{ config('chatify.pusher.key') }}", {
            encrypted: true,
            cluster: "{{ config('chatify.pusher.options.cluster') }}",
            authEndpoint: '{{ route('pusher.auth') }}',
            auth: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }
        });

        // Bellow are all the methods/variables that using php to assign globally.
        const allowedImages = {!! json_encode(config('chatify.attachments.allowed_images')) !!} || [];
        const allowedFiles = {!! json_encode(config('chatify.attachments.allowed_files')) !!} || [];
        const getAllowedExtensions = [...allowedImages, ...allowedFiles];
        const getMaxUploadSize = {{ Chatify::getMaxUploadSize() }};
        const projectId = '{{ $row->id }}';
        const roleID = '{{ auth()->user()->roles->first()->id }}';
        const ChatURL = "{{ url('/' . Auth::user()->roles[0]->name . '/followup/' . $row->id) }}";
        // Client Id from users Table

        const CUId = '{{ $row->customer->user_id }}';
    </script>
    {{-- /////// SET CHAT DEFAULT OPEN WINDOW/////// --}}
    <script src="{{ asset('js/chatify/code-discussion.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
                localStorage.setItem('activeTab', $(e.target).attr('href'));
            });
            var activeTabX = localStorage.getItem('activeTab');
            if (activeTabX) {
                $('#myTabProjects a[href="' + activeTabX + '"]').tab('show');
            }
        });
    </script>
@stop
