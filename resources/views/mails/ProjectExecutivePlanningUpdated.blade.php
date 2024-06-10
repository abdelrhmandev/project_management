<!DOCTYPE html>
<html dir="rtl" style="direction: rtl" lang="ar-SA">

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
    <meta property="og:site_name"  />
    <link rel="canonical" href="google.com" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico')}}" />
    <link href="{{ asset('assets/plugins/global/plugins.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="app-blank">
    <!--begin::Main-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Wrapper-->
        <div class="d-flex flex-column flex-column-fluid">
            <!--begin::Body-->
            <div class="scroll-y flex-column-fluid px-10 py-10" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header_nav" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true" style="background-color:#ffffff; --kt-scrollbar-color: #d9d0cc; --kt-scrollbar-hover-color: #d9d0cc">
                <!--begin::Email template-->
                <style>
                    html,
                    body {
                        padding: 0;
                        margin: 0;
                        font-family: 'Cairo', sans-serif !important;
                    }

                    a:hover {
                        color: #009ef7;
                    }
                </style>
                <div id="#kt_app_body_content" style="font-family:'Cairo', sans-serif !important; line-height: 1.5;text-align:center !important; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:0; width:100%;">
                    <div style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:40px auto; max-width: 600px;">
                        <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
                            <tbody>
                                <tr>
                                    <td align="center" valign="center" style="text-align:right !important; padding-bottom: 10px">
                                        <img alt="al-fares Logo" src="https://al-fares.sa/project/public/assets/media/training/alfars-logo.png" />
                                        <br>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" valign="center" style="text-align:center !important; padding-bottom: 10px">
                                        <!--begin:Email content-->
                                        <div style="text-align:center !important; margin:0 15px 34px 15px">
                                            <!--begin:Logo-->
                                            <div style="margin-bottom: 10px">
                                                <a href="https://al-fares.sa" rel="noopener" target="_blank">
                                                    <img alt="al-fares" src="https://al-fares.sa/project/public/assets/media/training/pie-chart.png" />
                                                </a>
                                            </div>
                                            <!--end:Logo-->
                                            <!--begin:Text-->
                                            <div style="font-size: 14px; font-weight: bold; margin-bottom: 27px; font-family:'Cairo', sans-serif !important;">
                                                <p style="margin-bottom:9px; color:#014358; font-size: 22px; font-weight:700;font-family:'Cairo', sans-serif !important;
                                                    text-align: center !important;">
                                                    نود أن نعلمك أن هناك نسخه محدثه من الخطه التنفيذيه لمشروع "{{ $PData['project_title'] }}"
                                                    
                                                </p>
                                                <p style="margin-bottom:9px; color:#00AC9F; font-size: 18px;
                                                    font-weight:600;font-family:'Cairo', sans-serif !important;
                                                    text-align: center !important;">
                                                    للإطلاع علي ملف ملاحظلات العميل
                                                </p>
                                            </div>
                                            <!--end:Text-->
                                            <!--begin:Action-->
                                            <a href="{{ $PData['url']}}" target="_blank" style="background-color:#00AC9F;
                                                border-radius:10px;display:inline-block;
                                                padding:20px 0px; color: #ffffff; font-size: 16px;
                                                font-weight:600;font-family:'Cairo', sans-serif !important;
                                                text-decoration:none !important;width:170px;text-align:center;">من هنا</a>
                                            <!--begin:Action-->
                                        </div>
                                        <!--end:Email content-->
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" valign="center" style="text-align:center; padding-bottom: 20px;">
                                    <div style="direction:rtl;">
                                        <div style="display:inline-block;text-align:right;color:#014358;
                                                font-family:'Cairo', sans-serif !important;font-size:18px;
                                                font-weight:600;width:350px;">
                                            <p v style="text-align:right !important;color:#014358;
                                                font-family:'Cairo', sans-serif !important;font-size:18px;
                                                font-weight:600">تابعونا على وسائل التواصل الإجتماعي</p>
                                        </div>
                                        <div style="display:inline-block;text-align:left;">

                                            <a href="https://www.linkedin.com/company/alfares-research/" style="margin-left:10px">
                                                <img alt="Linkedin" src="https://al-fares.sa/project/public/assets/media/training/linkedin.png" width="37" height="37" />
                                            </a>
                                            <a href="https://twitter.com/Alfares_sa">
                                                <img alt="Twitter" src="https://al-fares.sa/project/public/assets/media/training/twitter.png" width="37" height="37" /></a>
                                        </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" valign="center" style="font-size: 14px; padding:0 15px; text-align:center !important;
                                        font-weight: 500; color: #000000;font-family:'Cairo', sans-serif !important;
                                        ">
                                        <p style="text-align:center !important;font-size:14px;">
                                            <a href="https://al-fares.sa" target="_blank" class="text-gray-800 text-hover-primary" style="font-family:'Cairo', sans-serif !important;
                                                color:#000000;
                                                font-size:14px;
                                                text-decoration:none;
                                                ">
                                                @ جميع الحقوق محفوظة لدى شركه الفارس
                                            </a>
                                            &nbsp;
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--end::Email template-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Root-->
    <!--end::Main-->
    <!--end::Javascript-->
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js')}}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js')}}"></script>
</body>
<!--end::Body-->

</html>