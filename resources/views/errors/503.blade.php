<!DOCTYPE html>
<html direction="rtl" dir="rtl" style="direction: rtl" lang="ar" lang="ar">

<head>
	<title>Error 503</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="description" content="The most advanced Bootstrap Admin " />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta property="og:locale" content="ar_SA" />
	<meta property="og:type" content="article" />
	<meta property="og:url" content="#" />
	<link rel="canonical" href="google.com" />
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico')}}" />
	@yield('style')
	<link href="{{ asset('assets/plugins/global/plugins.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/css/style.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />
</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="app-blank bgi-size-cover bgi-position-center bgi-no-repeat">
		<!--begin::Theme mode setup on page load-->
 		<!--end::Theme mode setup on page load-->
		<!--begin::Main-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Page bg image-->
			<style>body { background-image: url('assets/media/auth/bg1.jpg'); } [data-theme="dark"] body { background-image: url('assets/media/auth/bg1-dark.jpg'); }</style>
			<!--end::Page bg image-->
			<!--begin::Authentication - Signup Welcome Message -->
			<div class="d-flex flex-column flex-center flex-column-fluid">
				<!--begin::Content-->
				<div class="d-flex flex-column flex-center text-center p-10">
					<!--begin::Wrapper-->
					<div class="card card-flush w-lg-650px py-5">
						<div class="card-body py-15 py-lg-20">
							<!--begin::Title-->
							<h1 class="fw-bolder fs-2hx text-gray-900 mb-4">عذرا</h1>
							<!--end::Title-->
							<!--begin::Text-->
							<div class="fw-semibold fs-6 text-gray-500 mb-7">الخدمه غير متاحه الآن</div>
							<!--end::Text-->
							<!--begin::Illustration-->
							<div class="mb-3">
								<img src="{{ asset('assets/media/auth/503-error.png') }}" class="mw-100 mh-300px theme-light-show" alt="ww" />
								<img src="{{ asset('assets/media/auth/503-error-dark.png') }}" class="mw-100 mh-300px theme-dark-show" alt="wwww" />
							</div>
							<!--end::Illustration-->
							<!--begin::Link-->
							<div class="mb-0">
								<a href="{{ url('/')}}" class="btn btn-sm btn-primary">الرئيسيه</a>
							</div>
							<!--end::Link-->
						</div>
					</div>
					<!--end::Wrapper-->
				</div>
				<!--end::Content-->
			</div>
			<!--end::Authentication - Signup Welcome Message-->
		</div>
		<!--end::Root-->
		<!--end::Main-->
		<!--begin::Javascript-->

		<!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js')}}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js')}}"></script>
		<!--end::Global Javascript Bundle-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>