<!DOCTYPE html>
<html direction="rtl" dir="rtl" style="direction: rtl" lang="ar" lang="ar">

<head>
	<title>{{ config('app.name', 'Laravel') }} | @yield('title')</title>
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
	<link rel="shortcut icon" href="{{ asset('assets/media/logos/pm-logo.svg') }}" />
	@yield('style')
	<link href="{{ asset('assets/plugins/global/plugins.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/css/style.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />
	<style type="text/css">
		div.projectData div.card-body.p-9 div.fs-3.fw-bold.text-dark {
			height: 55px;
		}
		table tr td {
			vertical-align:middle !important;
		}
	</style>
</head>

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed">
	<div class="d-flex flex-column flex-root">
		<!--begin::Page-->
		<div class="page d-flex flex-row flex-column-fluid">
			<!--begin::Aside-->
			@include('layouts.aside._base')
			<!--end::Aside-->
			<!--begin::Wrapper-->
			<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
				<!--begin::Header-->
				@include('layouts.header._base')
				<!--end::Header-->
				<!--begin::Toolbar-->
				<div class="toolbar py-2" id="kt_toolbar">
					<!--begin::Container-->
					<div id="kt_toolbar_container" class="container-fluid d-flex align-items-center">
						<!--begin::Page title-->
						<div class="flex-grow-1 flex-shrink-0 me-5">
							@yield('breadcrumbs')
						</div>
						<!--end::Page title-->
						<!--begin::Action group-->
						<div class="d-flex align-items-center flex-wrap">
							<!--begin::Wrapper-->
							<div class="d-flex align-items-center">
								<!--begin::Daterangepicker-->
								<a href="#" class="btn btn-sm btn-bg-light btn-color-gray-500 btn-active-color-primary me-2" id="kt_dashboard_daterangepicker" data-bs-toggle="tooltip" data-bs-dismiss="click" data-bs-trigger="hover" title="Select dashboard daterange">
									<span class="fw-semibold me-1" id="kt_dashboard_daterangepicker_title">تاريخ اليوم هو</span>
									<span class="fw-bold" id="kt_dashboard_daterangepicker_date">{{ date('Y/m/d') }}</span>
								</a>
								<!--end::Daterangepicker-->
							</div>
							<!--end::Wrapper-->
						</div>
						<!--end::Action group-->
					</div>
					<!--end::Container-->
				</div>
				<!--end::Toolbar-->
				<!--begin::Content-->
				<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
					<!--begin::Container-->
					@yield('content')
					<!--end::Container-->
				</div>

				<!--end::Content-->
				<!--begin::Footer-->
				@section('footer')
				@include('layouts._footer')
				@show
				<!--end::Footer-->
			</div>
			<!--end::Wrapper-->
		</div>
	</div>
	<!--end::Page-->

	<!--begin::Helper drawer-->
	@include('partials.topbar._helper-drawer')
	<!--end::Helper drawer-->

	<!--begin::Scrolltop-->
	@include('layouts._scrolltop')
	<!--end::Scrolltop-->
	<script>
		"use strict";
		var projectBaseUrl = "{{url('/')}}";
	</script>
	<script src="{{ asset('assets/plugins/global/plugins.bundle.js')}}"></script>
	<script src="{{ asset('assets/js/scripts.bundle.js')}}"></script>
	@include('partials.toastsJs')
	<script>
		$("input#projectFilter").on("input", function() {
			let $projectList = $('#projectList');
			$.get(projectBaseUrl + '/project/ajax', {
				"projectName": $(this).val()
			}, function(data) {
				$projectList.html(data.views);
			});
		});

		$("#status").on("change", function() {
			var opt = $(this).find('option:selected')[0];
			var $request = $.get(projectBaseUrl + '/project/ajax/' + $(this).val()); // make request
			var $projectList = $('#projectList');
			$request.done(function(data) { // success
				$projectList.html(data.views);
			});
			$request.always(function() {
				$projectList.removeClass('loading');
			});
		});

		function sendMarkRequest() {
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			// var formData = new FormData($('#offerForm')[0]);
			$.ajax({
				method: "POST",
				url: '{{ route('admin.markNotification') }}',
				// data: formData,
				dataType: "json",
				cache: false,
				contentType: false, //tell jquery to avoid some checks
				processData: false,
			});
		}
	</script>
	@yield('scripts')
	<script src="https://npmcdn.com/flatpickr/dist/l10n/ar.js"></script>
</body>
</html>