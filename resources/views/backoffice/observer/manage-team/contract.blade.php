<!DOCTYPE html>
<html direction="rtl" dir="rtl" style="direction: rtl" lang="ar" lang="ar">

<head>
    <title>{{ config('app.name', 'Laravel') }} | @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="The most advanced Bootstrap Admin " />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta property="og:locale" content="ar_SA" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="#" />
    <link rel="canonical" href="google.com" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}" />
    @yield('style')
    <link href="{{ asset('assets/plugins/global/plugins.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
    <style>
        @font-face {
            font-family: "Sakkal Majalla";
            src: url("//db.onlinewebfonts.com/t/708bed747111fd418c6b35b909cd1d3a.eot");
            src: url("//db.onlinewebfonts.com/t/708bed747111fd418c6b35b909cd1d3a.eot?#iefix") format("embedded-opentype"),
                url("//db.onlinewebfonts.com/t/708bed747111fd418c6b35b909cd1d3a.woff2") format("woff2"),
                url("//db.onlinewebfonts.com/t/708bed747111fd418c6b35b909cd1d3a.woff") format("woff"),
                url("//db.onlinewebfonts.com/t/708bed747111fd418c6b35b909cd1d3a.ttf") format("truetype"),
                url("//db.onlinewebfonts.com/t/708bed747111fd418c6b35b909cd1d3a.svg#Sakkal Majalla") format("svg");
        }
        .divContractPreview {
            font-family: 'Sakkal Majalla', sans-serif !important;
            font-size: 20px;
        }
        #clear_button {
            z-index: 10;
            position: absolute;
            padding: 1.5em 2em;
            color: #21cfa6;
            font-weight: 600;
            font-size: 12px;
            cursor: pointer;
        }
        #finish_button {
            z-index: 10;
            position: absolute;
            left: 2em;
            padding: 26.0em 0.5em;
            color: #1aa8f8;
            font-weight: 600;
            font-size: 12px;
            cursor: pointer;
        }
        .header-fixed.toolbar-fixed .wrapper {
            padding-top: 50px !important;
        }
        .header-fixed.toolbar-fixed .wrapper {
            padding-right: 0px !important;
        }
    </style>
    <!--end::Global Stylesheets Bundle-->
</head>

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed">
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::Container-->
                    <div id="kt_content_container" class="container-xxl">
                        <!--begin::Form-->
                        <form id="kt_ecommerce_add_product_form" method="post" action="{{ route('team-member-generate-contract', [$projectId, $teamuserId, $typeTd]) }}" class="form d-flex flex-column flex-lg-row">
                            @csrf
                            @method('PUT')
                            <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                                <div class="d-flex flex-column gap-7 gap-lg-10">
                                    <!--begin::General options-->
                                    <div class="card card-flush py-4">
                                        <!--begin::Card header-->
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h2>{{ __('project.contract_details') }}</h2>
                                            </div>
                                        </div>
                                        <!--end::Card header-->
                                        <!--begin::Card body-->
                                        <div class="card-body pt-0">
                                            <!--begin::Input group-->
                                            <div class="mb-10 fv-row">
                                                @if(Request::get('Case'))
                                                @if (Crypt::decrypt(Request::get('Case')) == 'ObserverContract')
                                                <input type="hidden" name="case" value="observer">
                                                @include('pages.contracts.observer', [
                                                    'div_class' => 'divContractPreview',
                                                    'user' => $row,
                                                    'typeTd' => 5,
                                                    'logo' => $logo,
                                                    'team_rank_item'=> $team_rank_item,
                                                    'today_day_arabic' => $today_day_arabic,
                                                    'project_title' => $project_title,
                                                ])
                                                @endif
                                                @else
                                                @include('pages.contracts.index', [
                                                    'div_class' => 'divContractPreview',
                                                    'attracting' => $row,
                                                    'team_rank_item' => $team_rank_item,
                                                    'typeTd' => Crypt::decrypt($typeTd),
                                                    'logo' => $logo,
                                                    'team_rank_type_trans' => $team_rank_type_trans,
                                                    'today_day_arabic' => $today_day_arabic,
                                                    'project_title' => $project_title,
                                                    'contract_research_items' => $contract_research_items,
                                                ])
                                                @endif
                                            </div>
                                            <!--end::Input group-->
                                        </div>
                                        <!--end::Card header-->
                                    </div>
                                    <!--end::General options-->
                                    <!--begin::Media-->
                                    <div class="card card-flush py-4">
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h2> الشروط والأحكام</h2>
                                            </div>
                                        </div>
                                        <div class="card-body pt-0">
                                            <div class="d-flex align-items-center mb-4">
                                                <span class="bullet bullet-vertical h-40px bg-success"></span>
                                                <div class="form-check form-check-custom form-check-solid mx-5">
                                                    <input class="form-check-input" type="radio" id="kt_accept_contract" required name="term" value="1" />
                                                </div>
                                                <div class="text-success fs-7">أقر على الموافقة على العقد</div>
                                            </div>
                                            <div class="d-flex align-items-center mb-8">
                                                <span class="bullet bullet-vertical h-40px bg-danger"></span>
                                                <div class="form-check form-check-custom form-check-solid mx-5">
                                                    <input class="form-check-input" id="kt_reject_contract" type="radio" required name="term" value="0" />
                                                </div>
                                                <div class="text-danger fs-7">لا أريد الإنضمام في هذا المشروع</div>
                                            </div>
                                            <div id="reason" class="d-none">
                                                <textarea class="form-control form-control-flush mb-3 form-control-solid" name="rejection_reason" rows="4" data-kt-element="input" placeholder="اكتب سبب الرفض هنا"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Media-->
                                </div>
                                <!--end::Tab content-->
                                <div class="d-flex justify-content-end">
                                    <!--begin::Button-->
                                    <button id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">{{ __('site.cancel') }}</button>
                                    <!--end::Button-->
                                    <!--begin::Button-->
                                    <button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-primary">
                                        <span class="indicator-label">{{ __('site.send') }}</span>
                                        <span class="indicator-progress">{{ __('site.please_wait') }}...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                    <!--end::Button-->
                                </div>
                            </div>
                        </form>
                        <!--end::Main column-->
                        <!--end::Form-->
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Wrapper-->
        </div>
    </div>
    <!--end::Page-->
    @include('partials.toastsJs')
</body>
<script>
    const box = document.getElementById('box');
    function handleRadioClick() {
        if (!document.getElementById('kt_accept_contract').checked) {
            document.getElementById('reason').classList.remove("d-none");
        } else {
            document.getElementById('reason').classList.add("d-none");
        }
    }

    const radioButtons = document.querySelectorAll('input[name="term"]');
    radioButtons.forEach(radio => {
        radio.addEventListener('click', handleRadioClick);
    });
</script>
</html>
