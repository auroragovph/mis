<div class="col-md-5">
    <div class="card card-custom card-stretch gutter-b">
       
        <!--begin::Body-->
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="card bg-primary" style="height: 150px">
                        <!--begin::Body-->
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <a href="{{ route('fms.afl.index') }}" class="text-white font-weight-bold">Application For Leave</a>
                        </div>
                        <!--end::Body-->
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-olive" style="height: 150px">
                        <!--begin::Body-->
                        <div class="card-body align-items-center d-flex justify-content-center">

                            <a href="#" class="text-white font-weight-bold">Payroll</a>
                        </div>
                        <!--end::Body-->
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card bg-maroon" style="height: 150px">

                        <!--begin::Body-->
                        <div class="card-body align-items-center d-flex justify-content-center">
                            <a href="{{ route('fms.procurement.index') }}" class="text-white font-weight-bold">Procurement</a> <br>
                        </div>
                        <!--end::Body-->
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-navy" style="height: 150px">

                        <!--begin::Body-->
                        <div class="card-body align-items-center d-flex justify-content-center">

                            <a href="#" class="text-white font-weight-bold">Travel</a>
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


                    {{-- PROCUREMENT --}}
                    

                    <option value="{{ route('fms.procurement.request.index') }}">Procurement - Purchase Request (PR) </option>
                    <option value="{{ route('fms.procurement.order.index') }}">Procurement - Purchase Order (PO)</option>
                    <option value="{{ route('fms.procurement.cafoa.index') }}">Procurement - Certification On Appropriations, Funds And Obligation Of Allotment (CAFOA)</option>

                    {{-- TRAVEL --}}
                    <option value="{{ route('fms.travel.itinerary.index') }}">Travel - Itinerary of Travel </option>
                    <option value="{{ route('fms.travel.order.index') }}">Travel - Travel Order (TO)</option>






                </select>
            </div>
        </div>
        <!--end::Body-->
    </div>
</div>