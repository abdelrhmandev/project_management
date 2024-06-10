<!--begin::Modal - Genderal Equipment-->
<div class="modal fade" id="kt_modal_general_equipment" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-1000px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <div class="text-center">
                    <h1 class="text-success">التجهيزات العامة</h1>
                </div>
                <!--begin::Close-->
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                    <span class="svg-icon svg-icon-1">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
                <!--end::Close-->
            </div>
            <!--begin::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y pt-0">
                <div id="kt_modal_general_equipment_handler" data-kt-search-keypress="true" data-kt-search-min-length="2" data-kt-search-enter="enter" data-kt-search-layout="inline">
                    <div class="">
                        <form class="form" method="post" action="{{ url('operation/create') }}" novalidate="novalidate">
                            @csrf
                            <input type="hidden" name="project_id" id="project_id" value="{{ $row->id }}" />
                            <input type="hidden" name="equipment_type" id="equipment_type" value="1" />

                            <div class="modal-body scroll-y">
                                <!--begin::Results(add d-none to below element to hide the users list by default)-->
                                <div data-kt-search-element="results">
                                    <!--begin::Users-->
                                    <div class="mh-375px scroll-y me-n7 pe-2">
                                        @include('partials.backoffice.equipment.equipments_modal_header')
                                        @foreach ($selected_equipments as $selected_equipment)
                                        @if ($equipments->where('id', $selected_equipment->equipment_id)->first()->type_id == 1)
                                        <!--begin::User-->
                                        <div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="0">
                                            <!--begin::Details-->
                                            <div class="d-flex align-items-center">
                                                <!--begin::Checkbox-->
                                                <label class="form-check form-check-custom form-check-solid me-5">
                                                    <input checked id="{{ $selected_equipment->equipment_id }}" class="form-check-input" onclick="disable_option({{ $selected_equipment->equipment_id }},{{ $selected_equipment->equipment_type }},'selected')" type="checkbox" name="selected-equipment-checkbox[]" value="{{ $selected_equipment->equipment_id }}" />
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Details-->
                                                <div class="ms-5">
                                                    <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">{{ $equipments->where('id', $selected_equipment->equipment_id)->first()->title }}</a>
                                                </div>
                                                <!--end::Details-->
                                            </div>
                                            <!--end::Details-->
                                            <!--begin::Access menu-->
                                            <div class="ms-2">
                                                <input type="text" onkeypress="return isNumberKey(event)" class="form-control" id="selected-equipment-price-{{ $selected_equipment->equipment_type }}-{{ $selected_equipment->equipment_id }}" name="selected-equipment-price[{{ $selected_equipment->equipment_id }}]" value="{{ $selected_equipment->price }}" />
                                            </div>
                                            <div class="ms-2">
                                                <input type="text" onkeypress="return isNumberKey(event)" class="form-control" id="selected-equipment-qty-{{ $selected_equipment->equipment_type }}-{{ $selected_equipment->equipment_id }}" name="selected-equipment-qty[{{ $selected_equipment->equipment_id }}]" value="{{ $selected_equipment->qty }}" />
                                            </div>
                                            <!--end::Access menu-->
                                        </div>
                                        <!--end::User-->
                                        <!--begin::Separator-->
                                        <div class="border-bottom border-gray-300 border-bottom-dashed">
                                        </div>
                                        <!--end::Separator-->
                                        @endif
                                        @endforeach

                                        @foreach ($remaining_equipments->where('type_id', 1) as $equipment)
                                        <!--begin::User-->
                                        <div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="0">
                                            <!--begin::Details-->
                                            <div class="d-flex align-items-center">
                                                <!--begin::Checkbox-->
                                                <label class="form-check form-check-custom form-check-solid me-5">
                                                    <input id="{{ $equipment->id }}" class="form-check-input" type="checkbox" onclick="disable_option({{ $equipment->id }},{{ $equipment->type_id }},'remaining')" name="equipment-checkbox[]" value="{{ $equipment->id }}" data-kt-check="true" data-kt-check-target="[data-user-id='{{ $equipment->id }}']" />
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Details-->
                                                <div class="ms-5">
                                                    <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary">{{ $equipment->title }}</a>
                                                </div>
                                                <!--end::Details-->
                                            </div>
                                            <!--end::Details-->
                                            <!--begin::Access menu-->
                                            <div class="ms-2">
                                                <input type="text" disabled onkeypress="return isNumberKey(event)" class="form-control" id="remaining-equipment-price-{{ $equipment->type_id }}-{{ $equipment->id }}" name="equipment-price[{{ $equipment->id }}]" placeholder="0" />
                                            </div>
                                            <div class="ms-2">
                                                <input type="text" disabled onkeypress="return isNumberKey(event)" class="form-control" id="remaining-equipment-qty-{{ $equipment->type_id }}-{{ $equipment->id }}" name="equipment-qty[{{ $equipment->id }}]" placeholder="0" />
                                            </div>
                                            <!--end::Access menu-->
                                        </div>
                                        <!--end::User-->
                                        <!--begin::Separator-->
                                        <div class="border-bottom border-gray-300 border-bottom-dashed"></div>
                                        <!--end::Separator-->
                                        @endforeach
                                    </div>
                                    <!--end::Users-->
                                </div>
                                <!--end::Results-->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                                <button type="submit" id="save-equipments" class="btn btn-primary">حفظ التغييرات</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modals-->

