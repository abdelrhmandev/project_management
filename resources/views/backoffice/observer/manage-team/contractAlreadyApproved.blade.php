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

<body id="kt_body"
    class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed">
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::Container-->
                    <div id="kt_content_container" class="container-xxl">
                        <!--begin::Form-->

                       
                        <div class="card card-flush" style="width:50%;margin-right: 25%;background: #014358 0% 0% no-repeat padding-box;">
                            <!--begin::Card header-->
                            
                            <!--end::Card header-->
                            <!--begin::Card body-->

                            <div class="py-10 text-center">
                                <img src="{{ asset('assets/media/svg/illustrations/contract.png') }}"
                                    class="theme-light-show w-200px" alt="" />
                               
                            </div>

                            <div class="card-body pt-0" align="center" style="color: white">
                                <!--begin::Input group-->

                                {{ $msg }}
                                <!--end::Card header-->
                            </div>
                            <!--end::General options-->
                            <!--begin::Media-->

                            <!--end::Media-->
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

</html>
