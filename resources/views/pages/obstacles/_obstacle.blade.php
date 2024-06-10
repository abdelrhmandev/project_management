@extends('layouts.app')
@section('style')
    <style type="text/css">
        div#oWrap {
            box-sizing: border-box;
            margin: 20px 0 !important;
            padding: 0 !important;
            display: grid;
            grid-template-columns: 30% 68%;

        }

        div#oWrap .oSide {
            box-sizing: border-box;
            border-radius: 8px;
        }

        div#oWrap .oSide div {
            padding-right: 0 !important;
        }

        div#oWrap .oSide h3 span {
            color: #f8242b !important;
            padding-right: 25px !important;
        }

        div#oWrap .oChat {
            box-sizing: border-box;
            border-radius: 8px;
        }

        .oSide ul#oNav {
            box-sizing: border-box;
            list-style-type: none;
        }

        .oSide ul#oNav>li {
            box-sizing: border-box;
            padding: 20px 0px;
        }

        .oSide ul#oNav li:not(:last-child) {
            border-bottom: 1px dashed gray;
        }

        .oSide ul#oNav>li span.oDate {
            display: block;
            color: gray;
            margin-right: 30px;
        }

        article.oMsg {
            box-sizing: border-box;
            margin-top: 20px;
        }

        article.oMsg div.first {
            float: right;
            width: 70px;
            margin-left: 20px;
            box-sizing: border-box;
        }

        article.oMsg div.second {
            float: right;
            padding-top: 15px;
            box-sizing: border-box;
        }

        article.oMsg div.second span {
            color: gray;
            display: inline-block;
            margin-right: 20px;
        }

        article.oMsg div.second p {
            color: #45c2b9;
            font-size: 12px;
        }

        article.oMsg div.first img {
            display: block;
            width: 100%;
            height: auto;
            border-radius: 18px;
        }

        article.oMsg div.msg {
            clear: both;
            padding: 12px 10px 5px 10px !important;
            color: #aaa;
            box-sizing: border-box;
        }

        div#formWrap {
            display: flex;
            margin-top: 30px;
        }

        div#formWrap>div#textarea {
            flex: 0 0 80%;
        }

        div#formWrap>div#textarea textarea {
            height: 60px;
            transition: 0.3s linear;
            padding: 15px 36px 0 0;
            box-sizing: border-box;
            background-image: url('/assets/media/team/message.png');
            background-repeat: no-repeat;
            background-position: 99% center;
        }

        div#formWrap>div#textarea span {
            color: #f1416c;
            display: inline-block;
            margin-bottom: 10px;
        }

        .error {
            border: 1px solid #f1416c !important;
        }

        div#formWrap>div#button {
            flex: 0 0 20%;
            margin-right: 20px;
        }

        div#formWrap>div#button button {
            margin-top: 27px;
        }
    </style>
@endsection

