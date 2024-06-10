<!DOCTYPE html>

<html lang="ar">

<head>
	<base href="../../../" />
	<title>نسيت كلمة المرور</title>
	<meta charset="utf-8" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta property="og:locale" content="ar_SA" />
	<meta property="og:type" content="article" />
	<meta property="og:title" content="" />
	<meta property="og:url" content="" />
	<meta property="og:site_name" content="" />
	<link rel="canonical" href="" />
	<link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}" />
	<!--begin::Fonts(mandatory for all pages)-->
	<link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
	<!--end::Fonts-->
	<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
	<link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
	<!--end::Global Stylesheets Bundle-->
</head>
<!--end::Head-->

<!--begin::Body-->

<body id="kt_body" class="app-blank bgi-size-cover bgi-position-center bgi-no-repeat">
	<!--begin::Theme mode setup on page load-->
	<script>
		var defaultThemeMode = "light";
		var themeMode;
		if (document.documentElement) {
			if (document.documentElement.hasAttribute("data-theme-mode")) {
				themeMode = document.documentElement.getAttribute("data-theme-mode");
			} else {
				if (localStorage.getItem("data-theme") !== null) {
					themeMode = localStorage.getItem("data-theme");
				} else {
					themeMode = defaultThemeMode;
				}
			}
			if (themeMode === "system") {
				themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
			}
			document.documentElement.setAttribute("data-theme", themeMode);
		}
	</script>
	<!--end::Theme mode setup on page load-->
	<!--begin::Main-->
	<!--begin::Root-->
	<div class="d-flex flex-column flex-root">
		<!--begin::Page bg image-->
		<style>
			body {
				font-family: 'Cairo', sans-serif !important;
				background-image: url({{ asset('assets/media/auth/bg4.jpg') }});
			}
			[data-theme="dark"] body {
				font-family: 'Cairo', sans-serif !important;
				background-image: url({{ asset('assets/media/auth/bg4-dark.jpg') }});
			}
		</style>
		<!--end::Page bg image-->
		<!--begin::Authentication - Password reset -->
		<div class="d-flex flex-column flex-column-fluid flex-lg-row">
			<!--begin::Aside-->
			<div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10">
				<!--begin::Aside-->
				<div class="d-flex flex-center flex-lg-start flex-column">
					<!--begin::Logo-->
					<a href="https://al-fares.sa" class="mb-7">
						<img alt="Logo" src="https://al-fares.sa/wp-content/uploads/2022/09/alfars_logo_white.png" width="250px" />
					</a>
					<!--end::Logo-->
					<!--begin::Title-->
					<h2 class="text-white fw-normal m-0">{{__('passwords.description')}}</h2>
					<!--end::Title-->
				</div>
				<!--begin::Aside-->
			</div>
			<!--begin::Aside-->
			<!--begin::Body-->
			<div class="d-flex flex-center w-lg-50 p-10">
				<!--begin::Card-->
				<div class="card rounded-3 w-md-550px">
					<!--begin::Card body-->
					<div class="card-body p-10 p-lg-20">
						<!--begin::Form-->
						<form class="form w-100" novalidate="novalidate" id="kt_password_reset_form" method="post" data-action="{{route('password.send')}}">
							@csrf
							<!--begin::Heading-->
							<div class="text-center mb-10">
								<!--begin::Title-->
								<h1 class="text-dark fw-bolder mb-3">@lang('passwords.forgot_password')</h1>
								<!--end::Title-->
								<!--begin::Link-->
								<div class="text-gray-500 fw-semibold fs-6">@lang('passwords.enterEmail')</div>
								<!--end::Link-->
							</div>
							<!--begin::Heading-->
							<!--begin::Input group=-->
							<span id="MSG" style="display:inline-block;text-align:right !important;direction:rtl !important;"></span>
							<div class="fv-row mb-8">
								<!--begin::Email-->
								<input type="text" placeholder="@lang('passwords.Email')" name="email" autocomplete="off" class="form-control bg-transparent" />
								<!--end::Email-->
							</div>
							<!--begin::Actions-->
							<div class="d-flex flex-wrap justify-content-center pb-lg-0">
								<button type="button" id="kt_password_reset_button" class="btn btn-primary me-4">
									<!--begin::Indicator label-->
									<span class="indicator-label">@lang('passwords.submit')</span>
									<!--end::Indicator label-->
									<!--begin::Indicator progress-->
									<span class="indicator-progress">Please wait...
										<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
									<!--end::Indicator progress-->
								</button>
								<a href="#" class="btn btn-light">@lang('passwords.cancel')</a>
							</div>
							<!--end::Actions-->
						</form>
						<!--end::Form-->
					</div>
					<!--end::Card body-->
				</div>
				<!--end::Card-->
			</div>
			<!--end::Body-->
		</div>
		<!--end::Root-->
		<!--end::Main-->
		<!--begin::Javascript-->
		<script>
			var hostUrl = "assets/";
		</script>
		<!--begin::Global Javascript Bundle(mandatory for all pages)-->
		<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
		<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Custom Javascript(used for this page only)-->
		<script>
			"use strict";
			class ResetPass {
				constructor() {
					this.loadingEl = document.createElement("div") ?? $("<div></div>");
					this.redirectUrl = "{{url('/login')}}" || "/";
					this._sendButton();
				}
				_sendButton(self = this) {
					$("button#kt_password_reset_button").on("click", function() {
						document.body.prepend(self.loadingEl);
						self.loadingEl.classList.add("page-loader");
						self.loadingEl.classList.add("flex-column");
						self.loadingEl.classList.add("bg-dark");
						self.loadingEl.classList.add("bg-opacity-25");
						self.loadingEl.innerHTML = `
							<span class="spinner-border text-primary" role="status"></span>
							<span class="text-gray-800 fs-6 fw-semibold mt-5">الرجاء الإنتظار...</span>
						`;
						KTApp.showPageLoading();
						setTimeout(() => {
							$.post($("form#kt_password_reset_form").data("action"), $("form#kt_password_reset_form").serialize(), function(data) {
								KTApp.hidePageLoading();
								self.loadingEl.remove();
								if (data.code == 401) {
									$("span#MSG").css({
										color: "red"
									}).html(data.MSG);
								} else {
									$("span#MSG").css({
										color: "green"
									}).html(data.MSG);
									window.location.href = self.redirectUrl;
								}
							}).done(function() {

							});
						}, 2000);
					});
				}
			}
			try {
				new ResetPass();
			} catch (err) {
				console.error(err);
			}
		</script>
		<script src="{{ asset('assets/js/custom/authentication/reset-password/reset-password.js') }}"></script>
		<!--end::Custom Javascript-->
		<!--end::Javascript-->
</body>
<!--end::Body-->

</html>