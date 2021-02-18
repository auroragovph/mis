@extends('layouts.master')


@section('page-title')
Messenger
@endsection

@section('toolbar')
@endsection

@section('content')
<!--begin::Chat-->
<div class="d-flex flex-row">
    <!--begin::Aside-->
    <div class="flex-row-auto offcanvas-mobile w-350px w-xl-400px" id="kt_chat_aside">
        <!--begin::Card-->
        <div class="card card-custom">
            <!--begin::Body-->
            <div class="card-body">
                <!--begin:Search-->
                <div class="input-group input-group-solid">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <span class="svg-icon svg-icon-lg">
                                <!--begin::Svg Icon | path:assets/media/svg/icons/General/Search.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24" />
                                        <path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                        <path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero" />
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>
                        </span>
                    </div>
                    <input type="text" class="form-control py-4 h-auto" placeholder="Email" />
                </div>
                <!--end:Search-->
                <!--begin:Users-->
                <div class="mt-7 scroll scroll-pull">
                    <!--begin:User-->
                    <div class="d-flex align-items-center justify-content-between mb-5">
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-circle symbol-50 mr-3">
                                <img alt="Pic" src="{{ asset('media/users/300_12.jpg') }}" />
                            </div>
                            <div class="d-flex flex-column">
                                <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-lg">Matt Pears</a>
                                <span class="text-muted font-weight-bold font-size-sm">Head of Development</span>
                            </div>
                        </div>
                        <div class="d-flex flex-column align-items-end">
                            <span class="text-muted font-weight-bold font-size-sm">35 mins</span>
                        </div>
                    </div>
                    <!--end:User-->
                    <!--begin:User-->
                    <div class="d-flex align-items-center justify-content-between mb-5">
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-circle symbol-50 mr-3">
                                <img alt="Pic" src="{{ asset('media/users/300_11.jpg') }}" />
                            </div>
                            <div class="d-flex flex-column">
                                <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-lg">Charlie Stone</a>
                                <span class="text-muted font-weight-bold font-size-sm">Art Director</span>
                            </div>
                        </div>
                        <div class="d-flex flex-column align-items-end">
                            <span class="text-muted font-weight-bold font-size-sm">7 hrs</span>
                            <span class="label label-sm label-success">4</span>
                        </div>
                    </div>
                    <!--end:User-->
                  
                </div>
                <!--end:Users-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Aside-->
    <!--begin::Content-->
    <div class="flex-row-fluid ml-lg-8" id="kt_chat_content">
        <!--begin::Card-->
        <div class="card card-custom">
            <!--begin::Header-->
            <div class="card-header align-items-center px-4 py-3">
                
                <div class="text-center flex-grow-1">
                    <div class="text-dark-75 font-weight-bold font-size-h5">Matt Pears</div>
                    <div>
                        <span class="label label-sm label-dot label-success"></span>
                        <span class="font-weight-bold text-muted font-size-sm">Active</span>
                    </div>
                </div>
                
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body">
                <!--begin::Scroll-->
                <div class="scroll scroll-pull" data-mobile-height="350">
                    <!--begin::Messages-->
                    <div class="messages">
                       
                        <!--begin::Message In-->
                        <div class="d-flex flex-column mb-5 align-items-start">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-circle symbol-40 mr-3">
                                    <img alt="Pic" src="{{ asset('media/users/300_12.jpg') }}" />
                                </div>
                                <div>
                                    <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">Matt Pears</a>
                                    <span class="text-muted font-size-sm">40 seconds</span>
                                </div>
                            </div>
                            <div class="mt-2 rounded p-5 bg-light-success text-dark-50 font-weight-bold font-size-lg text-left max-w-400px">Most purchased Business courses during this sale!</div>
                        </div>
                        <!--end::Message In-->
                        <!--begin::Message Out-->
                        <div class="d-flex flex-column mb-5 align-items-end">
                            <div class="d-flex align-items-center">
                                <div>
                                    <span class="text-muted font-size-sm">Just now</span>
                                    <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">You</a>
                                </div>
                                <div class="symbol symbol-circle symbol-40 ml-3">
                                    <img alt="Pic" src="{{ asset('media/users/300_21.jpg') }}" />
                                </div>
                            </div>
                            <div class="mt-2 rounded p-5 bg-light-primary text-dark-50 font-weight-bold font-size-lg text-right max-w-400px">Company BBQ to celebrate the last quater achievements and goals. Food and drinks provided</div>
                        </div>
                        <!--end::Message Out-->
                    </div>
                    <!--end::Messages-->
                </div>
                <!--end::Scroll-->
            </div>
            <!--end::Body-->
            <!--begin::Footer-->
            <div class="card-footer align-items-center">
                <!--begin::Compose-->
                <textarea class="form-control border-0 p-0" rows="2" placeholder="Type a message"></textarea>
                <div class="d-flex align-items-center justify-content-between mt-5">
                    <div class="mr-3">
                        <a href="#" class="btn btn-clean btn-icon btn-md mr-1">
                            <i class="flaticon2-photograph icon-lg"></i>
                        </a>
                        <a href="#" class="btn btn-clean btn-icon btn-md">
                            <i class="flaticon2-photo-camera icon-lg"></i>
                        </a>
                    </div>
                    <div>
                        <button type="button" class="btn btn-primary btn-md text-uppercase font-weight-bold chat-send py-2 px-6">Send</button>
                    </div>
                </div>
                <!--begin::Compose-->
            </div>
            <!--end::Footer-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Content-->
</div>
<!--end::Chat-->
@endsection


@section('css-vendor')
@endsection

@section('css-custom')
@endsection


@section('js-vendor')
@endsection

@section('js-custom')
<script src="{{ asset('js/Modules/General/pages/messenger.js') }}"></script>
@endsection