@section('content')
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">
        <!--begin::Navbar-->
        <div class="card mb-xl-10 mb-5">
            <div class="card-body pt-9 pb-0">
                <!--begin::Details-->
                <div class="d-flex flex-sm-nowrap mb-3 flex-wrap">
                    <!--begin: Pic-->
                    <div class="me-7 mb-4">
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
                                    <a href="#" class="btn btn-sm btn-light-{{ $row->status->class }} fw-bold ms-2 fs-8 py-1 px-3" data-bs-toggle="modal" data-bs-target="#kt_modal_upgrade_plan">{{ $row->status->trans }}</a>
                                </div>
                                <!--end::Name-->
                                <!--begin::Info-->
                                <div class="d-flex fw-semibold fs-6 pe-2 mb-4 flex-wrap">
                                    <a href="#" class="d-flex align-items-center text-hover-primary me-5 mb-2 text-gray-400">
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
                                    <div class="min-w-125px me-2 mb-3 rounded border border-dashed border-gray-300 py-3 px-4">
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
                                    <div class="min-w-100px me-2 mb-3 rounded border border-dashed border-gray-300 py-3 px-2">
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
                                    <div class="min-w-125px me-2 mb-3 rounded border border-dashed border-gray-300 py-3 px-4">
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
                                <div class="d-flex justify-content-between w-100 mt-auto mb-2">
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
            </div>
            <!--end::Container-->

            <!--begin::Container-->
            <div class="col-xl-12 mt-6 gap-7" id="oWrap">
                <div class="card card-xl-stretch tab-pane oSide">
                    <div class="card-header cursor-pointer pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold fs-3 mb-1">
                                <img src="{{ asset('assets/media/team/flag.png') }}" alt="flag">
                                تعرقلات المشروع
                            </span>
                        </h3>
                    </div>
                    <div class="card-body py-3">
                        <ul id="oNav">
                            @foreach ($olist as $v)
                                <li>
                                    <input class="form-check-input oProject" type="radio" name="oProject" data-id="{{ $v->id }}" data-item="{{ $row->id }}" data-url="{{ route('obstacle.getMsg') }}" value="{{ $v->sender }}">
                                    &nbsp;
                                    {{ $v->name }}
                                    <span class="oDate">{{ $v->date }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="card card-xl-stretch tab-pane oChat">
                    <div class="card-body py-3">
                        <div id="oMsgs">
                            <article class="oMsg">
                                <div class="first">
                                    <img src="{{ asset('storage/uploads/users-avatar/blank.png') }}" alt="">
                                </div>
                                <div class="second">
                                    -
                                    <span>منذ - يوم</span>
                                    <p>-</p>
                                </div>
                                <div class="msg">-</div>
                            </article>
                        </div>

                        <form id="chatForm" data-action="{{ route('obstacle.sendMsg') }}">
                            @csrf
                            <input type="hidden" name="chatProject" value="{{ $row->id }}">
                            <input type="hidden" name="chatTo" value="">
                            <input type="hidden" name="chatId" value="">

                            <div id="formWrap">
                                <div id="textarea">
                                    <span></span>
                                    <textarea class="form-control" name="chatMsg" placeholder="ارسال رسالتك"></textarea>
                                </div>
                                <div id="button">
                                    <button id="chatSend" type="button" class="btn btn-primary">ارسال</button>
                                    <button id="chatClose" type="button" class="btn btn-primary">إغلاق</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--end::Container-->
        </div>
    </div>
@stop

@section('scripts')
    <script>
        "use strict";
        class PObstacle {
            constructor() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $("ul#oNav li:first-child input.oProject").attr({
                    "checked": true
                });
                $("form#chatForm input[name=chatTo]").val($("input.oProject:checked").val());
                $("form#chatForm input[name=chatId]").val($("input.oProject:checked").data("id"));
                this._getMessages();
                this._initMessages();
                this._sendMessage();
                this._closeMessage();
            }

            _initMessages() {
                $.post($("input.oProject:checked").data('url'), {
                    "id": $("input.oProject:checked").data("id"),
                    "project": $("input.oProject:checked").data("item"),
                    "sender": $("input.oProject:checked").val()
                }, function(data) {
                    $("div#oMsgs").html(data);
                });
            }

            _getMessages() {
                $("input.oProject").on("change", function() {
                    $("form#chatForm input[name=chatTo]").val($(this).val());
                    $("form#chatForm input[name=chatId]").val($(this).data("id"));
                    $.post($(this).data('url'), {
                        "id": $(this).data("id"),
                        "project": $(this).data("item"),
                        "sender": $(this).val()
                    }, function(data) {
                        $("div#oMsgs").html(data);
                    });
                });
            }

            _sendMessage() {
                $("button#chatSend").on("click", function() {
                    if ($("input.oProject:checked").val() != null) {
                        if ($("textarea").val() == "" || $("textarea").val() == " ") {
                            $("div#textarea span").html("يجب عليك ادخال رساله");
                            $("textarea").addClass('error');
                        } else {
                            $.post($("form#chatForm").data('action'), $("form#chatForm").serialize(), function(
                                data) {
                                $("div#textarea span").html("");
                                $("textarea").removeClass('error').val("");
                                $("div#oMsgs").append(data);
                            });

                            window.location.href = projectBaseUrl + '/obstacle/projects/' + $(
                                "input.oProject:checked").data("item");
                        }
                    }
                });
            }

            _closeMessage() {
                $("button#chatClose").on("click", function() {
                    if ($("input.oProject:checked").val() != null) {
                        $.post("{{ route('obstacle.closeObsticale') }}", {
                            "id": $("input.oProject:checked").data("id"),
                            "project": $("input.oProject:checked").data("item"),
                            "sender": $("input.oProject:checked").val()
                        }, function(data) {
                            window.location.href = projectBaseUrl + '/obstacle/projects/' + $(
                                "input.oProject:checked").data("item");
                        });
                    }
                });
            }
        }
        $(window).on("load", function() {
            try {
                new PObstacle();
            } catch (err) {
                console.error(err);
            }
        });
    </script>
@endsection
