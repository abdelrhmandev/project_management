<!DOCTYPE html>
<html direction="rtl" dir="rtl" style="direction: rtl" lang="ar">
	<!--begin::Head-->
	<head>
		<title>{{ config('app.name', 'Laravel') }} | @yield('title')</title>
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta property="og:locale" content="ar_SA" />
		<meta property="og:type" content="article" />
		<meta property="og:url" content="#" />
		<link rel="canonical" href="google.com" />
		<link rel="shortcut icon" href="{{ asset('assets/media/logos/pm-logo.svg') }}" />
		@yield('style')

		<link href="{{ asset('assets/plugins/global/plugins.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets/css/style.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />
		<link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet">
		<style>
			body {
				font-family: 'Cairo', sans-serif;
			}
		</style>
		<!--end::Global Stylesheets Bundle-->
	</head>
	<body id="kt_body" class="app-blank">
		@yield('content')
		@yield('scripts')
	</body>
</html>