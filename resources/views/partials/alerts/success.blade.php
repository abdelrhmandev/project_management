@if(Session::has('success'))
<div class="alert alert-dismissible bg-light-primary d-flex flex-column flex-sm-row p-5 mb-10">
        <!--begin::Icon--> <span class="svg-icon svg-icon-2hx svg-icon-primary me-4 mb-5 mb-sm-0">...</span>
        <!--end::Icon-->
        <!--begin::Wrapper-->
        <div class="d-flex flex-column pe-0 pe-sm-10">
            <!--begin::Title-->
            <!--end::Title-->
            <!--begin::Content--> <span>{{Session::get('success')}}</span>
            <!--end::Content-->
        </div>
        <!--end::Wrapper-->
        <!--begin::Close--> <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert"> <span class="svg-icon svg-icon-1 svg-icon-primary">...</span> </button>
        <!--end::Close-->
    </div>
@endif
