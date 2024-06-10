@extends('layouts.app')

@section('content')
<div id="kt_content_container" class="container-xxl">
    <div class="d-flex flex-column flex-xl-row">
        @include('partials.backoffice.sidebar-project')
        <div class="flex-lg-row-fluid ms-lg-15">
            <div class="tab-content" id="myTabContent">
         
                <div class="tab-pane fade show active">
                    @if($financial_bid_estimate->is_explore_tour_required == '0')
                    @include('partials.backoffice.research-details')
                    @endif
                    <div class="col-xl-12">
                        <form class="form" id="finance-hand-offer-task-form" action="{{ url('finance/hand-offer-task')}}" enctype="multipart/form-data" novalidate="novalidate" method="post">
                            @csrf
                            <input type="hidden" name="finance" id="finance" value="{{ $financial_bid_estimate->finance_file ?? '' }}" />
                            <input type="hidden" name="project_id" id="project_id" value="{{ $financial_bid_estimate->project_id ?? '' }}" />
                            <div class="card card-xl-stretch mb-xl-8">
                                <div class="card-header">
                                    <h3 class="card-title align-items-start flex-column">
                                        <span class="card-label fw-bold fs-3 mb-1">ملف العرض المالي</span>
                                    </h3>
                                </div>
                                <div class="card-body py-3">
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="kt_table_widget_7_tab_1">
                                            <div class="table-responsive">
                                                <div class="fv-row">
                                                    <div class="dropzone" id="finance_file">
                                                        <div class="dz-message needsclick">
                                                            <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                                            <div class="ms-4">
                                                                <h3 class="fs-5 fw-bold text-gray-900 mb-1">الرجاء رفع ملف العرض المالي</h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
    
                            <div class="text-center mt-8">
                                <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed min-w-lg-600px flex-shrink-0 p-6">
                                    <!--begin::Icon-->
                                    <!--begin::Svg Icon | path: icons/duotune/coding/cod004.svg-->
                                    <span class="svg-icon svg-icon-2tx svg-icon-primary me-4">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.3" d="M19.0687 17.9688H11.0687C10.4687 17.9688 10.0687 18.3687 10.0687 18.9688V19.9688C10.0687 20.5687 10.4687 20.9688 11.0687 20.9688H19.0687C19.6687 20.9688 20.0687 20.5687 20.0687 19.9688V18.9688C20.0687 18.3687 19.6687 17.9688 19.0687 17.9688Z" fill="currentColor" />
                                            <path d="M4.06875 17.9688C3.86875 17.9688 3.66874 17.8688 3.46874 17.7688C2.96874 17.4688 2.86875 16.8688 3.16875 16.3688L6.76874 10.9688L3.16875 5.56876C2.86875 5.06876 2.96874 4.46873 3.46874 4.16873C3.96874 3.86873 4.56875 3.96878 4.86875 4.46878L8.86875 10.4688C9.06875 10.7688 9.06875 11.2688 8.86875 11.5688L4.86875 17.5688C4.66875 17.7688 4.36875 17.9688 4.06875 17.9688Z" fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                    <!--end::Icon-->
                                    <!--begin::Wrapper-->
                                    <div class="d-flex flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
                                        <!--begin::Content-->
                                        <div class="mb-3 mb-md-0 fw-semibold">
                                            <h4 class="text-gray-900 fw-bold">حتى تتمكن من إنهاء المهمة يجب عليك </h4>
                                            <div class="fs-6 text-gray-700 pe-7">
                                            رفع ملف العرض المالي
                                            </div>
                                        </div>
                                        <!--end::Content-->
                                        <!--begin::Action-->
                                        <button type="submit" id="auditor-hand-offer-task-btn" class="btn btn-warning">إنهاء وتسليم المهمة</button>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('partials.obstacle._obstacle')
</div>
@stop

@section('scripts')
<script src="{{ asset('assets/js/custom/loading-page.js') }}"></script>
<script src="{{ asset('assets/js/custom/backoffice/admin.js') }}"></script>
<script src="{{ asset('assets/js/custom/backoffice/fieldwork.js') }}"></script>

<script>
    var $project_id = $('#project_id');
    var $finance = $('#finance');
    var image = '{{ URL::asset('assets/media/svg/files/pdf.svg') }}';

    new Dropzone("#finance_file", {
        url: projectBaseUrl + '/finance/upload-finance-file', // Set the url for your upload script location
        method: "post",
        paramName: "file", // The name that will be used to transfer the file
        maxFiles: 1,
        maxFilesize: 10, // MB
        addRemoveLinks: true,
        acceptedFiles: "application/pdf",
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
        init: function() {
            if ($finance.val()) {
                mockFile = {
                    name: projectBaseUrl + '/storage/' + $finance.val(),
                    id: 320212,
                    size: 452810,
                    accepted: true,
                    dataURL: image,
                    oldFile: $finance.val()
                };
                this.displayExistingFile(mockFile, mockFile.dataURL);
                this.files.push(mockFile);
            }
            this.on("removedfile", function(file) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: projectBaseUrl+'/finance/remove-finance-file',
                    dataType: "json",
                    data: {
                        'project_id': $project_id.val()
                    },
                });
            });
        }
    });
</script>
@stop
