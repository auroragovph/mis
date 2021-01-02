<!--begin::Container-->
<div class="d-flex flex-row flex-column-fluid container">
    <!--begin::Content Wrapper-->
    <div class="main d-flex flex-column flex-row-fluid">
        
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4" id="kt_subheader">
            <div class="w-100 d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <!--begin::Page Heading-->
                    <div class="d-flex align-items-baseline mr-5">
                        <!--begin::Page Title-->
                        <h5 class="text-dark font-weight-bold my-2 mr-5">@yield('page-title')</h5>
                        <!--end::Page Title-->
                    </div>
                    <!--end::Page Heading-->
                </div>
                <!--end::Info-->
                
                <!--begin::Toolbar-->
                <div class="d-flex align-items-center">
                    @section('toolbar')
                    @show
                </div>
                <!--end::Toolbar-->
            </div>
        </div>
        <!--end::Subheader-->



        <div class="content flex-column-fluid" id="kt_content">
            @include('layouts.includes.alerts')
            @section('content')
            @show
        </div>
        <!--end::Content-->
    </div>
    <!--begin::Content Wrapper-->
</div>
<!--end::Container-->