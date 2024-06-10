<div class="w-100">
	<!--begin::Heading-->
	<div class="fv-row mb-8">
		<!--begin::Wrapper-->
		<div class="d-flex flex-stack">
			<!--begin::Label-->
			<div class="me-5">
				<label class="fs-6 fw-semibold">{{ __('project.closing')}}</label>
			</div>
			<!--end::Label-->
			<!--begin::Switch-->
			<label class="form-check form-switch form-check-custom form-check-solid">
				<input class="form-check-input" type="checkbox" value="1" name="closing" checked="checked" onchange="manageClosing(this)"/>
				<span class="form-check-label fw-semibold text-muted">{{ __('site.yes')}}</span>
			</label>
			<!--end::Switch-->
		</div>
		<!--end::Wrapper-->
	</div>
	<div id="closing_div">
		<div class="fv-row mb-8">
			<!--begin::Wrapper-->
			<div class="d-flex flex-stack">
				<!--begin::Label-->
				<div class="me-5">
					<label class="fs-6 fw-semibold">{{ __('project.reserve_hall')}}</label>
				</div>
				<!--end::Label-->
				<!--begin::Switch-->
				<label class="form-check form-switch form-check-custom form-check-solid">
					<input class="form-check-input" type="checkbox" value="1" name="closing_reserve_hall" checked="checked" />
					<span class="form-check-label fw-semibold text-muted">{{ __('site.yes')}}</span>
				</label>
				<!--end::Switch-->
			</div>
			<!--end::Wrapper-->
		</div>
		<div class="fv-row mb-8">
			<!--begin::Label-->

			<div class="me-5">
				<h3 class="fw-bold text-dark">{{ __('project.attendance_nature') }}</h3>
			</div>

			<!--end::Label-->
			<!--begin::Row-->
			<div class="row g-9" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button='true']">
				<!--begin::Col-->
				<div class="col-md-6 col-lg-12 col-xxl-6">
					<!--begin::Option-->
					<label class="btn btn-outline btn-outline-dashed btn-active-light-primary active d-flex text-start p-6" data-kt-button="true">
						<!--begin::Radio-->
						<span class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
							<input class="form-check-input" type="radio" name="closing_attendance_nature" value="regulars" checked="checked" />
						</span>
						<!--end::Radio-->
						<!--begin::Info-->
						<span class="ms-5">
							<span class="fs-4 fw-bold text-gray-800 mb-2 d-block">{{ __('project.regulars')}}</span>
						</span>
						<!--end::Info-->
					</label>
					<!--end::Option-->
				</div>
				<!--end::Col-->
				<!--begin::Col-->
				<div class="col-md-6 col-lg-12 col-xxl-6">
					<!--begin::Option-->
					<label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6" data-kt-button="true">
						<!--begin::Radio-->
						<span class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
							<input class="form-check-input" type="radio" name="closing_attendance_nature" value="leaders" />
						</span>
						<!--end::Radio-->
						<!--begin::Info-->
						<span class="ms-5">
							<span class="fs-4 fw-bold text-gray-800 mb-2 d-block">{{ __('project.leaders')}}</span>
						</span>
						<!--end::Info-->
					</label>
					<!--end::Option-->
				</div>
				<!--end::Col-->
			</div>
			<!--end::Row-->
		</div>
		<div class="fv-row mb-8">
			<label class="required fs-6 fw-semibold mb-2">{{ __('project.closing_date')}}</label>
			<div class="position-relative d-flex align-items-center">
				<span class="svg-icon svg-icon-2 position-absolute mx-4">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z" fill="currentColor" />
						<path d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z" fill="currentColor" />
						<path d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z" fill="currentColor" />
					</svg>
				</span>
				<input class="form-control form-control-solid ps-12" placeholder="{{ __('project.closing_date')}}" name="closing_date" id="closing_date" />
			</div>
		</div>
	</div>
	<!--begin::Actions-->
	<div class="d-flex flex-stack">
		<button type="button" class="btn btn-lg btn-light me-3" data-kt-element="closing-previous" id="completeBack">
			<span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path opacity="0.5" d="M9.63433 11.4343L5.45001 7.25C5.0358 6.83579 5.0358 6.16421 5.45001 5.75C5.86423 5.33579 6.5358 5.33579 6.95001 5.75L12.4929 11.2929C12.8834 11.6834 12.8834 12.3166 12.4929 12.7071L6.95001 18.25C6.5358 18.6642 5.86423 18.6642 5.45001 18.25C5.0358 17.8358 5.0358 17.1642 5.45001 16.75L9.63433 12.5657C9.94675 12.2533 9.94675 11.7467 9.63433 11.4343Z" fill="currentColor"/>
			<path d="M15.6343 11.4343L11.45 7.25C11.0358 6.83579 11.0358 6.16421 11.45 5.75C11.8642 5.33579 12.5358 5.33579 12.95 5.75L18.4929 11.2929C18.8834 11.6834 18.8834 12.3166 18.4929 12.7071L12.95 18.25C12.5358 18.6642 11.8642 18.6642 11.45 18.25C11.0358 17.8358 11.0358 17.1642 11.45 16.75L15.6343 12.5657C15.9467 12.2533 15.9467 11.7467 15.6343 11.4343Z" fill="currentColor"/>
			</svg>
			</span> {{ __('project.the_opening')}}</button>
		<button type="button" class="btn btn-lg btn-primary" data-kt-element="closing-next" id="complete">
			<span class="indicator-label">
				<span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path opacity="0.5" d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z" fill="currentColor"/>
				<path d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z" fill="currentColor"/>
				</svg>
				</span>
				{{ __('project.completed')}}</span>

			<span class="indicator-progress">{{ __('site.please_wait') }}...
				<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
		</button>
	</div>
	<!--end::Actions-->
</div>