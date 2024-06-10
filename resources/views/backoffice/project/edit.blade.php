<div id="kt_modal_edit_project" class="modal fade" tabindex="-1">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-fullscreen p-9">
        <!--begin::Modal content-->
        <div class="modal-content modal-rounded">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2>{{ __('project.edit') }}
                    <span class="d-inline-block mb-2 text-primary" id="project_title"></span>
                </h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                    <span class="svg-icon svg-icon-1">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2"
                                rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                transform="rotate(45 7.41422 6)" fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y m-5">
                <!--begin::Stepper-->
                <div class="stepper stepper-links d-flex flex-column" id="kt_modal_edit_project_stepper">
                    <!--begin::Container-->
                    <div class="container">
                        <!--begin::Nav-->
                        <div class="stepper-nav justify-content-center py-2">
                            <!--begin::Step 1-->
                            <div class="stepper-item me-5 me-md-15 current" data-kt-stepper-element="nav">
                                <h3 class="stepper-title">{{ __('project.type') }}</h3>
                            </div>
                            <!--end::Step 1-->

                            <!--begin::Step 2-->
                            <div class="stepper-item me-5 me-md-15" data-kt-stepper-element="nav">
                                <h3 class="stepper-title">{{ __('project.inital-info') }}</h3>
                            </div>
                            <!--end::Step 2-->

                            <!--begin::Step 3-->
                            <div class="stepper-item me-5 me-md-15" data-kt-stepper-element="nav">
                                <h3 class="stepper-title">{{ __('project.notebook') }}</h3>
                            </div>
                            <!--end::Step 3-->

                            <!--begin::Step 4-->
                            <div class="stepper-item me-5 me-md-15" data-kt-stepper-element="nav">
                                <h3 class="stepper-title">{{ __('project.the_opening') }}</h3>
                            </div>
                            <!--end::Step 4-->

                            <!--begin::Step 5-->
                            <div class="stepper-item me-5 me-md-15" data-kt-stepper-element="nav">
                                <h3 class="stepper-title">{{ __('project.the_closing') }}</h3>
                            </div>
                            <!--end::Step 5-->

                            <!--begin::Step 6-->
                            <div class="stepper-item" data-kt-stepper-element="nav">
                                <h3 class="stepper-title">{{ __('project.completed') }}</h3>
                            </div>
                            <!--end::Step 6-->
                        </div>
                        <!--end::Nav-->
                        <!--begin::Form-->
                        <form method="post" class="mx-auto w-100 mw-600px pt-15 pb-10" data-route-url="{{ route('projects.updateModal')}}" enctype="multipart/form-data" novalidate="novalidate" id="kt_modal_edit_project_form">
                            <div class="current" data-kt-stepper-element="content">
                                <!--begin::Wrapper-->
                                <x-projects.edit.steps.1 :types="$types" />
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Type-->
                            <!--begin::Settings-->
                            <div data-kt-stepper-element="content">
                                <!--begin::Wrapper-->
                                <x-projects.edit.steps.2 :customers="$customers" :regions="$regions" />
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Settings-->
                            <!--begin::Team-->
                            <div data-kt-stepper-element="content">
                                <!--begin::Wrapper-->
                                <x-projects.edit.steps.3 />
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Team-->
                            <!--begin::Targets-->
                            <div data-kt-stepper-element="content">
                                <!--begin::Wrapper-->
                                <x-projects.edit.steps.4 />
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Targets-->
                            <!--begin::Files-->
                            <div data-kt-stepper-element="content">
                                <!--begin::Wrapper-->
                                <x-projects.edit.steps.5 />
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Files-->
                            <!--begin::Complete-->
                            <div data-kt-stepper-element="content">
                                <!--begin::Wrapper-->
                                <x-projects.edit.steps.6 />
                                <!--end::Wrapper-->
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--begin::Container-->
                </div>
                <!--end::Stepper-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
