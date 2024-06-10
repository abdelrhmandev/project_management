@extends('layouts.app')

@section('style')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/custom/vis-timeline/vis-timeline.bundle.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('style')
    <meta name="id" content="{{ $id }}">
    <meta name="type" content="{{ $type }}">
    <meta name="messenger-color" content="{{ $messengerColor }}">
    <meta name="url" content="{{ url('') . '/' . config('chatify.routes.prefix') }}" data-user="{{ Auth::user()->id }}">
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/custom/vis-timeline/vis-timeline.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link rel='stylesheet' href='https://unpkg.com/nprogress@0.2.0/nprogress.css' />
    <link href="{{ asset('css/chatify/style-discussion.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/chatify/' . $dark_mode . '.mode.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />

    <style type="text/css">
        .isDisabled {
            color: currentColor;
            cursor: not-allowed;
            opacity: 0.5;
            text-decoration: none;
        }

        #map_canvas {
            height: 100%;
        }

        .hide {
            display: none !important;
        }

        div#workMembers {
            display: flex;
            flex-wrap: wrap;
            box-sizing: border-box;
            padding: 0 0 0 3.4375rem;
        }

        div#workMembers .memb {
            flex: 0 0 47%;
            box-sizing: border-box;
            margin-left: 20px;
            border-radius: 20px;
        }

        div#workMembers div#pager {
            flex: 0 0 100%;
            margin-block: 0px 10px;
            color:black;
        }

        table.wmemb tr td span {
            color: black;
            font-size: 11px;
            display: block;
            margin-bottom: 4px;
        }

        table.wmemb tr td p {
            color: black;
            font-size: 14px;
        }

        table.wmemb tr td img {
            vertical-align: middle;
        }

        table.wmemb tr td.img {
            text-align: center;
        }

        .pagination li.active span {
            background-color: #47be7d !important;
        }

        label.editReq,
        label.delReq,
        label.viewReq {
            cursor: pointer;
            display: inline-block;
            margin-inline: 0 20px;
        }

        label.editReq i,
        label.delReq i,
        label.viewReq i {
            font-size: 1.5rem;
        }

        label.editReq i:hover {
            color: #00f;
        }

        label.delReq i:hover {
            color: #f00;
        }

        label.viewReq i:hover {
            color: #0f0;
        }

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

        td.tdReqInp {
            display: none;
        }

        div.input {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 16px;
        }

        div.input input {
            flex: 0 0 87%;
        }

        div.input button {
            flex: 0 0 10%;
            margin-right: 20px;
        }

        div.input span {
            flex: 0 0 100%;
            margin-bottom: 8px;
            color: #f1416c;
        }
        div.inputOut:not(:first-child){
            border-top:1px dashed #ccc;
            padding-top:16px;
            margin-top:16px;
        }
        button#delOutcome{
            display:none;
        }
        span.cycleIco {
            padding:0.625em;
            border-radius:50%;
        }
        div.linked:not(:last-child) {
            height:50px;
            width:50px;
            border-right:2px dotted #ccc;
            margin-right:20px;
        }
         button.delOutcome{
            /* border-top:1px dashed #ccc; */
            /* padding-top:16px; */
            margin-top: -81px;
           float: left;
        }  
        table#tblTOut td span {
           color:#fff !important;
           display:inline-block;
           padding:10px;
        }
        input.outCheck {
            position:absolute;
            left:0;
            top:0;
            visibility:hidden;
            opacity:0;
        }
        button#templateBtn,button#saveAll {
          display:none;
        }
        table.outTbl tr td {
          vertical-align:middle;
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
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <!--begin::User-->
                        <div class="d-flex flex-column">
                            <!--begin::Name-->
                            <div class="d-flex align-items-center mb-2">
                                <a href="#" class="text-hover-primary fs-2 fw-bold me-1 text-gray-900" style="display:inline-block;">
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
                            <div class="d-flex {{ $row->status_id == 11 ? '' : ($row->status_id == 13 ? '' : 'invisible') }}">
                                <form class="form" id="FormId" data-route-url="{{ url('operation/end-field') }}" enctype="multipart/form-data" novalidate="novalidate" method="POST">
                                    @csrf
                                    <input type="hidden" name="project_id" id="project_id" value="{{ $row->id }}" />
                                    <input type="hidden" id="redirectUrl" data-redirect-url="{{ url('operation/followup/' . $row->id) }}" />
                                    <input type="hidden" name="project_title" id="project_title" value="{{ $row->title }}" />
                                    <button type="button" class="btn btn-sm btn-primary me-2" id="kt_page_loading_overlay">إنهاء العمل الميداني</button>
                                </form>
                            </div>
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

                            <form class="form" action="{{ 'https://www.kashif-sa.com/tanmia/public/management/login' }}" enctype="multipart/form-data" novalidate="novalidate" method="POST">
                                @csrf
                                <input type="hidden" name="email" id="email" value="info@alsoda.sa" />
                                <input type="hidden" name="password" id="password" value="Ald11?11dlA" />
                                <button type="button" class="btn btn-sm btn-primary me-2" id="kt_page_loading_overlay">برنامج كاشف</button>
                            </form>

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

            <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x fs-5 fw-bold mt-4 border-transparent" id="myTabClients">
                <li class="nav-item">
                    <a class="nav-link text-active-primary active pb-4" data-toggle="tab" href="#kt_project_overview_tab">تفاصيل المشروع</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-toggle="tab" href="#kt_project_outcome_tab">المخرجات <span class="badge badge-warning badge-circle badge-md" style="margin-right:5px"> {{ $outcomes->count()}}</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-toggle="tab" href="#kt_project_requirements_tab">الطلبات<span class="badge badge-warning badge-circle badge-md" style="margin-right:5px"> {{ $requirements->count()}}</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-toggle="tab" href="#kt_project_redflags_tab">البلاغات <span class="badge badge-warning badge-circle badge-md" style="margin-right:5px"> {{ $RedFlagsCount }}</span></a>
                </li>
                @if($row->status_id >= 8)
                <li class="nav-item">
                    <a class="nav-link text-active-primary pb-4" data-toggle="tab" href="#kt_project_members_tab">فريق العمل</a>
                </li>
                @endif
                <!--<li class="nav-item">
                    <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-toggle="tab" href="#kt_project_discussions">مناقشات المشروع</a>
                </li>-->
                <li class="nav-item">
                    <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-toggle="tab" href="#kt_project_attachment_tab">مرفقات المشروع </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-toggle="tab" href="#kt_project_life_cycle_tab">دورة حياة المشروع</a>
                </li>
            </ul>
        </div>
    </div>
    <!--end::Navbar-->
    <div class="tab-content">
        <div class="tab-pane fade show active" id="kt_project_overview_tab" role="tabpanel">
            <!--begin::Card-->
            <input type="hidden" name="projectID" value="{{ $row->id }}">
            @csrf
            <div class="card mb-xl-10 tab-pane mb-5">
                <!--begin::Card header-->
                <div class="card-header pt-5">
                    <div class="card-title align-items-start flex-column">
                        <h3 class="card-label fw-bold fs-3 mb-1">
                            تفاصيل المشروع
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
                                            <td class="show text-gray-800">{{ $training->training_headquarter }}</td>
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
                                            <td class="text-muted min-w-125px w-250px">عدد المباني/المرافق التقديري في
                                                الحصر</td>
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
        </div>

        <div class="tab-pane fade" id="kt_project_members_tab" role="tabpanel">
            @if (count($teamMembers) != 0)
                <a href="{{ route('Client.Excel', ['projectID' => $row->id]) }}" class="btn btn-success">تصدير فريق عمل العميل الى اكسل</a>
                <form style="display:inline !important;">
                    @csrf
                    <input type="hidden" name="project" value="{{ $row->id }}">
                    <select class="form-select" id="teamType" name="teamtype" style="display:inline !important;width:15%;margin-right:20px;">
                        <option value="-1">كل الادوار</option>
                        <option value="4">مشرف</option>
                        <option value="5">باحث</option>
                    </select>
                </form>
                <br><br>
            @endif
            <div class="col-xl-12 gap-7" id="workMembers">
                @foreach ($teamMembers as $v)
                    <div class="card card-xl-stretch tab-pane memb">
                        <div class="card-header cursor-pointer pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold fs-3 mb-1">
                                    {{ $v->name }}
                                </span>
                            </h3>
                        </div>
                        <div class="card-body py-3">
                            <div class="table-responsive">
                                <table class="gs-0 gy-3 fw-bold wmemb table align-middle">
                                    <tr>
                                        <td class="img">
                                            <img src="{{ asset('assets/media/team/vuesax-linear-profile.png') }}" alt="">
                                        </td>
                                        <td>
                                            <span>الدور</span>
                                            <p class="black">{{ \App\Models\TeamRankType::find($v->type)->trans }}</p>
                                        </td>
                                        <td class="img">
                                            <img src="{{ asset('assets/media/team/vuesax-linear-user-square.png') }}" alt="">
                                        </td>
                                        <td>
                                            <span>رقم الهوية</span>
                                            <p>{{ $v->national_id }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="img">
                                            <img src="{{ asset('assets/media/team/vuesax-linear-teacher.png') }}" alt="">
                                        </td>
                                        <td>
                                            <span>المؤهل الدراسى</span>
                                            <p>{{ @\App\Models\Qualification::find($v->qualification_id)->title }}</p>
                                        </td>
                                        <td class="img">
                                            <img src="{{ asset('assets/media/team/vuesax-linear-briefcase.png') }}" alt="">
                                        </td>
                                        <td>
                                            <span>المهنة</span>
                                            <p>{{ $v->occupation }}</p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div id="pager">
                    {{ $teamMembers->links() }}
                </div>
            </div>
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
                <!--begin::Col-->
                @php $i=1; @endphp
                @foreach ($files as $f)
                    <div class="col-md-6 col-lg-4 col-xl-3" data-client="{{ $f->id }}">
                        <div class="card h-100" style="position:relative;">
                            <a href="javascript:void(0);" title="حذف" class="dcf btn btn-icon btn-circle btn-active-color-primary" style="position:absolute;z-index:5;right:40px;top:1px;" data-p="{{ $row->id }}" data-f="{{ $f->id }}">
                                <i class="bi bi-trash-fill fs-7"></i>
                            </a>
                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="تعديل" style="display:inline-block !important;margin:10px 20px 0 0;" aria-label="كراسة نطاق عمل المشروع" data-bs-original-title="كراسة نطاق عمل المشروع" data-kt-initialized="1">
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

                            <div class="card-body d-flex justify-content-center flex-column p-8 text-center">
                                <a href="{{ asset('storage' . $f->file) }}" class="text-hover-primary d-flex flex-column text-gray-800">
                                    <div class="symbol symbol-60px mb-5">
                                        <img src="{{ asset('assets/media/svg/files/' . \File::extension(asset('storage' . $f->file)) . '.svg') }}" class="theme-light-show" alt="" />
                                        <img src="{{ asset('assets/media/svg/files/' . \File::extension(asset('storage' . $f->file)) . '-dark.svg') }}" class="theme-dark-show" alt="" />
                                    </div>
                                    <div class="fs-5 fw-bold mb-2">ملف العميل {{ $i }}</div>
                                </a>
                                <div class="fs-7 fw-semibold text-gray-400">تم الرفع:
                                    {{ $f->created_at->diffForHumans() }}
                                    بواسطة : {{ @\App\Models\User::find($f->user_add)->name }}
                                </div>
                                @if (!is_null($f->updated_at) && isset($f->updated_at))
                                    <div class="fs-7 fw-semibold text-gray-400">تم التحديث:
                                        {{ $f->updated_at->diffForHumans() }}
                                        بواسطة : {{ @\App\Models\User::find($f->user_edit)->name }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @php $i++; @endphp
                @endforeach

                <!--begin::Dropzone-->
                <div id="explore_training_file" class="col-md-6 col-lg-4 col-xl-3 dropzone">
                    <!--begin::Message-->
                    <div class="dz-message needsclick">
                        <!--begin::Icon-->
                        <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                        <!--end::Icon-->
                        <!--begin::Info-->
                        <div class="ms-4">
                            <h3 class="fs-5 fw-bold mb-1 text-gray-900">الرجاء رفع ملفات العميل هنا</h3>
                        </div>
                        <!--end::Info-->
                    </div>
                </div>
                <!--end:dropzone-->
            </div>
        </div>

        <div class="tab-pane fade" id="kt_project_requirements_tab" role="tabpanel">
            <div class="col-lg-12">
                <div class="card h-md-100 tab-pane">
                    <div class="card-header py-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-dark">الطلبات {{ $requirements->count() }}</span>
                        </h3>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#modalWrap" id="addReqBtn" class="btn btn-sm me-2 btn-primary"><i class="bi bi-plus-square"></i>إنشاء طلب جديد</i></button>
                    </div>
                    <div class="card-body px-0 pt-7">
                            <table id="tblReq kt_datatable_both_scrolls" class="table table-striped table-row-bordered gy-5 gs-7">
                            <thead>
                                <tr class="fw-bold fs-7 text-white border-bottom border-gray-200 py-4 bg-danger">
                                    <th>&nbsp;</th>
                                    <th>تفاصيل الطلب</th> 
                                    <th>تاريخ الطلب</th>
                                    <th>حالة الطلب</th>
                                    <th>الرد على الطلب</th>
                                    <th>&nbsp;</th>
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
                                    <tr data-req="{{ $v->id }}" class="py-5 fw-semibold  border-bottom border-gray-300">
                                        <td class="index">
                                            <div style="border-right:4px solid #{{ $c }};">&nbsp;</div>
                                        </td>
                                        <td id="tdReq_{{ $v->id }}">{{ $v->title }}</td>
                                        <td class="tdReqInp" id="tdReqInp_{{ $v->id }}">
                                            <input type="text" class="ReqInp form-control" data-rid="{{ $v->id }}" data-pid="{{ $row->id }}" value="{{ $v->title }}">
                                        </td>
                                        <td>{{ $v->date }}</td>
                                        @if (!is_null($v->notes) && isset($v->notes))
                                            <td>تم الرد على طلبكم</td>
                                        @else 
                                            <td>سيتم معالجة طلبكم قريباً</td>
                                        @endif
                                        
                                        <td>{{ $v->notes }}</td>
                                        <td>
                                            <label class="editReq" title="تعديل" data-r="{{ $v->id }}" data-p="{{ $row->id }}"><i class="bi bi-pencil-fill"></i></label>
                                            <label class="delReq" title="حذف" data-r="{{ $v->id }}" data-p="{{ $row->id }}"><i class="bi bi-trash-fill"></i></label>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="kt_project_outcome_tab" role="tabpanel">
            <div class="col-lg-12">
                <div class="card h-md-100 tab-pane">
                    <div class="card-header py-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-dark">المخرجات {{ $outcomes->count()}}</span>
                        </h3>
                    </div>
                    <div class="card-body px-0 pt-7">
                        <div class="row">
                            <!--begin::Col-->
                            <div class="col-md-8 mr-4">
                                <div class="card-header border-0" id="map_canvas" style="width: 800px; height: 300px;"></div>
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-4">
                                <div class="card-body d-flex justify-content-center flex-column p-8 text-center">
                                    <a href="{{ @asset('storage/' . $row->ExecutivePlanning->executive_planning_file) }}" title="مشروع الخطه التنفيذيه" class="text-hover-primary d-flex flex-column text-gray-800">
                                        <div class="symbol symbol-60px mb-5">
                                            <img src="{{ asset('assets/media/svg/files/docx.svg') }}" class="theme-light-show" alt="" />
                                        </div>
                                    </a>
                                    <h1>مشروع الخطه التنفيذيه</h1>
                                    
                                    {{-- enable --}}
                                    @if (@$row->ExecutivePlanning->is_approved == 0 && @$row->ExecutivePlanning->is_updated == 1)
                                        <p class="pt-5"><a href="javascript:void(0)" onclick="return ApproveProject()" class="btn btn-sm me-2 btn-success">
                                                <i class="bi bi-hand-thumbs-up"></i>
                                                معتمد</a>
                                                <a href="#" class="fs-5 fw-bold text-gray-900 mb-2" data-bs-toggle="modal" data-bs-target="#kt_modal_client_not_approve">
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#kt_modal_client_not_approve" class="btn btn-sm me-2 btn-danger">
                                                <i class="bi bi-hand-thumbs-down"></i>
                                                غير معتمد</a>
                                        </p>
                                    @else
                                    {{-- disable --}}
                                        <p class="pt-5"><a href="javascript:void(0)" onclick="return ApproveProject()" class="isDisabled btn-sm me-2 btn btn-light-success">
                                                <i class="bi bi-hand-thumbs-up"></i>
                                                معتمد</a>
                                            <a href="javascript:void(0)" data-bs-toggle="modal" class="isDisabled btn btn-sm me-2 btn-light-danger">
                                                <i class="bi bi-hand-thumbs-down"></i>
                                                غير معتمد</a>
                                        </p>
                                        <p>بانتظار رفع ملف الخطة المعدل </p>
                                    @endif
                                </div>
                            </div>

                            <div class="modal fade" id="kt_modal_client_not_approve" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered mw-1000px">
                                    <div class="modal-content">
                                        <form class="form" id="ClientNoApproveFORM" enctype="multipart/form-data" data-route-url="{{ route('not.approve.project') }}">                                                        
                                            @method('PUT') 
                                            @csrf
                                                
                                            <input type="hidden" name="project_id" id="project_id" value="{{ $id }}" />
                                            <div class="modal-header">
                                                <h3 class="modal-title text-danger">رفض مشروع الخطه التنفيذيه</h3>
                                                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                                    <span class="svg-icon svg-icon-1">
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="card card-flush py-4">
                                                <div class="card-body pt-0">
                                                    <div class="row mb-6">
                                                        <label class="col-lg-12 col-form-label required fw-semibold fs-6">سبب عدم الأعتماد</label>
                                                        <div class="col-lg-12 fv-row">
                                                            <textarea class="form-control" name="rejection_note" id="rejection_note" class="form-control form-control-lg form-control-solid"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="mb-10">
                                                        <label class="form-label">ملف رفض الأعتماد</label>
                                                        <input accept=".doc,.docx" class="form-control form-control-solid" id="project_executive_rejection_file" name="project_executive_rejection_file" type="file">                                                                    <!--end::Editor-->
                                                    </div>
                                                </div>
                                            </div>                                                        
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-sm me-2 btn-light" data-bs-dismiss="modal">إلغاء</button>
                                                <button type="submit" class="btn btn-sm me-2 btn-primary" id="not-approve-btn">
                                                    <span class="indicator-label">حفظ التغييرات</span>
                                                    <span class="indicator-progress">أنتظر التحميل...
                                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                    </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <form id="outTemplate" method="post" action="{{route('outcome.TEMPLATE')}}">
                        @csrf 
                        @method('PUT')
                        <input type="hidden" name="project" value="{{$row->id}}">
                        <table id="kt_datatable_both_scrolls" class="outTbl table table-striped table-row-bordered gy-5 gs-7 mt-8">
                            <thead>
                                <tr class="fw-semibold fs-7 text-white border-bottom border-gray-200 py-4 bg-danger">
                                    <th>&nbsp;</th>
                                    <th>الأسم</th>
                                    <th>الوصف</th>
                                    <th>نموذج للمخرج</th>
                                    <th>حالة النموذج</th>
                                    @if($outcomesAccpted === $outcomesAll)
                                    <th>ملف المخرج</th>
                                    <th>حاله المخرج</th>
                                    @endif
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $s ='a0b1c2d3e4f56789'; @endphp
                                @foreach ($outcomes as $v)
                                    @php
                                        $j = 0;
                                        $c = '';
                                        while ($j < 6) {
                                            $c .= $s[mt_rand(0, strlen($s) - 1)];
                                            $j++;
                                        }
                                    @endphp
                                    <tr class="py-5 fw-semibold  border-bottom border-gray-300">
                                        <td class="index">
                                            <!--div style="border-right:4px solid #{{ $c }};"></div-->
                                            <input type="checkbox" class="form-check-input outCheck {{($v->is_template_approved == '1') ? 'agree' : ''}}" name='tOutcome[]' data-name="{{ $v->title }}" value="{{ $v->id }}" {{!is_null($v->is_template_approved) ? 'checked' : ''}} {{(is_null($v->template) && !isset($v->template) || !is_null($v->is_template_approved)) ? 'disabled' : ''}}>
                                            <input type='hidden' name='tStatus[]' value='A'>
                                            <button type='button' style="padding-block:7px;" class="togg accp btn {{($v->is_template_approved == '1') ? 'btn-success btn-sm me-2' : 'btn-secondary btn-sm me-2'}}" data-label="on" {{(is_null($v->template) && !isset($v->template) || !is_null($v->is_template_approved)) ? 'disabled' : ''}}>موافق</button>
                                            <button type='button' style="padding-block:7px;" class="togg rej btn {{($v->is_template_approved == '0') ? 'btn-danger btn-sm me-2' : 'btn-secondary btn-sm me-2'}}" data-label="off" {{(is_null($v->template) && !isset($v->template) || !is_null($v->is_template_approved)) ? 'disabled' : ''}}>رفض</button>
                                        </td>
                                        <td>{{ $v->title }}</td>
                                        <td style="width:170px;height:80px;overflow:auto;">{{ $v->description }}</td>
                                        <td>
                                            @if (!is_null($v->template) && isset($v->template))
                                                <a href="{{ asset('storage/' . $v->template) }}" rel="alternate" download title=" تحميل النموذج " class="btn btn-sm me-2 btn-primary clip">
                                                <i class="bi bi-paperclip" style="font-size:18px;color:#ccc;"> </i>تحميل النموذج </a>
                                            @else
                                                لايوجد ملف
                                            @endif
                                        </td>
                                        <td>
                                    @if (!is_null($v->is_template_approved) && isset($v->is_template_approved))
                                            @if($v->is_template_approved == '1')
                                                <span style="padding:10px 12px !important;" class="badge badge-light-success" title="موافق"> <i class="bi bi-check-circle-fill text-success" style=""></i> </span>
                                            @else
                                                <span style="padding:10px 12px !important;" class="badge badge-light-danger" title="مرفوض"> <i class="bi bi-exclamation-circle-fill text-danger" style=""></i> </span>
                                                @if (!is_null($v->template_reject_reason) && isset($v->template_reject_reason))
                                                &nbsp; <span style="color:#fff !important;cursor:pointer;" title="الملاحظات وسبب الرفض" onclick="_getRemarks('{{$v->template_reject_reason}}');"> <i class="bi bi-search" style="color:#888 !important;font-size:1.2em;"></i> </span>
                                                @endif
                                            @endif
                                        @else
                                        لم يحدد بعد 
                                        @endif
                                    </td>
                                        @if($outcomesAccpted === $outcomesAll)
                                        <td>
                                            @if (!is_null($v->file) && isset($v->file))
                                                <a href="{{ asset('storage/' . $v->file) }}" rel="alternate" download class="btn btn-sm me-2 btn-primary clip" title="تحميل الملف ">
                                                <i class="bi bi-paperclip" style="font-size:18px;color:#ccc;"></i> تحميل الملف </a>
                                            @else
                                                لايوجد ملف
                                            @endif
                                        </td>
                                        <td id="out-{{$v->id}}">                                                
                                        @if (!is_null($v->is_accepted) && isset($v->is_accepted))
                                            @if($v->is_accepted == '1')
                                                <span style="padding:10px 12px !important;" class="badge badge-light-success" title="موافق"> <i class="bi bi-check-circle-fill text-success" style=""></i> </span>
                                            @else
                                                <span style="padding:10px 12px !important;" class="badge badge-light-danger" title="مرفوض"> <i class="bi bi-exclamation-circle-fill text-danger" style=""></i> </span>
                                        @endif

                                        @elseif ($v->user_add == 2)
                                            <button type="button" data-out="{{$v->id}}" data-case="A" class="AccOrRej btn btn-sm me-2 btn-success"><i class="bi bi-check-circle"></i> موافق </button>
                                            <button type="button" data-out="{{$v->id}}" data-case="R" class="AccOrRej btn btn-sm me-2 btn-danger"><i class="bi bi-x-circle"></i> رفض </button>  
                                            <span id="outCase-{{$v->id}}" style="color:#fff !important;" class="badge"></span>  
                                        @elseif ($v->user_add != 2 && !is_null($v->file))
                                            <button type="button" data-out="{{$v->id}}" data-case="A" class="AccOrRej btn btn-sm me-2 btn-success"><i class="bi bi-check-circle"></i> موافق </button>
                                            <button type="button" data-out="{{$v->id}}" data-case="R" class="AccOrRej btn btn-sm me-2 btn-danger"><i class="bi bi-x-circle"></i> رفض </button>  
                                            <span id="outCase-{{$v->id}}" style="color:#fff !important;" class="badge"></span>  
                                        
                                        @else
                                        مخرج جديد قيد المراجعه
                                            @endif

                                    </td>
                                    @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </form>
                        <button type="button" class="btn btn-sm me-2 btn-info" id="saveAll" style="float:left;margin-left:20px;">إرســـال</button>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#modalOutTemplate" id="templateBtn" class="btn btn-sm me-2 btn-info" style="float:left;margin-left:20px;">حغظ التغيرات</i></button>
                            <br clear="all">
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="kt_project_redflags_tab" role="tabpanel">
             @include('backoffice.client.redflags')             
        </div>

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
                                {{--  
                                <div class="fw-bold fs-6 mb-2 text-gray-800">الخطوة الحالية</div>
                                @foreach ($transactions_history->where('is_done', '0') as $value)
                                    <div class="fw-semibold fs-6 text-gray-700">{{ $value->status->previous }} <span class="fw-semibold fs-7 text-gray-400">{{ $value->created_at->diffForHumans() }}</span>
                                    </div>
                                    <a href="{{ url('chats/' . $value->user_id . '?Ref=' . $value->user->name) }}" id="loadUserChat" class="text-primary opacity-75-hover fw-semibold" dir="rtl" data-user-id="{{ $value->user_id }}">لدى -
                                        {{ $value->user->name }}</a>
                                @endforeach
                                <div class="separator mt-4"></div>
                                --}} 
                                <!--begin::Wrapper-->
                                @forelse($transactions_history as $value)
                                    <div class="d-flex align-items-center mb-6" style="margin:0 !important;">
                                        <!--begin::Bullet-->
                                        @if($value->is_done == '1')
                                            @php 
                                            $co = '#01ADA0'; 
                                            $ty = "light";
                                            $col = "title";
                                            @endphp
                                            @else
                                            @php 
                                            $co = '#F3F3F3'; 
                                            $ty = "dark";
                                            $col = "previous";
                                            @endphp
                                            @endif
                                        <span data-kt-element="bullet" class="cycleIco" style="background-color:{{$co}};">
                                            <img src="{{asset('assets/media/status-icons/' . \App\Models\TransactionHistory::find($value->status_id)->icons.'-'.$ty.'.svg') }}" alt="{{ $value->status->class }}">
                                        </span>
                                        <!--end::Bullet-->
                                        <!--begin::Info-->
                                        <div class="flex-grow-1 me-5">
                                        <div class="fw-semibold fs-6 text-gray-800">{{\App\Models\TransactionHistory::find($value->status_id)->$col}} </div>
                                            <div class="fw-semibold fs-8 text-gray-700">
                                                {{--
                                                    في الساعة  {{ $value->created_at->format('h:i A')}} &nbsp; 
                                                    {{ $value->created_at->format('d/m/Y') }} 
                                                    --}}
                                                <span class="fw-semibold fs-8 text-gray-600">
                                                    {{ $value->created_at->diffForHumans() }} 
                                                </span>
                                            </div>
                                            {{--
                                            <div class="fw-semibold fs-8 text-gray-600">{{ __('site.by') }}
                                                <a href="{{ url('chats/' . $value->user_id . '?Ref=' . $value->user->name) }}" id="loadUserChat" class="text-primary opacity-75-hover fw-semibold" dir="rtl" data-user-id="{{ $value->user_id }}">{{ $value->user->name }}</a>
                                            </div>
                                            --}}
                                        </div>
                                    </div>
                                    <div class="linked"></div>
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
    </div>

    @include('partials.obstacle._obstacle')
    @include('partials.backoffice.contact-information-modal')

    <!--modal-->
    <div class="modal fade" id="modalOutTemplate" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-1000px">
            <div class="modal-content">
                <div class="modal-header">
                    <h3><i class="bi bi-box-arrow-left" style="color:#fff;font-size:1.3rem;"></i>  المخرجات </h3>
                    <br>
                </div>
                <div class="modal-body scroll-y mx-xl-18 pb-15 mx-5">
                    <!--ur content-->
                    <form id="outcomeTemplate" method="post" action="{{route('outcome.TEMPLATE')}}">
                        @csrf 
                        @method('PUT')
                        <input type="hidden" name="project" value="{{$row->id}}">
                        <table id="tblTOut" class="table table-striped table-row-bordered gy-5 gs-7">
                            <thead>
                                <tr class="fw-semibold fs-7 text-white border-bottom border-gray-200 py-4 bg-info">
                                    <th>&nbsp;</th>
                                    <th>الأسم</th>
                                    <th>حالة نموذج المخرج</th>
                                    <th>ملاحظات النموذج</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </form>
                    <div class="mt-5" style="border-top:1px solid #2a2a3f;padding-top:20px;">
                    <input type="button" class="canc btn" data-bs-dismiss="modal" value="إلغاء" style="float:left;background:#F60F37;color:#fff;margin:0 10px;">
                    <input type="button" class="btn btn me-2" id="saveTemplate" value="إرســـال" style="float:left;background: #004A61; color:white"">
                    <br clear="all">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalWrap" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-1000px">
            <div class="modal-content">
                <div class="modal-header mb-4">
                    <h3><i class="bi bi-plus-square mx-4" style="color:#fff;font-size:1.3rem;"></i>إنشاء طلب جديد</h3>
                </div>
                <div class="modal-body scroll-y mx-xl-10 pb-15 mx-5">
                    <form id="addReq">
                        @csrf
                        <input type="hidden" name="project" value="{{ $row->id }}">
                        <div id="inputWrap" class="mb-12">
                            <div class="input">
                                <span id="sp_0"></span>
                                <input type="text" class="form-control" name="req[]" placeholder="عنوان الطلب">
                                <button type="button" id="addNewReq" class="btn btn-success">
                                    <i class="bi bi-plus-circle"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mt-5" style="border-top:1px solid #2a2a3f;padding-top:20px;">
                        <input type="button" id="cancelReq" class="canc btn" style="float:left;background:#F60F37;color:#fff;margin-left:10px;" data-bs-dismiss="modal" value="إلغاء">
                        <input type="button" id="saveReq" class="btn btn me-2" style="float:left;background: #004A61; color:white" value="إضافة">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end-modal-->  
    <!--Client Red Flags modal-->
    @include('backoffice.followup.redflags.modals.client')

    <div class="modal fade" id="modalOutClientRejectionNote" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-1000px">
            <div class="modal-content">
                <div class="modal-header mb-4">
                    <h3><i class="bi bi-plus-square mx-4" style="color:#fff;font-size:1.3rem;"></i>سبب رفض المخرج</h3>
                </div>
                <div class="modal-body scroll-y mx-xl-10 pb-15 mx-5">
                    <form method="post" action="{{ route('outcome.ClientRejectionNote')}}">
                        @csrf
                        <input type="hidden" name="outcome_id" id="outcome_id"> 
                        <input type="hidden" name="project_id" value="{{ $row->id }}">                                                                     
                        <textarea required class="form-control" name="client_rejection_note" placeholder="وصف المخرج"></textarea>                              
                        <br>
                        <input type="submit" id="saveClientRejectionNote" class="btn btn-primary mx-4" value="إضافة">
                        <input type="button" id="cancelClientRejectionNote" class="btn btn-secondary" data-bs-dismiss="modal" value="إلغاء">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end::Container-->
@stop

@section('scripts')
    <script> const redflagstoreRoute = '{{ route('store.Redflag') }}'; </script>        
    <script src="{{ asset('assets/js/custom/backoffice/redflags/redflag.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/vis-timeline/vis-timeline.bundle.js') }}"></script>
    <script>    
    $("select#teamType").on("change", function() {
            $("div#workMembers").html("<h4 style='text-align:center;flex:0 0 100%'>الرجاء الانتظار...</h4>");
            setTimeout(() => {
                $.get("{{ route('Client.Filter') }}", $(this).parent().serialize(), function(data) {
                    $("div#workMembers").html(data);
                });
            }, 1800);
        });

        $("a.dcf").on("click", function() {
            var file = $(this).data("f");
            $.post("{{ route('del.file') }}", {
                "P": $(this).data("p"),
                "F": $(this).data("f"),
                "_token": "{{ csrf_token() }}",
                "_method": "DELETE"
            }, function(data) {
                $("div[data-client='" + file + "']").fadeOut();
            });
        });

        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            $('li').removeClass('active');
            $(this).parent().addClass('active');
            var link = $(this).attr('href');
            var page = $(this).attr('href').split('page=')[1];

            $.ajax({
                url: '?page=' + page,
                type: "get",
                datatype: "html",
            }).done(function(data) {
                $("div#workMembers").empty().html(data);
                location.hash = page;
            }).fail(function(jqXHR, ajaxOptions, thrownError) {
                alert('No response from server');
            });
        });

        $("button#addNewReq").on("click", function() {
            $("<div class='input'></div>").html('<span id="sp_' + i + '"></span><input type="text" class="form-control" name="req[]" placeholder="عنوان الطلب"><button type="button" class="delNewReq btn btn-danger"><i class="bi bi-trash-fill"></i></button>')
                .appendTo("div#inputWrap");
            i++;
        });

        $(document).on('click', 'button.delNewRedFlag', function() {
            $(this).parent().remove();
        });

        $(document).on('click', 'button.delNewReq', function() {
            $(this).parent().remove();
        });

        $("input#saveReq").on("click", function() {
            $("div.input span").html("");
            $.post("{{ route('add.Req') }}", $("form#addReq").serialize(), function(data) {
                if (data.code == 401) {
                    for (let x in data.err) {
                        $("span#sp_" + x).html(data.err[x]);
                    }
                } else {
                    window.location.reload();
                }
            });
        });

        $("label.delReq").on("click", function() {
            var req = $(this).data('r');
            $.post("{{ route('del.Req') }}", {
                "P": $(this).data('p'),
                "R": $(this).data('r'),
                "_token": "{{ csrf_token() }}",
                "_method": "DELETE"
            }, function(data) {
                //$("#tblReq tr[data-req='" + req + "']").fadeOut();
                window.location.reload();
            });
        });

        var v = true;
        $("label.editReq").on("click", function() {
            if (v) {
                $("td#tdReq_" + $(this).data('r')).hide();
                $("td#tdReqInp_" + $(this).data('r')).show();
                v = false;
            } else {
                $("td#tdReq_" + $(this).data('r')).show();
                $("td#tdReqInp_" + $(this).data('r')).hide();
                v = true;
            }
        });

        $("input.ReqInp").on("change", function() {
            var r = $(this).data('rid');
            $.post("{{ route('edit.Req') }}", {
                "P": $(this).data('pid'),
                "R": $(this).data('rid'),
                "T": $(this).val(),
                "_token": "{{ csrf_token() }}"
            }, function(data) {
                $("td#tdReq_" + r).html(data).show();
                $("td#tdReqInp_" + r).val(data).hide();
            });
        });

        $("label.viewReq").on("click", function() {
            $.get("{{ route('view.Req') }}", {
                "P": $(this).data('p'),
                "R": $(this).data('r'),
                "_token": "{{ csrf_token() }}"
            }, function(data) {
                $("a#RFile").attr({
                    "href": "/storage" + data.store.Redflag
                });
                $("p#RNotes").html(data.req.notes);
            });
        });

        $("button.AccOrRej").on("click",function(){
          var out = $(this).data('out');
          var is_approved = $(this).data('is-approved');
          
           $.post("{{route('outcome.AOR')}}",{
            "ID":$(this).data('out'),
            "P":"{{$row->id}}",
            "C":$(this).data("case"),
            "_token":"{{csrf_token()}}",
            "_method" : "PATCH"
        },function(data){
            $("td#out-"+out+" button.AccOrRej").hide();
            if(data.value == '1') {
              $("span#outCase-"+out).addClass('badge-light-success').html(data.MSG);              
            }else{
                $('#outcome_id').val(out); 

                $('#is_approved').val(is_approved); 

                $('#modalOutClientRejectionNote').modal('show'). 
                // show client rejection note
              $("span#outCase-"+out).addClass('badge-light-danger').html(data.MSG);
            }
        });
        });

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
                        //console.log(data.MSG);
                        window.location.reload();
                    },
                    error: function(xhr, desc, err) {}
                });

        });
        
        var $project_id = $('#project_id');
        new Dropzone("#explore_training_file", {
            url: projectBaseUrl + '/client/project/files', // Set the url for your upload script location
            method: "post",
            paramName: "file", // The name that will be used to transfer the file
            maxFiles: 1,
            maxFilesize: 10, // MB
            addRemoveLinks: true,
            acceptedFiles: "application/pdf,image/*,video/*,*.doc,*.docx",
            params: {
                'project_id': $project_id.val()
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            accept: function(file, done) {
                    if (file.name == "wow.jpg") {
                        done("Naha, you don't.");
                    } else {
                        done();
                    }
                },
            });

        var deleteProjectClientFile = ($file, $id) => {
            $.post(projectBaseUrl + '/client/project/delete/file', {
                "file": $file,
                "ID": $id,
                "_token": "{{ csrf_token() }}",
                "_method": "DELETE"
            }, function(data) {
                $("div[data-file='" + $file + "']").fadeOut(200);
            });
        }

        var i = 0;
        var btnROutcome = '<button type="button" class="delOutcome btn btn-danger"><i class="bi bi-trash-fill"></i></button>';
        $("button#addOutcome").on("click", function() {
            $("<div class=''></div>").html('<div class="col-11"><span id="sp_' + i + '"></span><div class="mt-2"><input type="text" class="form-control" name="titleOut[]" placeholder="عنوان المخرج"></div><div><div class="mt-2"><textarea class="form-control" name="descOut[]" placeholder="وصف المخرج"></textarea></div></div></div>'+btnROutcome)
                .appendTo("div#inputOutWrap");
            i++;
        }); 
        $(document).on('click', 'button.delOutcome', function() {
            $(this).parent().remove();
        });
        
        $("button.togg").on("click",function() {
        if($(this).data("label") == "on"){
            $(this).removeClass("btn-secondary").addClass("btn-success");
            $(this).parent().find("input.outCheck").addClass("agree").attr({"checked":true});
            $(this).parent().find("button.rej").removeClass("btn-danger").addClass("btn-secondary");
        }else{
            $(this).removeClass("btn-secondary").addClass("btn-danger");
            $(this).parent().find("input.outCheck").removeClass("agree").attr({"checked":true});
            $(this).parent().find("button.accp").removeClass("btn-success").addClass("btn-secondary");
        }
       
        if($("input.outCheck.agree:not(:disabled)").length == $("input.outCheck:not(:disabled)").length) {
            $("button#saveAll").show();
            $("button#templateBtn").hide();
        }else{
            $("button#saveAll").hide();
            $("button#templateBtn").show();
        }
        
        });
       
        $("button#templateBtn").on("click",function() {
            var checkLen = $("td.index input.outCheck:checked:not(:disabled)").length;
            var outPut ="";
            var typ ="";
            var status ="";
            var reject ="";
            for(var i = 0;i < checkLen;i++) {
            if($("td.index input.outCheck:checked:not(:disabled):eq("+i+")").hasClass("agree")) {
                status = "<span class='badge text-bg-success' style='padding:10px 12px !important;'>سيتم الموافقة</span>";
                typ = "A";
                reject ="&nbsp;";
            } else {
                status ="<span class='badge text-bg-danger' style='padding:10px 12px !important;'>سيتم الرفض</span>";
                typ = "R";
                reject = "<textarea class='form-control' name='tRemarks["+i+"]' placeholder='سبب الرفض'></textarea>";
            }
                outPut += "<tr><td><input type='hidden' name='tOutcome[]' value='"+$("td.index input.outCheck:checked:not(:disabled):eq("+i+")").val()+"'><input type='hidden' name='tStatus[]' value='"+typ+"'></td><td>"+$("td.index input.outCheck:checked:not(:disabled):eq("+i+")").data("name")+"</td><td>"+status+"</td><td>"+reject+"</td></tr>";
            }
            $("table#tblTOut tbody").html(outPut);
        });

        $("input#saveTemplate").on("click",function() {
            Swal.fire({
                title: 'هل انت متاكد؟',
                icon: 'question',
                html: '',
                showCloseButton: true,
                showCancelButton: true,
                showConfirmButton: true,
                confirmButtonText: "نعم",
                cancelButtonText: "لا",
                confirmButtonColor: '#50cd89',
                cancelButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    $("form#outcomeTemplate").trigger("submit");
                } else if (result.dismiss) {
                //
                }
            })
        });

        $("button#saveAll").on("click",function() {
            Swal.fire({
                title: 'هل انت متاكد؟',
                icon: 'question',
                html: 'سيتم الموافقة على جميع مخرجات المشروع',
                showCloseButton: true,
                showCancelButton: true,
                showConfirmButton: true,
                confirmButtonText: "نعم",
                cancelButtonText: "لا",
                confirmButtonColor: '#50cd89',
                cancelButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    $("form#outTemplate").trigger("submit");
                } else if (result.dismiss) {
                //
                }
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

        $(".handleOutCome").click(function() {
            document.getElementById('outcome_id').value = $(this).attr('data-outcome-id');
        });

        $(".AddRedFlagReplyClass").on("click", function() {
            document.getElementById('redFtitle').innerHTML = $(this).attr('data-red-title');
            document.getElementById('redflag_id').value = $(this).attr('data-red-id');
            document.getElementById('client_id').value = $(this).attr('data-client-id');
        });

        $("input#saveRedflagReply").on("click", function() {
            $("div.input span").html("");
            $.post("{{ route('reply.Redflag') }}", $("form#addRedflagReply").serialize(), function(data) {
                if (data.code == 401) {
                    for (let x in data.err) {
                        $("span#sp_" + x).html(data.err[x]);
                    }
                } else {
                    $.ajax({
                        success: function(response, textStatus, xhr) {
                            Swal.fire({
                                text: /*response['msg']*/ 'تم إرسال الرد علي البلاغ بنجاح', // respose from controller
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "موافق",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary",
                                }
                            }).then(function() {
                                // delete row data from server and re-draw datatable
                                dt.draw();
                            });
                            location.reload();
                            // Remove header checked box
                        }
                    });
                }
            });
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
    </script>

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
                $('#myTabClients a[href="' + activeTabX + '"]').tab('show');
            }
        });
    </script>

    {{-- // load google map  --}}
    <script>
        $(document).ready(function() {
            initialize();
        });
    </script>

    <script>
        function ApproveProject() {
            Swal.fire({
                html: "<strong>هل أنت متأكد من أعتماد خطه المشروع" + " ؟</strong>",
                icon: "success",
                showCancelButton: true,
                buttonsStyling: false,
                showLoaderOnConfirm: true,
                confirmButtonText: "تأكيد",
                cancelButtonText: "الألغاء",
                customClass: {
                    confirmButton: "btn fw-bold btn-success",
                    cancelButton: "btn fw-bold btn-secondary"
                },
            }).then(function(result) {
                if (result.value) { // Yes Delete
                    $.ajax({
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "{{ route('approve.project') }}",
                        data: {
                            'projectId': '{{ $row->id }}',
                        },
                        success: function(response, textStatus, xhr) {
                            Swal.fire({
                                text: "جار أعتماد خطه المشروع",
                                icon: "info",
                                buttonsStyling: false,
                                showConfirmButton: false,
                                timer: 2000
                            }).then(function() {
                                if (response["status"] == true) {
                                    Swal.fire({
                                        text: response['msg'], // respose from controller
                                        icon: "success",
                                        buttonsStyling: false,
                                        confirmButtonText: "{{ __('site.confirmButtonTextGotit') }}",
                                        customClass: {
                                            confirmButton: "btn fw-bold btn-primary",
                                        }
                                    }).then(function() {
                                        // delete row data from server and re-draw datatable
                                        location.reload();
                                    });
                                } else if (response["status"] == false) {
                                    Swal.fire({
                                        html: response["msg"], // respose from controller
                                        icon: "error",
                                        buttonsStyling: false,
                                        confirmButtonText: "{{ __('site.confirmButtonTextGotit') }}",
                                        customClass: {
                                            confirmButton: "btn btn-light-danger"
                                        }
                                    }).then(function() {
                                        location.reload();
                                    });
                                }
                            });
                        }
                    });
                } else if (result.dismiss === 'cancel') {
                    Swal.fire({
                        text: "عذرا لم يتم الأعتماد",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: destroy.getAttribute("data-confirm-button-textGotit"),
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary",
                        }
                    });
                }
            });

        }
        // Not Approve
        
        var title = '{{ $row->title }}';
        var image = '{{ asset('storage/' . $row->logo) }}';
        var map_x = '{{ $coordinatex }}';
        var map_y = '{{ $coordinatey }}';
        var sites = [
            [title, map_x, map_y, 1, title + '<br/><a href="al-fares.sa/" title="' + image + '"><img src="' + image + '" width="240" height="160" alt="' + title + '" /></a><br/>'],
        ];
        var infowindow = null;

        function initialize() {
            var centerMap = new google.maps.LatLng(map_x, map_y);
            var myOptions = {
                zoom: 10,
                center: centerMap,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }
            var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
            setZoom(map, sites);
            setMarkers(map, sites);
            infowindow = new google.maps.InfoWindow({
                content: "Loading..."
            });
        }
        /*
        This functions sets the markers (array)
        */
        function setMarkers(map, markers) {
            for (var i = 0; i < markers.length; i++) {
                var site = markers[i];
                var siteLatLng = new google.maps.LatLng(site[1], site[2]);
                var marker = new google.maps.Marker({
                    position: siteLatLng,
                    map: map,
                    title: site[0],
                    zIndex: site[3],
                    html: site[4],
                    // Markers drop on the map
                    animation: google.maps.Animation.DROP
                });
                google.maps.event.addListener(marker, "click", function() {
                    infowindow.setContent(this.html);
                    infowindow.open(map, this);
                });
            }
        }
        /*
        Set the zoom to fit comfortably all the markers in the map
        */
        function setZoom(map, markers) {
            /*
            var boundbox = new google.maps.LatLngBounds();
            for ( var i = 0; i < markers.length; i++ )
            {
              boundbox.extend(new google.maps.LatLng(markers[i][1], markers[i][2]));
            }
            map.setCenter(boundbox.getCenter());
            map.fitBounds(boundbox);
            */
            map.setZoom(17);
        }
    </script>

<script src="{{ asset('assets/js/custom/backoffice/client_not_approve_project.js') }}"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAz4-NaqNiTPgHXoTqSPsJwIRNQ9q53A_4&callback=initMap" type="text/javascript"></script>
@stop
