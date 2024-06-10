@extends('layouts.app')

@section('breadcrumbs')
<div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
   <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">إستيراد فريق العمل
      <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
      <small class="text-muted fs-7 fw-semibold my-1 ms-1">{{ __('title_nav.dashboard') }}</small>
   </h1>
</div>
@stop

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div id="kt_content_container" class="container-xxl">
        <div class="col-lg-12 mb-8" id="import_researcherDiv">
            <div class="card card-flush">
                <div class="card-body pt-5" id="kt_contacts_list_body">
                    <h3 class="mt-5 card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-danger"> يمكنك تحميل ملف فريف العمل التوضيحي </span>

                        <a href="{{ asset('assets/media/import_attracting_users_demo.xlsx') }}" download="">من هنا</a>
                    </h3>
                    <form class="mt-10" method="post" id="import-users-form" enctype="multipart/form-data" action="{{ url('admin/saveCsvFileattractingTeamForm') }}">
                        @csrf
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-dark">أستيراد فريق العمل</span>
                        </h3>
                        <div class="fv-row mb-8">
                            <label class="required mb-2" style="color:#BFBFBF;font-size:11px;">اختر ملف اكسل للاستيراد</label>
                            <span class="excelFile form-control form-control-solid" style="display:block;padding:12px;font-size:11px;color:#ccc;cursor:pointer;">اختر الملف</span>
                            <input required type="file" accept=".xlsx" class="form-control form-control-solid" name="imported_users" id="imported_users" style="opacity:0;visibility:hidden;" />
                        </div>
                        <button type="submit" class="btn btn-primary" id="kt_import_users_list" style="float:left;">
                            <span class="indicator-label">رفع الملف</span>
                        </button>
                        <br clear="all">
                    </form>
                    <p><div id="invalid_id_numbers"></div></p>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('scripts')
<script>
    $("span.excelFile").on("click", function () {
        $("input#imported_users").click();
    });

    $("input#imported_users").on("change", function () {
        $("span.excelFile").text($(this).val());
    });
</script>
@stop