<div class="modal fade" id="kt_modal_training_equipment" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-1000px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <div class="text-center">
                    <h1 class="text-info">تجهيزات قسم التدريب</h1>
                </div>
                <!--begin::Close-->
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                    <span class="svg-icon svg-icon-1">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
                <!--end::Close-->
            </div>
            <!--begin::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y pt-0">
                <div id="kt_modal_training_equipment_handler" data-kt-search-keypress="true" data-kt-search-min-length="2" data-kt-search-enter="enter" data-kt-search-layout="inline">

                    <form class="form" action="{{ url('operation/create') }}" novalidate="novalidate" method="post">
                        @csrf
                        <input type="hidden" name="project_id" id="project_id" value="{{ $row->id }}" />
                        <input type="hidden" name="equipment_type" id="equipment_type" value="2" />

                        <div class="modal-body scroll-y">
                            <!--begin::Results(add d-none to below element to hide the users list by default)-->
                            <div data-kt-search-element="results">
                                <!--begin::Users-->
                                <div class="mh-375px scroll-y me-n7 pe-7">
                                    @include('partials.backoffice.equipment.equipments_modal_header')

                                    @foreach ($selected_equipments as $selected_equipment)
                                    @if ($equipments->where('id', $selected_equipment->equipment_id)->first()->type_id == 2)
                                    <!--begin::User-->
                                    <div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="0">
                                        <!--begin::Details-->
                                        <div class="d-flex align-items-center">
                                            <!--begin::Checkbox-->
                                            <label class="form-check form-check-custom form-check-solid me-5">
                                                <input checked id="{{ $selected_equipment->equipment_id }}" class="form-check-input" onclick="disable_option({{ $selected_equipment->equipment_id }},{{ $selected_equipment->equipment_type }},'selected')" type="checkbox" name="selected-equipment-checkbox[]" value="{{ $selected_equipment->equipment_id }}" />
                                            </label>
                                            <!--end::Checkbox-->
                                            <!--begin::Details-->
                                            <div class="ms-5">
                                                <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">{{ $equipments->where('id', $selected_equipment->equipment_id)->first()->title }}</a>
                                            </div>
                                            <!--end::Details-->
                                        </div>
                                        <!--end::Details-->
                                        <!--begin::Access menu-->
                                        <div class="ms-2">
                                            <input type="text" onkeypress="return isNumberKey(event)" class="form-control" id="selected-equipment-price-{{ $selected_equipment->equipment_type }}-{{ $selected_equipment->equipment_id }}" name="selected-equipment-price[{{ $selected_equipment->equipment_id }}]" value="{{ $selected_equipment->price }}" />
                                        </div>
                                        <div class="ms-2">
                                            <input type="text" onkeypress="return isNumberKey(event)" class="form-control" id="selected-equipment-qty-{{ $selected_equipment->equipment_type }}-{{ $selected_equipment->equipment_id }}" name="selected-equipment-qty[{{ $selected_equipment->equipment_id }}]" value="{{ $selected_equipment->qty }}" />
                                        </div>
                                        <!--end::Access menu-->
                                    </div>
                                    <!--end::User-->
                                    <!--begin::Separator-->
                                    <div class="border-bottom border-gray-300 border-bottom-dashed">
                                    </div>
                                    <!--end::Separator-->
                                    @endif
                                    @endforeach

                                    @foreach ($remaining_equipments->where('type_id', 2) as $equipment)
                                    <!--begin::User-->
                                    <div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="0">
                                        <!--begin::Details-->
                                        <div class="d-flex align-items-center">
                                            <!--begin::Checkbox-->
                                            <label class="form-check form-check-custom form-check-solid me-5">
                                                <input id="{{ $equipment->id }}" class="form-check-input" type="checkbox" onclick="disable_option({{ $equipment->id }},{{ $equipment->type_id }},'remaining')" name="equipment-checkbox[]" value="{{ $equipment->id }}" data-kt-check="true" data-kt-check-target="[data-user-id='{{ $equipment->id }}']" />
                                            </label>
                                            <!--end::Checkbox-->
                                            <!--begin::Details-->
                                            <div class="ms-5">
                                                <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">{{ $equipment->title }}</a>

                                            </div>
                                            <!--end::Details-->
                                        </div>
                                        <!--end::Details-->
                                        <!--begin::Access menu-->
                                        <div class="ms-2">
                                            <input type="text" disabled onkeypress="return isNumberKey(event)" class="form-control" id="remaining-equipment-price-{{ $equipment->type_id }}-{{ $equipment->id }}" name="equipment-price[{{ $equipment->id }}]" placeholder="0" />
                                        </div>
                                        <div class="ms-2">
                                            <input type="text" disabled onkeypress="return isNumberKey(event)" class="form-control" id="remaining-equipment-qty-{{ $equipment->type_id }}-{{ $equipment->id }}" name="equipment-qty[{{ $equipment->id }}]" placeholder="0" />
                                        </div>
                                        <!--end::Access menu-->
                                    </div>
                                    <!--end::User-->
                                    <!--begin::Separator-->
                                    <div class="border-bottom border-gray-300 border-bottom-dashed"></div>
                                    <!--end::Separator-->
                                    @endforeach
                                </div>
                                <!--end::Users-->
                            </div>
                            <!--end::Results-->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                            <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                        </div>
                    </form>
                </div>
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modals-->

