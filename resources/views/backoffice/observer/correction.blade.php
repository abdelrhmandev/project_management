@extends('layouts.app')

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div id="kt_content_container" class="container-xxl">
            <div class="d-flex flex-column flex-xl-row">
                <!--begin::Layout-->
                <!--begin::Sidebar-->
                @include('partials.backoffice.sidebar-project')
                <!--end::Sidebar-->

                <!--begin::Content-->
                <div class="flex-lg-row-fluid ms-lg-15">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active">
                            @include('partials.backoffice.research-details')

                            <form class="form" id="observer-hand-offer-task-form" action="{{ url('observer/hand-offer-correction') }}" enctype="multipart/form-data" autocomplete="off" method="post">
                                @csrf
                                <div class="row g-5 g-xl-8">
                                    @if ($row->type_id != 9)
                                        <div class="col-xl-4">
                                            <a href="#" class="fs-5 fw-bold noUi-target mb-2 text-gray-900" data-bs-toggle="modal" data-bs-target="#kt_modal_supervisors" disabled>
                                                <div class="card card-xl-stretch mb-xl-8">
                                                    <div class="card-header pt-5">
                                                        <span class="fs-2 fw-bold me-1">المشرفين</span>
                                                        <i class="bi bi-person-bounding-box fs-2x"></i>
                                                    </div>
                                                    <div class="card-body d-flex align-items-end pt-0">
                                                        <div class="d-flex align-items-center flex-column w-100 mt-3">
                                                            <div class="d-flex justify-content-between fw-bold fs-6 w-100 mt-auto mb-2 opacity-50">
                                                                <span>{{ $fieldwork_team->supervisor_qty -($observer_team->where('type_id', 4)->where('superior_id', Auth::user()->id)->first()->qty ??0) }} المتبقي</span>
                                                                <span>{{ round((($observer_team->where('type_id', 4)->where('superior_id', Auth::user()->id)->first()->qty ??0) /$fieldwork_team->supervisor_qty) *100,0) }} %</span>
                                                            </div>
                                                            <div class="h-8px w-100 bg-light-danger mx-3 rounded">
                                                                <div class="bg-danger h-8px rounded" role="progressbar" style="width: {{ round((($observer_team->where('type_id', 4)->where('superior_id', Auth::user()->id)->first()->qty ??0) /$fieldwork_team->supervisor_qty) *100,0) }}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-xl-4">
                                            <a href="{{ url('/' . Auth::user()->roles[0]->name . '/get-correction-researchers/' . $row->id) }}" class="fs-5 fw-bold mb-2 text-gray-900">
                                                <div class="card card-xl-stretch mb-xl-8">
                                                    <!--begin::Header-->
                                                    <div class="card-header pt-5">
                                                        <!--begin::Title-->
                                                        <span class="fs-2 fw-bold me-1">الباحثين</span>
                                                        <i class="bi bi-people fs-2x"></i>
                                                        <!--end::Title-->
                                                    </div>
                                                    <!--end::Header-->
                                                    <!--begin::Card body-->
                                                    <div class="card-body d-flex align-items-end pt-0">
                                                        <!--begin::Progress-->
                                                        <div class="d-flex align-items-center flex-column w-100 mt-3">
                                                            <div class="d-flex justify-content-between fw-bold fs-6 w-100 mt-auto mb-2 opacity-50">
                                                                <span>{{ $fieldwork_team->researcher_qty - ($observer_team_researchers->qty ?? 0) }} المتبقي</span>
                                                                <span>{{ round((($observer_team_researchers->qty ?? 0) / $fieldwork_team->researcher_qty) * 100, 0) }} %</span>
                                                            </div>
                                                            <div class="h-8px w-100 bg-light-danger mx-3 rounded">
                                                                <div class="bg-danger h-8px rounded" role="progressbar" style="width: {{ round((($observer_team_researchers->qty ?? 0) / $fieldwork_team->researcher_qty) * 100, 0) }}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                        <!--end::Progress-->
                                                    </div>
                                                    <!--end::Card body-->
                                                </div>
                                            </a>
                                        </div>
                                    @else
                                        <label class="form-check form-check-custom form-check-solid align-items-start">
                                            <!--begin::Input-->
                                            <input class="form-check-input me-3" type="checkbox" id="is_explore_tour_required" name="is_explore_tour_required" disabled onchange="manageNeedTrainer(this)" {{ !empty($project_training_file->is_trainers_needed) == 1 ? 'checked' : '' }} placeholder="سيتم العمل عليها إذا أصبح هناك آلية لتدريب المدربين على برنامج كاشف" />
                                            <!--end::Input-->
                                            <!--begin::Label-->
                                            <span class="form-check-label d-flex flex-column align-items-start mt-4">
                                                <span class="fw-bold fs-5 mb-0">تدريب الباحثين</span>
                                                <span class="text-muted fs-6">هل هناك حاجة إلى تحديد باحثين داخلين لتدريبهم؟</span>
                                            </span>
                                            <!--end::Label-->
                                        </label>

                                        <div id="needTrainer" class="col-xl-4 {{ !empty($project_training_file->is_trainers_needed) == 1 ? '' : 'd-none' }}">
                                            <a href="#" class="fs-5 fw-bold mb-2 text-gray-900" data-bs-toggle="modal" data-bs-target="#kt_modal_trainer">
                                                <div class="card card-xl-stretch mb-xl-8">
                                                    <div class="card-header pt-5">
                                                        <span class="fs-2 fw-bold me-1">المدربين</span>
                                                        <i class="fonticon-cms fs-2x"></i>
                                                    </div>
                                                    <div class="card-body d-flex align-items-end pt-0">
                                                        <div class="d-flex align-items-center flex-column w-100 mt-3">
                                                            <div class="d-flex justify-content-between fw-bold fs-6 w-100 mt-auto mb-2 opacity-50">
                                                                <span>{{ $financial_bid_estimate->trainer_qty - ($observer_team->where('type_id', 7)->first()->qty ?? 0) }} المتبقي</span>
                                                                <span>{{ round((($observer_team->where('type_id', 7)->first()->qty ?? 0) / $financial_bid_estimate->trainer_qty) * 100, 0) }} %</span>
                                                            </div>
                                                            <div class="h-8px w-100 bg-light-danger mx-3 rounded">
                                                                <div class="bg-danger h-8px rounded" role="progressbar" style="width: {{ round((($observer_team->where('type_id', 7)->first()->qty ?? 0) / $financial_bid_estimate->trainer_qty) * 100, 0) }}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <!--begin::Col-->
                                        <div class="col-xl-4">
                                            <div class="card card-xl-stretch mb-xl-8">
                                                <div class="card-header">
                                                    <h3 class="card-title align-items-start flex-column">
                                                        <span class="card-label fw-bold fs-3 mb-1">تقرير التدريب</span>
                                                    </h3>
                                                </div>
                                                <div class="card-body py-3">
                                                    <div class="tab-content">
                                                        <div class="tab-pane fade show active" id="kt_table_widget_7_tab_1">
                                                            <div class="table-responsive">
                                                                <!--begin::Form-->
                                                                <div class="fv-row">
                                                                    <!--begin::Dropzone-->
                                                                    <div class="dropzone" id="explore_training_file">
                                                                        <!--begin::Message-->
                                                                        <div class="dz-message needsclick">
                                                                            <!--begin::Icon-->
                                                                            <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                                                            <!--end::Icon-->
                                                                            <!--begin::Info-->
                                                                            <div class="ms-4">
                                                                                <h3 class="fs-5 fw-bold mb-1 text-gray-900">الرجاء الرفع هنا</h3>
                                                                            </div>
                                                                            <!--end::Info-->
                                                                        </div>
                                                                    </div>
                                                                    <!--end::Dropzone-->
                                                                </div>
                                                                <!--end::Form-->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Col-->
                                    @endif

                                    <input type="hidden" name="project_id" id="project_id" value="{{ $row->id }}" />
                                    <input type="hidden" name="type_id" id="type_id" value="{{ $row->type_id }}" />
                                    @if ($row->type_id == 9)
                                        <input type="hidden" name="is_trainer" id="is_trainer" value="true" />
                                        <input type="hidden" name="project_training_file" id="project_training_file" value="{{ $project_training_file->file ?? '' }}" />
                                    @else
                                        <input type="hidden" name="is_trainer" id="is_trainer" value="false" />
                                    @endif

                                    <button type="submit" class="btn btn-warning" id="observer-hand-offer-task-btn">إنهاء المعالجة</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--end::Content-->
                <!--end::Layout-->
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script src="{{ asset('assets/js/custom/account/referrals/referral-program.js') }}"></script>
    <script src="{{ asset('assets/js/custom/backoffice/observer.js') }}"></script>
@stop
