@include('Chatify::layouts.headLinks')
<!--end::Global Stylesheets Bundle-->

<body id="kt_body"
    class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed">
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <!--begin::Aside-->
            @include('layouts.aside._base')
            <!--end::Aside-->
            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <!--begin::Header-->
                @include('layouts.header._base')
                <!--end::Header-->
                <!--begin::Toolbar-->
                <div class="toolbar py-2" id="kt_toolbar">
                    <!--begin::Container-->
                    <div id="kt_toolbar_container" class="container-fluid d-flex align-items-center">
                        <!--begin::Page title-->
                        <div class="flex-grow-1 flex-shrink-0 me-5">
                            <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                                data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                                class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                                <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">{{ __('site.chats') }}
                                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                                    <small
                                        class="text-muted fs-7 fw-semibold my-1 ms-1">{{ __('title_nav.dashboard') }}</small>
                                </h1>
                            </div>
                            <!--begin::Page title-->
                            <!--end::Page title-->
                        </div>
                        <!--end::Page title-->
                        <!--begin::Action group-->
                        <div class="d-flex align-items-center flex-wrap">
                            <!--begin::Wrapper-->
                            <div class="d-flex align-items-center">
                                <!--begin::Daterangepicker-->
                                <a href="#"
                                    class="btn btn-sm btn-bg-light btn-color-gray-500 btn-active-color-primary me-2"
                                    id="kt_dashboard_daterangepicker" data-bs-toggle="tooltip" data-bs-dismiss="click"
                                    data-bs-trigger="hover" title="Select dashboard daterange">
                                    <span class="fw-semibold me-1" id="kt_dashboard_daterangepicker_title">تاريخ اليوم
                                        هو</span>
                                    <span class="fw-bold"
                                        id="kt_dashboard_daterangepicker_date">{{ date('Y/m/d') }}</span>
                                </a>
                                <!--end::Daterangepicker-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Action group-->
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Toolbar-->
                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::Container-->
                    <div id="kt_content_container" class="container-xxl">
                        <div class="row g-6 g-xl-9">
                            <div class="d-flex flex-column flex-lg-row">
                                <div class="messenger">
                                    {{-- ----------------------Users/Groups lists side---------------------- --}}
                                    <div class="messenger-listView">
                                        {{-- Header and search bar --}}
                                        <div class="m-header">
                                            <nav>
                                                <a href="#"><i class="fas fa-inbox"></i> 
                                                    <span class="messenger-headTitle">{{ __('site.messages') }}</span>
                                                </a>
                                                {{-- header buttons --}}
                                                <nav class="m-header-right">
                                                    <a href="#"><i class="fas fa-cog settings-btn"></i></a>
                                                    <a href="#" class="listView-x"><i
                                                            class="fas fa-times"></i></a>
                                                </nav>
                                            </nav>
                                            {{-- Search input --}}
                                            <input type="text" value="{{ app('request')->input('Ref') ?? '' }}"
                                                class="messenger-search" placeholder="{{ __('site.search') }} .." />
                                            {{-- Tabs --}}
                                            <div class="messenger-listView-tabs">
                                                <a href="#"
                                                    @if ($type == 'user') class="active-tab" @endif
                                                    data-view="users">
                                                    <span class="far fa-user"></span> {{ __('site.people') }}</a>
                                            </div>
                                        </div>
                                        {{-- tabs and lists --}}
                                        <div class="m-body contacts-container">
                                            {{-- Lists [Users/Group] --}}
                                            {{-- ---------------- [ User Tab ] ---------------- --}}
                                            <div class="@if ($type == 'user') show @endif messenger-tab users-tab app-scroll"
                                                data-view="users">
                                                {{-- Favorites --}}
                                                <div class="favorites-section">
                                                    <p class="messenger-title">{{ __('site.favorites') }}</p>
                                                    <div class="messenger-favorites app-scroll-thin"></div>
                                                </div>
                                                {{-- Saved Messages --}}
                                                {!! view('Chatify::layouts.listItem', ['get' => 'saved']) !!}
                                                {{-- Contact --}}
                                                <div class="listOfContacts"
                                                    style="width: 100%;height: calc(100% - 200px);position: relative;">
                                                </div>
                                            </div>
                                            {{-- ---------------- [ Group Tab ] ---------------- --}}
                                            <div class="@if ($type == 'group') show @endif messenger-tab groups-tab app-scroll"
                                                data-view="groups">
                                                {{-- items --}}
                                                <p style="text-align: center;color:grey;margin-top:30px">
                                                    <a target="_blank" style="color:{{ $messengerColor }};"
                                                        href="https://chatify.munafio.com/notes#groups-feature">Click
                                                        here</a> for more info!
                                                </p>
                                            </div>
                                            {{-- ---------------- [ Search Tab ] ---------------- --}}
                                            <div class="messenger-tab search-tab app-scroll" data-view="search">
                                                {{-- items --}}
                                                <p class="messenger-title">{{ __('site.search') }}</p>
                                                <div class="search-records">
                                                    <p class="message-hint center-el">
                                                        <span>{{ __('site.type_to_search') }}..</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- ----------------------Messaging side---------------------- --}}
                                    <div class="messenger-messagingView">
                                        {{-- header title [conversation name] amd buttons --}}
                                        <div class="m-header m-header-messaging">
                                            <nav
                                                class="chatify-d-flex chatify-justify-content-between chatify-align-items-center">
                                                {{-- header back button, avatar and user name --}}
                                                <div
                                                    class="chatify-d-flex chatify-justify-content-between chatify-align-items-center">
                                                    <a href="#" class="show-listView"><i
                                                            class="fas fa-arrow-left"></i></a>
                                                    <div class="avatar av-s header-avatar"
                                                        style="margin: 0px 10px; margin-top: -5px; margin-bottom: -5px;">
                                                    </div>
                                                    <a href="#" class="user-name">{{ config('chatify.name') }}
                                                    </a>
                                                </div>
                                                {{-- header buttons --}}
                                                <nav class="m-header-right">
                                                    <a href="#" class="add-to-favorite"><i
                                                            class="fas fa-star"></i></a>
                                                    <a href="/"><i class="fas fa-home"></i></a>
                                                    <a href="#" class="show-infoSide"><i
                                                            class="fas fa-info-circle"></i></a>
                                                </nav>
                                            </nav>
                                        </div>
                                        {{-- Messaging area --}}
                                        <div class="m-body messages-container app-scroll">
                                            {{-- Internet connection --}}
                                            <div class="internet-connection">
                                                <span class="ic-connected">{{ __('site.connected') }}</span>
                                                <span class="ic-connecting">{{ __('site.connecting') }}...</span>
                                                <span class="ic-noInternet">{{ __('site.no_internet_access') }}</span>
                                            </div>
                                            <div class="messages">
                                                <p class="message-hint center-el">
                                                    <span>{{ __('site.please_select_a_chat_to_start_messaging') }}</span>
                                                </p>
                                            </div>
                                            {{-- Typing indicator --}}
                                            <div class="typing-indicator">
                                                <div class="message-card typing">
                                                    <p>
                                                        <span class="typing-dots">
                                                            <span class="dot dot-1"></span>
                                                            <span class="dot dot-2"></span>
                                                            <span class="dot dot-3"></span>
                                                        </span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Send Message Form --}}
                                        @include('Chatify::layouts.sendForm')
                                    </div>
                                    {{-- ---------------------- Info side ---------------------- --}}
                                    <div class="messenger-infoView app-scroll">
                                        {{-- nav actions --}}
                                        <nav>
                                            <a href="#"><i class="fas fa-times"></i></a>
                                        </nav>
                                        {!! view('Chatify::layouts.info')->render() !!}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Content-->
                <!--begin::Footer-->
                @include('layouts._footer')
                <!--end::Footer-->
            </div>
            <!--end::Wrapper-->
        </div>
    </div>
    <!--end::Page-->
    <!--begin::Helper drawer-->
    @include('partials.topbar._helper-drawer')
    <!--end::Helper drawer-->
    <!--begin::Scrolltop-->
    @include('layouts._scrolltop')
    <!--end::Scrolltop-->

    @include('Chatify::layouts.modals')
    @include('Chatify::layouts.footerLinks')

    @if(auth()->user()->roles->first()->id == 14)
    <script>
            messengerSearch($(".messenger-search").val());
            $(".messenger-tab").hide();
            $('.messenger-tab[data-view="search"]').show();
            $(".messenger-listView").hide();            
            const dataId = '2';
            const dataType =  'user';
            setMessengerId(dataId);
            setMessengerType(dataType);
            IDinfo(dataId, dataType);
        const dataView = $(".messenger-list-item")
        .find("p[data-type]")
        .attr("data-type");
        $(".messenger-tab").hide();
        $(".messenger-tab[data-view=" + dataView + "s]").show();


     </script>  
     @elseif(auth()->user()->roles->first()->id <> 14)

    @if (app('request')->input('Ref'))
        <script>
            messengerSearch($(".messenger-search").val());
            $(".messenger-tab").hide();
            $('.messenger-tab[data-view="search"]').show();
            // set item active on click
            if ($(this).find("tr[data-action]").attr("data-action") == "1") {
                $(".messenger-listView").hide();
            }
            const dataId = '{{ $id }}';
            const dataType =  '{{ $type }}';
            setMessengerId(dataId);
            setMessengerType(dataType);
            IDinfo(dataId, dataType);
        </script>
    @endif
    @endif

    @yield('scripts')
</body>
</html>
