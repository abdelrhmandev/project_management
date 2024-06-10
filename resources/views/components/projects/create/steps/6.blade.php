<div class="w-100">
   <div class="pb-12 text-center">
      <div class="card-toolbar">


         
         <div class="fv-row mb-10">
            <!--begin::Label-->

            <!--End::Label-->
            <!--begin::Row-->
            <div class="row" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button='true']">
               <!--begin::Col-->
               <div class="col">
                  <!--begin::Option-->
                  <label class="btn btn-outline btn-outline-dashed btn-active-light-primary active d-flex text-start p-6" data-kt-button="true">
                     <!--begin::Radio-->
                     <span class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                        <input class="form-check-input" type="radio" name="save" value="save" checked="checked" />
                     </span>
                     <!--end::Radio-->
                     <!--begin::Info-->
                     <span class="ms-5">
                        <span class="fs-4 fw-bold text-gray-800 d-block">{{ __('project.submit') }}</span>
                     </span>
                     <!--end::Info-->
                  </label>
                  <!--end::Option-->
               </div>


               <div class="col">
                  <!--begin::Option-->
                  <label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6" data-kt-button="true">
                     <!--begin::Radio-->
                     <span class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                        <input class="form-check-input" type="radio" name="save" value="save_only" />
                     </span>
                     <!--end::Radio-->
                     <!--begin::Info-->
                     <span class="ms-5">
                        <span class="fs-4 fw-bold text-gray-800 d-block">{{ __('site.only_save') }}</span>
                     </span>
                     <!--end::Info-->
                  </label>
                  <!--end::Option-->
               </div>
               <!--end::Col-->
               <!--begin::Col-->
               <!--end::Col-->
               <!--begin::Col-->
               
               <!--end::Col-->
            </div>
            <!--end::Row-->
         </div>

         <button type="button" id="kt_modal_create_project_btn" class="btn btn" style="background: #004A61; color:white">
            <span class="indicator-label">{{ __('site.send')}}</span>            
         </button> 


      </div>
   </div>
   <div class="text-center px-4">
      <img src="{{ asset('assets/media/illustrations/sketchy-1/project.svg')}}" alt="" class="mww-100 mh-350px" />
   </div>
</div>