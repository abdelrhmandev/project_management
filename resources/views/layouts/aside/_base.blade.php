<div id="kt_aside" class="aside pt-lg-0 overflow-visible pb-5 pt-5" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'80px', '300px': '100px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_mobile_toggle">
    <div class="aside-logo py-8" id="kt_aside_logo">
        <a href="{{ url('/' . Auth::user()->roles[0]->name) }}" class="d-flex align-items-center">
            <img alt="Logo" src="{{ asset('assets/media/logos/pm-logo-dark.svg') }}" class="h-60px logo" />
        </a>
    </div>
    <div class="aside-menu flex-column-fluid" id="kt_aside_menu">
        <div class="hover-scroll-overlay-y my-lg-5 pe-lg-n1 my-2" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside, #kt_aside_menu" data-kt-scroll-offset="5px">
            <div class="menu menu-column menu-title-gray-700 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-semibold" id="#kt_aside_menu" data-kt-menu="true">
                <div class="menu-item py-2">
                    <span class="menu-link menu-center">
                        <a href="{{ url('/' . Auth::user()->roles[0]->name) }}">
                            <span class="menu-icon me-0">
                                <i class="fonticon-house fs-1 nav-link"></i>
                            </span>
                            <span class="menu-title">{{ __('title_nav.home') }}</span>
                        </a>
                    </span>
                </div>
                @if (Auth::user()->hasAnyRole(['it', 'finance', 'client', 'project', 'auditor', 'trainer', 'equipment', 'creator', 'inspector']))
                    <div class="menu-item py-2">
                        <span class="menu-link menu-center">
                            <a href="{{ url('/' . Auth::user()->roles[0]->name . '/projects') }}">
                                <span class="menu-icon me-0">
                                    <i class="fonticon-stats fs-1" style="margin-right:105px"></i>
                                </span>
                                <span class="menu-title" style="margin-right:30px">{{ __('title_nav.project') }}
                                    <span class="menu-badge">
                                        <span class="badge badge-sm badge-circle badge-danger">{{ $projectsCount }}</span>
                                    </span>
                                </span>
                            </a>
                        </span>
                    </div>
                @endif

                @if (Auth::user()->hasAnyRole(['observer', 'fieldwork']))
                    <div class="menu-item py-2">
                        <span class="menu-link menu-center">
                            <a href="{{ url('/' . Auth::user()->roles[0]->name . '/projects/tour') }}">
                                <span class="menu-icon me-0">
                                    <i class="bi bi-globe-americas fs-1" style="margin-right:90px"></i>
                                </span>
                                <span class="menu-title" style="margin-right:20px">الجولات
                                    <span class="menu-badge">
                                        <span class="badge badge-sm badge-circle badge-danger">{{ $toursCount }}</span>
                                    </span>
                                </span>
                            </a>
                        </span>
                    </div>
                    <div class="menu-item py-2">
                        <span class="menu-link menu-center">
                            <a href="{{ url('/' . Auth::user()->roles[0]->name . '/projects') }}">
                                <span class="menu-icon me-0">
                                    <i class="fonticon-stats fs-1" style="margin-right:85px"></i>
                                </span>
                                <span class="menu-title" style="margin-right:25px">المهام
                                    <span class="menu-badge">
                                        <span class="badge badge-sm badge-circle badge-danger">{{ $projectsCount }}</span>
                                    </span>
                                </span>
                            </a>
                        </span>
                    </div>
                @endif

                @if (Auth::user()->hasRole('observer'))
                    <div class="menu-item py-2">
                        <span class="menu-link menu-center">
                            <a href="{{ route('observer.handoverProjects') }}">
                                <span class="menu-icon me-0">
                                    <i class="bi bi-box fs-4x" style="margin-right:83px"></i>
                                </span>
                                <span class="menu-title" style="margin-right:25px">{{ __('site.handover') }}
                                    <span class="menu-badge">
                                        <span class="badge badge-sm badge-circle badge-danger">{{ $handoverEquipmentCount }}</span>
                                    </span>
                                </span>
                            </a>
                        </span>
                    </div>
                    <div class="menu-item py-2">
                        <span class="menu-link menu-center">
                            <a href="{{ url('/' . Auth::user()->roles[0]->name . '/correct-project') }}">
                                <span class="menu-icon me-0">
                                    <i class="bi bi-card-checklist fs-4x" style="margin-right:45px"></i>
                                </span>
                                <span class="menu-title">{{ __('title_nav.project') }}</span>
                            </a>
                        </span>
                    </div>
                @endif

                @if (Auth::user()->hasAnyRole(['trainer', 'observer']))
                    <div class="menu-item py-2">
                        <span class="menu-link menu-center">
                            <a href="{{ url('/' . Auth::user()->roles[0]->name . '/projects/correction') }}">
                                <span class="menu-icon me-0">
                                    <i class="bi bi-arrow-left-right fs-4x" style="margin-right:85px"></i>
                                </span>
                                <span class="menu-title" style="margin-right:25px">{{ __('site.process') }}
                                    <span class="menu-badge">
                                        <span class="badge badge-sm badge-circle badge-danger">{{ $projectCorrection }}</span>
                                    </span>
                                </span>
                            </a>
                        </span>
                    </div>
                @endif

                @if (Auth::user()->hasRole('operation'))
                    <div class="menu-item py-2">
                        <span class="menu-link menu-center">
                            <a href="{{ url('/' . Auth::user()->roles[0]->name . '/estimate-quote') }}">
                                <span class="menu-icon me-0">
                                    <i class="fonticon-cash-payment fs-1" style="margin-right:105px"></i>
                                </span>
                                <span class="menu-title" style="margin-right:30px">{{ __('title_nav.estimate_quote') }}
                                    <span class="menu-badge">
                                        <span class="badge badge-sm badge-circle badge-danger">{{ $estimatesBidCount }}</span>
                                    </span>
                                </span>
                            </a>
                        </span>
                    </div>
                    <div class="menu-item py-2">
                        <span class="menu-link menu-center">
                            <a href="{{ url('/' . Auth::user()->roles[0]->name . '/projects') }}">
                                <span class="menu-icon me-0">
                                    <i class="fonticon-stats fs-1" style="margin-right:105px"></i>
                                </span>
                                <span class="menu-title" style="margin-right:30px">{{ __('title_nav.project') }}
                                    <span class="menu-badge">
                                        <span class="badge badge-sm badge-circle badge-danger">{{ $projectsCount }}</span>
                                    </span>
                                </span>
                            </a>
                        </span>
                    </div>
                @endif

                @if (Auth::user()->hasRole('inspector'))
                    <div class="menu-item py-2">
                        <span class="menu-link menu-center">
                            <a href="{{ url('inspector/handover/projects') }}">
                                <span class="menu-icon me-0">
                                    <i class="bi bi-box fs-4x" style="margin-right:83px"></i>
                                </span>
                                <span class="menu-title" style="margin-right:25px">{{ __('site.handover') }}
                                    <span class="menu-badge">
                                        <span class="badge badge-sm badge-circle badge-danger">{{ $handoverEquipmentCount }}</span>
                                    </span>
                                </span>
                            </a>
                        </span>
                    </div>
                @endif

                @if (Auth::user()->hasRole('equipment|auditor|fieldwork'))
                    <div class="menu-item py-2">
                        <span class="menu-link menu-center">
                            <a href="{{ url('/' . Auth::user()->roles[0]->name . '/contract-projects') }}">
                                <span class="menu-icon me-0">
                                    <i class="fonticon-alignment-right fs-4x" style="margin-right:35px"></i>
                                </span>
                                <span class="menu-title">{{ __('site.contracts') }}</span>
                            </a>
                        </span>
                    </div>
                @endif

                @if (Auth::user()->hasRole('equipment'))
                    <div class="menu-item py-2">
                        <span class="menu-link menu-center">
                            <a href="{{ route('d.projects') }}" class="">
                                <span class="menu-icon me-0">
                                    <i class="fonticon-user-2 fs-4x" style="margin-right:45px"></i>
                                </span>
                                <span class="menu-title">الحسابات</span>
                            </a>
                        </span>
                    </div>
                    
                    <div class="menu-item py-2">
                        <span class="menu-link menu-center">
                            <a href="{{ url('/' . Auth::user()->roles[0]->name . '/ImportcsvFileattractingTeamForm') }}">
                                <span class="menu-icon me-0">
                                    <i class="fa-solid fa-file-csv" style="margin-right:40px"></i>
                                </span>
                                <span class="menu-title">الفريق</span>
                            </a>
                        </span>
                    </div>
                @endif

                @if (Auth::user()->hasRole('project'))
                    <div class="menu-item py-2">
                        <span class="menu-link menu-center">
                            <a href="{{ route('RejectedProjectsPlanning') }}">
                                <span class="menu-icon me-0">
                                    <i class="fonticon-repeat fs-4x" style="margin-right:105px"></i>
                                </span>
                                <span class="menu-title" style="margin-right:25px">المرفوض
                                    <span class="menu-badge">
                                        <span class="badge badge-sm badge-circle badge-danger">{{ $RejectedProjectsPlanningCounter ?? '' }}</span>
                                    </span>
                                </span>
                            </a>
                        </span>
                    </div>
                @endif

                @if (Auth::user()->hasRole('admin'))
                    <div class="menu-item py-2">
                        <span class="menu-link menu-center">
                            <a href="{{ url('/' . Auth::user()->roles[0]->name . '/projects') }}">
                                <span class="menu-icon me-0">
                                    <i class="fonticon-stats fs-1" style="margin-right:105px"></i>
                                </span>
                                <span class="menu-title" style="margin-right:30px">{{ __('title_nav.project') }}
                                    <span class="menu-badge">
                                        <span class="badge badge-sm badge-circle badge-danger">{{ $projectsCount }}</span>
                                    </span>
                                </span>
                            </a>
                        </span>
                    </div>
                    <div class="menu-item py-2">
                        <span class="menu-link menu-center">
                            <a href="{{ url('/' . Auth::user()->roles[0]->name . '/sender-credential') }}">
                                <span class="menu-icon me-0">
                                    <i class="fonticon-mail fs-1" style="margin-right:40px"></i>
                                </span>
                                <span class="menu-title">{{ __('site.sender_credential') }}</span>
                            </a>
                        </span>
                    </div>
                @endif

                <div class="menu-item py-2">
                    <span class="menu-link menu-center">
                        <a href="{{ route('obstacle.projects') }}">
                            <span class="menu-icon me-0">
                                <i class="bi bi-exclamation-octagon fs-4x" style="margin-right:90px"></i>
                            </span>
                            <span class="menu-title" style="margin-right:25px">{{ __('site.obstacles') }}
                                <span class="menu-badge">
                                    <span class="badge badge-sm badge-circle badge-danger">{{ $projectObsticales ?? '' }}</span>
                                </span>
                            </span>
                        </a>
                    </span>
                </div>

                @if (Auth::user()->hasRole('auditor'))
                    <div class="menu-item py-2">
                        <span class="menu-link menu-center">
                            <a href="{{ route('evals') }}" class="">
                                <span class="menu-icon me-0">
                                    <i class="fonticon-user-2 fs-4x" style="margin-right:45px"></i>
                                </span>
                                <span class="menu-title">{{ __('site.evaluations') }}</span>
                            </a>
                        </span>
                    </div>
                @endif

                @if (Auth::user()->hasRole('design'))
                    <div class="menu-item py-2">
                        <span class="menu-link menu-center">
                            <a href="{{ route('unprocessed') }}">
                                <span class="menu-icon me-0">
                                    <i class="bi bi-brush" style="margin-right:45px"></i>
                                </span>
                                <span class="menu-title" style="margin-right:8px">جديد</span>
                            </a>
                        </span>
                    </div>

                    <div class="menu-item py-2">
                        <span class="menu-link menu-center">
                            <a href="{{ route('processed') }}">
                                <span class="menu-icon me-0">
                                    <i class="bi bi-brush-fill" style="margin-right:55px"></i>
                                </span>
                                <span class="menu-title" style="margin-right:10px">المعالج</span>
                            </a>
                        </span>
                    </div>
                @endif

                <div class="menu-item py-2">
                    <span class="menu-link menu-center">
                        <a href="{{ route('calendar.index') }}">
                            <span class="menu-icon me-0">
                                <i class="fonticon-calendar fs-1" style="margin-right:35px"></i>
                            </span>
                            <span class="menu-title">{{ __('title_nav.calendar') }}</span>
                        </a>
                    </span>
                </div>
                <div class="menu-item py-2">
                    <span class="menu-link menu-center">
                        <a href="{{ route('chats') }}">
                            <span class="menu-icon me-0">
                                <i class="fonticon-chat fs-1" style="margin-right:65px"></i>
                            </span>
                            <span class="menu-title" style="margin-right:10px">{{ __('site.chats') }}
                                <span class="menu-badge">
                                    @if ($ChatunseenMessageCounter > 0)
                                        <span class="badge badge-sm badge-circle badge-danger">{{ $ChatunseenMessageCounter }}</span>
                                    @endif
                                </span>
                            </span>
                        </a>
                    </span>
                </div>

                @if (Auth::user()->hasAnyRole(['trainer']))
                    <div class="menu-item py-2">
                        <span class="menu-link menu-center">
                            <a href="{{ route('admin.users.index') }}">
                                <span class="menu-icon me-0">
                                    <i class="fonticon-user-2 fs-4x" style="margin-right:50px"></i>
                                </span>
                                <span class="menu-title">{{ __('user.all') }}</span>
                            </a>
                        </span>
                    </div>
                @endif

                @if (Auth::user()->hasAnyRole(['project']))
                    <div class="menu-item py-2">
                        <span class="menu-link menu-center">
                            <a href="{{ route('admin.customers.index') }}">
                                <span class="menu-icon me-0">
                                    <i class="bi bi-briefcase fs-1" style="margin-right:40px"></i>
                                </span>
                                <span class="menu-title">{{ __('title_nav.customer') }}</span>
                            </a>
                        </span>
                    </div>
                @endif

                @if (Auth::user()->hasAnyRole(['equipment', 'operation']))
                    <div class="menu-item py-2">
                        <span class="menu-link menu-center">
                            <a href="{{ route('admin.equipments.index') }}">
                                <span class="menu-icon me-0">
                                    <i class="bi bi-box fs-1" style="margin-right:50px"></i>
                                </span>
                                <span class="menu-title">{{ __('title_nav.equipment') }}</span>
                            </a>
                        </span>
                    </div>
                    <div class="menu-item py-2">
                        <span class="menu-link menu-center">
                            <a href="{{ route('admin.equipment_types.index') }}">
                                <span class="menu-icon me-0">
                                    <i class="bi bi-stickies fs-1" style="margin-right:40px"></i>
                                </span>
                                <span class="menu-title">{{ __('title_nav.equipment_type') }}</span>
                            </a>
                        </span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
