<!DOCTYPE html>
<html lang="ar">
<!--begin::Head-->

<head>
	<base href="../../../" />
	<title>تغيير كلمة المرور</title>
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
		<!--begin::Authentication - New password -->
		<div class="d-flex flex-column flex-column-fluid flex-lg-row">
			<!--begin::Aside-->
			<div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10">
				<!--begin::Aside-->
				<div class="d-flex flex-center flex-lg-start flex-column">
					<!--begin::Logo-->
					<a href="https://al-fares.sa" class="mb-7">
						<img alt="Logo" src="https://al-fares.sa/wp-content/uploads/2022/09/alfars_logo_white.png" width="250px"/>
					</a>
					<!--end::Logo-->
					<!--begin::Title-->
					<h2 class="text-white fw-normal m-0">{{__('passwords.description')}} </h2>
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
						<form class="form w-100" novalidate="novalidate" id="kt_new_password_form" method="post" action="{{route('password.change')}}">
							@csrf
							@method('PATCH')
							<input type="hidden" name="idx" value="{{$id}}">
							<input type="hidden" name="emailx" value="{{$email}}">
							<!--begin::Heading-->
							<div class="text-center mb-10">
								<!--begin::Title-->
								<h1 class="text-dark fw-bolder mb-3">@lang('passwords.setpass')</h1>
								<span style="color:green;">{{session('success')}}</span>
								<!--end::Title-->
							</div>
							<!--begin::Heading-->
							<!--begin::Input group-->
							<div class="fv-row mb-8" data-kt-password-meter="true">
								<!--begin::Wrapper-->
								<div class="mb-1">
									<!--begin::Input wrapper-->
									<div class="position-relative mb-3">
										<span style="color:red;">{{$errors->first('password')}}</span>
										<input class="form-control bg-transparent" type="password" placeholder="@lang('passwords.pass')" name="password" autocomplete="off" />
										<span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
											<i class="bi bi-eye-slash fs-2"></i>
											<i class="bi bi-eye fs-2 d-none"></i>
										</span>
									</div>
									<!--end::Input wrapper-->
								</div>
								<!--end::Wrapper-->
							</div>
							<!--begin::Input group=-->
							<!--end::Input group=-->
							<div class="fv-row mb-8">
								<!--begin::Repeat Password-->
								<input type="password" placeholder="@lang('passwords.confirmpass')" name="password_confirmation" autocomplete="off" class="form-control bg-transparent" />
								<span class="btn btn-sm btn-icon position-absolute translate-middle" style="top:53% !important;right: 11% !important" data-kt-password-meter-control="visibility">
									<i class="bi bi-eye-slash fs-2"></i>
									<i class="bi bi-eye fs-2 d-none"></i>
								</span>
								<!--end::Repeat Password-->
							</div>
							<!--end::Input group=-->
							<!--begin::Action-->
							<div class="d-grid mb-10">
								<button type="submit" id="kt_new_password_change" class="btn btn-primary">
									<!--begin::Indicator label-->
									<span class="indicator-label">@lang('passwords.change')</span>
									<!--end::Indicator label-->
									<!--begin::Indicator progress-->
									<span class="indicator-progress">Please wait...
										<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
									<!--end::Indicator progress-->
								</button>
							</div>
							<!--end::Action-->
						</form>
						<!--end::Form-->
					</div>
					<!--end::Card body-->
				</div>
				<!--end::Card-->
			</div>
			<!--end::Body-->
		</div>
		<!--end::Authentication - New password-->
	</div>
	<!--end::Root-->
	<!--end::Main-->
	<!--begin::Javascript-->
	<script>
		var hostUrl = "assets/";
	</script>
	<!--begin::Global Javascript Bundle(mandatory for all pages)-->
	<script src="{{ asset('assets/plugins/global/plugins.bundle.js')}}"></script>
	<script src="{{ asset('assets/js/scripts.bundle.js')}}"></script>
	<!--end::Global Javascript Bundle-->
	<!--begin::Custom Javascript(used for this page only)-->
	<script src="{{ asset('assets/js/custom/authentication/password-reset/new-password.js')}}"></script>
	<!--end::Custom Javascript-->
	<!--end::Javascript-->
</body>
<!--end::Body-->

</html>