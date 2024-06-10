<div class="w-100">
	<div class="fv-row mb-10">
		<!--begin::Label-->
		<label class="d-block fw-semibold fs-6 mb-5">
			<span class="required">{{ __('project.logo')}}</span>
			<i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="{{ __('project.logo')}}"></i>
		</label>
		<!--end::Label-->
		<!--begin::Image input placeholder-->
		<style>
			.image-input-placeholder {
				background-image: url({{ asset('assets/media/svg/files/blank-image.svg') }});
			}

			[data-theme="dark"] .image-input-placeholder {
				background-image: url('assets/media/svg/files/blank-image-dark.svg');
			}
		</style>
		<!--end::Image input placeholder-->
		<!--begin::Image input-->
		<div class="image-input image-input-empty image-input-outline image-input-placeholder" data-kt-image-input="true">
			<!--begin::Preview existing avatar-->
			<div class="image-input-wrapper w-125px h-125px"></div>
			<!--end::Preview existing avatar-->
			<!--begin::Label-->
			<label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="{{ __('project.change_logo')}}">
				<i class="bi bi-pencil-fill fs-7"></i>
				<!--begin::Inputs-->
				<input type="file" id="logo" name="logo" accept=".png, .jpg, .jpeg" />
				<input type="hidden" name="logo_remove" />
				<!--end::Inputs-->
			</label>
			<!--end::Label-->
			<!--begin::Cancel-->
			<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="{{ __('site.cancel')}}">
				<i class="bi bi-x fs-2"></i>
			</span>
			<!--end::Cancel-->
			<!--begin::Remove-->
			<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="{{ __('site.remove')}}">
				<i class="bi bi-x fs-2"></i>
			</span>
			<!--end::Remove-->
		</div>
		<!--end::Image input-->
		<!--begin::Hint-->
		<div class="form-text">{{ __('site.allowed_file')}} png, jpg, jpeg </div>
		<!--end::Hint-->
	</div>
	<div class="fv-row mb-8">
		<label class="required fs-6 fw-semibold mb-2">{{ __('project.rfp')}}</label>
		<input type="file" accept=".pdf" class="form-control form-control-solid" placeholder="{{ __('project.rfp')}}.." name="rfp" />
	</div>
	<div class="fv-row mb-8">
		<label class="required fs-6 fw-semibold mb-2">{{ __('project.requirements_specifications')}}</label>
		<input type="file" accept=".pdf" class="form-control form-control-solid" placeholder="{{ __('project.requirements_specifications')}}.." name="requirements_specifications" />
	</div>
	<div class="fv-row mb-8">
		<label class="fs-6 fw-semibold mb-2">{{ __('project.additional_questions')}}</label>
		<input type="file" accept=".pdf" class="form-control form-control-solid" placeholder="{{ __('project.additional_questions')}}.." name="additional_questions" />
	</div>
	<div class="fv-row mb-8" id="google_map">
		<label class="required fs-6 fw-semibold mb-2">{{ __('project.google_map')}}</label>
		<div id="goMaps"></div>
		<input type="file" accept=".kml, .kmz" class="form-control form-control-solid" placeholder="{{ __('project.google_map')}}.." name="google_map[]" id="gooMaps" multiple />
	</div>
	<div class="fv-row mb-8" id="research_survey">
		<label class="required fs-6 fw-semibold mb-2">{{ __('project.research_survey')}}</label>
		<input type="file" accept=".pdf" class="form-control form-control-solid" placeholder="{{ __('project.research_survey')}}.." name="research_survey" />
	</div>
	<div class="fv-row mb-8" id="charity_list">
		<label class="required fs-6 fw-semibold mb-2">{{ __('project.charity_list_file')}}</label>
		<input type="file" accept=".pdf" class="form-control form-control-solid" placeholder="{{ __('project.charity_list_file')}}.." name="charity_list" />
	</div>
	<div id="training_files">
		<div class="fv-row mb-8">
			<label class="required fs-6 fw-semibold mb-2">{{ __('project.training_agenda')}}</label>
			<input type="file" accept=".pdf" class="form-control form-control-solid" placeholder="{{ __('project.training_agenda')}}.." name="training_agenda" />
		</div>
		<div class="fv-row mb-8">
			<label class="required fs-6 fw-semibold mb-2">{{ __('project.trainee_list')}}</label>
			<input type="file" accept=".pdf" class="form-control form-control-solid" placeholder="{{ __('project.trainee_list')}}.." name="trainee_list" />
		</div>
	</div>
	<div class="d-flex flex-stack">
		<button type="button" class="btn btn-lg btn-light me-3" data-kt-element="attachment-previous">
			<span class="svg-icon svg-icon-muted svg-icon-2hx">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path opacity="0.5" d="M9.63433 11.4343L5.45001 7.25C5.0358 6.83579 5.0358 6.16421 5.45001 5.75C5.86423 5.33579 6.5358 5.33579 6.95001 5.75L12.4929 11.2929C12.8834 11.6834 12.8834 12.3166 12.4929 12.7071L6.95001 18.25C6.5358 18.6642 5.86423 18.6642 5.45001 18.25C5.0358 17.8358 5.0358 17.1642 5.45001 16.75L9.63433 12.5657C9.94675 12.2533 9.94675 11.7467 9.63433 11.4343Z" fill="currentColor"/>
					<path d="M15.6343 11.4343L11.45 7.25C11.0358 6.83579 11.0358 6.16421 11.45 5.75C11.8642 5.33579 12.5358 5.33579 12.95 5.75L18.4929 11.2929C18.8834 11.6834 18.8834 12.3166 18.4929 12.7071L12.95 18.25C12.5358 18.6642 11.8642 18.6642 11.45 18.25C11.0358 17.8358 11.0358 17.1642 11.45 16.75L15.6343 12.5657C15.9467 12.2533 15.9467 11.7467 15.6343 11.4343Z" fill="currentColor"/>
				</svg>
			</span>  {{ __('project.inital-info') }}</button>
		<button type="button" class="btn btn-lg btn-primary" data-kt-element="attachment-next">
			<span class="indicator-label">
				<span class="svg-icon svg-icon-muted svg-icon-2hx">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path opacity="0.5" d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z" fill="currentColor"/>
						<path d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z" fill="currentColor"/>
					</svg>
				</span>المخرجات</span>
			<span class="indicator-progress">{{ __('site.please_wait') }}...
				<span class="spinner-border spinner-border-sm align-middle ms-2"></span>
			</span>
		</button>
		
	</div>
</div>