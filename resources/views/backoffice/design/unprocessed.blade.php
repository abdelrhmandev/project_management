@extends('layouts.app')

@section('breadcrumbs')
<div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
    <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">الصور الغير معالجة
        <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
        <small class="text-muted fs-7 fw-semibold my-1 ms-1">{{ __('title_nav.dashboard') }}</small>
    </h1>
</div>
@stop

@section('style')
<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />
@stop

@section('content')
<div id="kt_content_container" class="container-xxl">
    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <div class="d-flex align-items-center position-relative my-1">
                    <span class="svg-icon svg-icon-1 position-absolute ms-6">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                            <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                        </svg>
                    </span>
                    <input type="text" data-kt-table-filter="search" class="form-control form-control-solid w-200px ps-15" placeholder="{{ __('site.search') }} ......" />
                </div>
            </div>

            <div class="card-toolbar">
                <div class="d-flex justify-content-end align-items-center d-none" data-kt-table-toolbar="selected">
                    <div class="fw-bold me-5">
                        <span class="me-2" data-kt-table-select="selected_count"></span>{{ __('customer.selected') }}
                    </div>
                    <button type="button" class="btn btn-danger" id="destroyMultipleroute" data-destroyMultiple-route="{{ route('admin.users.destroyMultipleUser') }}" data-kt-table-select="delete_selected">{{ __('customer.delete-selected') }}</button>
                </div>
            </div>
        </div>
        <div class="card-body pt-0">
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_datatable">
                <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th class="w-10px pe-2 noExport">
                            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_datatable .form-check-input" value="1" />
                            </div>
                        </th>
                        <th class="min-w-125px">{{ __('site.name')}}</th>
                        <th class="min-w-125px">{{ __('site.avatar')}} </th>
                        <th class="min-w-125px">{{ __('site.name')}} باللغه الأنجليزيه</th>
                        <th class="min-w-125px"></th>
                    </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600">
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="kt_modal_view_unprocessed_details" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content modal-rounded">
            <div class="modal-header py-7 d-flex justify-content-between">
                <h2>معالجه الصور</h2>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <span class="svg-icon svg-icon-1">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                        </svg>
                    </span>
                </div>
            </div>
            <div class="modal-body scroll-y m-5">
                <div class="stepper stepper-links d-flex flex-column" id="kt_modal_create_campaign_stepper">
                    <form enctype="multipart/form-data" data-route-url="{{ route('design.attractingTeamPost') }}" class="mx-auto w-100 mw-600px pt-0 pb-10" novalidate="novalidate" id="UpdateattractingteamForm">
                        <input type="hidden" name="id" id="id">
                        <div class="current" data-kt-stepper-element="content">
                            <div class="w-100">
                                <div class="mb-10 fv-row">
                                    <label class="required form-label mb-3">الإسم بالكامل باللغه العربيه</label>
                                    <input type="text" class="form-control form-control-lg form-control-solid" name="name" id="name" placeholder="" value="" />
                                </div>

                                <div class="fv-row mb-10">
                                    <div id="avatar_preview"></div>
                                    <label class="d-block fw-semibold fs-6 mb-5">
                                        <span class="required">الصورة</span>
                                    </label>

                                    <style>
                                        .image-input-placeholder {
                                            background-image: url({{ asset('assets/media/svg/files/blank-image.svg') }});
                                        }

                                        .image-input-placeholder {
                                            background-image: {
                                                {
                                                    asset('assets/media/svg/files/blank-image-dark.svg')
                                                }
                                            };
                                        }
                                    </style>
                                    <div class="image-input image-input-empty image-input-outline image-input-placeholder" data-kt-image-input="true">
                                        <div class="image-input-wrapper w-125px h-125px"></div>
                                        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="تغير الصورة">
                                            <i class="bi bi-pencil-fill fs-7"></i>
                                            <input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
                                            <input type="hidden" name="avatar_remove" />
                                        </label>
                                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="إلغاء الصورة">
                                            <i class="bi bi-x fs-2"></i>
                                        </span>
                                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="إلغاء الصورة">
                                            <i class="bi bi-x fs-2"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="mb-10 fv-row">
                                    <label class="required form-label mb-3">الأسم بالكامل باللغه الأنجليزيه</label>
                                    <input type="text" class="form-control form-control-lg form-control-solid" name="en_name" id="en_name" placeholder="" value="" /> <!--end::Input-->
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer flex-center">
                            <button type="button" id="saveFormbtn" onclick="return savedata('0')" name="save_case" value="only_save" class="btn btn-light-success">حفظ فقط</button>
                            <button type="button" id="saveFormbtn" name="save_case" onclick="return savedata('1')" value="save_and_deliver" class="btn btn-warning">حفظ و تسليم</button>
                            <button type="button" class="btn btn-bg-secondary" data-bs-dismiss="modal" aria-hidden="true">إلغاء</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('scripts')
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
@include('includes.datatables2')

