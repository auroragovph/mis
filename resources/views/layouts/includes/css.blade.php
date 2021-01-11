<!--begin::Fonts-->
{{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" /> --}}
<!--end::Fonts-->

<!--begin::Page Vendors Styles(used by this page)-->
@section('css-vendor')
@show
<!--end::Page Vendors Styles-->

<!--begin::Global Theme Styles(used by all pages)-->
<link href="{{ asset('plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
<!--end::Global Theme Styles-->

<!--begin::Layout Themes(used by all pages)-->
<!--end::Layout Themes-->


@section('css-custom')
@show

<link rel="shortcut icon" href="{{ asset('media/logos/favicon.png') }}" />