<div class="modal fade" id="kt_modal_opening_equipment" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-1000px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <div class="text-center">
                    <h1 class="text-warning">تجهيزات إفتتاح/إغلاق مشروع</h1>
                </div>
                <!--begin::Close-->
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                    <span class="svg-icon svg-icon-1">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
                <!--end::Close-->
            </div>
            <!--begin::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y pt-0">
                <div id="kt_modal_opening_equipment_handler" data-kt-search-keypress="true" data-kt-search-min-length="2" data-kt-search-enter="enter" data-kt-search-layout="inline">
                    <form class="form" action="{{ url('operation/create') }}" novalidate="novalidate" method="post">
                        @csrf
                        <input type="hidden" name="project_id" id="project_id" value="{{ $row->id }}" />
                        <input type="hidden" name="equipment_type" id="equipment_type" value="3" />

                        <div class="modal-body scroll-y">
                            <!--begin::Results(add d-none to below element to hide the users list by default)-->
                            <div data-kt-search-element="results">
                                <!--begin::Users-->
                                <div class="mh-375px scroll-y me-n7 pe-7">
                                    @include('partials.backoffice.equipment.equipments_modal_header')

                                    @foreach ($selected_equipments as $selected_equipment)
                                    @if ($equipments->where('id', $selected_equipment->equipment_id)->first()->type_id == 3)
                                    <!--begin::User-->
                                    <div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="0">
                                        <!--begin::Details-->
                                        <div class="d-flex align-items-center">
                                            <!--begin::Checkbox-->
                                            <label class="form-check form-check-custom form-check-solid me-5">
                                                <input checked id="{{ $selected_equipment->equipment_id }}" class="form-check-input" onclick="disable_option({{ $selected_equipment->equipment_id }},{{ $selected_equipment->equipment_type }},'selected')" type="checkbox" name="selected-equipment-checkbox[]" value="{{ $selected_equipment->equipment_id }}" />
                                            </label>
                                            <!--end::Checkbox-->
                                            <!--begin::Details-->
                                            <div class="ms-5">
                                                <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">{{ $equipments->where('id', $selected_equipment->equipment_id)->first()->title }}</a>
                                            </div>
                                            <!--end::Details-->
                                        </div>
                                        <!--end::Details-->
                                        <!--begin::Access menu-->
                                        <div class="ms-2">
                                            <input type="text" onkeypress="return isNumberKey(event)" class="form-control" id="selected-equipment-price-{{ $selected_equipment->equipment_type }}-{{ $selected_equipment->equipment_id }}" name="selected-equipment-price[{{ $selected_equipment->equipment_id }}]" value="{{ $selected_equipment->price }}" />
                                        </div>
                                        <div class="ms-2">
                                            <input type="text" onkeypress="return isNumberKey(event)" class="form-control" id="selected-equipment-qty-{{ $selected_equipment->equipment_type }}-{{ $selected_equipment->equipment_id }}" name="selected-equipment-qty[{{ $selected_equipment->equipment_id }}]" value="{{ $selected_equipment->qty }}" />
                                        </div>
                                        <!--end::Access menu-->
                                    </div>
                                    <!--end::User-->
                                    <!--begin::Separator-->
                                    <div class="border-bottom border-gray-300 border-bottom-dashed">
                                    </div>
                                    <!--end::Separator-->
                                    @endif
                                    @endforeach

                                    @foreach ($remaining_equipments->where('type_id', 3) as $equipment)
                                    <!--begin::User-->
                                    <div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="0">
                                        <!--begin::Details-->
                                        <div class="d-flex align-items-center">
                                            <!--begin::Checkbox-->
                                            <label class="form-check form-check-custom form-check-solid me-5">
                                                <input id="{{ $equipment->id }}" class="form-check-input" type="checkbox" onclick="disable_option({{ $equipment->id }},{{ $equipment->type_id }},'remaining')" name="equipment-checkbox[]" value="{{ $equipment->id }}" data-kt-check="true" data-kt-check-target="[data-user-id='{{ $equipment->id }}']" />
                                            </label>
                                            <!--end::Checkbox-->
                                            <!--begin::Details-->
                                            <div class="ms-5">
                                                <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">{{ $equipment->title }}</a>
                                            </div>
                                            <!--end::Details-->
                                        </div>
                                        <!--end::Details-->
                                        <!--begin::Access menu-->
                                        <div class="ms-2">
                                            <input type="text" disabled onkeypress="return isNumberKey(event)" class="form-control" id="remaining-equipment-price-{{ $equipment->type_id }}-{{ $equipment->id }}" name="equipment-price[{{ $equipment->id }}]" placeholder="0" />
                                        </div>
                                        <div class="ms-2">
                                            <input type="text" disabled onkeypress="return isNumberKey(event)" class="form-control" id="remaining-equipment-qty-{{ $equipment->type_id }}-{{ $equipment->id }}" name="equipment-qty[{{ $equipment->id }}]" placeholder="0" />
                                        </div>
                                        <!--end::Access menu-->
                                    </div>
                                    <!--end::User-->
                                    <!--begin::Separator-->
                                    <div class="border-bottom border-gray-300 border-bottom-dashed"></div>
                                    <!--end::Separator-->
                                    @endforeach
                                </div>
                                <!--end::Users-->
                            </div>
                            <!--end::Results-->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                            <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                        </div>
                    </form>
                </div>
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modals-->

