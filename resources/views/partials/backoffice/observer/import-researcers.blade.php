<div class="col-lg-6 col-xl-3 mb-8" id="import_researcherDiv">
    <!--begin::Contacts-->
    <div class="card card-flush">
        <!--begin::Card body-->
        <div class="card-body pt-5" id="kt_contacts_list_body">
            <!--begin::List-->
            <form method="post" id="import-researchers-form" enctype="multipart/form-data" data-route-url="{{ url('observer/import-researchers') }}">
                @csrf
                <input type="hidden" id="url" value="{{ url('observer/get-researchers/'.$project_id)}}"/>
                <input type="hidden" name="import_superior_id" id="import_superior_id" />
                <input type="hidden" name="import_project_id" id="import_project_id" value="{{ $project_id }}" />
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-dark">إستيراد الباحثين التابعين</span>
                </h3>
                <!--begin::Option-->
                <div class="fv-row mb-8">
                    <label class="required mb-2" style="color:#BFBFBF;font-size:11px;">اختر ملف اكسل للاستيراد</label>
                    <span class="excelFile form-control form-control-solid" style="display:block;padding:12px;font-size:11px;color:#ccc;cursor:pointer;">اختر الملف</span>
                    <input type="file" accept=".xlsx" class="form-control form-control-solid" name="imported_researchers" id="imported_researchers" style="opacity:0;visibility:hidden;" />
                </div>
                <!--begin::Row-->
                <button type="button" class="btn btn-primary" id="kt_import_researcher_list" style="float:left;">
                    <!--begin::Indicator label-->
                    <span class="indicator-label">رفع الملف</span>
                    <!--end::Indicator label-->
                    <!--begin::Indicator progress-->
                    <span class="indicator-progress">{{ __('site.please_wait') }}..
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    <!--end::Indicator progress-->
                </button>
                <br clear="all">
            </form>
            <p><div id="invalid_id_numbers"></div></p>
            <!--end::List-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Contacts-->
</div>
