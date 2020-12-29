<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
    <head><base href="">
        
		<meta charset="utf-8" />
		<meta name="description" content="Updates and statistics" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Aurora Management Information System</title>

        @include('layouts.includes.css')
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed subheader-enabled page-loading">


		<!--begin::Main-->
		<div class="d-flex flex-column flex-root">

			<!--begin::Page-->
			<div class="d-flex flex-row flex-column-fluid page">

				<!--begin::Wrapper-->
				<div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
					@include('layouts.includes.header-mobile')
					@include('layouts.includes.header')

					
					@include('layouts.includes.main')
					@include('layouts.includes.footer')
				</div>
				<!--end::Wrapper-->

			</div>
			<!--end::Page-->

		</div>
        <!--end::Main-->
        
		@include('layouts.panels.user')
		{{-- @include('layouts.panels.chat') --}}
		@include('layouts.panels.scrolltop')
		@include('layouts.includes.js')
	</body>
	<!--end::Body-->
</html>