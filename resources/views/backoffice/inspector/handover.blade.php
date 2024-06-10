@extends('layouts.app')

@section('content')
<div id="kt_content_container" class="container-xxl">
    <!--begin::Layout-->
    <div class="d-flex flex-column flex-xl-row">
        <!--begin::Sidebar-->
        @include('partials.backoffice.sidebar-project')
        <!--end::Sidebar-->

        <!--begin::Content-->
        <div class="flex-lg-row-fluid ms-lg-15">
            <div class="tab-content" id="myTabContent">
                <!--begin::Content-->
                <div class="tab-pane fade show active">
                    <form class="form" action="{{ route('inspector.handoverTask')}}" enctype="multipart/form-data" novalidate="novalidate" method="post">
                        @csrf
                        @method('PATCH')
                        <div class="row g-5 g-xl-8">
                            <!--begin::general equipment-->
                            @if($project_equipments->where('equipment_type', 1)->count() > 0)
                            <div class="col-lg-6 col-xl-6">
                                <!--begin::Contacts-->
                                <div class="card" id="kt_contacts_list">
                                    <!--begin::Card header-->
                                    <div class="card-header pt-7" id="kt_contacts_list_header">
                                        <a href="#" class="text-gray-900 fs-2 fw-bold me-1">التجهيزات العامة</a>
                                    </div>
                                    <!--end::Card header-->
                                    <!--begin::Card body-->
                                    <div class="card-body" id="researcherlist">
                                        <!--begin::List-->
                                        <div class="scroll-y me-n5 pe-5 h-600px h-xl-auto" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_header, #kt_toolbar, #kt_footer, #kt_contacts_list_header" data-kt-scroll-wrappers="#kt_content, #kt_contacts_list_body" data-kt-scroll-stretch="#kt_contacts_list, #kt_contacts_main" data-kt-scroll-offset="5px">
                                            @foreach($project_equipments->where('equipment_type', 1) as $project_equipment)
                                            <div class="mb-2">
                                                <label id="mylist" class="rounded d-flex flex-stack bg-active-lighten btn btn-outline btn-outline-dashed btn-active-light-primary d-flex align-items-center" for="kt_select_researcher . {{ $project_equipment->equipment_id }}">
                                                    <div class="d-flex align-items-center">
                                                        <div class="ms-4">
                                                            <input type="checkbox" class="form-check-input me-1" name="equipment_id[]" value="{{ $project_equipment->equipment_id }}" id="kt_select_researcher . {{ $project_equipment->equipment_id }}" {{ $project_equipment->return_equipment_receipt == 1? 'checked' : ''}} />
                                                            <span class="fs-6 fw-bold text-gray-900">{{ $project_equipment->title }}</span>
                                                            <div class="fw-semibold fs-7 text-muted text-start">{{ $project_equipment->price }} SAR</div>
                                                        </div>
                                                    </div>
                                                    <div class="fw-semibold text-muted align-items-end mt-5">
                                                        @if($project_equipment->return_equipment_receipt == 1)
                                                        <span class="w-100px badge badge-light-success">المطلوب إرجاعه {{ $project_equipment->qty }}</span>
                                                        @else
                                                        <span class="w-100px badge badge-light-warning">المطلوب إرجاعه {{ $project_equipment->qty }}</span>
                                                        @endif
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="separator separator-dashed d-none mt-4"></div>
                                            @endforeach
                                        </div>
                                        <!--end::List-->
                                        @include('backoffice.equipment.project_equipments_files',['equipment_type'=>1])
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Contacts-->
                            </div>
                            @endif
                            <!--end::general equipment-->

                            <input type="hidden" name="project_id" id="project_id" value="{{ $row->id }}" />
                            <div class="text-center mt-8">
                                <a href="#" class="btn btn-primary me-3" id="kt_save_general_equipment_handover" data-bs-toggle="tooltip" data-bs-dismiss="click" data-bs-trigger="hover">حفظ التغييرات فقط</a>
                                <button type="submit" id="kt_edit_project_submit" class="btn btn-danger me-3">إنهاء وتسليم المهمة</button>
                                <button type="reset" id="kt_cancel_inspector_handover" class="btn btn-secondary me-3">إلغاء</button>
                            </div>
                        </div>
                    </form>
                    <!--end::Content-->
                </div>
            </div>
            <!--end::Content-->
        </div>
        <!--end::Layout-->
    </div>
</div>
@stop

@section('scripts')
<script src="{{ asset('assets/js/custom/backoffice/equipment.js')}}"></script>
<script src="{{ asset('assets/plugins/custom/fslightbox/fslightbox.bundle.js') }}"></script>
<script>
    "use strict";
    KTUtil.onDOMContentLoaded(function() {
        new Dropzone("#kt_project_equipments_files_1", {
            url: "{{ route('UploadProjectEquipmentFile') }}", // Set the url for your upload script location
            method: "post",
            maxFiles: 10,
            maxFilesize: 10, // MB
            addRemoveLinks: true,
            acceptedFiles: "application/pdf,image/*",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            init: function() {
                this.on("sending", function(file, xhr, formData) {
                    formData.append("equipment_type", 1);
                    formData.append("project_id", $('#project_id').val());
                });
            },
            accept: function(file, done) {
                if (file.name == "wow.jpg") {
                    done("Naha, you don't.");
                } else {
                    done();
                }
            }
        });
        
        $(document).on("click", "#kt_cancel_inspector_handover", function() {
            window.location.href = projectBaseUrl+'/inspector/handover/projects'; // make request
        });
    });

    function deleteProjectEquipmentFile(file, projectId, eqType) {
        Swal.fire({
            text: "{{ __('site.confirmMultiDeleteMessage') }}" + "؟",
            icon: "warning",
            showCancelButton: true,
            buttonsStyling: false,
            showLoaderOnConfirm: true,
            confirmButtonText: "{{ __('site.confirmButtonText') }}",
            cancelButtonText: "{{ __('site.cancelButtonText') }}",
            customClass: {
                confirmButton: "btn fw-bold btn-danger",
                cancelButton: "btn fw-bold btn-active-light-primary"
            },
        }).then(function(result) {
            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('RemoveProjectEquipmentFile')}}",
                data: {
                    '_method': 'delete',
                    'file': file,
                    'projectId': projectId,
                    'eqType': eqType,
                },
                success: function(response, textStatus, xhr) {
                    if (result.value) {
                        $("[data-file='" + file + "']").hide(500);
                        Swal.fire({
                            text: "{{ __('site.deletingselecteditem') }}",
                            icon: "info",
                            buttonsStyling: false,
                            showConfirmButton: false,
                            timer: 2000
                        }).then(function() {
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
                                // dt.draw();
                            });
                            //location.reload();
                        });
                    } else if (result.dismiss === 'cancel') {
                        Swal.fire({
                            text: "{{ __('site.notdeletedMessage') }}",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "{{ __('site.confirmButtonTextGotit') }}",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary",
                            }
                        });
                    }
                }
            });
        });
    }
</script>
@stop