<div class="modal fade" id="kt_modal_auditing_equipment" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-1000px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <div class="text-center">
                    <h1 class="text-primary">تجهيزات قسم التدقيق</h1>
                </div>
                <!--begin::Close-->
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                    <span class="svg-icon svg-icon-1">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
                <!--end::Close-->
            </div>
            <!--begin::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y pt-0">
                <div id="kt_modal_auditing_equipment_handler" data-kt-search-keypress="true" data-kt-search-min-length="2" data-kt-search-enter="enter" data-kt-search-layout="inline">
                    <form class="form" action="{{ url('operation/create') }}" novalidate="novalidate" method="post">
                        @csrf
                        <input type="hidden" name="project_id" id="project_id" value="{{ $row->id }}" />
                        <input type="hidden" name="equipment_type" id="equipment_type" value="4" />

                        <div class="modal-body scroll-y">
                            <!--begin::Results(add d-none to below element to hide the users list by default)-->
                            <div data-kt-search-element="results">
                                <!--begin::Users-->
                                <div class="mh-375px scroll-y me-n7 pe-7">
                                    @include('partials.backoffice.equipment.equipments_modal_header')

                                    @foreach ($selected_equipments as $selected_equipment)
                                    @if ($equipments->where('id', $selected_equipment->equipment_id)->first()->type_id == 4)
                                    <!--begin::User-->
                                    <div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="0">
                                        <!--begin::Details-->
                                        <div class="d-flex align-items-center">
                                            <!--begin::Checkbox-->
                                            <label class="form-check form-check-custom form-check-solid me-5">
                                                <input checked id="{{ $selected_equipment->equipment_id }}" class="form-check-input" onclick="disable_option({{ $selected_equipment->equipment_id }},{{ $selected_equipment->equipment_type }},'selected')" type="checkbox" name="selected-equipment-checkbox[]" value="{{ $selected_equipment->equipment_id }}" />
                                            </label>
                                            <!--end::Checkbox-->
                                            <!--begin::Details-->
                                            <div class="ms-5">
                                                <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">{{ $equipments->where('id', $selected_equipment->equipment_id)->first()->title }}</a>
                                                <div class="fw-semibold text-muted">
                                                    {{ $selected_equipment->title }}
                                                </div>
                                            </div>
                                            <!--end::Details-->
                                        </div>
                                        <!--end::Details-->
                                        <!--begin::Access menu-->
                                        <div class="ms-2">
                                            <input type="text" onkeypress="return isNumberKey(event)" class="form-control" id="selected-equipment-price-{{ $selected_equipment->equipment_type }}-{{ $selected_equipment->equipment_id }}" name="selected-equipment-price[{{ $selected_equipment->equipment_id }}]" value="{{ $selected_equipment->price }}" />
                                        </div>
                                        <div class="ms-2">
                                            <input type="text" onkeypress="return isNumberKey(event)" class="form-control" id="selected-equipment-qty-{{ $selected_equipment->equipment_type }}-{{ $selected_equipment->equipment_id }}" name="selected-equipment-qty[{{ $selected_equipment->equipment_id }}]" value="{{ $selected_equipment->qty }}" />
                                        </div>
                                        <!--end::Access menu-->
                                    </div>
                                    <!--end::User-->
                                    <!--begin::Separator-->
                                    <div class="border-bottom border-gray-300 border-bottom-dashed">
                                    </div>
                                    <!--end::Separator-->
                                    @endif
                                    @endforeach

                                    @foreach ($remaining_equipments->where('type_id', 4) as $equipment)
                                    <!--begin::User-->
                                    <div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="0">
                                        <!--begin::Details-->
                                        <div class="d-flex align-items-center">
                                            <!--begin::Checkbox-->
                                            <label class="form-check form-check-custom form-check-solid me-5">
                                                <input id="{{ $equipment->id }}" class="form-check-input" type="checkbox" onclick="disable_option({{ $equipment->id }},{{ $equipment->type_id }},'remaining')" name="equipment-checkbox[]" value="{{ $equipment->id }}" data-kt-check="true" data-kt-check-target="[data-user-id='{{ $equipment->id }}']" />
                                            </label>
                                            <!--end::Checkbox-->
                                            <!--begin::Details-->
                                            <div class="ms-5">
                                                <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">{{ $equipment->title }}</a>
                                                <div class="fw-semibold text-muted">
                                                    {{ $equipment->title }}
                                                </div>
                                            </div>
                                            <!--end::Details-->
                                        </div>
                                        <!--end::Details-->
                                        <!--begin::Access menu-->
                                        <div class="ms-2">
                                            <input type="text" disabled onkeypress="return isNumberKey(event)" class="form-control" id="remaining-equipment-price-{{ $equipment->type_id }}-{{ $equipment->id }}" name="equipment-price[{{ $equipment->id }}]" placeholder="0" />
                                        </div>
                                        <div class="ms-2">
                                            <input type="text" disabled onkeypress="return isNumberKey(event)" class="form-control" id="remaining-equipment-qty-{{ $equipment->type_id }}-{{ $equipment->id }}" name="equipment-qty[{{ $equipment->id }}]" placeholder="0" />
                                        </div>
                                        <!--end::Access menu-->
                                    </div>
                                    <!--end::User-->
                                    <!--begin::Separator-->
                                    <div class="border-bottom border-gray-300 border-bottom-dashed"></div>
                                    <!--end::Separator-->
                                    @endforeach
                                </div>
                                <!--end::Users-->
                            </div>
                            <!--end::Results-->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                            <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                        </div>
                    </form>
                </div>
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modals-->