<script>
    var dynamicColumns = [{
            data: 'id',
            name: 'id',
            exportable: false
        }, {
            data: 'name',
            name: 'name'
        }, {
            data: 'avatar',
            name: 'avatar'
        }, {
            data: 'en_name',
            name: 'en_name'
        }, {
            data: 'actions',
            name: 'actions'
        }
    ];

    KTUtil.onDOMContentLoaded(function() {
        loadDatatable('{{ route('unprocessed') }}', dynamicColumns);
    });

    function savedata(is_processed) {
        var form = document.getElementById('UpdateattractingteamForm');
        var validator = FormValidation.formValidation(
            form, {
                fields: {
                    'name': {
                        validators: {
                            notEmpty: {
                                message: 'برجاء أدخال الإسم بالكامل باللغه العربيه'
                            }
                        }
                    },
                    'en_name': {
                        validators: {
                            notEmpty: {
                                message: 'برجاء أدخال الأسم بالكامل باللغه الأنجليزيه'
                            }
                        }
                    },
                },

                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
                    })
                }
            }
        );
        if (validator) {
            validator.validate().then(function(status) {
                if (status == 'Valid') {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var formData = new FormData($('#UpdateattractingteamForm')[0]);
                    formData.append("is_processed", is_processed);
                    $.ajax({
                        method: "POST",
                        url: $('#UpdateattractingteamForm').data("route-url"),
                        data: formData,
                        dataType: "json",
                        cache: false,
                        contentType: false, //tell jquery to avoid some checks
                        processData: false,
                        success: function(response, textStatus, xhr) {
                            if (response['status'] == true) {
                                Swal.fire({
                                    text: response['msg'], // respose from controller
                                    icon: 'success',
                                    buttonsStyling: false,
                                    confirmButtonText: "حسنا موافق",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary",
                                    }
                                }).then(function(result) {
                                    document.location.href = '{{ route('unprocessed')}}';
                                });
                            } else if (response['status'] == false) {
                                let msgError = '';
                                $.each(response['msg'], function(key, value) {
                                    msgError += '<p>' + value + '</p>';
                                });
                                // manage response jquery
                                Swal.fire({
                                    html: msgError, // respose from controller
                                    icon: 'error',
                                    buttonsStyling: false,
                                    confirmButtonText: "حسنا موافق",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary",
                                    }
                                }).then(function(result) {
                                    document.location.href = '{{ route('processed')}}';
                                });
                            }
                        },
                        error: function(response, textStatus, xhr) {
                            Swal.fire({
                                text: errorMessages, // respose from controller
                                icon: 'error',
                                buttonsStyling: false,
                                confirmButtonText: "حسنا موافق",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary",
                                }
                            }).then(function(result) {
                                document.location.href = '{{ route('processed') }}';
                            });
                        },
                    });
                } else {
                    // Enable button
                    submitButton.disabled = false;
                    // Show popup warning. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                    Swal.fire({
                        text: "عذراً ، يبدو أنه تم اكتشاف بعض الأخطاء في أستكمال معالجه الصور ، يرجى المحاولة مرة أخرى.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "حسنا موافق",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }
            });
        }
    }

    // Supporter Modal
    function attractingTeamDetails(id) {
        $.ajax({
            type: 'GET',
            url: "{{ route('design.attractingTeamEdit') }}",
            data: {
                id: id
            },
            success: function(data) {
                $("#name").val(data.name);
                $("#en_name").val(data.en_name);
                $("#id").val(data.id);
                var dirstorage = '{{  asset('storage') }}';
                var avatar = data.avatar;
                $("#avatar_preview").html('<img src="' + avatar + '" class="w-25">');
            }
        });

        $("#kt_modal_view_unprocessed_details").modal('show');
    }
</script>
@stop