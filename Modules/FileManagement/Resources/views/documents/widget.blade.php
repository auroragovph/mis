
    <div class="col-md-5">
        <div class="row">
            <div class="col-xl-6">

                <!--begin::Tiles Widget 2-->
                <div class="card card-custom bg-primary gutter-b" style="height: 150px">
                    <div class="card-body">
                        <span class="svg-icon svg-icon-3x svg-icon-white ml-n2">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"></rect>
                                    <rect fill="#000000" x="4" y="4" width="7" height="7" rx="1.5"></rect>
                                    <path d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z" fill="#000000" opacity="0.3"></path>
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>
                        <div class="text-inverse-success font-weight-bolder font-size-h2 mt-3">{{ $documents->whereBetween('created_at', [Carbon\Carbon::now()->startOfDay(), Carbon\Carbon::now()->endOfDay()])->count() }}</div>
                        <a href="#" class="text-inverse-success font-weight-bold font-size-lg mt-1">Today's Document</a>
                    </div>
                </div>
                <!--end::Tiles Widget 2-->

                <!--begin::Tiles Widget 2-->
                <div class="card card-custom gutter-b bg-success" style="height: 150px">
                    <div class="card-body">
                        <span class="svg-icon svg-icon-3x svg-icon-white ml-n2">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"></rect>
                                    <rect fill="#000000" x="4" y="4" width="7" height="7" rx="1.5"></rect>
                                    <path d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z" fill="#000000" opacity="0.3"></path>
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>
                        <div class="text-inverse-success font-weight-bolder font-size-h2 mt-3">{{ $total }}</div>
                        <a href="#" class="text-inverse-success font-weight-bold font-size-lg mt-1">Total Document</a>
                    </div>
                </div>
                <!--end::Tiles Widget 2-->

            </div>
            <div class="col-xl-6">
                <!--begin::Tiles Widget 2-->
                <div class="card card-custom bg-warning gutter-b" style="height: 150px">
                    <div class="card-body">
                        <span class="svg-icon svg-icon-3x svg-icon-white ml-n2">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"></rect>
                                    <rect fill="#000000" x="4" y="4" width="7" height="7" rx="1.5"></rect>
                                    <path d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z" fill="#000000" opacity="0.3"></path>
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>
                        <div class="text-inverse-success font-weight-bolder font-size-h2 mt-3">N/A</div>
                        <a href="#" class="text-inverse-success font-weight-bold font-size-lg mt-1">On Process</a>
                    </div>
                </div>
                <!--end::Tiles Widget 2-->

                <!--begin::Tiles Widget 2-->
                <div class="card card-custom bg-danger gutter-b" style="height: 150px">
                    <div class="card-body">
                        <span class="svg-icon svg-icon-3x svg-icon-white ml-n2">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"></rect>
                                    <rect fill="#000000" x="4" y="4" width="7" height="7" rx="1.5"></rect>
                                    <path d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z" fill="#000000" opacity="0.3"></path>
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>
                        <div class="text-inverse-success font-weight-bolder font-size-h2 mt-3">N/A</div>
                        <a href="#" class="text-inverse-success font-weight-bold font-size-lg mt-1">Returned</a>
                    </div>
                </div>
                <!--end::Tiles Widget 2-->

            </div>

        </div>
        {{-- <!--begin::Mixed Widget 20-->
        <div class="card card-custom bgi-no-repeat gutter-b" style="height: 180px; background-color: #4AB58E; background-position: calc(100% + 0.5rem) bottom; background-size: 25% auto; background-image: url(assets/media/svg/humans/custom-1.svg)">
            <!--begin::Body-->
            <div class="card-body d-flex align-items-center">
                <div class="py-2">
                    <h3 class="text-white font-weight-bolder mb-3">File Management Announcements</h3>
                    <p class="text-white font-size-lg">
                        Please attach the documents when you released the documents.
                    </p>
                </div>
            </div>
            <!--end::Body-->
        </div>
        <!--end::Mixed Widget 20--> --}}
    </div>