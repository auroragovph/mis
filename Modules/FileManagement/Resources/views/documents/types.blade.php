<div class="col-md-5">
    <div class="card card-custom card-stretch gutter-b">
        <!--begin::Header-->
        <div class="card-header border-0 mt-5">
            <h3 class="card-title align-items-start flex-column text-dark">
                <span class="font-weight-bolder text-dark">Document Types</span>
                <span class="text-muted mt-3 font-weight-bold font-size-sm">Select document type</span>
            </h3>
           
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-custom bgi-no-repeat bgi-size-cover gutter-b" style="height: 150px; background-image: url(/media/stock-600x600/img-13.jpg)">
                        <!--begin::Body-->
                        <div class="card-body text-center">
                            <a href="{{ route('fms.afl.index') }}" class="btn btn-link btn-link-dark-75 font-weight-bold font-size-h5">Application For Leave</a>
                        </div>
                        <!--end::Body-->
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-custom bgi-no-repeat bgi-size-cover gutter-b" style="height: 150px; background-image: url(/media/stock-600x600/img-5.jpg)">
                        <!--begin::Body-->
                        <div class="card-body text-center">
                            <a href="#" class="btn btn-link btn-link-dark-75 font-weight-bold font-size-h5 ">Payroll</a>
                        </div>
                        <!--end::Body-->
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-custom bgi-no-repeat bgi-size-cover gutter-b" style="height: 150px; background-image: url(/media/stock-600x600/img-19.jpg)">
                        <!--begin::Body-->
                        <div class="card-body text-center">
                            <a href="{{ route('fms.procurement.index') }}" class="btn btn-link btn-link-dark-75 font-weight-bold font-size-h5">Procurement</a>
                        </div>
                        <!--end::Body-->
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-custom bgi-no-repeat bgi-size-cover gutter-b" style="height: 150px; background-image: url(/media/stock-600x600/img-21.jpg)">
                        <!--begin::Body-->
                        <div class="card-body text-center">
                            <a href="#" class="btn btn-link btn-link-dark-75 font-weight-bold font-size-h5 ">Travel</a>
                        </div>
                        <!--end::Body-->
                    </div>
                </div>
            </div>


            <div class="form-group">
                <label for="">Or Select Another Document Type</label>
                <select class="form-control select2" data-live-search="true" data-size="5" name="param" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                    <option value="" selected hidden></option>
                    <option value="{{ route('fms.afl.index') }}">Application For Leave (AFL)</option>
                    <option value="{{ route('fms.cafoa.index') }}">Certification On Appropriations, Funds And Obligation Of Allotment (CAFOA)</option>
                    {{-- <option value="{{ route('fms.obr.index') }}">Obligation Request (OBR)</option> --}}
                    <option value="{{ route('fms.travel.itinerary.index') }}">Itinerary of Travel </option>


                    {{-- PROCUREMENT --}}
                    

                    <option value="{{ route('fms.procurement.request.index') }}">Procurement - Purchase Request (PR) </option>
                    <option value="{{ route('fms.procurement.order.index') }}">Procurement - Purchase Order (PO)</option>
                    <option value="{{ route('fms.procurement.cafoa.index') }}">Procurement - Certification On Appropriations, Funds And Obligation Of Allotment (CAFOA)</option>


                    <option value="{{ route('fms.travel.order.index') }}">Travel Order (TO)</option>
                </select>
            </div>
        </div>
        <!--end::Body-->
    </div>
</div>